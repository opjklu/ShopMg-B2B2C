<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\Aspect\Balance;
use App\Common\Aspect\OpenShopCallBack;
use App\Common\TraitClass\AlipayNotifyTrait;
use App\Common\TraitClass\OpenShopTrait;
use App\Common\TraitClass\PayTrait;
use App\Common\TraitClass\WxNofityTrait;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\Hook;
use App\Common\Aspect\AlipaySerialNumber;
use Swoft\Http\Message\Server\Response;
use App\Common\Aspect\Decorate;

/**
 * 开店回调通知
 * @Controller(perfix="/openShopNofity")
 *
 * @author Administrator
 */
class OpenShopNofityController
{
    use WxNofityTrait;
    use AlipayNotifyTrait;
    use OpenShopTrait;
    use PayTrait;

    /**
     * 回调配置
     *
     * @var array
     */
    private $storeCallBack = [
        'persoStoreCallBack',
        'companyStoreCallBack'
    ];
    
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
     * 支付宝开店充值通知
     * @RequestMapping(route="aplipayNotify", method=RequestMethod::POST)
     */
    public function aplipayNotifyByShopMGSc(Request $request, Response $response)
    {
        $post = $request->post();

        $alipayConf = $this->parseResultConf($post);
        
        if (0 === count($alipayConf)) {
            return $response->raw('failure');
        }
        
        session()->setId($alipayConf['token'])->start();
        
        $data = $this->alipayResultParse($post);

        if (0 === count($data)) {
            return $response->raw('failure');
        }
        

        Hook::add('aplipayBalanceSerial', AlipaySerialNumber::class);

        Hook::add($this->storeCallBack[$data['store_type']], OpenShopCallBack::class);

        $status = $this->opShopNofity($this->storeCallBack[$data['store_type']], $post['trade_no']);

        $this->msg($status);

        echo 'SUCCESS';
        die();
    }

    /**
     * 微信开店通知
     * @RequestMapping(route="wxNotify", method=RequestMethod::POST)
     */
    public function wxNotifyByShopMGLl(Request $request, Response $response)
    {

        $data = $this->getTheCustomParamter($request->raw());
        
        if (0 === count($data)) {
            return $response->raw($this->returnErrorWxResult);
        }
        
        session()->setId($data['token'])->start();
        
        $payConfig = session()->get('pay_config_by_user');
        
        if (0 === count($payConfig)) {
            return $response->raw($this->returnErrorWxResult);
        }
        
        $this->getPayConfig($payConfig);
        
        if (false === $this->nofityWx()) {
            return $response->raw($this->returnErrorWxResult);
            
        }


        $orderDataByShop = session()->get('order_data_by_open_shop');
        
        if (0 === count($orderDataByShop)) {
            return $response->raw($this->returnErrorWxResult);
        }
        
        Hook::add('aplipayBalanceSerial', Decorate::class);

        Hook::add($this->storeCallBack[$orderDataByShop['store_type']], OpenShopCallBack::class);

        $status = $this->opShopNofity($data, $this->storeCallBack[$orderDataByShop['store_type']], $data['out_trade_no']);

        if (false === $this->nofityWx()) {
            return $response->raw($this->returnErrorWxResult);
        }
       
        return $response->raw($this->returnWxResult);
    }

    /**
     * 余额通知balanceuser
     * @RequestMapping(route="balanceNotify", method=RequestMethod::POST)
     */
    public function balanceNotifyByShopMGLc(Request $req): string
    {
        $post = $req->post();

        if (session()->get('ley_user') !== $post['ley_user']) {
            return 'ERROR';
        }

        $orderDataByShop = session()->get('order_data_by_open_shop');

        if (0 === count($orderDataByShop)) {
            return 'ERROR';
        }

        Hook::add('aplipayBalanceSerial', Balance::class);

        Hook::add($this->storeCallBack[$orderDataByShop['store_type']], OpenShopCallBack::class);

        $listener = $this->storeCallBack[$orderDataByShop['store_type']];

        $status = $this->opShopNofity($listener);

        if ($status === false) {
            return 'ERROR';
        }

        return 'SUCCESS';
    }

    private function msg($status)
    {
        if (empty($status)) {
            echo 'ERROR';
            die();
        }
    }

    public function __destructByShopMGUe()
    {
        unset($this->notify);
    }
}