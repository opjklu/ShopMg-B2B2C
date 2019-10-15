<?php

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\NewsLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Bean\Annotation\Number;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/news")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class NewsController
{

    /**
     * @Inject()
     *
     * @var NewsLogic
     */
    private $logic;

    /**
     * @RequestMapping(route="lists", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function listsByShopMGDk(Request $req): array
    {

        $ret = $this->logic->getParseDataByListNoSearch($req->post()); // 逻辑处理

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        } // 获取失败提示并返回

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * 查看我的消息详情
     * @RequestMapping(route="info", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function infoByShopMGDn(Request $req): array
    {

        $ret = $this->logic->info(); // 逻辑处理

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        } // 获取失败提示并返回

        return AjaxReturn::sendData($ret); // 返回数据
    }
}
