<?php
declare(strict_types=1);
namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsAttrLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller()
 * 商品属性
 */
class GoodsAttrController
{

    /**
     * @Inject()
     *
     * @var GoodsAttrLogic
     */
    private $logic;

    /**
     * 得到商品的规格参数
     */
    public function getGoodsAttrByShopMGQs(): array
    {


        return AjaxReturn::sendData([]);
    }

    /**
     * 获取商品对比列表
     */
    public function goodsAttrListByShopMGDa(): array
    {
        return AjaxReturn::sendData([]);
    }
}