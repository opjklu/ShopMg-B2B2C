<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\GoodsSpecItemLogic;
use App\Models\Logic\Specific\GoodsSpecLogic;
use App\Models\Logic\Specific\SpecGoodsPriceLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 商品规格控制器
 * @Controller(perfix="/goodsSpec")
 *
 * @author wq
 */
class GoodsSpecController
{

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsSpecLogic
     */
    private $goodsSpecLogic;

    /**
     * @Inject()
     *
     * @var GoodsSpecItemLogic
     */
    private $goodsSpecItemLogic;

    /**
     * @Inject()
     *
     * @var SpecGoodsPriceLogic
     */
    private $specGoodsPriceLogic;

    /**
     * 获取商品子类数据
     * @RequestMapping(route="goodSpecsByGoodsChildren", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @author 米糕网络团队
     */
    public function goodSpecsByGoodsChildrenByShopMGBc(Request $req): array
    {
        // 商品集合
        $goodsChildren = $this->logic->getChildrenGoods($req->post());

        if (count($goodsChildren) === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        // 获取规格商品集合
        $ret = $this->specGoodsPriceLogic->getSpecByGoods($goodsChildren, $this->logic->getPrimaryKey());

        if (count($ret) === 0) {
            return AjaxReturn::error('沒有規格');
        }

        // 获取规格项
        $specItemArray = $this->goodsSpecItemLogic->getSpecItemName($ret, $this->specGoodsPriceLogic->getSplitKeyByGoods());

        if (count($specItemArray) === 0) {
            return AjaxReturn::error('无规格项，数据异常');
        }

        // 获取主规格
        $specialArray = $this->goodsSpecLogic->getGoodSpecial($specItemArray, $this->goodsSpecItemLogic->getSplitKeyBySpecial());

        return AjaxReturn::sendData([
            'goods' => $ret,
            'spec' => $specialArray
        ]);
    }
}