<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsSpecItem;
use App\Models\Entity\DbGoodsSpecItem;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 规格项逻辑
 * @Bean()
 *
 * @author 米糕网络团队
 */
class GoodsSpecItemLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbGoodsSpecItem::class;
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
        return GoodsSpecItem::class;
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
            GoodsSpecItem::$item
        ];
    }

    /**
     * 获取规格项名称
     *
     * @param array $data
     *            商品数组
     * @param string $splitKey
     *            分割建
     * @return array
     */
    public function getSpecItemName(array $data, string $splitKey): array
    {
        $keyArray = array_column($data, $splitKey);

        $length = count($keyArray);

        if ($length === 0) {
            return [];
        }

        $temp = [];

        for ($i = 0; $i < $length; $i++) {

            $temp = array_merge(explode('_', $keyArray[$i]), $temp);
        }

        $idString = array_unique($temp);

        $whereField = GoodsSpecItem::$id;

        $specData = $this->getQueryBuilderProxy()
            ->whereIn($whereField, $idString)
            ->select();

        return $specData;
    }

    /**
     * 获取规格组相关字段
     */
    public function getSplitKeyBySpecial()
    {
        return GoodsSpecItem::$specId;
    }
}
