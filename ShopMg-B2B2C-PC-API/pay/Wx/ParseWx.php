<?php
declare(strict_types = 1);
namespace Pay\Wx;

use Swoft\App;
use App\Models\Logic\Specific\OrderWxpayLogic;

/**
 * 微信支付处理
 * 
 * @author wq
 *        
 */
class ParseWx
{

    /**
     * 处理
     * 
     * @param array $data
     *            订单数据
     * @param int $type
     *            支付类型
     * @return array
     */
    public static function parse(array $data, int $type): string
    {
        return App::getBean(OrderWxpayLogic::class)->parseOrderByWx($data, $type);
    }
    
    /**
     * 处理余额充值
     */
    public static function parseBalance(array $data): string
    {
        return App::getBean(OrderWxpayLogic::class)->getResultByPay($data);
    }
}