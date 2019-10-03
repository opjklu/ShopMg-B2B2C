<template>
    <div class="fullOrde">
        <div class="alike" v-for="(item, index) in data.data" :key="index">
            <div class="both">
                <input class="l" type="checkbox">
                <p class="l">{{item.create_time | formatDate}}</p>
                <p class="l">订单号： {{item.order_sn_id}}</p>
                <p class="l">
                    店铺：
                    <router-link
                        target="_blank"
                        :to="{path:'/storehome',query:{id:item.store_id}}"
                    >{{item.shop_name}}</router-link>
                </p>
                <img src="../../../../assets/img/qq.jpg">
                <i v-if="item.order_status == 4" class="el-icon-delete r"></i>
            </div>
            <div class="order-item clearfix">
                <div class="order-info l">
                    <div class="zuo" v-for="(goods,i) in orderGoodsData" :key="i">
                        <div class="huowu" v-if="goods.order_id === item.id">
                            <router-link
                                target="_blank"
                                class="a-block"
                                :to="{path:'/inroyaldrink',query:{id:goods.goods_id}}"
                            >
                                <img v-lazy="URL + goods.pic_url">
                            </router-link>
                            <p>
                                <router-link
                                    target="_blank"
                                    class="a-block"
                                    :to="{path:'/inroyaldrink',query:{id:goods.goods_id}}"
                                >{{goods.title}}</router-link>
                            </p>
                            <p>￥{{goods.goods_price}}</p>
                            <p>{{goods.goods_num}}</p>
                            <router-link class="goods-operate" target="_blank" to>投诉卖家</router-link>
                        </div>
                    </div>
                </div>
                <div class="right r" >
                    <p>
                        <span>￥{{parseFloat(item.price_sum)+parseFloat(item.shipping_monery)|keep2Num}}</span>
                        <span>（含运费：￥{{item.shipping_monery|keep2Num}}）</span>
                    </p>
                    <p>
                        <span v-if="item.order_status == 0">等待买家付款</span>
                        <router-link
                            class="a-block"
                            target="_blank"
                            :to="{path: '/orderDetail', query: {id: item.id}}"
                        >订单详情</router-link>
                    </p>
                    <p>
                        <span
                            ref="msg"
                            class="hand"
                            @click="state(item)"
                        >{{$Status[item.order_status]}}</span>
                        <a
                            v-if="item.order_status == 0"
                            class="a-block"
                            @click="cancelOrder(item.id)"
                        >取消订单</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="pagation" v-if="data.length != 0">
            <el-pagination
                background
                layout="prev, pager, next"
                :total="~~data.count"
                :page-size="data.page_size"
                @current-change="handleCurrentChange"
            ></el-pagination>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: [],
            currentPage: 1,
            orderGoodsData: [],
            h: true,
            dingDan: false,
            message: ""
        };
    },
    created() {
        this.Order();
        this.$emit("changeOrderNum");
    },
    methods: {
        state(item) {
            this.HTTP(this.$httpConfig.regularOrders, { id: item.id }, "post")
                .then(res => {
                    //console.log(res.data.status)
                    if (res.data.status === 1) {
                        let total_price =
                            parseFloat(item.price_sum) +
                            parseFloat(item.shipping_monery);
                        total_price = total_price.toFixed(2);
                        console.log(total_price);
                        this.$router.push({
                            path: "/pay",
                            query: {
                                total_price: total_price
                            }
                        });
                    }
                })
                .catch(e => {});
        },
        // 全部商品
        Order() {
            this.HTTP(
                this.$httpConfig.pendingPayment,
                {
                    page: this.currentPage
                },
                "post",
                false
            )
                .then(res => {
                    this.data = res.data.data.order;
                    this.orderGoodsData = res.data.data.order_goods;
                })
                .catch(res => {
                    this.orderGoodsData = [];
                    this.data = [];
                });
        },
        cancelOrder(id) {
            this.$confirm("您确定要取消该订单吗?", "提示", {
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                type: "warning",
                lockScroll: false,
                center: true,
                closeOnClickModal: false
            })
                .then(() => {
                    this.HTTP(
                        this.$httpConfig.cancelOrder,
                        {
                            id: id
                        },
                        "post"
                    ).then(res => {
                        this.Order();
                        this.$emit("changeOrderNum");
                    });
                })
                .catch(() => {});
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.Order();
        },
        xiangqing() {
            this.h = false;
            this.dingDan = true;
        }
    }
};
</script>
<style>
.hand {
    cursor: pointer;
}
</style>


<style lang="less" scoped>
.pagation {
    display: flex;
    justify-content: center;
}

.l {
    float: left;
}

.r {
    float: right;
}

.center {
    width: 1190px;
    margin: 0 auto;
    height: 100%;
}

.alike {
    overflow: hidden;
    border: 1px solid #e7e6e6;
    margin: 0 17px 10px;
    .goods-operate {
        display: inline-block;
        margin-top: 20px;
    }
    .a-block {
        display: block;
    }
    a {
        font-size: 12px;
        color: #333;
    }
    a:hover {
        color: red;
    }
    .both {
        height: 42px;
        line-height: 42px;
        background: #f1f1f1;
        i {
            font-size: 16px;
            margin: 13px 16px 0 0;
            color: #999;
            font-weight: 900;
        }
        input {
            margin: 16px 14px 0 13px;
        }
        p {
            font-size: 12px;
            color: #333;
        }
        p:nth-of-type(2) {
            margin: 0 67px 0 25px;
        }
        img {
            float: right;
            margin: 9px 150px 0 35px;
        }
    }
    .zuo {
        overflow: hidden;
        width: 613px;
        .huowu {
            height: 110px;
            img {
                width: 70px;
                height: 70px;
                float: left;
                margin: 15px 10px 0 13px;
            }
            p {
                float: left;
                font-size: 12px;
                color: #333;
                margin-top: 20px;
            }
            p:nth-of-type(1) {
                width: 147px;
                margin: 18px 117px 0 0;
            }
            p:nth-of-type(3) {
                margin: 20px 83px 0 44px;
            }
        }
    }
    .right {
        height: 110px;
        overflow: hidden;
        p {
            float: left;
            border-left: 1px solid #e7e6e6;
            height: 100%;
            text-align: center;
            span {
                display: block;
                font-size: 12px;
                color: #333;
            }
        }
        p:nth-of-type(1) {
            width: 120px;
            span:nth-of-type(1) {
                margin-top: 20px;
            }
        }
        p:nth-of-type(2) {
            width: 105px;
            span:nth-of-type(1) {
                margin-top: 20px;
            }
        }
        p:nth-of-type(2) > :first-child {
            margin-top: 20px;
        }
        p:nth-of-type(3) {
            width: 106px;
            span:nth-of-type(1) {
                cursor: pointer;
                margin: 17px auto 8px;
                width: 72px;
                height: 28px;
                line-height: 28px;
                color: #fff;
                background: #ff6000;
                border-radius: 3px;
            }
        }
    }
    .youhui {
        line-height: 35px;
        color: #333;
        font-size: 12px;
        margin-left: 13px;
        span {
            color: red;
        }
    }
}
</style>


