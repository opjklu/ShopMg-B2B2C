<?php

namespace App\Controllers\Home;

use App\Models\Logic\Specific\IndexLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;

/**
 * @Controller(perfix="/homeIndex")
 * 首页控制器
 *
 * @author Administrator
 */
class HomeIndexController
{

    /**
     * @Inject()
     *
     * @var IndexLogic
     */
    private $logic;

    /**
     * 首页数据
     * @RequestMapping(route="home")
     */
    public function homeByShopMGFj(): array
    {
        $ret = $this->logic->getHomeInfo();

        return AjaxReturn::sendData($ret);
    }
}