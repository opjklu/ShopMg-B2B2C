<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\CouponList;
use App\Models\Entity\DbCouponList;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\Db;
use Tool\SessionManager;

/**
 * 用户优惠券逻辑处理层
 *
 * @Bean()
 */
class CouponListLogic extends AbstractLogic
{

    /**
     * @Inject(name="cache")
     *
     * @var Cache
     */
    private $cache;

   
    public function __construct()
    {
        $this->tableName = DbCouponList::class;
    }

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
        return CouponList::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
        return [
            CouponList::$cId
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::parseOption()
     */
    protected function parseOption(array $options): array
    {
        $options['where']['user_id'] = session()->get('user_id');

        return $options;
    }

    /**
     * 用户可用代金券
     *
     * @return array
     */
    public function getUsersCanUseCoupons(): array
    {
        $cache = &$this->cache;

        $userId = session()->get('user_id');

        $key = 'coupon_key_' . $userId . '145qq';

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field($this->getColumByGetField())
            ->where(CouponList::$status, 0)
            ->where(CouponList::$userId, $userId)
            ->limit(30)
            ->order(CouponList::$sendTime, 'DESC')
            ->select();
        if (0 === count($data)) {
            return [];
        }

        $cache->set($key, json_encode($data), 45);

        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            CouponList::$id,
            CouponList::$cId,
            CouponList::$status,
            CouponList::$code,
            CouponList::$type
        ];
    }

    protected function getColumByGetField(): array
    {
        return [
            CouponList::$id,
            CouponList::$cId,
            CouponList::$code
        ];
    }

    /**
     * 获取优惠券相关字段
     */
    public function getSplitKeyByCoupon(): string
    {
        return CouponList::$cId;
    }

    /**
     * 优惠券 处理
     */
    public function couponParse(array $payData)
    {
        $coupon = SessionManager::GET_COUPON_LIST();

        if (empty($coupon)) {
            return true;
        }

        $res = [];

        $time = time();

        $doUse = SessionManager::GET_DO_USE();

        foreach ($payData as $key => $value) {
            if (empty($coupon[$value['store_id']])) {
                continue;
            }

            if (empty($doUse[$coupon[$value['store_id']]['id']])) {
                continue;
            }

            $res[$coupon[$value['store_id']]['id']][] = $key;

            $res[$coupon[$value['store_id']]['id']][] = $time;

            $res[$coupon[$value['store_id']]['id']][] = 1;
        }

        $length = count($res);

        if ($length === 0) {
            return true;
        }

        $sql = $this->buildUpdateSql($res);
        try {
            $status = Db::query($sql)->getResult('itmes');
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            Db::rollback();
            return false;
        }

        if (!$this->traceStation($status)) {
            return false;
        }

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getColumToBeUpdated()
     */
    protected function getColumToBeUpdated(): array
    {
        return [
            CouponList::$orderId,
            CouponList::$useTime,
            CouponList::$status
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getDataToBeUpdated()
     */
    protected function getDataToBeUpdated(array $data): array
    {
        return $data;
    }

    /**
     * @param array $insert
     * @return array
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $insert[CouponList::$userId] = session()->get('user_id');

        $insert[CouponList::$status] = 0;

        $insert[CouponList::$code] = uniqid("mg_");

        $insert[CouponList::$sendTime] = time();

        return $insert;
    }

}