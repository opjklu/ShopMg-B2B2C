<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\AdLogic;
use App\Models\Logic\Specific\GoodsClassLogic;
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
 * @Controller(perfix="/floor")
 * 首页楼层
 *
 * @author Administrator
 */
class FloorController
{

    /**
     * @Inject()
     *
     * @var GoodsClassLogic
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
    private $goodsImagesLogic;

    /**
     * @Inject()
     *
     * @var AdLogic
     */
    private $adLogic;

    /**
     * 首页楼层数据
     *
     * @author 米糕网络团队
     * @RequestMapping(route="homefLoor", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function homefLoorByShopMGLs(Request $req): array
    {
        $param = $req->post();

        $goodsClass = $this->logic->getClassByPage($param);

        $twoClass = $this->logic->getClassTwoByOneCache($goodsClass);

        // 新品推荐
        $newArrivals = $this->goodsLogic->newArrivals($goodsClass);

        $newArrivals = $this->goodsImagesLogic->getImageByArrayGoods($newArrivals);

        // 热卖商品
        $hotSellingGoods = $this->goodsLogic->hotSellingGoods($goodsClass);

        $hotSellingGoods = $this->goodsImagesLogic->getImageByArrayGoods($hotSellingGoods);

        // 疯狂抢购
        $panicBuying = $this->goodsLogic->panicBuying($goodsClass);

        $panicBuying = $this->goodsImagesLogic->getImageByArrayGoods($panicBuying);

        // 猜你喜欢
        $guessWhatYouLike = $this->goodsLogic->guessWhatYouLike($goodsClass);

        $guessWhatYouLike = $this->goodsImagesLogic->getImageByArrayGoods($guessWhatYouLike);

        // 楼层底部广告
        $floorAdvertising = $this->adLogic->floorAdvertisingCache($param);

        // 楼层中间广告
        $floorAdvertisement = $this->adLogic->floorAdvertisementCache($param);

        return AjaxReturn::sendData([
            'goods_news' => $newArrivals,
            'hotGoods' => $hotSellingGoods,
            'rushGoods' => $panicBuying,
            'loveGoods' => $guessWhatYouLike,
            'button' => $floorAdvertising,
            'middle' => $floorAdvertisement,
            'floor' => $goodsClass,
            'classTwo' => $twoClass
        ]);
    }
}