<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

/**
 * 检查订单是否已支付
 *
 * @author Administrator
 *
 */
trait IsPayedTrait
{

    /**
     * 检查是否已支付
     */
    public function isCheckPay(array $post): bool
    {
        $orderStatus = $this->selectorderStatus($post);

        if (($length = count($orderStatus)) === 0) {
            $this->errorMessage = '订单数据错误';
            return false;
        }

        $model = $this->getMapperClassName();

        foreach ($orderStatus as $key => $value) {

            if ($value[$model::$orderStatus] != 1) {
                $this->errorMessage = '订单支付失败';
                return false;
            }
        }
        return true;
    }

    /**
     * 查询订单状态
     *
     * @return array
     */
    public function selectorderStatus(array $post): array
    {
        $model = $this->getMapperClassName();

        $field = [
            $model::$id,
            $model::$orderStatus
        ];

        $orderStatus = $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn($model::$id, explode(',', $post['order_id']))
            ->select();

        return $orderStatus;
    }

    /**
     * 检查数据
     *
     * @return array
     */
    public function getValidateByOrderCheck(): array
    {
        return [
            'order_id' => [
                'required' => '订单参数必传',
                'checkStringIsNumber' => '参数必须是以逗号组成的数字字符串'
            ]
        ];
    }
}