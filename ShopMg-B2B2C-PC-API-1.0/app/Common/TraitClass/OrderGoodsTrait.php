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
// |简单与丰富！让外表简单一点，内涵就会更丰富一点。
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

use Tool\SessionManager;

/**
 * 订单商品组件
 *
 * @author Administrator
 *
 */
trait OrderGoodsTrait
{

    /**
     * 查询购买数量
     *
     * @return array
     */
    public function getPurchaseQuantity(array $data, string $splitKey): array
    {
        $model = $this->getMapperClassName();

        return $this->getQueryBuilderProxy()
            ->field($this->getCoulmByPay())
            ->condition([
                $model::$orderId => $data[$splitKey],
                $model::$userId => session()->get('user_id'),
                $model::$status => 0
            ])
            ->select();
    }

    /**
     * 计算购买数量
     */
    public function statisticalPurchaseQuantity(array $data, string $splitKey): bool
    {
        $data = $this->getPurchaseQuantity($data, $splitKey);

        if (count($data) === 0) {
            $this->errorMessage = '商品信息有误';
            return false;
        }

        $goodsNumById = [];

        $orderGoodsData = [];

        $model = $this->getMapperClassName();

        $i = 0;

        foreach ($data as $key => $value) {
            $goodsNumById[$value[$model::$goodsId]] = $value[$model::$goodsNum];

            $orderGoodsData[$i] = [
                'goods_num' => $value[$model::$goodsNum],
                'goods_price' => $value['goods_price'],
                'goods_id' => $value['goods_id']
            ];

            $i++;
        }

        SessionManager::SET_GOODS_ID_BY_USER($goodsNumById);

        SessionManager::SET_ORDER_GOODS_DATA($orderGoodsData);

        return true;
    }

    protected function getCoulmByPay(): array
    {
        $model = $this->getMapperClassName();

        return [
            $model::$goodsNum,
            $model::$goodsPrice,
            $model::$goodsId
        ];
    }
}