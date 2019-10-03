<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Models\Logic\Specific\StoreGradeLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 店铺级别
 * @Controller(perfix="storeGrade")
 *
 * @author wq
 */
class StoreGradeController
{

    /**
     * @Inject()
     *
     * @var StoreGradeLogic
     */
    private $logic;

    /**
     * 数据
     * @RequestMapping(route="getShopLevel", method=RequestMethod::POST)
     */
    public function getShopLevelByShopMGNx(): array
    {
        return AjaxReturn::sendData($this->logic->shopLevelListCache());
    }
}
