<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsDetail;
use App\Models\Entity\DbGoodsDetail;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 逻辑处理层
 * @Bean()
 */
class GoodsDetailLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;


    public function __construct()
    {
        //
        //

        // $this->getQueryBuilderProxy() = Base::getInstance('GoodsDetail');
        $this->tableName = DbGoodsDetail::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'goods_id' => [
                'required' => '必须输入商品Id'
            ]
        ];
        return $message;
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
        return GoodsDetail::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [
        ];
    }

    /**
     * 获取商品详情
     */
    public function getGoodDetail(array $post): string
    {
        $cache = &$this->cache;

        $key = $post[GoodsDetail::$goodsId] . '_goods_detail_pc';

        $data = $cache->get($key);

        if (!empty($data)) {
            return $data;
        }

        $data = $this->getQueryBuilderProxy()
            ->field([
                GoodsDetail::$detail
            ])
            ->condition([
                'goods_id' => $post[GoodsDetail::$goodsId]
            ])
            ->find();
        if (0 === count($data)) {
            $this->errorMessage = '暂无详情';
            return '';
        }
        $detail = htmlspecialchars_decode($data[GoodsDetail::$detail]);

        $cache->set($key, $detail, 90);

        return $detail;
    }

    /**
     * 验证字段
     */
    public function getMessageByDetail()
    {
        return [
            GoodsDetail::$goodsId => [
                'number' => '必须是数字'
            ]
        ];
    }
}
