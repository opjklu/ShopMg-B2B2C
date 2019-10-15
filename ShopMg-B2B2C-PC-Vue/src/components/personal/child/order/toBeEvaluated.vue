<template>
    <div class="fullOrde" v-if="data.data">
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
                                    :to="{path:'/apply',query:{id:item.id,goods_id:goods.goods_id}}"
                                >售后处理</router-link>
                                <span
                                    v-if="goods.status == 5 || goods.status == 6 || goods.status == 7 || goods.status == 8 || goods.status == 9 || goods.status == 10 || goods.status == 11"
                                    class="goods-operate"
                                >{{status[goods.status]}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right l" >
                    <p>
                        <span>￥{{parseFloat(item.price_sum)+parseFloat(item.shipping_monery)|keep2Num}}</span>
                        <span>（含运费：￥{{item.shipping_monery|keep2Num}}）</span>
                    </p>
                    <p>
                        <router-link
                            class="a-block"
                            target="_blank"
                            :to="{path: '/orderDetail', query: {id: item.id}}"
                        >订单详情</router-link>
                        <a @click="lookLogistics(item)" class="a-block">查看物流</a>
                    </p>
                    <p>
                            <span class="appraise"
                                @click="$router.push({path: '/publishComment', query: {id: item.id,goods_id:goods.goods_id}})"
                            >评价</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="pagation" v-if="data">
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
            h: true,
            dingDan: false,
            message: "",
            status: [],
            orderGoodsData: [],
        };
    },
    created() {
        this.status = ConstJsData.orderConst();
        this.Order();
        this.$emit("changeOrderNum");
    },
    methods: {
        to(item, good) {
            console.log(item, good);
        },
        //查看物流
        lookLogistics(item) {
            window.open(
                window.location.origin +
                    "/logistics?id=" +
                    item.id +
                    "&express_id=" +
                    item.express_id +
                    "&exp_id=" +
                    item.exp_id +
                    "&status=" +
                    item.order_status
            );
        },
        Order() {
            this.HTTP(
                this.$httpConfig.toBeEvaluated,
                {
                    page: this.currentPage
                },
                "post",
                false
            )  .then(res => {
                    this.data = res.data.order;
                    this.orderGoodsData = res.data.order_goods;
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
.l {
    float: left;
}

.r {
    float: right;
}
.pagation {
    display: flex;
    justify-content: center;
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
            border-bottom: 1px solid #e7e6e6;
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
    .zuo:last-child {
        .huowu {
            border-bottom: 0px;
        }
    }
    .right {
        height: 110px;
        overflow: hidden;
        p {
            float: left;
            border-left: 1px solid #e7e6e6;
            height: 100%;
            line-height: 251%;
            text-align: center;
            span {
                display: block;
                text-align: center;
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
            align-items: center;
            span:nth-of-type(1) {
                margin-top: 20px;
            }
        }
        p:nth-of-type(2) > :first-child {
            margin-top: 20px;
        }
        p:nth-of-type(3) {
            width: 106px;
            align-items: center;
            display: block;
            span.appraise {
                justify-items: center;
                cursor: pointer;
                height: 110px;
                line-height: 110px;
                align-items: center;
                border-bottom: 1px solid #e7e6e6;
                span {
                    border-radius: 3px;
                    margin: 0 auto;
                    width: 72px;
                    color: #fff;
                    height: 28px;
                    line-height: 28px;
                    background: #ff6000;
                }
            }
            span.appraise:last-child {
                border-bottom: 0px;
            }
        }
        .quxiao {
            background: #cbcaca !important;
        }
        .queren {
            background: #66b6ff !important;
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


