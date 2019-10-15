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
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\FreightArea;
use App\Models\Entity\DbFreightArea;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\ArrayChildren;

/**
 * 配送地区表
 * @Bean()
 *
 * @author Administrator
 * @version 1.0.0
 */
class FreightAreaLogic extends AbstractLogic
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

        // $this->getQueryBuilderProxy() = Base::getInstance('FreightArea');
        $this->tableName = DbFreightArea::class;
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
        return FreightArea::class;
    }

    /**
     * 获取运送地区
     */
    public function getAddressArea(array $condition): array
    {
        $cache = &$this->cache;

        $conIds = array_keys($condition);

        $idString = implode(',', $conIds) . 'khlj';

        $temp = $cache->get($idString);

        if ($temp) {
            return json_decode($temp, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->whereIn(FreightArea::$freightId, $conIds)
            ->select();

        if (empty($data)) {
            return [];
        }

        $temp = [];

        foreach ($data as $key => $value) {
            $temp[$value[FreightArea::$freightId]][] = $value[FreightArea::$mailArea];
        }

        $cache->set($idString, json_encode($temp, JSON_UNESCAPED_UNICODE), 105);

        return $temp;
    }

    /**
     * 收货地址是否在包邮地区内
     *
     * @return boolean
     */
    public function sendAddressIsInFreeShipping(array $param): array
    {
        $area = $this->getAddressArea($param['con']);

        $freightMode = $param['freight_mode'];

        if (empty($area)) {
            // 没有包邮设置
            foreach ($freightMode as $key => & $value) {
                $value['mail_area_num'] = 0;
                $value['mail_area_wieght'] = 0;
                $value['mail_area_volume'] = 0;
                $value['mail_area_monery'] = 0;
            }

            return $freightMode;
        }

        $provId = $param['param']['prov_id'];

        $cityId = $param['param']['city_id'];

        $sendArea = [
            $provId => $provId,
            $cityId => $cityId
        ];

        $isFreeShipping = []; // 判断 哪个商家包邮

        foreach ($area as $key => $value) {
            if (!empty(array_intersect($sendArea, $value))) {
                $isFreeShipping[$key] = $key;
            }
        }

        $arrayObj = new ArrayChildren($param['con']);

        // 获取指定条件包邮商家
        $result = $arrayObj->getArrayAssocByData($isFreeShipping);

        $arrayObj->setData($result);

        $result = $arrayObj->convertIdByData('freight_id');

        // 指定條件包郵
        foreach ($freightMode as $key => & $value) {
            if (empty($result[$value['freight_id']])) {
                $value['mail_area_num'] = 0;
                $value['mail_area_wieght'] = 0;
                $value['mail_area_volume'] = 0;
                $value['mail_area_monery'] = 0;
            } else {
                $value['mail_area_num'] = $result[$value['freight_id']]['mail_area_num'];
                $value['mail_area_wieght'] = $result[$value['freight_id']]['mail_area_wieght'];
                $value['mail_area_volume'] = $result[$value['freight_id']]['mail_area_volume'];
                $value['mail_area_monery'] = $result[$value['freight_id']]['mail_area_monery'];
            }
        }

        return $freightMode;
    }

    /**
     * 获取关联字段
     */
    public function getMialAreaSplitKey(): string
    {
        return FreightArea::$mailArea;
    }
}