<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderPackageComment;
use App\Common\TraitClass\CommentComponentTrait;
use App\Models\Entity\DbOrderPackageComment;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 套餐评价商品逻辑
 *
 * @author Administrator
 * @Bean()
 */
class OrderPackageCommentLogic extends AbstractLogic
{

    use CommentComponentTrait;


    public function __construct()
    {
        $this->tableName = DbOrderPackageComment::class;
    }

    /**
     * 获取结果
     */
    public function getResult()
    {
    }
    
    protected function getTableColum(): array
    {
        return [
            OrderPackageComment::$id,
            OrderPackageComment::$anwser,
            OrderPackageComment::$score,
            OrderPackageComment::$status,
            OrderPackageComment::$storeId,
            OrderPackageComment::$level,
            OrderPackageComment::$content,
            OrderPackageComment::$labels,
            OrderPackageComment::$goodsId,
            OrderPackageComment::$createTime
        ];
    }
    
    

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return OrderPackageComment::class;
    }
}