<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderCommentImg;
use App\Common\TraitClass\CommentComponentImgTrait;
use App\Models\Entity\DbOrderCommentImg;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\ArrayChildren;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class OrderCommentImgLogic extends AbstractLogic
{
    use CommentComponentImgTrait;


    public function __construct()
    {
        $this->tableName = DbOrderCommentImg::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'goods_id' => [
                'required' => '必须输入商品ID'
            ]
        ];
        return $message;
    }

    public function getValidatesByLogin()
    {
        $message = [
            'goods_id' => [
                'required' => '必须输入商品ID'
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
        return OrderCommentImg::class;
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

    protected function getSlaveColumnByWhere()
    {
        return OrderCommentImg::$commentId;
    }

    public function getSlaveField()
    {
        return [
            OrderCommentImg::$path,
            OrderCommentImg::$commentId
        ];
    }

    protected function parseSlaveData(array $data, string $splitKey, array $slaveData, $slaveColumnWhere)
    {
        $slaveData = (new ArrayChildren($slaveData))->convertIdByData(OrderCommentImg::$commentId);

        foreach ($data as $key => &$value) {
            if (!isset($slaveData[$value[$splitKey]])) {
                continue;
            }
            $value = array_merge($value, $slaveData[$value[$splitKey]]);
        }
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
            OrderCommentImg::$commentId,
            OrderCommentImg::$path
        ];
    }

    /**
     *
     * @return array
     */
    public function getOrderCommentImage(array $data): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(OrderCommentImg::$commentId, $data['id'])
            ->select();
    }
}
