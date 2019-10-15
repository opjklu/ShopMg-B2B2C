<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CapitaInvoiceLogic;
use App\Models\Logic\Specific\RegionLogic;
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
 * @Controller(prefix="/invoice")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class InvoiceController
{

    /**
     * @Inject()
     *
     * @var CapitaInvoiceLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var RegionLogic
     */
    private $regionLogic;

    /**
     * 我的发票--添加增值发票
     * @RequestMapping(route="capitaAdd", method=RequestMethod::POST)
     *
     * @param Request $req
     * @return array
     */
    public function capitaAddByShopMGHl(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByAddCapita(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->addData($post);

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 我的发票--修改增值发票
     * @RequestMapping(route="capitaSave", method=RequestMethod::POST)
     */
    public function capitaSaveByShopMGHl(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByEditCapita(), $post);

        $status = $checkObj->detectionParameters();
        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }
        $ret = $this->logic->saveData($post);

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 我的发票--删除增值发票
     * @RequestMapping(route="capitaDelete", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function capitaDeleteByShopMGXt(Request $req): array
    {
        $ret = $this->logic->delete($req->post());

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        return AjaxReturn::sendData($ret);
    }

    /**
     * 我的发票--添加增值发票列表
     * @RequestMapping(route="capitaList", method=RequestMethod::POST)
     *
     * @author 米糕网络团队
     */
    public function capitaListByShopMGPq(Request $req): array
    {
        // 检测传值 //检测方法
        $ret = $this->logic->getNoPageList($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无数据');
        }

        $ret = $this->regionLogic->getRegionByCapita($ret, $this->logic->parseAreaWhere($ret));

        return AjaxReturn::sendData($ret);
    }

    /**
     * 我的发票--增值发票详细
     * @RequestMapping(route="capitaDetails", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @author 米糕网络团队
     */
    public function capitaDetailsByShopMGNv(Request $req): array
    {
        $ret = $this->logic->getFindOne($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('数据错误');
        }

        $ret = $this->regionLogic->getRegionByOneCapita($ret, $this->logic->parseAreaWhereOne($ret));

        return AjaxReturn::sendData($ret);
    }
} 