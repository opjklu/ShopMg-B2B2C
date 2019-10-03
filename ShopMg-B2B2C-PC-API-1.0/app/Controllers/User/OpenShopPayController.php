<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
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
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\DispatcherPayTrait;
use App\Models\Logic\Specific\OpenShopOrderLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 开店支付
 * @Controller(perfix="/openShopPay")
 *
 * @author Administrator
 */
class OpenShopPayController
{
    use DispatcherPayTrait;

    /**
     * @Inject()
     *
     * @var OpenShopOrderLogic
     */
    private $openShopOrderLogic;

    /**
     * 支付类型处理
     *
     * @var array
     */
    private $payName = [
        'Pay\\OpenShopByWxPay',
        'Pay\\OpenShopByAlipayPay',
        'Pay\\OpenShopByUnionPay',
        'Pay\\OpenShopByAlipayPay'
    ];

    /**
     * 通知控制器及其action
     *
     * @var array
     */
    private $notifyURL = [
        '/openShopNofity/alipayNotify',
        '/openShopNofity/alipayNotify',
        '/openShopNofity/unionNotify',
        '/openShopNofity/balanceNotify'
    ];

    /**
     *
     * @var string
     */
    private $reuturnURL = [
        '/OpenShopNofity/wxNotify',
        '/lookProgress',
        '/unionNotify',
        '//OpenShopNofity/balanceNotify'
    ];

    /**
     * 开店处理
     * @RequestMapping(route="openShop", method=RequestMethod::POST)
     * @Number(name="pay_type_id", min=1)
     */
    public function openShopByShopMGWh(Request $req)
    {
        $post = $req->post();

        $storeData = session()->get('store_data_by_person');

        if (0 === count($storeData)) {
            return AjaxReturn::error('店铺数据异常');
        }

        // 余额充值
        $post['platform'] = 0;

        $post['special_status'] = 3;

        $payConfig = $this->logic->getPayInfoByType($post, $req->getCookieParams());

        if (0 === count($payConfig)) {

            return AjaxReturn::error('无法获取支付配置');
        }

        $receive = $this->openShopOrderLogic->pushOpenShopOrder($storeData);

        if (0 === count($receive)) {
            return AjaxReturn::error('无法生成开店订单');
        }

        $receive['store_type'] = $storeData['type'];

        $receive['money'] = session()->get('money');

        $result = $this->dispatcherPay($payConfig, $receive, $post);

        if (0 === count($result)) {
            return AjaxReturn::error($this->errorMessage);
        }

        return $result;
    }
}