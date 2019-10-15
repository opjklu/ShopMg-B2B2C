<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\IntegralGoods;
use App\Models\Entity\DbIntegralGoods;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 逻辑处理层
 * @Bean()
 */
class IntegralGoodsLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
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


    public function __construct()
    {
        $this->tableName = DbIntegralGoods::class;
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
        return IntegralGoods::class;
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
     * @see \App\Models\Logic\Specific\AbstractLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            'id',
            'goods_id',
            'integral',
            'money',
            'create_time',
            'store_id'
        ];
    }

    /**
     * 最新兑换商品
     */
    public function getNewList(): array
    {
        $where['status'] = 1;
        $where['is_show'] = 1;

        $dataList = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition($where)
            ->limit(20)
            ->order('create_time', 'DESC')
            ->select();

        return $dataList;
    }

    /**
     * 获取商品关联key
     *
     * @return string
     */
    public function getSplitKeyByGoods(): string
    {
        return IntegralGoods::$goodsId;
    }

    /**
     * 验证是否可兑换
     */
    public function checkIsConvertibility(array $post): array
    {
        $integral = $this->getIntegralGoodInfo($post);

        if (empty($integral)) {
            $this->errorMessage = '积分商品错误';
            return [];
        }

        if ((time() - $integral[IntegralGoods::$createTime] - $integral[IntegralGoods::$delayed] * 86400) > 0) {
            $this->errorMessage = '购买还没开始';
            return [];
        }
        return $integral;
    }

    /**
     * 获取积分商品的详细信息
     */
    public function getIntegralGoodInfo(array $post)
    {
        $cache = &$this->cache;

        $key = $post['id'] . '_integral_what';

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(IntegralGoods::$id, $post['id'])
            ->where(IntegralGoods::$isShow, 1)
            ->find();

        if (0 == count($data)) {
            $this->errorMessage = '没有数据';
            return [];
        }

        $data[IntegralGoods::$delayed] = $data[IntegralGoods::$delayed] * 86400;

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 60);

        return $data;
    }
}
