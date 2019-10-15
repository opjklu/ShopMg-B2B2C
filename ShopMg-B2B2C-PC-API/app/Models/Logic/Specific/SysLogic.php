<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\SystemConfig;
use Common\Tool\Extend\UnlinkPicture;
use Common\Tool\Tool;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 系统配置
 *
 * @author Administrator
 * @Bean()
 */
class SysLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    /**
     * 架构方法
     */
    public function __construct(array $data = [], $splitKey = null)
    {
        $this->tableName = 'mg_system_config';
    }

    /**
     * 获取商品分类
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getResult()
     */
    public function getResult()
    {
    }

    /**
     * 返回模型类名
     *
     * @return string
     */
    public function getMapperClassName(): string
    {
        return SystemConfig::class;
    }

    public function getAllConfig()
    {
        $data = $this->getQueryBuilderProxy()
            ->field('create_time,update_time', true)
            ->select();

        if (empty($data)) {
            return [];
        }

        foreach ($data as $key => &$value) {
            if (!empty($value['config_value'])) {
                $unData = unserialize($value['config_value']);
                unset($data[$key]['config_value']);
                $value = array_merge($value, $unData);
            }
        }

        return $data;
    }

    /**
     * 获取无缓存组配置
     *
     * @return mixed|NULL|unknown|string[]|unknown[]|object
     */
    public function getNoCacheConfigByGroup(string $key)
    {
        $field = [
            SystemConfig::$id,
            SystemConfig::$configValue,
            SystemConfig::$classId,
            SystemConfig::$key,
            SystemConfig::$currentId
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(SystemConfig::$parentKey, $key)
            ->getField();

        return $data;
    }

    /**
     * 获取无缓存具体配置
     *
     * @return mixed|NULL|unknown|string[]|unknown[]|object
     */
    public function getDetailCacheConfig(string $key): array
    {
        $field = [
            SystemConfig::$configValue
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where(SystemConfig::$key, $key)
            ->find();
    }

    /**
     * c 获取具体的有缓存的配置
     *
     * @return array
     */
    public function getConfigByDetailKey(string $key): string
    {
        $cacheKey = 'eef' . $key;

        $cacheObj = &$this->cache;

        $data = $cacheObj->get($cacheKey);

        if ($data) {
            return $data;
        }

        $data = $this->getDetailCacheConfig($key);

        if (0 === count($data)) {
            return '';
        }

        $cacheObj->set($cacheKey, $data[SystemConfig::$configValue], 200);

        return $data[SystemConfig::$configValue];
    }

    /**
     * 转换配置(有缓存)
     */
    public function covertMapByNoCacheConfig()
    {
        $data = $this->getDataByKey();

        if (empty($data)) {
            return [];
        }

        $tmp = [];

        foreach ($data as $key => $value) {
            $tmp[$value[SystemConfig::$key]] = $value[SystemConfig::$configValue];
        }
        return $tmp;
    }

    /**
     * c 依据某个键 获取 子集
     *
     * @return array
     */
    public function getDataByKey(string $key): array
    {
        $cacheKey = 'ssd' . $key;

        $cacheObj = $this->cache;

        $data = $cacheObj->get($cacheKey);

        if ($data) {

            return json_decode($data, true);
        }

        $data = $this->getNoCacheConfigByGroup($key);

        if (empty($data)) {
            return array();
        }

        $cacheObj->set($cacheKey, json_encode($data, JSON_UNESCAPED_UNICODE), 200);

        return $data;
    }

    /**
     * 转换配置(有缓存)
     */
    public function covertMapByConfig(string $key): array
    {
        $data = $this->getDataByKey($key);

        if (0 === count($data)) {
            return [];
        }

        $tmp = [];

        foreach ($data as $key => $value) {
            $tmp[$value[SystemConfig::$key]] = $value[SystemConfig::$configValue];
        }
        return $tmp;
    }

    /**
     * 要更新的字段
     *
     * @return array
     */
    protected function getColumToBeUpdated(): array
    {
        return [
            SystemConfig::$configValue,
            SystemConfig::$classId,
            SystemConfig::$currentId
        ];
    }

    /**
     * 获取配置值
     *
     * @param array $options
     *            条件
     * @return array
     */
    public function getValue()
    {
        $field = [
            SystemConfig::$id . ' as c_id',
            SystemConfig::$classId,
            SystemConfig::$configValue,
            SystemConfig::$key,
            SystemConfig::$parentKey,
            SystemConfig::$currentId
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->select();

        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMessageNotice()
     */
    public function getMessageNotice(): array
    {
        return [
            SystemConfig::$classId => [
                'number' => '分类必须是数字'
            ]
        ];
    }
}