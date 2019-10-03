<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

use Tool\SessionManager;

/**
 * 普通订单套餐订单 订单列表里面的立即支付
 *
 * @author Administrator
 *
 */
trait OrderAndPackageTrait
{

    /**
     * 组装支付数据
     *
     * @return array
     */
    public function orderPayBuildData(array $post): bool
    {
        $model = $this->getMapperClassName();

        $field = [
            $model::$priceSum,
            $model::$shippingMonery,
            $model::$storeId,
            $model::$id,
            $model::$couponDeductible
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition([
                'id' => $post['id'],
                'user_id' => session()->get('user_id'),
                'order_status' => 0
            ])
            ->find();

        if (0 === count($data)) {
            $this->errorMessage = '订单错误';
            return false;
        }

        $totalMoney = $data[$model::$priceSum] + $data[$model::$shippingMonery] - $data[$model::$couponDeductible];

        if ($totalMoney <= 0) {
            $this->errorMessage = '订单金额错误';
            return false;
        }

        $payData = [];

        $payData[0] = [
            'order_id' => $data[$model::$id],
            'store_id' => $data[$model::$storeId],
            'total_money' => sprintf('%.2f', $totalMoney)
        ];

        SessionManager::SET_ORDER_DATA($payData);

        return true;
    }
}