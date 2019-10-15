<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreAdv;
use App\Models\Entity\DbStoreAdv;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 店铺广告
 *
 * @author Administrator
 *
 * @Bean()
 */
class StoreAdvLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbStoreAdv::class;
    }

    /**
     * 获取结果（广告）
     */
    public function getResult()
    {
    }

    public function getStoreButtonImg(array $post): array
    {
        $storeId = $post['store_id'];

        $cacheKey = 's_list' . $storeId;

        $cache = &$this->cache;

        $data = $cache->get($cacheKey);

        if ($data) {
            return json_decode($data, true);
        }
        // 店铺广告(列表)

        $field = [
            'id,adv_title,adv_content,ad_url'
        ];

        $time = time();

        $list = $this->getQueryBuilderProxy()
            ->field($field)
            ->where('store_id', $storeId)
            ->where('status', 0)
            ->where('ap_id', 1043)
            ->condition([
                [
                    'adv_end_date',
                    '<=',
                    $time
                ],
                [
                    'adv_start_date',
                    '>=',
                    $time
                ]
            ])
            ->select();
        if (0 === count($list)) {
            return [];
        }

        $cache->set($cacheKey, json_encode($list), 100);

        return $list;
    }

    /**
     * 获取banner
     */
    public function getBanner(array $post): array
    {
        $storeId = $post['store_id'];

        $cacheKey = 'static_adds' . $storeId;

        $cache = &$this->cache;

        $data = $cache->get($cacheKey);

        if ($data) {
            return json_decode($data, true);
        }

        // 获取店铺轮播图
        $b_where['store_id'] = $storeId;
        $b_where['status'] = 0;

        $b_where['ap_id'] = 1053;
        $field = [
            'id',
            'adv_title',
            'adv_content',
            'ad_url'
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition($b_where)
            ->select();

        if (0 === count($data)) {
            return [];
        }

        $cache->set($cacheKey, json_encode($data, JSON_UNESCAPED_UNICODE), 70);

        return $data;
    }

    /**
     * 获取 不规则图片
     */
    public function getBannerButton(array $post)
    {
        $storeId = $post['store_id'];

        $cacheKey = 'button_adds' . $storeId;

        $cache = &$this->cache;

        $data = $cache->get($cacheKey);

        if ($data) {
            return json_decode($data, true);
        }

        // 店铺广告(左)

        $time = time();

        $field = [
            'id',
            'adv_title',
            'adv_content',
            'ad_url'
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition([
                [
                    'adv_start_date',
                    '>',
                    $time
                ],
                [
                    'adv_end_date',
                    '<',
                    $time
                ]
            ])
            ->where('ap_id', 1038)
            ->where('store_id', $storeId)
            ->where('status', 0)
            ->limit(1)
            ->select();

        $reslut = [];

        if (0 !== count($data)) {
            $reslut['left'] = $data;
        }

        // 店铺广告(右)

        $reight = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition([
                [
                    'adv_start_date',
                    '>',
                    $time
                ],
                [
                    'adv_end_date',
                    '<',
                    $time
                ]
            ])
            ->where('ap_id', 1052)
            ->where('store_id', $storeId)
            ->where('status', 0)
            ->limit(2)
            ->select();

        if (0 !== count($reight)) {
            $reslut['reight'] = $reight;
        }

        if (0 === count($reslut)) {
            return [
                'left' => [],
                'reight' => []
            ];
        }

        $cache->set($cacheKey, json_encode($reslut), 70);

        return $reslut;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return StoreAdv::class;
    }
}