<?php
declare(strict_types=1);

namespace App\Controllers\Home;

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
 * @Controller(prefix="/recommendedSale")
 *
 * @author wq
 */
class RecommendedSaleController
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
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;

    /**
     * 商品热卖方法
     *
     * @var array
     */
    private $method = [
        'hotSellingGoods',
        'hotSellingGoodsAll'
    ];

    /**
     * 新品推荐
     *
     * @var array
     */
    private $methodNewArrivals = [
        'newArrivals',
        'newArrivalsAll'
    ];

    /**
     * 热卖推荐
     *
     * @var array
     */
    private $methodHotSale = [
        'hotSellingGoods',
        'hotSellingGoodsAll'
    ];

    /**
     * 获取热卖列表
     * @RequestMapping(route="getGoodsList", method=RequestMethod::POST)
     * @Number(name="id", min=0)
     */
    public function getGoodsListByShopMGDu(Request $req): array
    {
        $post = $req->post();

        $index = (int)$post['id'] === '0';

        $method = $this->method[$index];

        // 热卖商品
        $hotSellingGoods = $this->logic->$method($post);

        if (0 === count($hotSellingGoods)) {
            return AjaxReturn::error('暂无商品');
        }
        $hotSellingGoods = $this->goodsImagesLogic->getImageByArrayGoods($hotSellingGoods);

        return AjaxReturn::sendData($hotSellingGoods);
    }

    /**
     * 新品推荐
     * @RequestMapping(route="newRecommend", method=RequestMethod::POST)
     * @Number(name="id", min=0)
     */
    public function newRecommendByShopMGXt(Request $req): array
    {
        $post = $req->post();

        $index = (int)$post['id'] === '0';

        $method = $this->methodNewArrivals[$index];

        $ret = $this->logic->$method($post);
        if (0 === count($ret)) {
            return AjaxReturn::error('暂无数据');
        }

        $ret = $this->goodsImagesLogic->getImageByArrayGoods($ret);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 热卖推荐
     * @RequestMapping(route="hotSale", method=RequestMethod::POST)
     * @Number(name="id", min=0)
     */
    public function hotSaleByShopMGKv(Request $req): array
    {
        $post = $req->post();

        $index = (int)$post['id'] === '0';

        $method = $this->methodNewArrivals[$index];

        $ret = $this->logic->$method($post);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $ret = $this->goodsImagesLogic->getImageByArrayGoods($ret);

        return AjaxReturn::sendData($ret);
    }
}
