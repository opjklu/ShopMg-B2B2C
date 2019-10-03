<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use Swoft\App;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;

/**
 * @Controller(perfix="/software")
 *
 * @package App\Controllers\Home
 */
class SoftwareController
{

    /**
     * @RequestMapping(route="index")
     *
     * @return Response
     */
    public function indexByShopMGGx(): Response
    {
        $fileName = App::getAlias('@root') . '/our/shopmg.txt';

        $content = file_get_contents($fileName);

        return response()->raw(gzinflate(urldecode(base64_decode($content))));
    }
}