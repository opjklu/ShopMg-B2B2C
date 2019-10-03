<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
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
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Common\TraitClass;

use App\Models\Logic\Specific\ExpressLogic;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\InvoiceTypeLogic;
use App\Models\Logic\Specific\OrderPackageInvoiceLogic;
use App\Models\Logic\Specific\PayTypeLogic;
use App\Models\Logic\Specific\RegionLogic;
use App\Models\Logic\Specific\StoreLogic;
use App\Models\Logic\Specific\UserAddressLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;

/**
 * 根据订单信息获取商品信息
 *
 * @author Administrator
 *
 */
trait GetGoodsInforByOrderTrait
{

    /**
     * @Inject()
     *
     * @var UserAddressLogic
     */
    private $userAddressLogic;

    /**
     * @Inject()
     *
     * @var RegionLogic
     */
    private $regionLogic;

    /**
     * @Inject()
     *
     * @var OrderPackageInvoiceLogic
     */
    private $orderPackageInvoiceLogic;

    /**
     * @Inject()
     *
     * @var ExpressLogic
     */
    private $expressLogic;

    /**
     * @Inject()
     *
     * @var PayTypeLogic
     */
    private $payeTypeLogic;

    /**
     * @Inject()
     *
     * @var InvoiceTypeLogic
     */
    private $invoiceTypeLogic;

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * 获取商品信息
     * @RequestMapping(route="getOrderDetail", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function getOrderDetail(Request $req): array
    {
        $data = $this->logic->getOrderDetail($req->post());

        if (0 === count($data)) {
            return [
                'status' => 0,
                'message' => '暂无数据',
                'data' => ''
            ];
        }

        $orderInfo = $this->orderRelatedLogic->getOrderGoodsById($data);

        if (0 === count($orderInfo)) {
            return [
                'status' => 0,
                'message' => '暂无数据',
                'data' => ''
            ];
        }

        $goodsData = $this->goodsLogic->getGoodsByData($orderInfo, $this->orderRelatedLogic->getSplitKeyByGoods());

        $goodsData = $this->goodsImagesLogic->getImageByArrayGoods($goodsData);

        $address = $this->userAddressLogic->getAddressByOrder($data, $this->logic->getSplitKeyByAddress());

        $address = $this->regionLogic->getAddressDataCache($address);

        // 发票
        $invoice = $this->orderPackageInvoiceLogic->isOpenInvoice($data);

        $invoiceType = $this->invoiceTypeLogic->isOpenInvoice($invoice, $this->orderPackageInvoiceLogic->getSplitKeyByType());

        // 支付类型
        $payData = $this->payeTypeLogic->isPayedCache($data, $this->logic->getSplitKeyByPayType());

        $expData = $this->expressLogic->isDeliverGoods($data, $this->logic->getSplitKeyByExp());

        $storeData = $this->storeLogic->getInfo($data, $this->logic->getSplitKeyByStore());

        return [
            'status' => 1,
            'message' => '成功',
            'data' => [
                'order' => array_merge($payData, $expData, $data),
                'goods' => $goodsData,
                'address' => $address,
                'store' => $storeData
            ]
        ];
    }
}