<?php
declare(strict_types = 1);
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
namespace Tool\Strategy\SpecificStrategy;

use Tool\Strategy\Attribute\Attribute;
use Tool\Strategy\Strategy;

/**
 * 减价优惠 类
 * @author 米糕网络团队
 * @version 1.0.0
 */
class NumberMoney implements Strategy
{
	use Attribute;
	/**
	 * @param array $receive
	 */
	public function __construct( array $receive, $freightData)
    {
        $this->receive = $receive;
        
        $this->freightData = $freightData;
    }
    
    
    /**
     * {@inheritDoc}
     * @see \Home\Strategy\Strategy::acceptCash()
     */
    public function acceptCash() :float
    {
        
        $data = $this->receive;
        
        if (empty($this->freightData)) {
            throw new \Exception('商品数量错误');
        }
        
        
        $data = $this->receive;
        
        if (empty($data)) {
        	throw new \Exception('运费配置错误');
        }
        
        // 件数（商户）
        $totalNumber = $this->freightData;
        
        //首件
        $fristThing = 0;
        
        //续件
        $continuedThing = 0;
        
        //首费
        $fristMoney = 0;
        
        //续费
        $continuedMonery = 0;
        
        $unitThing = 0;
        
        $money = 0;
        
        $fristThing = intval($data['first_thing']);
        
        $continuedThing = (int)$data['continued_thing'];
        	
        $fristMoney = floatval($data['frist_money'] - $data['mail_area_monery']);
        	
        $continuedMonery = (float)$data['continued_money'];
        	
        $unitThing = $totalNumber- $fristThing ;
        $unitThing = $unitThing <= 0 ? 0 : $unitThing;
        
        $fristMoney = $fristMoney < 0 ? 0 : $fristMoney;
        
        $continuedThing = $continuedThing <= 0 ? 1 : $continuedThing;
        	
//         	                        showData($totalNumber);// 12.5
//         	                        showData($fristThing);// 1
        	
//         	                        showData($continuedThing); //1
        	
//         	                        showData($continuedMonery);// 6
        	
//         	                        showData($fristMoney); // 8   8+ (11.5/1)*6
        	
//         	                        showData($unitThing); // 11.5
        	
        $money = (float)sprintf('%.2f', $fristMoney + ($unitThing/$continuedThing)*$continuedMonery);
        return $money;
    }
}