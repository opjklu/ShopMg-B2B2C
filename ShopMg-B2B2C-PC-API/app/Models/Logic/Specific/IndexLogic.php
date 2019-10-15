<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Ad;
use App\Models\Entity\DbAd;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 首页逻辑处理层
 * @Bean()
 */
class IndexLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbAd::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'classId' => [
                'required' => '必须输入商品分类标识'
            ]
        ];
        return $message;
    }

    /**
     * 获取首页的信息
     */
    public function getHomeInfo()
    {
        return [
            'banner' => $this->getQueryBuilderProxy()
                ->where('ad_space_id', 1)
                ->limit(5)
                ->order('sort_num', 'DESC')
                ->order('hit_num', 'DESC')
                ->select()
        ];
    }

    /**
     * 获取店品牌数据
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
        return Ad::class;
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
