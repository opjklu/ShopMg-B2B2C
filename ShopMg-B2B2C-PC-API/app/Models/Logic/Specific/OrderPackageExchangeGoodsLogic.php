<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderPackageExchangeGoods;
use App\Common\TraitClass\ExchangeOfGoodsTrait;
use App\Models\Entity\DbOrderPackageExchangeGoods;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class OrderPackageExchangeGoodsLogic extends AbstractLogic
{
    use ExchangeOfGoodsTrait;


    public function __construct()
    {
        $this->tableName = DbOrderPackageExchangeGoods::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByQuery()
    {
        $message = [
            'id' => [
                'required' => '售后申请ID必填'
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
        return OrderPackageExchangeGoods::class;
    }

    // 填写快递单号
    public function setCourierNumber(array $data): bool
    {
        return $this->saveData($data) === 1;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {

        $insert[OrderPackageExchangeGoods::$updateTime] = time();

        return $insert;
    }

    // 申请售后进度查询
    public function getProgressQuery()
    {

        return array(
            "status" => 1,
            "message" => "获取成功!",
            "data" => []
        );
    }

    // 申请售后详情
    public function returnInfo()
    {

        return array(
            "status" => 1,
            "message" => "获取成功!",
            "data" => []
        );
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \App\Models\Logic\AbstractLogic::getWhereBySaveAndDelete()
     */
    protected function getWhereBySaveAndDelete(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }
    // 搜索
    public function getSearchOrder()
    {
       return [];
    }
}
