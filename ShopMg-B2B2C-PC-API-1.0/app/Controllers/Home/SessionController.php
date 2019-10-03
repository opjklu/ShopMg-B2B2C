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

use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;

/**
 * @Controller(prefix="/session")
 */
class SessionController
{

    /**
     * @RequestMapping()
     *
     * @return array
     */
    public function dumpByShopMGJg(): array
    {
        return session()->all();
    }

    /**
     * @RequestMapping()
     *
     * @param Request $request
     * @return array
     */
    public function setByShopMGMc(Request $request): array
    {
        $key = $request->input('key');
        $value = $request->input('value');
        session()->put([
            $key => $value
        ]);
        return session()->all();
    }

    /**
     * @RequestMapping()
     *
     * @param Request $request
     * @return array
     */
    public function removeByShopMGKb(Request $request): array
    {
        $key = $request->input('key');
        session()->remove($key);
        return session()->all();
    }

    /**
     * @RequestMapping()
     */
    public function flushByShopMGAi(): array
    {
        session()->flush();
        return session()->all();
    }

    /**
     * @RequestMapping()
     */
    public function regenerateIdByShopMGPx(): array
    {
        return session()->migrate(true);
    }
}