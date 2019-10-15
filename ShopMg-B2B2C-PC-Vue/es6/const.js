
/**
 * 常量 类
 */
class ConstJsData {
    /**
     * 订单属性常量
     * @returns Array
     */
    static orderConst() {
        return [
            "取消订单",
            "未支付",
            "已支付",
            "发货中",
            "已发货",
            "已收货",
            "退货审核中",
            "审核失败",
            "审核成功",
            "退款中",
            "退款成功",
            "退货中",
            "卖家已收货"
        ];
    }

    /**
     * 订单消息
     * @returns Array
     */
    static orderMessageConst() {
        return [
            {
                message: '全部',
                status: ''
            }, {
                message: '取消订单',
                status: -1
            }, {
                message: '未支付',
                status: 0
            }, {
                message: '已支付',
                status: 1
            }, {
                message: '发货中',
                status: 2
            }, {
                message: '已发货',
                status: 3
            }, {
                message: '已收货',
                status: 4
            }, {
                message: '退货审核中',
                status: 5
            }, {
                message: '审核失败',
                status: 6
            }, {
                message: '审核成功',
                status: 7
            }, {
                message: '退款中',
                status: 8
            }, {
                message: '退款成功',
                status: 9
            }];
    }

    /**
     * 订单评价
     */
    static orderCommentConst() 
    {
        return [{
            message: '全部',
            status: ''
          }, {
            message: '未评价',
            status: 0
          }, {
            message: '已评价',
            status: 1
          }]
    }
}

export { ConstJsData };