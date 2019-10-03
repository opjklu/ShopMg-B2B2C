<template>
    <div class="fullOrde" v-if="data.data">
        <div class="alike" v-for="(item, index) in data.data" :key="index">
            <div class="both">
                <input class="l" type="checkbox">
                <p class="l">{{item.create_time | formatDate}}</p>
                <p class="l">订单号： {{item.order_sn_id}}</p>
                <span></span>
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
                            <div class="l g-operation">
                                <router-link
                                    class="goods-operate"
                                    target="_blank"
                                    to="complain"
                                >投诉卖家</router-link>
                                <router-link
                                    v-if="goods.status == 1 || goods.status == 2 || goods.status == 3"
                                    class="goods-operate"
                                    target="_blank"
                                    :to="{path:'/apply',query:{id:item.id,goods_id:goods.goods_id, order_sn_id: item.order_sn_id}}"
                                >退款/退换货</router-link>
                                <span
                                    v-if="goods.status == 5 || goods.status == 6 || goods.status == 7 || goods.status == 8 || goods.status == 9 || goods.status == 10 || goods.status == 11"
                                    class="goods-operate"
                                >{{status[Number(goods.status)]}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right r">
                    <p>
                        <span>￥{{parseFloat(item.price_sum)+parseFloat(item.shipping_monery)|keep2Num}}</span>
                        <span>（含运费：￥{{item.shipping_monery|keep2Num}}）</span>
                    </p>
                    <p>
                        <span v-if="item.order_status == 1">等待卖家发货</span>
                        <router-link
                            target="_blank"
                            class="a-block"
                            :to="{path: '/orderDetail', query: {id: item.id}}"
                        >订单详情</router-link>
                    </p>
                    <p>
                        <span ref="msg">{{$Status[item.order_status]}}</span>
                        <span></span>
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
import {ConstJsData} from '../../../../../es6/const.js'
export default {
    data() {
        return {
            data: [],
            currentPage: 1,
            orderGoodsData: [],
            h: true,
            dingDan: false,
            message: "",
            status:[]
        };
    },
    created() {
       
       this.status = ConstJsData.orderConst();
        this.Order();
        this.$emit("changeOrderNum");
    },
    methods: {
        Order() {
            this.HTTP(
                this.$httpConfig.pendingDelivery,
                {
                    page: this.currentPage
                },
                "post"
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
    width: 1200px;
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
            .g-operation {
                text-align: center;
                span {
                    font-size: 12px;
                }
                a:first-child {
                    margin-top: 20px;
                }
                .goods-operate {
                    display: block;
                    margin-top: 5px;
                }
            }
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
                cursor: default;
                margin: 17px auto 8px;
                width: 72px;
                height: 28px;
                line-height: 28px;
                color: #fff;
                background: #cbcaca;
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


