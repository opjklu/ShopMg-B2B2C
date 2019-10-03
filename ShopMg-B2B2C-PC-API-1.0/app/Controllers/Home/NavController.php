<?php

namespace App\Controllers\Home;

use App\Models\Logic\Specific\NavLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(perfix="/Nav")
 *
 * @author Administrator
 */
class NavController
{

    /**
     * @Inject()
     *
     * @var NavLogic
     */
    private $logic;

    /**
     * 获取导航列表
     * @RequestMapping(route="getNavList", method=RequestMethod::POST)
     */
    public function getNavListByShopMGDt(): array
    {
        $res = $this->logic->getPCNav();

        return AjaxReturn::sendData($res);
    }
}