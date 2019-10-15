<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsItemLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller()
 * 店内排行榜
 *
 * @author Administrator
 */
class StoreRankingsController
{

    /**
     * @Inject()
     *
     * @var GoodsItemLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;

    /**
     * 获取店铺排行商品
     * @RequestMapping(route="getGoodsStoreRankingsList", method=RequestMethod::POST)
     * @Number(name="store_id", min=1)
     */
    public function getGoodsStoreRankingsListByShopMGXh(Request $req): array
    {
        $data = $this->logic->getGoodsByStoreRankingsCache($req->post());

        if (count($data) === 0) {
            return AjaxReturn::error('暂无数据');
        }

        $data = $this->goodsImagesLogic->getImageByArrayGoods($data);

        return AjaxReturn::sendData($data);
    }
}