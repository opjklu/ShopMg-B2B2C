<?php
declare(strict_types=1);

// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 wq.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://wq.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\StoreJoinCompanyLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 待审核店铺(企业)
 *
 * @author Administrator
 * @Controller(prefix="/companyStoreAduitProgress")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class CompanyStoreAduitProgressController
{

    /**
     * @Inject()
     *
     * @var StoreJoinCompanyLogic
     */
    private $logic;

    /**
     * 获取用户店铺(
     * @RequestMapping(route="getStoreByUser", method=RequestMethod::POST)
     */
    public function getStoreByUserByShopMGDo(): array
    {
        $data = $this->logic->getStoreInfo();

        if (0 === count($data)) {
            return AjaxReturn::error('暂无数据');
        }

        return AjaxReturn::sendData($data);
    }
}
