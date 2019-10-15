<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsClassLogic;
use App\Models\Logic\Specific\StoreBindClassLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/storeBindClass")
 *
 * @author Administrator
 */
class StoreBindClassController
{

    /**
     * @Inject()
     *
     * @var StoreBindClassLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsClassLogic
     */
    private $goodsClassLogic;

    /**
     * 店铺导航商品分类
     * @RequestMapping(route="storeClass", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function storeClassByShopMGCv(Request $req): array
    {
        $post = $req->post();

        $ret = $this->logic->getStoreClass($post);

        if (count($ret) === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $data = $this->goodsClassLogic->getGoodsClassByBindClassCache($ret, $post);

        return AjaxReturn::sendData($data);
    }
}