<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderPackageExchangeProgress;
use App\Models\Entity\DbOrderPackageExchangeProgress;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 套餐订单审核原因
 *
 * @author Administrator
 *
 * @Bean()
 */
class OrderPackageExchangeProgressLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOrderPackageExchangeProgress::class;
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
        return OrderPackageExchangeProgress::class;
    }

    protected function getParseResultByAdd(array $insert): array
    {
        $data = [];

        $data['exchange_id'] = $insert['insert_id'];
        $data['status'] = 0;
        $data['create_time'] = $time = time();
        $data['approval_content'] = "亲!您的申请正在等待管理员审核!";
        $data['update_time'] = $time;

        return $data;
    }

    /**
     * 添加审核进度
     *
     * @return bool
     */
    public function addProcess(array $data): bool
    {
        $status = $this->addData($data);

        if (!$this->traceStation($status)) {
            return false;
        }

        return true;
    }

    /**
     * 申请售后进度查询
     *
     * @return array
     */
    public function getProgressQuery(): array
    {
    }
}