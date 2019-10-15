<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderPackageReviewProgress;
use App\Models\Entity\DbOrderPackageReviewProgress;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 退货申请进度逻辑
 *
 * @author Administrator
 * @Bean()
 */
class OrderPackageReviewProgressLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOrderPackageReviewProgress::class;
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
        return OrderPackageReviewProgress::class;
    }

    protected function getParseResultByAdd(array $insert): array
    {
        $data = [];

        $data['return_id'] = $insert['insert_id'];
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
            $this->errorMessage = '审核日志添加错误';
            return false;
        }

        return true;
    }
}