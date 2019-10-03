<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\AlipaySerialNumber;
use App\Models\Entity\DbAlipaySerialNumber;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Log\Log;

/**
 * 支付宝数据逻辑
 * @Bean()
 */
class AlipaySerialNumberLogic extends AbstractLogic
{

    private $orderALiData = [];

    /**
     * 支付宝订单号
     *
     * @var unknown
     */
    private $aliOrderId;

    /**
     *
     * @return \App\Models\Logic\Specific\unknown
     */
    public function getAliOrderId()
    {
        return $this->aliOrderId;
    }


    public function __construct()
    {
        $this->tableName = DbAlipaySerialNumber::class;
    }

    /**
     * 更新支付宝单号
     */
    public function getResult()
    {
    }

    /**
     * 处理支付宝订单
     *
     * @param array $data
     * @return bool
     */
    public function parseAlipayConfig(array $data): bool
    {
        $status = $this->addAll($data);

        if (!$this->traceStation($status)) {
            $data['sql'] = get_last_sql();

            Log::error('商品支付失败', $data);

            return false;
        }
        return true;
    }

    /**
     * 添加时处理参数
     *
     * @return array
     */
    protected function getParseResultByAddAll(array $post): array
    {
        $bitchData = $post['order_id'];

        $result = [];
        $i = 0;

        foreach ($bitchData as $key => $value) {

            $result[$i][AlipaySerialNumber::$orderId] = $value;

            $result[$i][AlipaySerialNumber::$alipayCount] = $post['trade_no'];

            $result[$i][AlipaySerialNumber::$type] = $post['type'];

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
        return AlipaySerialNumber::class;
    }

    /**
     * 余额回调处理
     */
    public function parseByPay(array $data): bool
    {
        $status = $this->addData($data);

        if (!$this->traceStation($status)) {
            $data['sql'] = get_last_sql();

            Log::error('余额充值失败', $data);

            return false;
        }
        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        return [
            AlipaySerialNumber::$alipayCount => $insert['trade_no'],
            AlipaySerialNumber::$orderId => $insert['order_sn_id'],
            AlipaySerialNumber::$type => $insert['type']
        ];
    }
}