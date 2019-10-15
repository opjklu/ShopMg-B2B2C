<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreHelp;
use App\Models\Entity\DbStoreHelp;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class StoreHelpLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbStoreHelp::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'page' => [
                'required' => '必须输入分页信息'
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
        // return Brand::class;
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
        // return [
        // User::$userName,
        // ];
    }

    public function enter_flow($title)
    {
        $where[StoreHelp::$title] = $title;
        $where[StoreHelp::$status] = 1;
        $field = "id,title,info,help_url";
        $data = $this->getQueryBuilderProxy()
            ->where($where)
            ->field($field)
            ->find();
        return $data;
    }
}
