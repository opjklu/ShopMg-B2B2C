<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsAdvisoryReply;
use App\Models\Entity\DbGoodsAdvisoryReply;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\QueryBuilderProxy;

/**
 * 咨询回答
 *
 * @author Administrator
 *
 * @Bean()
 */
class GoodsAdvisoryReplyLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbGoodsAdvisoryReply::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getResult()
     */
    public function getResult()
    {
        // TODO
    }

    /**
     * 获取模型类名
     *
     * @return string
     */
    public function getMapperClassName(): string
    {
        return GoodsAdvisoryReply::class;
    }

    /**
     * 获取每个回答中的一条
     * SELECT replay.user_id, replay.id, replay.content, replay.consultation_id, replay.type
     * FROM (
     * SELECT MAX(id) as id FROM mg_goods_advisory_reply
     * WHERE consultation_id in (1, 2)
     * GROUP BY consultation_id
     * ) goods_adv INNER JOIN mg_goods_advisory_reply as replay
     * ON goods_adv.id = replay.id
     */
    public function getGoodsAdvisoryReply(array $data, string $splitKey)
    {
        $idString = implode(',', array_column($data, $splitKey));

        $field = [
            'replay.user_id',
            'replay.id',
            'replay.content',
            'replay.consultation_id',
            'replay.type',
            'd.count_answer'
        ];

        $table = QueryBuilderProxy::getTableNameByClassName($this->tableName);

        return $this->getQueryBuilderProxy('replay')
            ->field($field)
            ->innerJoin('(select MAX(`id`) as id, count(consultation_id) as count_answer  From ' . $table . ' where consultation_id in(' . $idString . ') group by consultation_id order by id desc )', 'd.id = replay.id', 'd')
            ->getField($field);
    }

    /**
     * 获取每个回答中的一条并缓存
     */
    public function getParseGoodsAdvisoryReply(array $data, string $splitKey)
    {
        $result = $this->getGoodsAdvisoryReply($data, $splitKey);

        foreach ($data as $key => & $value) {
            if (!isset($result[$value[$splitKey]])) {
                $value['answer'] = '';
                $value['count_answer'] = 0;
                continue;
            }
            $value['answer'] = $result[$value[$splitKey]]['content'];

            $value['count_answer'] = $result[$value[$splitKey]]['count_answer'];
        }

        return $data;
    }
}