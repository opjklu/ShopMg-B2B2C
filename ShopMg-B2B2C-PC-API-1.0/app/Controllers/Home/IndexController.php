<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Controllers\Home;

use App\Lib\IndexInterface;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Rpc\Client\Bean\Annotation\Reference;

/**
 * @Controller(perfix="/index")
 * Class IndexController
 */
class IndexController
{

    /**
     * @Reference(name="user")
     *
     * @var IndexInterface
     */
    private $indexService;

    /**
     * @RequestMapping(route="getHomeInfo")
     *
     * @return array
     */
    public function getHomeInfoByShopMGMd(): array
    {
        return $this->indexService->getHomeInfo();
    }
}
