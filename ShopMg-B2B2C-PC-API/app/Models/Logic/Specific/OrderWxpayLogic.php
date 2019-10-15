<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderWxpay;
use App\Models\Entity\DbOrderWxpay;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Log\Log;
use Tool\Db;
use Tool\Token;

/**
 * @Bean()
 *
 * @author wq
 */
class OrderWxpayLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOrderWxpay::class;
    }

    /**
     * 更新微信订单号
     */
    public function getResult()
    {
    }

    /**
     * 余额充值处理订单号
     */
    public function getResultByPay(array $data): string
    {
        $isHave = $this->getOrderWxpayCredentials($data);

        // 生成不同的支付码
        $wxPay = Token::toGUID();

        if (0 === count($isHave)) {

            $data[OrderWxpay::$wxPay_id] = $wxPay;

            $status = $this->addData($data);
        } else {

            $isHave[OrderWxpay::$wxPay_id] = $wxPay;

            $status = $this->saveData($isHave);
        }

        return $status && true ? $wxPay : '';
    }

    /**
     * 获取微信订单凭据
     */
    public function getOrderWxpayCredentials(array $data): array
    {
        if (empty($data)) {
            return [];
        }

        $wxOrderId = $data['order_id'];

        $data = $this->getQueryBuilderProxy()
            ->field([
                'id',
                'order_id',
                'wx_pay_id'
            ])
            ->where('order_id', $wxOrderId)
            ->where(OrderWxpay::$type, $data['pay_type'])
            ->getField();
        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $result = [
            OrderWxpay::$id => $update[OrderWxpay::$id],
            OrderWxpay::$wxPay_id => $update[OrderWxpay::$wxPay_id]
        ];
        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        // 生成不同的支付码
        $result = [
            OrderWxpay::$orderId => $insert['order_id'],
            OrderWxpay::$wxPay_id => $insert[OrderWxpay::$wxPay_id],
            OrderWxpay::$status => 0,
            OrderWxpay::$type => $insert['pay_type']
        ];
        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getColumToBeUpdated()
     */
    protected function getColumToBeUpdated(): array
    {
        return [
            OrderWxpay::$wxPay_id
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getDataToBeUpdated()
     */
    protected function getDataToBeUpdated(array $data): array
    {
        // 生成不同的支付码
        list ($orderData, $wxPay) = $data;

        $result = [];

        foreach ($orderData as $key => $value) {
            $result[$key][] = $wxPay;
        }

        return $result;
    }

    /**
     * 处理微信订单
     *
     * @param array $info
     * @return int
     */
    public function parseOrderByWx(array $info, int $type): string
    {
        $isHave = $this->getOrderWx($info, $type);

        $wxPay = Token::toGUID();

        $status = 0;
        if (0 === count($isHave)) {

            $status = $this->addAll([
                $info,
                $type,
                $wxPay
            ]);
        } else { // 失败更新订单号
            $sql = $this->buildUpdateSql([
                $isHave,
                $wxPay
            ]);
            try {
                $status = Db::query($sql)->getResult('items');
            } catch (\Exception $e) {
                $this->errorMessage = $e->getMessage();
                return '';
            }
        }
        return $status && true ? $wxPay : '';
    }

    /**
     * 获取凭据
     */
    public function getOrderWx(array $info, int $type)
    {
        $wxOrderId = array_column($info, 'order_id');

        return $this->getQueryBuilderProxy()
            ->field([
                'id',
                'order_id',
                'wx_pay_id'
            ])
            ->whereIn('order_id', $wxOrderId)
            ->where(OrderWxpay::$type, $type)
            ->getField();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAddAll()
     */
    protected function getParseResultByAddAll(array $post): array
    {
        list ($data, $type, $wxPay) = $post;

        $result = [];

        $i = 0;

        foreach ($data as $key => &$value) {
            $result[$i][OrderWxpay::$orderId] = $value['order_id'];
            $result[$i][OrderWxpay::$wxPay_id] = $wxPay;
            $result[$i][OrderWxpay::$type] = $type;
            $result[$i][OrderWxpay::$status] = 0;
            $i++;
        }

        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return OrderWxpay::class;
    }

    /**
     * 微信回调更新微信订单号
     */
    public function nofityUpdate(array $param): bool
    {
        $wxOrderId = $param['wx_order_id'];

        $type = $param['type'];

        try {
            $status = $this->getQueryBuilderProxy()
                ->whereIn(OrderWxpay::$orderId, $wxOrderId)
                ->where(OrderWxpay::$type, $type)
                ->save([
                    OrderWxpay::$status => 1
                ]);

            if (!$this->traceStation($status)) {
                Log::error('更新微信订单-失败-sql -- ' . get_last_sql());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('更新微信订单-失败-error- ' . $e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * 微信回调更新微信订单号(余额充值及其 开店)
     */
    public function nofityUpdateBySpecial(array $param)
    {
        $wxOrderId = $param['wx_order_id'];

        $type = $param['type'];

        $status = $this->getQueryBuilderProxy()
            ->where(OrderWxpay::$orderId, $wxOrderId)
            ->where(OrderWxpay::$type, $type)
            ->save([
                OrderWxpay::$status => 1
            ]);

        if (!$this->traceStation($status)) {
            Log::error('微信订单更新失败', [
                get_last_sql()
            ]);
            return false;
        }
        return true;
    }
}