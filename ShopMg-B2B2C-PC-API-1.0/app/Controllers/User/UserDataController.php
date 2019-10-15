<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\UserDataLogic;
use App\Models\Logic\Specific\UserLevelLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 用户数据
 *
 * @author wq
 * @Controller(prefix="/userData")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class UserDataController
{

    /**
     * @Inject()
     *
     * @var UserDataLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var UserLevelLogic
     */
    private $userLevelLogic;

    /**
     * 获取积分(无缓存)
     * @RequestMapping(route="getIntegral", method=RequestMethod::POST)
     *
     * @return array
     */
    public function getIntegralByShopMGRj(): array
    {
        $ret = $this->logic->getIntegralAndSaveSession();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 获取积分(缓存)
     * @RequestMapping(route="getIntegralCache", method=RequestMethod::POST)
     *
     * @return array
     */
    public function getIntegralCacheByShopMGSc(): array
    {
        $ret = $this->logic->getIntegralByUserIdCache();

        return AjaxReturn::sendData($ret);
    }

    /**
     * 等级列表
     * @RequestMapping(route="getLevel", method=RequestMethod::POST)
     */
    public function getLevelByShopMGEu(): array
    {
        $ret = $this->logic->getIntegralByUserIdCache();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $data = $this->userLevelLogic->parseUserNextLevel($ret, $this->logic->getSplitKeyByIntegral());

        return AjaxReturn::sendData($data);
    }
}
