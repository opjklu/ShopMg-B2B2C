<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsDetailLogic;
use Swoft\App;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Cache\Cache;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;

/**
 * @Controller(perfix="/goodsDetail")
 * 商品图文详情
 *
 * @author Administrator
 *
 */
class GoodsDetailController
{

    /**
     * @Inject()
     *
     * @var GoodsDetailLogic
     */
    private $logic;

    /**
     * 商品图文详情
     * @RequestMapping(route="getGoodsDetail")
     * @Number(name="goods_id", min=0)
     */
    public function getGoodsDetailByShopMGPx(Request $req): array
    {
        $cache = App::getBean('cache');

        $cache->set('origin', $req->getHeader('origin')[0]);

        $cache->set('host', $req->getHeader('host')[0]);

        $cache->set('ip', $req->getHeader('x-real-ip')[0]);

        return AjaxReturn::sendData($this->logic->getGoodDetail($req->post()));
    }
}