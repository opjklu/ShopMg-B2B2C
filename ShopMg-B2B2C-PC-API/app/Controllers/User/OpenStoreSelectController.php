<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\CallIsPayReturnClientTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OpenShopOrderLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Server\Bean\Annotation\Controller;

/**
 * 开店支付查询
 *
 * @author Administrator
 * @Controller(prefix="/openStoreSelect")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class OpenStoreSelectController
{

    use CallIsPayReturnClientTrait;



    /**
     * @Inject()
     *
     * @var OpenShopOrderLogic
     */
    private $logic;
}
