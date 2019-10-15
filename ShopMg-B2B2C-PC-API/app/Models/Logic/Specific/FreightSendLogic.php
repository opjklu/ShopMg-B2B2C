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

use App\Common\FieldMapping\FreightSend;
use App\Models\Entity\DbFreightSend;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 发货逻辑
 * @Bean()
 *
 * @author 米糕网络团队
 */
class FreightSendLogic extends AbstractLogic
{

    /**
     * 具体的运费计算方式(剔除包邮的)
     *
     * @var array
     */
    private $modeDetail = [];

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    /**
     *
     * @return array
     */
    public function getModeDetail()
    {
        return $this->modeDetail;
    }

    /**
     * 构造方法
     *
     */
    public function __construct()
    {
        $this->tableName = DbFreightSend::class;
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
        return FreightSend::class;
    }

    /**
     * 获取配送地址
     *
     * @return array
     */
    public function getSendAddress(array $freightMode)
    {
        if (empty($freightMode)) {
            return [];
        }

        $modeConf = $freightMode;

        $cache = &$this->cache;

        $modeIds = array_keys($modeConf);

        $key = implode(',', $modeIds) . '_edfg';

        $temp = $cache->get($key);

        if ($temp) {
            return json_decode($temp, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->whereIn(FreightSend::$freightId, $modeIds)
            ->select();
        if (empty($data)) {
            return [];
        }

        $temp = [];

        foreach ($data as $key => $value) {
            $temp[$value[FreightSend::$freightId]][] = $value[FreightSend::$mailArea];
        }

        $cache->set($key, json_encode($temp, JSON_UNESCAPED_UNICODE), 100);

        return $temp;
    }

    /**
     * 验证收货地址是否在配送区域内
     *
     * @return bool
     */
    public function userAddressIndexOfSendArea(array $data): bool
    {
        $dataByMode = $this->getSendAddress($data['f_mode']);

        if (empty($dataByMode)) {
            $this->errorMessage = '商家运费设置错误,请联系对应商品的商家';
            return false;
        }

        $area = [
            $data['area_conf']['prov_id'],
            $data['area_conf']['city_id']
        ];

        foreach ($dataByMode as $key => $value) { // 没有指出具体商家
            if (empty(array_intersect($area, $value))) {
                $this->errorMessage = '配送区域不包含用户的收货地址';
                return false;
            }
        }

        $freightConf = $data['f_mode'];

        $filterFreight = [];

        // 筛选包邮->指定条件包邮和自定义运费
        foreach ($freightConf as $key => $value) {
            if (($value['is_free_shipping'] === '1' && $value['is_select_condition'] === '0')) {
                continue;
            }
            $filterFreight[$key] = $value;
        }
        $this->modeDetail = $filterFreight;

        return true;
    }

    /**
     * 获取地区关联字段
     */
    public function getRegionAddress()
    {
        return FreightSend::$mailArea;
    }
}