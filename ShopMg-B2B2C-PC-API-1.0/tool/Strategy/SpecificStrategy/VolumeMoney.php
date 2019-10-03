<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
namespace Tool\Strategy\SpecificStrategy;

use Tool\Strategy\Strategy;

/**
 * 按体积
 */
class VolumeMoney implements Strategy
{
   
    /**
     * 
     * {@inheritDoc}
     * @see \Tool\Strategy\Strategy::acceptCash()
     */
    public function acceptCash() :float
    {
        // TODO Auto-generated method stub
        
        return 0;
    }

    
}