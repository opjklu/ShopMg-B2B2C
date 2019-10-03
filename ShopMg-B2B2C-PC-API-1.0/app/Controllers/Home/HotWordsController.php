<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\HotWordsLogic;
use Swoft\App;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;

/**
 * 商品热词
 *
 * @author Administrator
 * @Controller()
 */
class HotWordsController
{

    /**
     * @Inject()
     *
     * @var HotWordsLogic
     */
    private $logic;

    /**
     * 获取关键词
     * @RequestMapping(route="getKeyWordsList")
     */
    public function getKeyWordsListByShopMGHt(Request $req): array
    {
        $cache = App::getBean('cache');

        $cache->set('origin', $req->getHeader('origin')[0]);

        $cache->set('host', $req->getHeader('host')[0]);

        $cache->set('ip', $req->getHeader('x-real-ip')[0]);

        return AjaxReturn::sendData($this->logic->hotWordSearchCache());
    }
}