<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\StoreNavLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 店铺导航
 * @Controller(perfix="/storeNav")
 *
 * @author wq
 */
class StoreNavController
{

    /**
     * @Inject()
     *
     * @var StoreNavLogic
     */
    private $logic;

    /**
     * 店铺导航
     * @RequestMapping(route="storeNav", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function storeNavByShopMGBv(Request $req): array
    {
        $ret = $this->logic->getStoreNav($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无导航');
        }

        return AjaxReturn::sendData($ret);
    }
}