<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsCartLogic;
use App\Models\Logic\Specific\GoodsLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller()
 * 添加购物车
 *
 * @author Administrator
 */
class AddGoodsCartController
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
     * @var GoodsCartLogic
     */
    private $goodsCartLogic;

    /**
     * 添加多个商品
     * @RequestMapping(route="addAll", method=RequestMethod::POST)
     */
    public function addAllByShopMGDg(Request $req): array
    {
        $post = $req->post();

        $checkParam = new CheckParam($this->logic->getValidateByContrast(), $post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::sendData('', 0, $checkParam->getErrorMessage());
        }

        $data = $this->logic->checkGoodsStock($post);

        if (count($data) === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $status = $this->goodsCartLogic->addCarAll($data, $this->logic->getPrimaryKey());

        if ($status === false) {
            return AjaxReturn::error($this->goodsCartLogic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}