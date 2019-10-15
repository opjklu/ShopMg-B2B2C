<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderExchangeGoods;
use App\Common\TraitClass\ExchangeOfGoodsTrait;
use App\Models\Entity\DbOrderExchangeGoods;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 换货
 *
 * @Bean()
 */
class OrderExchangeGoodsLogic extends AbstractLogic
{
    use ExchangeOfGoodsTrait;


    public function __construct()
    {
        $this->tableName = DbOrderExchangeGoods::class;
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
        return OrderExchangeGoods::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByNumber(): array
    {
        return [
            'id' => [
                'number' => '售后申请ID必填'
            ],
            'express_id' => [
                'number' => '快递方式必填'
            ],
            'waybill_id' => [
                'number' => '运单号必填'
            ]
        ];
    }

    // 填写快递单号
    public function setCourierNumber(array $data): bool
    {
        return $this->saveData($data) !== 0;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $insert[OrderExchangeGoods::$updateTime] = time();

        return $insert;
    }
    
    /**
     * 保存时条件处理
     *
     * @param array $post
     * @return array
     */
    protected function getWhereBySaveAndDelete(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }
}


