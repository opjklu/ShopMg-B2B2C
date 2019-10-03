<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\AdLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(perfix="/ad")
 * 广告控制器
 *
 * @author Administrator
 */
class AdController
{

    /**
     * @Inject()
     *
     * @var AdLogic
     */
    private $logic;

    /**
     * 获取抢购广告
     * @RequestMapping(route="getPanicAd", method=RequestMethod::POST)
     */
    public function getPanicAdByShopMGMf(): array
    {
        $data = $this->logic->getPanicAdByCache();

        if (0 === count($data)) {
            return AjaxReturn::error('没有抢购广告');
        }

        return AjaxReturn::sendData($data);
    }

    /**
     * 获取积分商城广告
     * @RequestMapping(route="getIntegralAd", method=RequestMethod::POST)
     */
    public function getIntegralAdByShopMGKj(): array
    {
        $data = $this->logic->getIntegralShopCityAdCache();

        if (0 === count($data)) {
            return AjaxReturn::error('没有积分商城广告');
        }

        return AjaxReturn::sendData($data);
    }
}