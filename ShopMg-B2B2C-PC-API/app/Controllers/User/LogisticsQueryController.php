<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\GETConfigTrait;
use App\Common\TraitClass\LogistTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\ExpressLogic;
use App\Models\Logic\Specific\OrderGoodsLogic;
use App\Models\Logic\Specific\OrderIntegralGoodsLogic;
use App\Models\Logic\Specific\OrderIntegralLogic;
use App\Models\Logic\Specific\OrderLogic;
use App\Models\Logic\Specific\OrderPackageGoodsLogic;
use App\Models\Logic\Specific\OrderPackageLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 物流查询
 *
 * @author Administrator
 * @Controller(prefix="/logisticsQuery")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class LogisticsQueryController
{

    use GETConfigTrait;

    use LogistTrait;

    /**
     * @Inject()
     *
     * @var ExpressLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var OrderLogic
     */
    private $orderLogic;

    /**
     * @Inject()
     *
     * @var OrderPackageLogic
     */
    private $orderPackageLogic;

    /**
     * @Inject()
     *
     * @var OrderIntegralLogic
     */
    private $orderIntegralLogic;

    /**
     * @Inject()
     *
     * @var OrderGoodsLogic
     */
    private $orderGoodsLogic;

    /**
     * @Inject()
     *
     * @var OrderPackageGoodsLogic
     */
    private $orderPackageGoodsLogic;

    /**
     * @Inject()
     *
     * @var OrderIntegralGoodsLogic
     */
    private $orderIntegralGoodsLogic;

    /**
     * 查看物流
     *
     * @author 米糕网络团队
     * @RequestMapping(route="lookGoodsExpress", method=RequestMethod::POST)
     * @Number(name="express_id", min=1)
     * @Number(name="exp_id", min=1)
     * @Number(name="id", min=1)
     * @Number(name="order_status", min=1)
     */
    public function lookGoodsExpressByShopMGPb(Request $req): array
    {
        $post = $req->post();

        $result = $this->logistQuery($post);

        $logist = json_decode($result[0]);

        if ($post['order_status'] === '3' && $logist->State === '3') {

            $status = $this->orderLogic->getOverTime($post);

            if (!$status) {
                return AjaxReturn::error('修改收货错误');
            }

            $status = $this->orderGoodsLogic->setOrderOverTime($post);

            if (!$status) {
                return AjaxReturn::error('修改收货错误');
            }
        }

        return AjaxReturn::sendData([
            'logist' => $result[0],
            'express' => $result[1]
        ]);
    }

    /**
     * 查看套餐订单物流
     *
     * @author 米糕网络团队
     * @RequestMapping(route="lookOrderPackageExpress", method=RequestMethod::POST)
     * @Number(name="express_id", min=1)
     * @Number(name="exp_id", min=1)
     * @Number(name="id", min=1)
     * @Number(name="order_status", min=1)
     */
    public function lookOrderPackageExpressByShopMGTu(Request $req): array
    {
        $post = $req->post();

        $result = $this->logistQuery($post);

        $logist = json_decode($result[0]);

        if ($post['order_status'] === '3' && $logist->State === '3') {

            $status = $this->orderPackageLogic->getOverTime($post);

            if (!$status) {
                return AjaxReturn::error('修改收货状态错误');
            }

            $status = $this->orderPackageGoodsLogic->setOrderOverTime($post);

            if (!$status) {
                return AjaxReturn::error('修改收货错误');
            }
        }

        return AjaxReturn::sendData([
            'logist' => $result[0],
            'express' => $result[1]
        ]);
    }

    /**
     * 查看积分订单物流
     *
     * @author 米糕网络团队
     * @RequestMapping(route="lookOrderIntegralExpress", method=RequestMethod::POST)
     * @Number(name="express_id", min=1)
     * @Number(name="exp_id", min=1)
     * @Number(name="id", min=1)
     * @Number(name="order_status", min=1)
     */
    public function lookOrderIntegralExpressByShopMGCq(Request $req): array
    {
        $post = $req->post();

        $result = $this->logistQuery($post);

        $logist = json_decode($result[0]);

        if ($post['order_status'] === '3' && $logist->State === '3') {

            $status = $this->orderIntegralLogic->getOverTime($post);

            if (!$status) {
                return AjaxReturn::error('修改收货状态错误');
            }

            $status = $this->orderIntegralGoodsLogic->setOrderOverTime($post);

            if (!$status) {
                return AjaxReturn::error('修改收货错误');
            }
        }

        return AjaxReturn::sendData([
            'logist' => $result[0],
            'express' => $result[1]
        ]);
    }
}