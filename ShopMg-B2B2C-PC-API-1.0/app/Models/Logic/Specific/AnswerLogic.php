<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Answer;
use App\Common\FieldMapping\Problem;
use App\Common\FieldMapping\User;
use App\Models\Entity\DbAnswer;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 * @Bean()
 */
class AnswerLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbAnswer::class;
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

    public function getProblemValidateByLogin()
    {
        $message = [
            'goods_id' => [
                'required' => '必须输入商品ID'
            ],
            'problem' => [
                'required' => '必须输入问题内容'
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
        return Problem::class;
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

    public function getAnswerByQuestion(array $data)
    {
        $field = [
            Answer::$id,
            Answer::$answer,
            Answer::$addtime,
            Answer::$problemId
        ];

        // $paramEntity = new ParamsParse($data, $field, Answer::$problemId, $splitKey)

        $goods = $this->getDataByOtherModel($field, Answer::$problemId);
        return $goods;
    }
}
