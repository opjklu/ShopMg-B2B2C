<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsImages;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\ArrayChildren;
use Tool\ParamsParse;
use Tool\ParamsParseInterface;
use Tool\QueryBuilderProxy;

/**
 * 商品图片逻辑处理
 *
 * @author Administrator
 * @Bean()
 */
class GoodsImagesLogic extends AbstractLogic
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
     * @param array $data
     * @param string $split
     */
    public function __construct()
    {
        $this->tableName = 'mg_goods_images';
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
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return GoodsImages::class;
    }

    /**
     *
     * @return mixed|void
     */
    protected function getSlaveColumnByWhere()
    {
        return GoodsImages::$goodsId;
    }

    /**
     *
     * @return array
     */
    public function getSlaveField()
    {
        return [
            GoodsImages::$picUrl,
            GoodsImages::$goodsId
        ];
    }

    /**
     * 数据处理组合
     *
     * @param array $slaveData
     * @param string $slaveColumnWhere
     * @return array
     */
    protected function parseSlaveData(array $data, string $splitKey, array $slaveData, $slaveColumnWhere)
    {
        $slaveData = (new ArrayChildren($slaveData))->convertIdByData(GoodsImages::$goodsId);

        foreach ($data as $key => &$value) {
            if (!isset($value[$splitKey]) || !isset($slaveData[$value[$splitKey]])) {
                continue;
            }
            $value = array_merge($slaveData[$value[$splitKey]], $value);
        }
        return $data;
    }

    /**
     * 再次处理where 根据主表数据查从表数据
     *
     * @return string
     */
    protected function parseSlaveWhereAgain(QueryBuilderProxy $queryBuild)
    {
        $queryBuild->where(GoodsImages::$isThumb, 1);
    }

    /**
     * 检查参数
     */
    public function checkValidateByGoodsId()
    {
        return [
            'goods_id' => [
                'number' => 'goods_id必须是数字'
            ]
        ];
    }

    /**
     * 获取压缩的图片
     */
    public function getThumbImagesByGoodsId(array $goods, string $splitKey): array
    {
        $cache = &$this->cache;

        $key = $goods[$splitKey] . '_goods_thumb_images';

        $data = $cache->get($key);

        if (!empty($data)) {
            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field([
                GoodsImages::$picUrl
            ])
            ->condition([
                GoodsImages::$goodsId => $goods[$splitKey],
                GoodsImages::$isThumb => 1,
                GoodsImages::$status => 1
            ])
            ->find();

        if (empty($data)) {

            $this->errorMessage = '没有找到图片信息';

            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 72);

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
            GoodsImages::$picUrl,
            GoodsImages::$goodsId
        ];
    }

    /**
     * 获取自营店铺商品
     *
     * @return array
     */
    public function getSelfStoreGoodsImage(array $goodsData): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn(GoodsImages::$goodsId, array_column($goodsData, 'p_id'))
            ->where(GoodsImages::$isThumb, 0)
            ->select();
    }

    /**
     * 获取自营店铺商品
     *
     * @return array
     */
    public function getSelfStoreGoodsImageCache(array $args, array $goodsData): array
    {
        $key = 'store_goods_image_key_self' . $args['p'];

        $cache = & $this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_encode($data);
        }

        $data = $this->getSelfStoreGoodsImage($goodsData);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data), 60);
        
        return $data;
    }

    /**
     * 获取图片（根据商品）
     */
    public function getImageByArrayGoods(array $source): array
    {
        $field = [
            GoodsImages::$goodsId,
            GoodsImages::$picUrl
        ];

        $paramEntity = new ParamsParse($source, $field, GoodsImages::$goodsId, 'p_id');

        return $this->parseAssociatedData($paramEntity);
    }

    /**
     * 获取数据源
     * @param ParamsParseInterface $paramEntity
     * @param array $ids
     * @return array
     */
    protected function getAssciatedSource(ParamsParseInterface $paramEntity, array $ids): array
    {
        if (0 === count($ids)) {
            $this->errorMessage = '条件为空';
            return [];
        }

        $key = implode('', $ids) . '-image-111';

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = parent::getAssciatedSource($paramEntity, $ids);

        if (0 === count($data)) {
            return [];
        }

        $this->cache->set($key, json_encode($data), 100);

        return $data;

    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Models\Logic\Specific\AbstractLogic::parseWhere()
     */
    protected function parseWhere(QueryBuilderProxy $queryBuilder): void
    {
        $queryBuilder->where(GoodsImages::$isThumb, 1);
    }

    /**
     * 获取商品图片(商品详情)
     */
    public function getGoodsImagesByPid(array $data, string $splitKey): array
    {
        // 获取图片数组
        return $this->getQueryBuilderProxy()
            ->field([
                'id',
                'pic_url'
            ])
            ->where('goods_id', $data[$splitKey])
            ->select();
    }

    /**
     * 获取商品图片(商品详情)
     */
    public function getGoodsImagesByPidCache(array $data, string $splitKey): array
    {
        $key = 'goods_images_dd' . $data[$splitKey];

        $images = $this->cache->get($key);

        if ($images) {
            return json_decode($images, true);
        }

        $data = $this->getGoodsImagesByPid($data, $splitKey);

        if (count($data) === 0) {
            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 60);

        return $data;
    }
}