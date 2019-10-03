<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\RegionLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(perfix="region")
 *
 * @author wq
 */
class RegionController
{

    /**
     * @Inject()
     *
     * @var RegionLogic
     */
    private $logic;

    /**
     * 获取省级列表
     * @RequestMapping(route="regionLists", method=RequestMethod::POST)
     * @Number(name="parent_id", min=0)
     */
    public function regionListsByShopMGHd(Request $req): array
    {
        $ret = $this->logic->regionLists($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无地区');
        }

        return AjaxReturn::sendData($ret);
    }
}
