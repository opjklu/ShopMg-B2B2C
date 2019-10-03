<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsClassLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(perfix="/goodsClass")
 * 商品分类控制器
 *
 * @author Administrator
 */
class GoodsClassController
{

    /**
     * @Inject()
     *
     * @var GoodsClassLogic
     */
    private $logic;

    /**
     * 获取所有的一级分类
     */
    public function topClassByShopMGSw(): array
    {
        $ret = $this->logic->getTopClass();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret['data'], $ret['status'], $ret['message']);
    }

    /**
     * 获取所有的分类
     * @RequestMapping(route="getClassByPid", method = RequestMethod::POST)
     * @Number(name="id")
     */
    public function getClassByPidByShopMGFd(Request $req): array
    {
        $ret = $this->logic->getCacheByClassByPid($req->post());

        if (count($ret) === 0) {
            return AjaxReturn::error('暂无分类数据');
        }
        return AjaxReturn::sendData($ret);
    }

    /**
     * 根据一级分类获取二三级分类
     * @RequestMapping(route="getClassChildrenByParent", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function getClassChildrenByParentByShopMGUh(Request $req): array
    {
        $ret = $this->logic->classTwoThreeBuild($req->post());

        if (count($ret) === 0) {
            return AjaxReturn::error('暂无分类数据');
        }
        return AjaxReturn::sendData($ret);
    }
}