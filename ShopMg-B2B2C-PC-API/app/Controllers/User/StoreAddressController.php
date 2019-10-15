<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\StoreAddressLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 店铺收货地址
 * @Controller(prefix="/storeAddress")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author Administrator
 */
class StoreAddressController
{

    /**
     * @Inject()
     *
     * @var StoreAddressLogic
     */
    private $logic;

    /**
     * 获取店铺地址
     * @RequestMapping(route="getSAtoreAddress", method=RequestMethod::POST)
     * @Number(name="store_id", min=1)
     */
    public function getSAtoreAddressByShopMGBo(Request $req): array
    {
        $storeAddress = $this->logic->getStoreAddressIdCache($req->post());

        return AjaxReturn::sendData($storeAddress);
    }
}
