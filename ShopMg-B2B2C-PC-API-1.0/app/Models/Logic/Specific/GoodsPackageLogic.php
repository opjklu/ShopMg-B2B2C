<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsPackage;
use App\Common\TraitClass\SmsVerification;
use App\Models\Entity\DbGoodsPackage;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\ParamsParse;

/**
 * 逻辑处理层
 * @Bean()
 */
class GoodsPackageLogic extends AbstractLogic
{
    use SmsVerification;

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    /**
     *
     * @return the $cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * 构造方法
     *
     * @param array $data
     *
     */
    public function __construct()
    {
        $this->tableName = DbGoodsPackage::class;
    }

    /**
     * 获取结果
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
        return GoodsPackage::class;
    }

    /**
     * 套餐购物车检查数据
     *
     * @return array
     */
    public function getValidateByGoodsPackage(): array
    {
        $message = [
            'id' => [
                'required' => '套餐Id参数必须',
                'checkStringIsNumber' => '套餐Id,例如1,2,3'
            ]
        ];
        return $message;
    }

    // 套餐立即购买--获取商品详情
    public function getPackageBuyNow(array $post): array
    {
        $carry_id = $post['id'];

        $userId = session()->get('user_id');

        $catch_name = $carry_id . "goods_package" . $userId;
        // 检查缓存中时候有商品信息 如果没有则进行查询如果有的话则进行提取

        $cache = &$this->cache;

        $data = $cache->get($catch_name);

        if ($data) {
            return json_decode($data, true);
        }

        $field = [
            'id',
            'total',
            'discount',
            'store_id',
            'title'
        ];

        $reData = $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn('id', explode(',', $carry_id))
            ->select();

        if (0 === count($reData)) {
            return [];
        }

        $cache->set($catch_name, json_encode($reData), 60);

        return $reData;
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
            GoodsPackage::$id,
            GoodsPackage::$total,
            GoodsPackage::$discount,
            GoodsPackage::$storeId,
            GoodsPackage::$title => 'package_title'
        ];
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
            'goods_id' => [
                'number' => '商品编号必须是数字'
            ],
            'store_id' => [
                'number' => '店铺编号必须是数字'
            ]
        ];
    }

    /**
     * 获取商品套餐
     */
    public function getPackageListCache(array $post): array
    {
        $key = $post['store_id'] . 'package_list_me';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getPackageList($post);

        if (count($data) === 0) {
            $this->errorMessage = '没有套餐数据';
            return [];
        }

        $cache->set($key, json_encode($data), 60);

        return $data;
    }

    /**
     * 获取商品套餐
     */
    public function getPackageList(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(GoodsPackage::$storeId, $post['store_id'])
            ->where(GoodsPackage::$status, 1)
            ->select();
    }

    /**
     * 获取关联字段
     *
     * @return string
     */
    public function getSplitKeyByStore(): string
    {
        return GoodsPackage::$storeId;
    }

    /**
     * 根据编号获取套餐数据
     */
    public function getPackageListByIds(array $post): array
    {
        $field = [
            GoodsPackage::$id,
            GoodsPackage::$storeId
        ];
        return $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn(GoodsPackage::$id, $post['id'])
            ->select();
    }

    /**
     * 根据套餐购物车获取套餐商品数据
     *
     * @return array
     */
    public function getPackageByPackageCart(array $dataSources, string $splitKey): array
    {
        $field = $this->getTableColum();

        $paramEntity = new ParamsParse($dataSources, $field, GoodsPackage::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }
}
