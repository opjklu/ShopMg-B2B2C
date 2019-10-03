<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 检查是否支付返回客户端
 *
 * @author Administrator
 *
 */
trait CallIsPayReturnClientTrait
{

    /**
     * 检查是否已支付【微信支付】
     * @RequestMapping(route="isCheckPay", method=RequestMethod::POST)
     */
    public function isCheckPay(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidateByOrderCheck(), $post);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::sendData($checkObj->getErrorMessage());
        }

        $status = $this->logic->isCheckPay($post);

        if (!$status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}