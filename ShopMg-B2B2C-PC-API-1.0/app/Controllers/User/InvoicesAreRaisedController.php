<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\InvoicesAreRaisedLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 发票抬头
 *
 * @author Administrator
 * @Controller(perfix="invoicesAreRaised")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class InvoicesAreRaisedController
{

    /**
     * @Inject()
     *
     * @var InvoicesAreRaisedLogic
     */
    private $logic;

    /**
     * 资金中心--我的发票--普通发票抬头
     *
     * @RequestMapping(route="getInvoiceAreRaised", method=RequestMethod::POST)
     */
    public function getInvoiceAreRaisedByShopMGPf(Request $req): array
    {
        $ret = $this->logic->getNoPageList($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无数据');
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 我的发票--添加发票抬头发票数据
     * @RequestMapping(route="invoicesAreRaisedAdd", method=RequestMethod::POST)
     *
     * @author 米糕网络团队
     */
    public function invoicesAreRaisedAddByShopMGFm(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByAddAreRaised(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }
        $ret = $this->logic->addData($post);

        if (!$status) {
            return AjaxReturn::error('添加失败');
        }
        return AjaxReturn::sendData($ret);
    }

    /**
     * 修改发票抬头发票数据
     * @RequestMapping(route="invoicesAreRaisedSave", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @author 米糕网络团队
     */
    public function invoicesAreRaisedSaveByShopMGOd(Request $req): array
    {
        $ret = $this->logic->saveData($req->post());

        if (!$ret) {
            return AjaxReturn::error('保存失败');
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 删除
     * @RequestMapping(route="delete", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function deleteByShopMGXv(Request $req): array
    {
        $status = $this->logic->delete($req->post());

        if (!$status) {
            return AjaxReturn::error('删除失败');
        }
        return AjaxReturn::sendData($status);
    }
}
