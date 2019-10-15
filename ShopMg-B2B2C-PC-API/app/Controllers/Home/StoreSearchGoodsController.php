<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller(prefix="/storeSearchGoods")
 *
 * @author wq
 */
class StoreSearchGoodsController
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
     * 商品详情 店内搜索
     * @RequestMapping(route="searchGoodsList", method=RequestMethod::POST)
     */
    public function searchGoodsListByShopMGKx(Request $req): array
    {
        $post = $req->post();
        
        $checkParam = new CheckParam($this->logic->getValidateByShopSearch(), $post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }

        $goodsData = $this->logic->searchListByStore($post);

        if (0 === count($goodsData['data'])) {
            return AjaxReturn::error('暂无商品');
        }

        $goodsData['data'] = $this->goodsImagesLogic->getImageByArrayGoods($goodsData['data']);

        return AjaxReturn::sendData($goodsData);
    }

    /**
     * 店内搜索商品
     * @RequestMapping(route="getGoodsInStore", method={RequestMethod::POST})
     * @param Request $req
     * @return array
     */
    public function getGoodsInStoreByShopMGAa(Request $req): array
    {
        $post = $req->post();
        
        $checkParam = new CheckParam($this->logic->vlidateParam(),$post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }

        $data = $this->logic->getParseDataByList($post);

        if (0 === count($data['data'])) {
            return AjaxReturn::error('暂无商品');
        }

        $data['data'] = $this->goodsImagesLogic->getImageByArrayGoods($data['data']);

        return AjaxReturn::sendData($data);
    }
}
