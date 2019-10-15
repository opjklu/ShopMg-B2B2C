<?php

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsRestrictionsLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;

/**
 * @Controller()
 *
 * @author Administrator
 *
 */
class GoodsRestrictionsController
{

    /**
     * @Inject()
     *
     * @var GoodsRestrictionsLogic
     */
    private $logic;

    /**
     * 数据
     *
     * @RequestMapping(route="getRestrictionGoods")
     */
    public function getRestrictionGoodsByShopMGOx(Request $req): array
    {
        return [];
    }
}