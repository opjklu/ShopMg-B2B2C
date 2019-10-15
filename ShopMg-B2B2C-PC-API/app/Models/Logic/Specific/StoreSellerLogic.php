<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreSeller;
use App\Models\Entity\DbStoreSeller;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\ParamsParse;

/**
 * 入驻申请成功逻辑处理
 *
 * @author 米糕网络团队
 * @version 1.0
 * @Bean()
 */
class StoreSellerLogic extends AbstractLogic
{

    /**
     * 构造方法
     *
     * @param array $args
     */
    public function __construct()
    {
        $this->tableName = DbStoreSeller::class;
    }

    public function getResult()
    {
    }

    /**
     * 获取商家账号
     * @return array
     */
    public function getSellerDataByStore(array $data, string $splitKey)
    {

        $field = [
            StoreSellerModel::$sellerName_d,

            StoreSellerModel::$storeId_d
        ];

        $paramEntity = new ParamsParse($data, $field, StoreSellerModel::$storeId_d, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }
    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return StoreSeller::class;
    }
}