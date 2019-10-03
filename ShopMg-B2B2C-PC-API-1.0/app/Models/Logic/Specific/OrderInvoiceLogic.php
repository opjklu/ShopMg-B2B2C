<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderInvoice;
use App\Models\Entity\DbOrderInvoice;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 *
 * @author wq
 *
 * @Bean()
 */
class OrderInvoiceLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOrderInvoice::class;
    }

    /**
     * 获取结果
     */
    public function getResult()
    {
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return OrderInvoice::class;
    }

    /**
     * 发票更新
     */
    public function updateInvoice(array $invoiceData): bool
    {
        $data = &$invoiceData;

        if (empty($data)) {
            return true;
        }

        $sql = $this->buildUpdateSql($data);

        try {
            $status = Db::query($sql)->getResult('items');

            if (!$this->traceStation($status)) {
                return false;
            }
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            Db::rollback();
            return false;
        }

        return true;
    }

    /**
     * 要更新的字段
     *
     * @return array
     */
    protected function getColumToBeUpdated(): array
    {
        return [
            OrderInvoice::$orderId,
            OrderInvoice::$updateTime
        ];
    }

    /**
     * 要更新的数据【已经解析好的】
     *
     * @return array
     */
    protected function getDataToBeUpdated(array $data): array
    {
        // 批量更新
        $pasrseData = array();
        $time = time();
        foreach ($data as $key => $value) {
            $pasrseData[$value['id']][] = $value['order_id'];

            $pasrseData[$value['id']][] = $time;
        }

        return $pasrseData;
    }

    /**
     * 发票->立即购买更新
     */
    public function updateInvoiceByPlaceTheOrder(array $invoiceData): bool
    {
        if (0 === count($invoiceData)) {
            return true;
        }

        $status = $this->saveData($invoiceData);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '发票更新失败';
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
    protected function getParseResultBySave(array $update = []): array
    {
        return [
            OrderInvoice::$orderId => $update['order_id'],
            OrderInvoice::$id => $update['id']
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {

        $insert[OrderInvoice::$userId] = session()->get('user_id');

        $insert[OrderInvoice::$createTime] = $time = time();

        $insert[OrderInvoice::$updateTime] = $time;

        return $insert;
    }
}