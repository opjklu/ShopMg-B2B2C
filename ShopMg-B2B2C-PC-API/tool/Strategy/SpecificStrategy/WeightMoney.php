<?php
declare(strict_types = 1);
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



use Tool\Strategy\Attribute\Attribute;
use Tool\Strategy\Strategy;

/**
 * 买就送代金券 类
 * @author 米糕网络团队
 * @version 1.0.0
 */
class WeightMoney implements Strategy
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
    	
        // 总重（单个商户）
        $heavy = $this->freightData;
        
        $money = 0;
        
        //首重
        $fristHeavy = 0;
        
        //续重
        $continuedHeavy = 0;
        
        //首费
        $fristMoney = 0;
        
        //续费
        $continuedMonery = 0;
        
        //计算钱的重量
        $unitWeight = 0;
        
        	
        $fristHeavy = floatval($data['first_weight']);
        	
        $continuedHeavy = floatval($data['continued_heavy']);
        	
        $fristMoney = floatval($data['frist_money'] - $data['mail_area_monery']);
        	
        $continuedMonery = (float)$data['continued_money'];
        	
        $unitWeight = ($heavy - $fristHeavy)/1000 ;
        	
        $unitWeight = $unitWeight <= 0 ? 0 : $unitWeight;
        
        $fristMoney = $fristMoney < 0 ? 0 : $fristMoney;
        
        $continuedHeavy = $continuedHeavy <=0 ? 1 : $continuedHeavy;
        	 
        	//         showData($heavy);// 12.5 20
        	
        	//         showData($fristHeavy);// 1 2
        	
        	//         showData($continuedHeavy); //1 5
        	
        	//         showData($continuedMonery);// 6 7
        	
        	//         showData($fristMoney); // 8   8+ (11.5/1)*6 4
        	
        	//         showData($unitWeight); // 11.5 (18/5)*
        	
        $money = sprintf('%.2f', $fristMoney + ($unitWeight/$continuedHeavy)*$continuedMonery);
        return (float)$money;
    }
}