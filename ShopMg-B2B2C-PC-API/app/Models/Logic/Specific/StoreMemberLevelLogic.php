<?php
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

use App\Common\FieldMapping\StoreMemberLevel;
use App\Models\Entity\DbStoreMemberLevel;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\ArrayChildren;
use Tool\Db;

/**
 * 会员等级
 * @Bean()
 *
 * @author Administrator
 */
class StoreMemberLevelLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbStoreMemberLevel::class;
    }

    /**
     * 获取结果卍卐卍
     */
    public function getResult()
    {
    }

    /**
     *
     * @return array
     */
    public function parseMemberLevel(array $data, string $splitKey): array
    {
        $result = $this->getLevelList($data, $splitKey);

        if (0 === count($result)) {
            // 提交事务 无需添加店铺会员
            Db::commit();
            return [];
        }

        $resourceCovert = [];

        // 这里 刚生成的订单（商家编号）是不会重复的
        $resourceCovert = (new ArrayChildren($data))->convertIdByData('store_id');

        $flag = [];

        foreach ($result as $key => $value) {

            if (!isset($resourceCovert[$value['store_id']])) {
                continue;
            }

            if ($value[StoreMemberLevel::$moneySmall] <= $resourceCovert[$value['store_id']]['total_money'] && $resourceCovert[$value['store_id']]['total_money'] <= $value[StoreMemberLevel::$moneyBig]) {
                $flag[$value['store_id']] = $resourceCovert[$value['store_id']];
            }
        }

        if (0 === count($flag)) {
            // 提交事务 无需添加店铺会员
            Db::commit();
            return [];
        }

        return $flag;
    }

    /**
     * 获取会员等级列表
     *
     * @return array
     */
    public function getLevelList(array $data, string $splitKey): array
    {
        $cache = &$this->cache;

        $column = array_column($data, $splitKey);

        $idString = implode('', $column);

        $key = $idString . 'member_level';

        $res = $cache->get($key);

        if ($res) {
            return json_decode($res, true);
        }

        $res = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn(StoreMemberLevel::$storeId, $column)
            ->select();

        if (0 === count($res)) {
            return [];
        }

        $this->cache->set($key, json_encode($res), 60);

        return $res;
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
            StoreMemberLevel::$id,
            StoreMemberLevel::$discount,
            StoreMemberLevel::$conditionNum,
            StoreMemberLevel::$storeId,
            StoreMemberLevel::$moneySmall,
            StoreMemberLevel::$moneyBig,
            StoreMemberLevel::$numBig
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return StoreMemberLevel::class;
    }
}