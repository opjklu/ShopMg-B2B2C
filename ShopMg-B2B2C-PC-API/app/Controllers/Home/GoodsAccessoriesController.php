<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsAccessoriesLogic;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller()
 * 搭配配件
 */
class GoodsAccessoriesController
{

    /**
     * @Inject()
     *
     * @var GoodsAccessoriesLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * 得到搭配配件
     *
     * @RequestMapping(route="matchGood", method=RequestMethod::POST)
     * @Number(name="goods_id", min=0)
     */
    public function matchGoodByShopMGGg(Request $req): array
    {
        $ret = $this->logic->getComplementaryCommodities($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $goods = $this->goodsLogic->getGoodsCombo($ret);

        if (0 === count($goods)) {
            return AjaxReturn::error('商品配置错误');
        }

        $ret = $this->goodsImagesLogic->getImageByArrayGoods($goods);

        return AjaxReturn::sendData($ret);
    }
}