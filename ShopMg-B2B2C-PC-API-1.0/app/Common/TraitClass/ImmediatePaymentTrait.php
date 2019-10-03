<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 立即支付【未付款】
 *
 * @author Administrator
 */
trait ImmediatePaymentTrait
{

    /**
     * 立即支付【未付款】
     * @RequestMapping(route="immediatePayment", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function immediatePayment(Request $req): array
    {
        $post = $req->post();

        $status = $this->logic->orderPayBuildData($post);

        if (!$status) {
            return AjaxReturn::error('支付数据错误');
        }

        $status = $this->buildPayParam($post);

        if (!$status) {
            return AjaxReturn::error('订单商品数据错误');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 组装 商品信息 用于 减库存。。。
     */
    private function buildPayParam(array $post): bool
    {
        return true;
    }
}