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
declare(strict_types = 1);
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderPackageCommentImg;
use App\Common\TraitClass\CommentComponentImgTrait;
use App\Models\Entity\DbOrderPackageCommentImg;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 套餐评价晒图
 *
 * @author Administrator
 *        
 *         @Bean()
 */
class OrderPackageCommentImgLogic extends AbstractLogic
{
    use CommentComponentImgTrait;

    public function __construct()
    {
        $this->tableName = DbOrderPackageCommentImg::class;
    }

    /**
     * 获取结果
     */
    public function getResult()
    {}

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return OrderPackageCommentImg::class;
    }

    /**
     *
     * @return array
     */
    public function getOrderCommentImage(array $data): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(OrderPackageCommentImg::$commentId, $data['id'])
            ->select();
    }
}