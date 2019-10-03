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

use App\Common\FieldMapping\FreightCondition;
use App\Models\Entity\DbFreightCondition;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\ArrayChildren;

/**
 * 运费条件逻辑处理
 * @Bean()
 *
 * @author 米糕网络团队
 * @version 1.0.0
 */
class FreightConditionLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    /**
     * 构造方法
     *
     * @param array $data
     * @param string $split
     */
    public function __construct()
    {
        //

        //

        // $this->getQueryBuilderProxy() = Base::getInstance('FreightCondition');
        $this->tableName = DbFreightCondition::class;
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
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return FreightCondition::class;
    }

    /**
     * 获取 运费配置信息
     */
    public function getFreightOneData(array $data, string $key)
    {
        $cache = &$this->cache;

        $ids = array_column($data, $key);

        $idString = implode('', $ids) . 'freight';

        $data = $cache->get($idString);

        if ($data) {
            return json_decode($data, true);
        }

        $result = $this->getQueryBuilderProxy()
            ->field([
                FreightCondition::$id,
                FreightCondition::$freightId,
                FreightCondition::$mailArea_monery,
                FreightCondition::$mailArea_num,
                FreightCondition::$mailArea_volume,
                FreightCondition::$mailArea_wieght
            ])
            ->whereIn(FreightCondition::$freightId, $ids)
            ->select();

        if (empty($data)) {
            $this->errorMessage = '未设置包邮设置';
            return [];
        }

        $result = (new ArrayChildren($result))->convertIdByData(FreightCondition::$id);

        $cache->set($idString, json_encode($result, JSON_UNESCAPED_UNICODE), 88);

        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMessageNotice()
     */
    public function getMessageNotice(): array
    {
    }

    /**
     * 获取包邮地区关联字段
     *
     * @return string
     */
    public function getIdBySendSplitKey()
    {
        return FreightCondition::$id;
    }
}