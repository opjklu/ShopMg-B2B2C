<?php

namespace App\Controllers\Home;

use App\Models\Logic\Specific\StoreEvaluateLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/storeEvaluate")
 *
 * @author wq
 *
 */
class StoreEvaluateController
{

    /**
     * @Inject()
     *
     * @var StoreEvaluateLogic
     */
    private $logic;

    /**
     * 获取店铺动态评分
     * @RequestMapping(route="getTheStoreDynamicRating", method=RequestMethod::POST)
     * @Number(name="store_id", min=1)
     */
    public function getTheStoreDynamicRatingByShopMGMp(Request $req): array
    {
        return AjaxReturn::sendData($this->logic->getStoreScore($req->post()));
    }
}
