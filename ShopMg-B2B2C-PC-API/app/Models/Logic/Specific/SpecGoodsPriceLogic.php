<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\SpecGoodsPrice;
use App\Models\Entity\DbSpecGoodsPrice;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\ParamsParse;
use Tool\ParamsParseInterface;

/**
 * 逻辑处理层
 * @Bean()
 */
class SpecGoodsPriceLogic extends AbstractLogic
{


    public function __construct()
    {
        //

        //

        // $this->getQueryBuilderProxy() = Base::getInstance('SpecGoodsPrice');
        $this->tableName = DbSpecGoodsPrice::class;
    }

    /**
     * 获取商品规格数据
     *
     * @return array
     */
    public function getSpecByGoods(array $data, string $splitKey)
    {
        $field = array(
            SpecGoodsPrice::$id,
            SpecGoodsPrice::$goodsId,
            SpecGoodsPrice::$key,
            SpecGoodsPrice::$sku
        );

        $paramEntity = new ParamsParse($data, $field, SpecGoodsPrice::$goodsId, $splitKey);

        $data = $this->getDataByOtherModel($paramEntity);

        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::parseReflectionData()
     */
    protected function parseReflectionData(array $getData, ParamsParseInterface $paramEntity)
    {
        $temp = [];

        foreach ($getData as $key => &$value) {
            if (empty($value[SpecGoodsPrice::$goodsId])) {
                continue;
            }
            $temp[$value[SpecGoodsPrice::$goodsId]] = $value;
        }

        $twoMany = $paramEntity->getDataSources();

        $flagArray = array();

        $splitKey = $paramEntity->getSplitKey();

        foreach ($twoMany as $key => &$association) {
            $flagArray[$association[$splitKey]] = array_merge(empty($temp[$association[$splitKey]]) ? [] : $temp[$association[$splitKey]], $association);
        }

        return $flagArray;
    }

    /**
     * 获取 规格相关字段
     */
    public function getSplitKeyByGoods()
    {
        return SpecGoodsPrice::$key;
    }

    /**
     */
    public function getResult()
    {
    }

    public function getMapperClassName(): string
    {
        return SpecGoodsPrice::class;
    }
}