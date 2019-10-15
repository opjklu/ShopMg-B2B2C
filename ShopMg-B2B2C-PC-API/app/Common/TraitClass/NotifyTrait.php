<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

use App\Common\Aspect\AlipaySerialNumber;
use App\Common\Aspect\Balance;
use App\Common\Aspect\Decorate;
use Swoft\Core\RequestContext;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\Hook;

/**
 * 通知抽象类
 *
 * @author Administrator
 */
trait NotifyTrait
{
    use AlipayNotifyTrait;
    use WxNofityTrait;
    use WxListenResTrait;
    use PayTrait;

    private $returnWxResult = <<<aaa
<xml>
  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>
aaa;

    private $errorWxResult = <<<aaa
<xml>
  <return_code><![CDATA[ERROR]]></return_code>
  <return_msg><![CDATA[FAIL]]></return_msg>
</xml>
aaa;

    /**
     * pc 和 wap 回调
     * @RequestMapping(route="wxNofity", method=RequestMethod::POST)
     */
    public function wxNofity(Request $req, Response $response): Response
    {
        $returnData = $req->raw();

        $data = $this->getTheCustomParamter($returnData);

        if (0 === count($data)) {
            return $response->raw($this->errorWxResult);
        }

        session()->setId($data['token'])->start();

        $payConfig = session()->get('pay_config_by_user');

        if (0 === count($payConfig)) {
            return $response->raw($this->errorWxResult);
        }

        $this->getPayConfig($payConfig);

        $status = $this->nofityWx();

        if ($status === false) {
            return $response->raw($this->errorWxResult);
        }

        Hook::add('aplipaySerial', Decorate::class);

        $status = $this->orderNotice($this->getPayIntegral());

        if ($status === false) {
            return $response->raw($this->errorWxResult);
        }

        return $response->raw($this->returnWxResult);
    }

    /**
     * 异步通知
     * @RequestMapping(route="alipayNotify", method=RequestMethod::POST)
     */
    public function alipayNotify(Request $req, Response $response): Response
    {
        $post = $req->post();

        $alipayConf = $this->parseResultConf($post);


        if (0 === count($alipayConf)) {
            return $response->raw('failure');
        }

        session()->setId($alipayConf['token'])->start();

        $status = $this->alipayResultParse($post);

        if ($status === false) {
            return $response->raw('failure');
        }

        Hook::add('aplipaySerial', AlipaySerialNumber::class);

        $status = $this->orderNotice($this->getPayIntegral(), $post['trade_no']);

        if ($status === false) {
            return $response->raw('failure');
        }
        return $response->raw('success');
    }

    /**
     * 余额支付通知
     * @RequestMapping(route="balanceNofty", method=RequestMethod::POST)
     */
    public function balanceNofty(): string
    {
        Hook::add('aplipaySerial', Balance::class);

        $status = $this->orderNotice($this->getPayIntegral());

        if (!$status) {

            return 'ERROR';
        }

        return 'SUCCESS';
    }

    /**
     * 获取积分比例
     */
    private function getPayIntegral(): float
    {
        return (float)$this->getGroupConfig('integral')['integral_proportion'];
    }

    public function __destruct()
    {
        unset($this->errorMessage, $this->payData, $this->payReturnData);
    }
}