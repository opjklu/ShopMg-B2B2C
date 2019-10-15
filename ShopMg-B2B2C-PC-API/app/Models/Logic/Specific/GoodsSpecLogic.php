<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsSpec;
use App\Models\Entity\DbGoodsSpec;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\ArrayChildren;

/**
 * 逻辑处理层
 * @Bean()
 */
class GoodsSpecLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbGoodsSpec::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'type_id' => [
                'required' => '商品类型必传'
            ],
            'store_id' => [
                'required' => '店铺Id必传'
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
        return GoodsSpecLogic::class;
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
     * 获取商品规格组名称
     *
     * @author 米糕网络团队
     */
    public function getGoodSpecial(array $data, string $splitKey): array
    {
        $idString = array_column($data, $splitKey);

        $field = [
            GoodsSpec::$id,
            GoodsSpec::$name
        ];

        $specData = $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn(GoodsSpec::$id, $idString)
            ->select();

        if (0 === count($specData)) {
            return [];
        }

        $specData = (new ArrayChildren($specData))->convertIdByData(GoodsSpec::$id);

        return [
            'spec_group' => $specData,
            'spec_children' => $data
        ];
    }
}
