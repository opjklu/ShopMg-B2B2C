<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Brand;
use App\Common\FieldMapping\User;
use App\Models\Entity\DbBrand;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\ParamsParse;

/**
 * 逻辑处理层
 * @Bean()
 */
class BrandLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbBrand::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'id' => [
                'required' => '必须输入品牌ID'
            ]
        ];
        return $message;
    }

    /**
     * 获取结果
     */
    public function getResult()
    {
        return $this->getQueryBuilderProxy()
            ->field([
                'id',
                'brand_logo',
                'brand_name'
            ])
            ->where('recommend', 1)
            ->where('status', 1)
            ->select();
    }

    /**
     * 获取推荐的品牌
     *
     * @return array
     */
    public function getRecommendBrandListCache(): array
    {
        $key = 'recommend_brand_list';

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getResult();

        if (0 === count($data)) {
            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 60);

        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return Brand::class;
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
            User::$userName
        ];
    }

    /**
     * 品牌列表逻辑
     */
    public function getBrandLists(array $post): array
    {
        $cache = &$this->cache;

        $key = 'brand_lists';

        $ret = $cache->get($key);

        if ($ret) {
            return json_decode($ret, true);
        }

        $field = [
            'id',
            'brand_name'
        ];

        $where['status'] = 1;

        $ret = $this->getQueryBuilderProxy()
            ->field($field)
            ->where('status', 1)
            ->order('create_time', 'DESC')
            ->select();

        if (0 === count($ret)) {
            $this->errorMessage = '暂无数据';
            return [];
        }

        $cache->set($key, json_encode($ret, JSON_UNESCAPED_UNICODE), 160);

        return $ret;
    }

    /**
     * 获取品牌数据
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getBrandForGoods(array $data, string $splitKey): array
    {
        $field = [
            Brand::$id,
            Brand::$brandName
        ];

        $paramEntity = new ParamsParse($data, $field, Brand::$id, $splitKey);

        $data = $this->parseAssociatedData($paramEntity);

        return $data;
    }
}
