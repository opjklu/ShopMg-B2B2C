<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\StoreAdvLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/storeAdv")
 *
 * @author wq
 */
class StoreAdvController
{

    /**
     * @Inject()
     *
     * @var StoreAdvLogic
     */
    private $logic;

    /**
     * 获取店铺banner
     * @RequestMapping(route="getBanner", method=RequestMethod::POST)
     * @Number(name="store_id", min=1)
     */
    public function getBannerByShopMGOc(Request $req): array
    {
        $data = $this->logic->getBanner($req->post());

        if (0 === count($data)) {
            return AjaxReturn::error('暂无广告');
        }

        return AjaxReturn::sendData($data);
    }

    /**
     * 获取店铺首页不规则图片
     * @RequestMapping(route="getIrregular", method=RequestMethod::POST)
     * @Number(name="store_id", min=1)
     */
    public function getIrregularByShopMGAs(Request $req): array
    {
        $data = $this->logic->getBannerButton($req->post());

        return AjaxReturn::sendData($data);
    }

    /**
     * 获取店铺下面的广告
     * @RequestMapping(route="getButton", method=RequestMethod::POST)
     * @Number(name="store_id", min=1)
     */
    public function getButtonByShopMGJj(Request $req): array
    {
        return AjaxReturn::sendData($this->logic->getStoreButtonImg($req->post()));
    }
}
