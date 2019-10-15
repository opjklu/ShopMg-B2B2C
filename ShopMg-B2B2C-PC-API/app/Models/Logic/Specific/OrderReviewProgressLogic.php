<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderReviewProgress;
use App\Models\Entity\DbOrderReviewProgress;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 *
 * @author Administrator
 *
 * @Bean()
 */
class OrderReviewProgressLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOrderReviewProgress::class;
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
        return OrderReviewProgress::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $data = [];

        $data[OrderReviewProgress::$returnId] = $insert['order_return'];

        $data[OrderReviewProgress::$createTime] = $time = time();

        $data[OrderReviewProgress::$updateTime] = $time;

        $data[OrderReviewProgress::$status] = '0';

        $data[OrderReviewProgress::$approvalContent] = '亲!您的申请正在等待管理员审核!';

        return $data;
    }

    /**
     * 添加审核记录
     *
     * @return bool
     */
    public function addOrderReview(array $data): bool
    {
        $status = $this->addData($data);

        if (!$this->traceStation($status)) {

            $this->errorMessage .= '添加失败';

            return false;
        }
        return true;
    }

    /**
     * 获取当前退货单审核进度
     *
     * @return array
     */
    public function returnInfo(array $data): array
    {
        return $this->getQueryBuilderProxy()
            ->field(['id','create_time','approval_content','approval_id'])
            ->where('return_id',$data['return_id'])
            ->order("create_time DESC")
            ->select();
    }

    /**
     *
     * @return string
     */
    public function getSplitKeyByApproval(): string
    {
        return OrderReviewProgress::$approvalId;
    }
}