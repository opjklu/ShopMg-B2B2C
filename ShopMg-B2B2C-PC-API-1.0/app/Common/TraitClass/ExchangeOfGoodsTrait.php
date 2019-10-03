<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

use Swoft\Cache\Cache;
use Swoft\Bean\Annotation\Inject;
use Swoft\Db\Db;
/**
 * 退换货组件
 *
 * @author Administrator
 *
 */
trait ExchangeOfGoodsTrait
{

    /**
     * @Inject(name="cache")
     * @var Cache
     */
    private $cache;

    /**
     * 退换货处理
     *
     * @return bool
     */
    public function applyForAfterSale(array $post): int
    {
        if (!$this->checkReturnInfo($post)) {
            return 0;
        }

        Db::beginTransaction();

        $res = $this->addData($post);

        if (!$this->traceStation($res)) {
            return 0;
        }

        return $res;
    }

    protected function checkReturnInfo(array $post): bool
    {
        $data = $this->cache->get($this->getReturnKey());

        if (!$data) {
            $this->errorMessage = '退货信息错误或者 超过两分钟，请刷新页面';

            return false;
        }

        return $this->checkMoneyAndGoodsNumber(json_decode($data, true), $post);
    }

    /**
     * 检查退货商品件数及其金额
     *
     * @return bool
     */
    private function checkMoneyAndGoodsNumber(array $data, array $post): bool
    {
        if ($post['price'] > 0 && $data['goods_discount'] < $post['price']) {
            $this->errorMessage = '退货金额错误';
            return false;
        }

        if ($data['package_num'] < $post['number']) {
            $this->errorMessage = '退货商品数量错误';
            return false;
        }

        return true;
    }

    protected function getReturnKey(): string
    {
        return session()->get('user_id') . '_order_package_goods_return';
    }

    /**
     * 返回验证数据
     */
    public function getValidateByApply(): array
    {
        return [
            'order_id' => [
                'number' => '订单ID必填'
            ],
            'goods_id' => [
                'number' => '商品ID必填'
            ],
            'explain' => [
                'required' => '申请理由说明必填'
            ],
            'apply_img' => [
                'required' => '申请图片必填'
            ],
            'store_id' => [
                'number' => '店铺ID必填'
            ],
            'price' => [
                'number' => '价格必须是数字'
            ],
            'number' => [
                'number' => '退货件数必须是数字'
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Common\Logic\AbstractGetDataLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {

        $insert['create_time'] = $time = time();

        $insert['apply_img'] = implode(",", $insert['apply_img']);

        $insert['update_time'] = $time;

        $insert['user_id'] = session()->get('user_id');

        return $insert;
    }
}