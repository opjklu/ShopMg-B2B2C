<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsComboLogic;
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
 * @Controller(prefix="/goodsCombo")
 */
class GoodsComboController
{

    /**
     * @Inject()
     *
     * @var GoodsComboLogic
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
     * 得到最佳组合
     *
     * @RequestMapping(route="matchGood", method=RequestMethod::POST)
     * @Number(name="goods_id", min=1)
     */
    public function matchGoodByShopMGGq(Request $req): array
    {
        $ret = $this->logic->getComplementaryCommodities($req->post());

        if (count($ret) === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $goods = $this->goodsLogic->getGoodsCombo($ret);

        if (0 === count($goods)) {
            return AjaxReturn::error('商品配置错误');
        }

        $goods = $this->goodsImageLogic->getImageByArrayGoods($goods, $this->goodsLogic->getSplitKeyByPid());

        return AjaxReturn::sendData($ret);
    }
}