<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsConsultation;
use App\Models\Entity\DbGoodsConsultation;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 咨询回复
 *
 * @author Administrator
 *
 * @Bean()
 */
class GoodsConsultationLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbGoodsConsultation::class;
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
     * 获取一个商品的咨询
     */
    public function getGoodsConsultationByGoods(array $data): array
    {
        return $this->getParseDataByList($data);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::searchArray()
     */
    protected function searchArray(): array
    {
        return [
            GoodsConsultation::$goodsId
        ];
    }

    /**
     * 验证提问
     */
    public function getMessageValidate()
    {
        return [
            'goods_id' => [
                'number' => '商品ID必须是数字'
            ],
            'content' => [
                'required' => '必须输入问题内容',
                'checkChineseAndEnglish' => '提问内容有非法字符'
            ]
        ];
    }

    /**
     * 获取模型类名
     *
     * @return string
     */
    public function getMapperClassName(): string
    {
        return GoodsConsultation::class;
    }

    /**
     * 获取商品关联字段
     */
    public function getSplitKeyByGoods()
    {
        return GoodsConsultation::$goodsId;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $insert[GoodsConsultation::$userId] = session()->get('user_id');

        $insert[GoodsConsultation::$commentType] = 0;

        $insert[GoodsConsultation::$createTime] = time();
        return $insert;
    }
}