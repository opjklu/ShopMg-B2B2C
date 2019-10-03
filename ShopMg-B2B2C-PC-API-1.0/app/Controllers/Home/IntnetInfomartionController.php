<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Common\TraitClass\GETConfigTrait;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Tool\AjaxReturn;

/**
 * @Controller(perfix="/intnetInfomartion")
 * 网站底部数据
 *
 * @author Administrator
 */
class IntnetInfomartionController
{
    use GETConfigTrait;

    /**
     * 关于我们相关
     */
    public function aboutEtceteraByShopMGKl(): array
    {
        $data = $this->getGroupConfig('information_by_intnet');

        return AjaxReturn::sendData($data);
    }
}