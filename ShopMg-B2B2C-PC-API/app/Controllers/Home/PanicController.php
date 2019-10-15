<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\PanicLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(perdix="/panic")
 *
 * @author Administrator
 */
class PanicController
{

    /**
     * @Inject()
     *
     * @var PanicLogic
     */
    private $logic;

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
    private $goodsImageLogic;

    /**
     * 得到抢购商品信息数据
     * @RequestMapping(route="getPanicGoods", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function getPanicGoodsByShopMGNg(Request $req): array
    {
        $ret = $this->logic->getParseDataByListNoSearch($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }

        $ret['data'] = $this->goodsLogic->getGoodsByData($ret['data'], $this->logic->getSplitKeyByGoods());

        $ret['data'] = $this->goodsImageLogic->getImageByArrayGoods($ret['data']);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 抢购内页
     * @RequestMapping(route="getInnerPanic", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function getInnerPanicByShopMGUv(Request $req): array
    {
        $ret = $this->logic->innerPanicCache($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无抢购商品');
        }

        $goods = $this->goodsLogic->getGoodsDetailCacheKey($ret, $this->logic->getSplitKeyByGoods());

        $images = $this->goodsImageLogic->getGoodsImagesByPidCache($goods, $this->goodsLogic->getSplitKeyByPid());

        // 存入redis
        $this->logic->redisOperation($goods, $ret);

        return AjaxReturn::sendData([
            'panic' => array_merge($goods, $ret),
            'images' => $images
        ]);
    }

    /**
     * 本周热门抢购
     * @RequestMapping(route="hotBuyThisWeek", method=RequestMethod::POST)
     */
    public function hotBuyThisWeekByShopMGEn(): array
    {
        $ret = $this->logic->getHotBuyThisWeekByCache();

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无数据');
        }

        $ret = $this->goodsLogic->getGoodsByData($ret, $this->logic->getSplitKeyByGoods());

        $ret = $this->goodsImageLogic->getImageByArrayGoods($ret);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 商品评论接口
     * @RequestMapping(route="goodsComment", method=RequestMethod::POST)
     */
    public function goodsCommentByShopMGTm(): array
    {
        $ret = $this->logic->getGoodsComment();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret['data'], $ret['status'], $ret['message']);
    }
}