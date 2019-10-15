<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\InvoiceType;
use App\Common\FieldMapping\OrderPackageInvoice;
use App\Common\FieldMapping\User;
use App\Models\Entity\DbOrderPackageInvoice;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class OrderPackageInvoiceLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOrderPackageInvoice::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'page' => [
                'required' => "必须填写  信息"
            ]
        ];
        return $message;
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
        return InvoiceType::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment(): array
    {
        return [
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    protected function likeSerachArray(): array
    {
        return [
            User::$userName
        ];
    }


    /**
     * 发票更新
     */
    public function updateInvoice(array $data): bool
    {

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
            OrderPackageInvoice::$orderId,
            OrderPackageInvoice::$updateTime
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
     *
     * @return string
     */
    public function getInvoice(array $data): array
    {
        return $this->getQueryBuilderProxy()
            ->field(OrderPackageInvoice::$typeId)
            ->where(OrderPackageInvoice::$orderId, $data['id'])
            ->find();
    }

    public function isOpenInvoice(array $data): array
    {
        if ($data['translate'] != 1) {
            return [];
        }

        return $this->getInvoice($data);
    }

    /**
     *
     * @return string
     */
    public function getSplitKeyByType(): string
    {
        return OrderPackageInvoice::$typeId;
    }
}

