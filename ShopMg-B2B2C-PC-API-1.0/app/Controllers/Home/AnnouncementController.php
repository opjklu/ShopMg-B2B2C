<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\AnnouncementLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/announcement")
 * 公告控制器
 *
 * @author Administrator
 */
class AnnouncementController
{

    /**
     * @Inject()
     *
     * @var AnnouncementLogic
     */
    private $logic;

    /**
     * @RequestMapping(route="announcement", method=RequestMethod::POST)
     */
    public function announcementByShopMGOe(): array
    {
        return AjaxReturn::sendData($this->logic->getAllAnnoucementCache());
    }
}