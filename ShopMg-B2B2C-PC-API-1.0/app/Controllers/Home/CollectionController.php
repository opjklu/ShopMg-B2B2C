<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CollectionLogic;
use App\Models\Logic\Specific\GoodsCartLogic;
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
 * @Controller(perfix="collection")
 * @Middleware(ValidateLoginMiddleware::class)
 * 收藏控制器
 */
class CollectionController
{

    /**
     * @Inject()
     *
     * @var CollectionLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsCartLogic
     */
    private $goodsCartLogic;

    /**
     * 购物车移入收藏
     * @RequestMapping(route="addCollection", method=RequestMethod::POST)
     * @Number(name="goods_id", min=1)
     * @Number(name="id", min=1)
     */
    public function addCollectionByShopMGKc(Request $req): array
    {
        $post = $req->post();

        $ret = $this->logic->collectGoods($post);

        if (!$ret) {
            return AjaxReturn::error('添加失败');
        }

        $status = $this->goodsCartLogic->delGoodsCartOneByTrancestation($post);

        if (!$status) {
            return AjaxReturn::error($this->goodsCartLogic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 购物车批量移入收藏
     * @RequestMapping(route="addBatchCollection", method=RequestMethod::POST)
     */
    public function addBatchCollectionByShopMGVj(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidate(), $post);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->batchCollectGoods($post);

        if (!$ret) {
            return AjaxReturn::error('添加失败');
        }

        $status = $this->goodsCartLogic->delManyGoodsCartsTrancsation($post);

        if (!$status) {
            return AjaxReturn::error($this->goodsCartLogic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 收藏商品
     * @RequestMapping(route="collectionGoods", method=RequestMethod::POST)
     * @Number(name="goods_id", min=1)
     */
    public function collectionGoodsByShopMGCv(Request $req): array
    {
        $ret = $this->logic->getCollectGoods($req->post());

        if (!$ret) {
            return AjaxReturn::error('收藏失败');
        }
        return AjaxReturn::sendData('');
    }
}