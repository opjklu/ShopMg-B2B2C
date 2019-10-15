<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\CollectionLogic;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsItemLogic;
use Search\Goods\GoodsSearchContext;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/goodsSearhByList")
 *
 * @author wq
 */
class GoodsSearhByListController
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
     * @Inject()
     *
     * @var CollectionLogic
     */
    private $collectionLogic;

    /**
     * 获取商品列表页
     * 1 商品分类
     * 2 商品品牌
     * 3 商品价格
     * -----------------------------
     * 1 销量
     * 2 价格
     * 3 自营
     * -----------------------------------
     * @RequestMapping(route="goodsList", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function goodsListByShopMGHh(Request $req): array
    {
        $post = $req->post();

        // 处理条件
        $condition = GoodsSearchContext::getInstance($post)->start();

        $result = $this->logic->goodsList($condition, $post);

        if (0 === count($result['list'])) {
            return AjaxReturn::error('暂无数据');
        }

        $result['list'] = $this->goodsImagesLogic->getImageByArrayGoods($result['list']);

        // 判断是否已收藏

        $result['list'] = $this->collectionLogic->checkAlreadyCollect($result['list']);

        return AjaxReturn::sendData($result);
    }
}