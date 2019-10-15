<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsCombo;
use App\Common\TraitClass\GoodsComboComponent;
use App\Models\Entity\DbGoodsCombo;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class GoodsComboLogic extends AbstractLogic
{
    use GoodsComboComponent;


    public function __construct()
    {
        $this->tableName = DbGoodsCombo::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        return [
            'goods_id' => [
                'required' => '必须输入搭配商品ID'
            ]
        ];
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
        return GoodsCombo::class;
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
}