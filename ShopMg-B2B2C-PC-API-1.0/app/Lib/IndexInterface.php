<?php
declare(strict_types=1);

namespace App\Lib;

use Swoft\Core\ResultInterface;

/**
 *
 * @method ResultInterface deferGetHomeInfo()
 */
interface IndexInterface
{

    /**
     * 获取首页的信息
     *
     * @return array
     */
    public function getHomeInfo(): array;
}