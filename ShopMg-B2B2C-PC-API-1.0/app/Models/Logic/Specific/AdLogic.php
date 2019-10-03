<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Ad;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * @Bean()
 *
 * @author Administrator
 */
class AdLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    /**
     * 构造方法
     *
     * @param unknown $data
     */
    public function __construct(array $array = [], $split = '')
    {
        $this->tableName = 'mg_ad';
    }

    /**
     * 获取店品牌数据
     */
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
        return Ad::class;
    }

    /**
     * 切换状态验证
     *
     * @return string[][]
     */
    public function getMessageByChangeStatus()
    {
        return [
            Ad::$id => [
                'number' => 'id 必须是数字'
            ],
            Ad::$enabled => [
                'number' => '状态必须是数字,且介于${0-1}'
            ]
        ];
    }

    public function getSplitKeyByAdSpace()
    {
        return Ad::$adSpace_id;
    }

    /**
     * 验证page
     */
    public function getValidateByClassPage()
    {
        return [
            'page' => [
                'number' => '商品分类编号必须是数字'
            ]
        ];
    }

    /**
     * 楼层底部广告
     *
     * @return array
     */
    public function floorAdvertising(array $post): array
    {
        $page = $post['page'];

        // 楼层底部广告
        $botton = $this->getQueryBuilderProxy()
            ->field("id,pic_url,ad_link")
            ->where('ad_space_id', 48)
            ->where('enabled', 1)
            ->where('platform', 0)
            ->order('sort_num')
            ->limit(1, $page)
            ->find();
        if (empty($botton)) {
            return [];
        }

        return $botton;
    }

    /**
     * 楼层底部广告
     *
     * @return array
     */
    public function floorAdvertisingCache(array $post): array
    {
        $key = $post['page'] . '_floor_ad_pic';

        $cache = $this->cache;

        $data = $cache->get($key);

        if (!empty($data)) {
            return json_decode($data, JSON_UNESCAPED_UNICODE);
        }

        $data = $this->floorAdvertising($post);

        if (empty($data)) {
            return [];
        }

        $cache->set($key, json_encode($data), 60);

        return $data;
    }

    /**
     * 楼层中间广告
     *
     * @return array
     */
    public function floorAdvertisement(array $param): array
    {
        $page = $param['page'];

        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where('ad_space_id', 49)
            ->where('enabled', 1)
            ->where('platform', 0)
            ->order("sort_num")
            ->limit(3, $page)
            ->select();
    }

    /**
     * 楼层中间广告
     *
     * @return array
     */
    public function floorAdvertisementCache(array $param): array
    {
        $key = $param['page'] . '_middle_ad_pic';

        $cache = $this->cache;

        $data = $cache->get($key);

        if (!empty($data)) {
            return json_decode($data, JSON_UNESCAPED_UNICODE);
        }

        $data = $this->floorAdvertisement($param);

        if (empty($data)) {
            return [];
        }

        $cache->set($key, json_encode($data), 60);

        return $data;
    }

    /**
     * 获取抢购广告list
     *
     * @return array
     */
    public function getPanicAd(): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where('ad_space_id', 56)
            ->find();
    }

    /**
     * 获取抢购广告list
     *
     * @return array
     */
    public function getPanicAdByCache(): array
    {
        $key = 'panic_pic';

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getPanicAd();

        if (0 === count($data)) {

            $this->errorMessage = '没有抢购广告';

            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 100);

        return $data;
    }

    /**
     * 获取积分抢购广告
     *
     * @return array
     */
    public function getIntegralShopCityAd(): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                'platform' => 0,
                'enabled' => 1,
                'ad_space_id' => 10
            ])
            ->limit(6)
            ->order('sort_num', 'DESC')
            ->select();
    }

    /**
     * 获取积分广告list
     *
     * @return array
     */
    public function getIntegralShopCityAdCache(): array
    {
        $key = 'integral_ad_pic';

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getIntegralShopCityAd();

        if (0 === count($data)) {

            $this->errorMessage = '没有积分广告';

            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 100);

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
            'id',
            'title',
            'ad_link',
            'pic_url'
        ];
    }
}