<?php
declare(strict_types = 1);

namespace Tool;

/**
 * 订单状态
 * @author wq
 *
 */
class OrderStatus
{
    // -1:取消订单,0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功, 10：代发货，11待收货
    const CancellationOfOrder = -1;
    
    const NotPaid = 0;
    
    const YesPaid = 1;
    
    const InDelivery = 2;
    
    const AlreadyShipped = 3;
    
    const ReceivedGoods = 4;
    
    const ReturnAudit = 5;
    
    const AuditFalse  = 6;
    
    const AuditSuccess = 7;
    
    const Refund = 8;
    
    const ReturnMonerySucess = 9;
    
    const ToBeShipped = 1;
    
    const ReceiptOfGoods = 3;
}