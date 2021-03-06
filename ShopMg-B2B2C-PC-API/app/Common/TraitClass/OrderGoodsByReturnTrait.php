<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
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

namespace App\Common\TraitClass;

use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\StoreLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 退货获取商品详情
 *
 * @author Administrator
 *
 */
trait OrderGoodsByReturnTrait
{

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;
    /** @noinspection AnnotationMissingUseInspection */

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * 订单详情
     * @RequestMapping(route="orderGoodsDetail", method=RequestMethod::POST)
     * @Number(name="order_id", min=1)
     * @Number(name="goods_id", min=1)
     * @Number(name="package_id", min=1, default = 1)
     */
    public function orderGoodsDetail(Request $req): array
    {
        $data = $this->logic->getOrderPackageGoodsInfoByOAndGId($req->post());

        if (0 === count($data)) {
            return AjaxReturn::error('订单详情异常');
        }

        $goodsData = $this->goodsLogic->getGoodsDetailCacheKey($data, $this->logic->getSplitKeyByGoods());

        if (0 === count($goodsData)) {
            return AjaxReturn::error('商品异常');
        }

        $img = $this->goodsImagesLogic->getThumbImagesByGoodsId($goodsData, $this->goodsLogic->getImagesByGoods());

        $storeData = $this->storeLogic->getInfo($data, $this->logic->getSplitKeyByStore());

        return AjaxReturn::sendData([
            'order_goods_info' => $data,
            'goods' => $goodsData,
            'img' => $img,
            'store' => $storeData
        ]);
    }
}