<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Common\TraitClass\GETConfigTrait;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/intnetInfomartion")
 * 网站底部数据
 * @author Administrator
 */
class IntnetInfomartionController
{
    use GETConfigTrait;

    /**
     * 关于我们相关
     * @RequestMapping(route="aboutEtcetera", method=RequestMethod::POST)
     */
    public function aboutEtceteraByShopMGKl(): array
    {
        return AjaxReturn::sendData($this->getGroupConfig('information_by_intnet'));
    }
}