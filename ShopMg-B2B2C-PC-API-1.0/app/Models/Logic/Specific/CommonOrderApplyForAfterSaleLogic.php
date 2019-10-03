<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderReturnGoods;
use App\Common\TraitClass\ExchangeOfGoodsTrait;
use App\Models\Entity\DbOrderReturnGoods;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 申请售后处理
 * @Bean()
 */
class CommonOrderApplyForAfterSaleLogic extends AbstractLogic
{
    use ExchangeOfGoodsTrait;


    public function __construct()
    {
        $this->tableName = DbOrderReturnGoods::class;
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
        return OrderReturnGoods::class;
    }

    // 填写快递单号
    public function setCourierNumber(array $data): bool
    {
        Db::beginTransaction();

        $status = $this->saveData($data);

        if (!$this->traceStation($status)) {
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
        $update[OrderReturnGoods::$updateTime] = time();

        $update[OrderReturnGoods::$status] = 3;

        return $update;
    }

    /**
     * 验证退货key
     *
     * @return string
     */
    protected function getReturnKey(): string
    {
        return session()->get('user_id') . '_order_goods_return11111';
    }

    /**
     * 检查退货商品件数及其金额覆盖Trait方法
     *
     * @return bool
     */
    private function checkMoneyAndGoodsNumber(array $data, array $post): bool
    {
        if ($post['price'] > 0 && $data['goods_price'] < $post['price']) {
            $this->errorMessage = '退货金额错误';
            return false;
        }

        if ($data['goods_num'] < $post['number']) {
            $this->errorMessage = '退货商品数量错误';
            return false;
        }

        return true;
    }
}
