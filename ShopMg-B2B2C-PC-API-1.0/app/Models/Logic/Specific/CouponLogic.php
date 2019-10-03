<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Coupon;
use App\Models\Entity\DbCoupon;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\ParamsParse;
use Tool\QueryBuilderProxy;
use Tool\SessionManager;

/**
 * 代金券
 *
 * @author Administrator
 * @Bean()
 */
class CouponLogic extends AbstractLogic
{

    /**
     * @Inject(name="cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbCoupon::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getResult()
     */
    public function getResult()
    {
    }

    /**
     * 处理优惠券
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getParseCoupon(array $data, string $splitKey): array
    {
        $key = array_column($data, $splitKey);

        $idString = implode('', $key);

        $key = 'coupon_ddd_' . $idString . session()->get('user_id');

        $cache = &$this->cache;

        $result = $cache->get($key);

        if ($result) {
            return json_decode($result, true);
        }

        $paramEntity = new ParamsParse($data, $this->getTableColum(), Coupon::$id, $splitKey);

        $coupon = $this->parseAssociatedData($paramEntity);

        if (0 === count($coupon)) {
            return [];
        }

        $time = time();

        // 不可用
        $doNotUse = [];
        // 可用
        $doUse = [];

        foreach ($coupon as $key => $value) {

            if (!isset($value[Coupon::$useStart_time])) {
                continue;
            }
            if ($time < $value[Coupon::$useStart_time] || $time > $value[Coupon::$useEnd_time]) {
                $doNotUse[] = $value;
            } else {
                $doUse[$value['c_id']] = $value;
            }
        }

        $result = [
            'do_not_use' => $doNotUse,
            'do_use' => $doUse
        ];
        $cache->set($key, json_encode($result), 45);

        return $result;
    }

    /**
     * getDataByOtherModel 附属方法
     */
    protected function parseWhere(QueryBuilderProxy $queryBuilder): void
    {
        $store = SessionManager::GET_STORE_ID_BY_STATION();

        $queryBuilder->whereIn(Coupon::$storeId, $store);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return Coupon::class;
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
            Coupon::$id,
            Coupon::$name,
            Coupon::$money,
            Coupon::$condition,
            Coupon::$useStart_time,
            Coupon::$useEnd_time,
            Coupon::$storeId
        ];
    }

    /**
     * 优惠券是否可用
     *
     * @return boolean
     */
    public function checkCouponIsUse(array $post): bool
    {
        $doUse = SessionManager::GET_DO_USE();

        if (!isset($doUse[$post['id']])) {
            $this->errorMessage = '此优惠券无法使用';
            return false;
        }

        $couponMoney = SessionManager::GET_COUPON_MONEY();

        if (empty($couponMoney)) {
            $this->errorMessage = '商品信息有误';
            return false;
        }

        $data = $doUse[$post['id']];

        if (empty($data)) {
            $this->errorMessage = '未找到优惠券:(';
            return false;
        }

        if (empty($couponMoney[$data[Coupon::$storeId]])) {
            $this->errorMessage = '商品信息有误';
            return false;
        }

        $money = $couponMoney[$data[Coupon::$storeId]];

        if ($money <= 0) {
            return false;
        }

        if ($data[Coupon::$condition] < $money) {

            SessionManager::SET_COUPON_LIST([
                $data[Coupon::$storeId] => [
                    'c_id' => $post['id'],
                    'money' => $data[Coupon::$money],
                    'condition' => $data[Coupon::$condition],
                    'id' => $post['coupon_list_id'],
                    'store_id' => $data[Coupon::$storeId]
                ]
            ]);

            unset($doUse[$post['id']]);

            SessionManager::SET_DO_USE($doUse);

            return true;
        }

        $this->errorMessage = '未满足优惠金额条件';
        return false;
    }

    /**
     * 获取该店铺优惠券
     *
     * @param bool $isMemberByCurrentShop
     *            是否是当前店铺会员
     */
    public function getCouponListByStore(array $post, bool $isMemberByCurrentShop): array
    {
        $where = [
            Coupon::$type => [
                'in',
                [
                    0,
                    1
                ]
            ],
            Coupon::$storeId => $post['store_id'],
            Coupon::$status => 1
        ];

        if (!$isMemberByCurrentShop) {
            $where[Coupon::$sendAll] = 0;
        }

        return $this->getParseDataByList($post, $where);
    }

    /**
     * 获取该店铺优惠券
     *
     * @param bool $isMemberByCurrentShop
     *            是否是当前店铺会员
     */
    public function getCouponListByStoreCache(array $post, bool $isMemberByCurrentShop): array
    {
        $cache = &$this->cache;

        $key = $post['store_id'] . $post['page'] . '_store_coupon';

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getCouponListByStore($post, $isMemberByCurrentShop);

        if (count($data['data']) === 0) {
            return [];
        }

        $time = time();

        $tmp = [];
        foreach ($data['data'] as $value) {
            if ($time < $value[Coupon::$useStart_time] || $time > $value[Coupon::$useEnd_time]) {
                continue;
            }

            $tmp[] = $value;
        }

        $data['data'] = $tmp;

        $cache->set($key, json_encode($data), 30);

        return $data;
    }

    /**
     * 获取优惠券数据
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getCouponByData(array $dataSources, string $splitKey): array
    {
        $field = [
            Coupon::$id,
            Coupon::$money,
            Coupon::$useStart_time,
            Coupon::$useEnd_time,
            Coupon::$storeId,
            Coupon::$condition
        ];

        $paramEntity = new ParamsParse($dataSources, $field, Coupon::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }

    /**
     * 店铺关联字段
     *
     * @return string
     */
    public function getSplitKeyByStore(): string
    {
        return Coupon::$storeId;
    }
}