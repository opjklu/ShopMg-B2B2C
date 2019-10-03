<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderExchangeProgress;
use App\Models\Entity\DbOrderExchangeProgress;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 换货逻辑
 *
 * @author Administrator
 *
 * @Bean()
 */
class OrderExchangeProgressLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOrderExchangeProgress::class;
    }

    public function getResult()
    {
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return OrderExchangeProgress::class;
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
    public function addProcess(array $post): bool
    {
        $status = $this->addData($post);

        if (!$this->traceStation($status)) {
            return false;
        }

        return true;
    }
}