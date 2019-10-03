<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Region;
use App\Models\Entity\DbRegion;
use Common\Tool\Tool;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 城市选择逻辑层
 * @Bean()
 */
class RegionLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbRegion::class;
    }

    public function getResult()
    {
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return Region::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [];
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
            Region::$name
        ];
    }

    /**
     * 城市选择验证规则
     */
    public function getRuleByRegionLists()
    {
        $message = [
            'parent_id' => [
                'required' => '参数不正确',
                'specialCharFilter' => '参数不正确'
            ]
        ];

        return $message;
    }

    /**
     * 城市选择列表逻辑
     */
    public function regionLists(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                'id',
                'name'
            ])
            ->where('parentid', $post['parent_id'])
            ->Order('displayorder', 'ASC')
            ->select();
    }

    /**
     * 获取编辑地区数据
     */
    public function getAddressDataByCSpecial(array $area): array
    {
        $region = $this->getRegion($area);

        if (0 === count($region)) {
            return array();
        }

        $area['prov_name'] = $region[$area['prov']];
        $area['city_name'] = $region[$area['city']];
        $area['dist_name'] = $region[$area['dist']];

        return $area;
    }

    /**
     * 获取地址缓存
     *
     * @return array
     */
    public function getAddressDataCache(array $area): array
    {
        $key = 'area_' . $area['prov'] . ',' . $area['city'] . ',' . $area['dist'];

        $data = &$this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getAddressDataByCSpecial($area);

        if (count($data) === 0) {
            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 20);

        return $data;
    }

    /**
     * 获取地区
     */
    protected function getRegion(array $area): array
    {
        if (0 === count($area)) {
            return [];
        }
        $where = [
            $area['prov'],
            $area['city'],
            $area['dist']
        ];

        $region = $this->getQueryBuilderProxy()
            ->field([
                Region::$id,
                Region::$name
            ])
            ->whereIn(Region::$id, $where)
            ->getField();

        return $region;
    }

    /**
     *
     * @param array $ids
     * @return array
     */
    protected function getRegionByIds(array $ids): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                Region::$id,
                Region::$name
            ])
            ->whereIn(Region::$id, $ids)
            ->getField();
    }

    /**
     *
     * @return array
     */
    public function getRegionByManyArea(array $area, array $ids): array
    {
        $data = $this->getRegionByIds($ids);

        if (count($data) === 0) {
            return [];
        }
        foreach ($area as $key => &$value) {

            if (isset($data[$value['prov']])) {
                $value['prov_name'] = $data[$value['prov']];
            }

            if (isset($data[$value['city']])) {
                $value['city_name'] = $data[$value['city']];
            }

            if (isset($data[$value['dist']])) {
                $value['dist_name'] = $data[$value['dist']];
            }
        }
        return $area;
    }

    /**
     * 根据增值税发票获取地区数据
     *
     * @return array
     */
    public function getRegionByCapita(array $area, array $ids): array
    {
        $data = $this->getRegionByIds($ids);

        if (count($data) === 0) {
            return [];
        }
        foreach ($area as $key => &$value) {

            if (isset($data[$value['prov_id']])) {
                $value['prov_name'] = $data[$value['prov_id']];
            }

            if (isset($data[$value['city_id']])) {
                $value['city_name'] = $data[$value['city_id']];
            }

            if (isset($data[$value['dist_id']])) {
                $value['dist_name'] = $data[$value['dist_id']];
            }
        }
        return $area;
    }

    /**
     * 根据单条增值税发票获取地区数据
     *
     * @return array
     */
    public function getRegionByOneCapita(array $area, array $ids): array
    {
        $data = $this->getRegionByIds($ids);

        if (count($data) === 0) {
            return [];
        }

        if (isset($data[$value['prov_id']])) {
            $area['prov_name'] = $data[$area['prov_id']];
        }

        if (isset($data[$value['city_id']])) {
            $area['city_name'] = $data[$area['city_id']];
        }

        if (isset($data[$value['dist_id']])) {
            $area['dist_name'] = $data[$area['dist_id']];
        }
        return $area;
    }
}
