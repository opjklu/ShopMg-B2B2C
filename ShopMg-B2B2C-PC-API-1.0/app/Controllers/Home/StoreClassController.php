<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\StoreClassLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(perfix="storeClass")
 *
 * @author Administrator
 */
class StoreClassController
{

    /**
     * @Inject()
     *
     * @var StoreClassLogic
     */
    private $logic;

    /**
     * 店铺分类
     * @RequestMapping(route="storeClasses", method=RequestMethod::POST)
     */
    public function storeClassesByShopMGQj(Request $req): array
    {
        return AjaxReturn::sendData($this->logic->getStoreClass());
    }
}