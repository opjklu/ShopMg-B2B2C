<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 米糕网络团队 All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>\n
// +----------------------------------------------------------------------
namespace App\Common\FieldMapping;

use App\Common\FieldMapping\BaseModel;

/**
 * 尾货清仓
 * 
 * @author 米糕网络团队
 * @version 1.0.1
 */
class PoopGoods
{

    private static $obj;

    public static $id;
 // 主键编号
    public static $poopId;
 // 尾货清仓主表编号
    public static $goodsId;
 // 商品编号
    
    /**
     * 获取类的实例
     * 
     * @return \App\Common\FieldMapping\PoopGoodsModel
     */
    public static function getInitnation()
    {
        $name = __CLASS__;
        return static::$obj = ! (static::$obj instanceof $name) ? new static() : static::$obj;
    }

    /**
     * 根据父级id 插入数据
     * 
     * @param array $data
     *            要插入的数据
     * @param int $insertId
     *            类别编号
     * @return boolean
     */
    public function addGoodsByPromotionId(array $data, $insertId)
    {
        if (empty($data[static::$goodsId]) || ! is_array($data) || $insertId == 0) {
            $this->rollback();
            return false;
        }
        
        $data = $this->create($data);
        if (empty($data)) {
            $this->rollback();
            return false;
        }
        $proGoods = array();
        foreach ($data[static::$goodsId] as $key => $value) {
            $proGoods[$key][static::$goodsId] = $value;
            $proGoods[$key][static::$poopId] = $insertId;
        }
        
        $flag = array();
        
        // 去重
        foreach ($proGoods as $key => $value) {
            $id = intval($value[static::$goodsId]);
            if (! isset($flag[$id])) {
                $flag[$id] = $value;
            }
        }
        
        if (empty($flag)) {
            $this->rollback();
            return false;
        }
        
        rsort($flag);
        
        $insertProId = $this->addAll($flag);
        
        if (empty($insertProId)) {
            $this->rollback();
            return false;
        }
        $this->commit();
        return $insertProId;
    }
}