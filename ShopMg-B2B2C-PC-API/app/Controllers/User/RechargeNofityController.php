<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 20019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
namespace App\Controllers\User;

use App\Common\Aspect\AlipaySerialNumber;
use App\Common\TraitClass\AlipayNotifyTrait;
use App\Common\TraitClass\BalanceParseTrait;
use App\Common\TraitClass\PayTrait;
use App\Common\TraitClass\WxNofityTrait;
use Swoft\Core\RequestContext;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\Hook;
use App\Common\Aspect\Decorate;

/**
 * @Controller(prefix="/rechargeNofity")
 *
 * @author wq
 */
class RechargeNofityController
{
    use WxNofityTrait;
    use AlipayNotifyTrait;
    use BalanceParseTrait;

    use PayTrait;
    
    
    private $returnWxResult = <<<aaa
<xml>
  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>
aaa;
    
    private $returnErrorWxResult = <<<aaa
<xml>
  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>
aaa;

    /**
     * 支付宝余额充值通知
     * @RequestMapping(route="aplipayRechargeNofity", method=RequestMethod::POST)
     */
    public function aplipayRechargeNofityByShopMGNv(Request $req, Response $response): Response
    {
        $post = $req->post();

        $alipayConf = $this->parseResultConf($post);


        if (0 === count($alipayConf)) {
            return $response->raw('ERROR');
        }

        session()->setId($alipayConf['token'])->start();

        Hook::add('aplipayBalanceSerial', AlipaySerialNumber::class);

        $status = $this->parseByBalance($post);

        if ($status === false) {
            return $response->raw('ERROR');
        }

        return $response->raw('SUCCESS');
    }

    /**
     * 微信余额通知
     */
    public function rechargeWxNotifyByShopMGXc(Request $req, Response $response)
    {
        $returnData = $req->raw();

        $data = $this->getTheCustomParamter($returnData);
        
        if (0 === count($data)) {
            return $response->raw($this->returnErrorWxResult);
        }
        session()->setId($data['token'])->start();
        
        $payConfig = session()->get('pay_config_by_user');
        
        if (0 === count($payConfig)) {
            return $response->raw($this->returnErrorWxResult);
        }
        
        $this->getPayConfig($payConfig);

        $status = $this->nofityWx();
        
        if ($status === false) {
            return $response->raw($this->returnErrorWxResult);
        }

        Hook::add('aplipayBalanceSerial', Decorate::class);

        $payParam = [];

        $payParam['trade_no'] = $data['out_trade_no'];
        
        $payParam['total_amount'] = $data['total_fee'] / 100;

        $status = $this->parseByBalance($payParam);

        if ($status === false) {
            return $response->raw($this->returnErrorWxResult);
        }
        
        return $response->raw($this->returnWxResult);
    }
}