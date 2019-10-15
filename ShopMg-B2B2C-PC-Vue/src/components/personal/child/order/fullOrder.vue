<template>
    <div class="all-order">
        <div class="filter clearfix">
            <p class="search l">
                <el-input
                    placeholder="输入商品标题或订单号进行搜索"
                    v-model="keyWords"
                    size="mini"
                    class="input-with-select"
                >
                    <el-button slot="append" @click="search(1)">订单搜索</el-button>
                </el-input>
            </p>
            <p @click="filter" class="tiaojian l">
                <span>精简筛选条件</span>
                <i :class="filterShow ? 'el-icon-arrow-up' : 'el-icon-arrow-down'"></i>
            </p>
            <div v-show="filterShow" class="l ipn">
                <p class="l leixing">
                    订单类型
                    <el-select size="mini" class="sel" v-model="order_status" placeholder="全部">
                        <el-option
                            v-for="item in orderStatus"
                            :key="item.status"
                            :label="item.message"
                            :value="item.status"
                        ></el-option>
                    </el-select>
                </p>
                <p class="l data">
                    成交时间
                    <el-date-picker
                        size="mini"
                        value-format="timestamp"
                        v-model="start_time"
                        type="datetime"
                        placeholder="请选择时间范围起始"
                    ></el-date-picker>-
                    <el-date-picker
                        size="mini"
                        value-format="timestamp"
                        v-model="end_time"
                        type="datetime"
                        placeholder="请选择时间范围结束"
                    ></el-date-picker>
                </p>
            </div>
            <div v-show="filterShow" class="l ipn">
                <p class="l leixing">
                    评价状态
                    <el-select size="mini" v-model="comment_status" placeholder="全部">
                        <el-option
                            v-for="item in evaluateStatus"
                            :key="item.status"
                            :label="item.message"
                            :value="item.status"
                        ></el-option>
                    </el-select>
                </p>
            </div>
        </div>
        <div class="thead">
            <p class="l">宝贝</p>
            <p class="l">单价</p>
            <p class="l">数量</p>
            <p class="l">商品操作</p>
            <p class="l">实付款</p>
            <p class="l">
                交易状态
                <i class="el-icon-caret-bottom"></i>
            </p>
            <p class="l">交易操作</p>
        </div>
        <div class="fullOrde"  v-if="data.data">
            <div class="alike" v-for="(item, index) in data.data" :key="index">
                <div class="both">
                    <p class="l">下单时间：{{item.create_time | formatDate}}</p>
                    <p class="l">订单号： {{item.order_sn_id}}</p>
                    <p class="l">
                        店铺：
                        <router-link
                            target="_blank"
                            :to="{path:'/storehome',query:{id:item.store_id}}"
                        >{{item.shop_name}}</router-link>
                    </p>
                    <img src="../../../../assets/img/qq.jpg">
                    <i
                        @click="deleteOrder(item.id)"
                        v-if="item.order_status == 4 || item.order_status == '-1'"
                        class="el-icon-delete r"
                    ></i>
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
                                        :to="{path:'/apply',query:{id:item.id,goods_id:goods.goods_id,order_sn_id:item.order_sn_id}}"
                                    >退款/退换货</router-link>
                                    <router-link
                                        v-if="goods.status == 4 && goods.status != 5 && goods.status != 6 && goods.status != 7 && goods.status != 8 && goods.status != 9"
                                        class="goods-operate"
                                        target="_blank"
                                        :to="{path:'/apply',query:{id:item.id,goods_id:goods.goods_id,order_sn_id:item.order_sn_id}}"
                                    >售后处理</router-link>
                                    <span
                                        v-if="goods.status == 5 || goods.status == 6 || goods.status == 7 || goods.status == 8 || goods.status == 9 || goods.status == 10 || goods.status == 11"
                                        class="goods-operate"
                                    >{{status(goods.status)}}</span>
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
                            <span v-if="item.order_status == 0">等待买家付款</span>
                            <span v-if="item.order_status == 1">等待卖家发货</span>
                            <router-link
                                target="_blank"
                                class="a-block"
                                :to="{path: '/orderDetail', query: {id: item.id}}"
                            >订单详情</router-link>
                            <a
                                @click="lookLogistics(item)"
                                class="a-block"
                                v-if="~~item.order_status === 2 || ~~item.order_status === 3 ||~~item.order_status === 4"
                            >查看物流</a>
                            <a
                                @click="confirmReceipt(item)"
                                class="a-block"
                                v-if="~~item.reder_status === 3"
                            >确认收货</a>
                        </p>
                        <p>
                            <span
                                ref="msg"
                                :class="~~item.order_status === 0 ? 'quxiao' : ''"
                                @click="state(item)"
                            >{{Status(item.order_status)}}</span>
                            <a
                                v-if="item.order_status == 0"
                                class="a-block"
                                @click="cancelOrder(item.id)"
                            >取消订单</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="pagation" v-if="data">
                <el-pagination
                    v-if="flag === true"
                    background
                    layout="prev, pager, next"
                    :current-page.sync="currentPage"
                    :total="~~data.count"
                    :page-size="data.page_size"
                    @current-change="handleCurrentChange"
                ></el-pagination>
                <el-pagination
                    v-if="flag === false"
                    background
                    layout="prev, pager, next"
                    :current-page.sync="currentPage"
                    :total="~~data.count"
                    :page-size="data.page_size"
                    @current-change="handleCurrentChange1"
                ></el-pagination>
            </div>
        </div>
    </div>
</template>

<script>
import { MapTool } from "../../../../../es6/tool.js";
import { ConstJsData } from "../../../../../es6/const.js";
import { OrderRelevant} from "../../../../../es6/order.js";

export default {
    data() {
        return {
            data: [],
            orderGoodsData: [],
            filterShow: false,
            currentPage: 1,
            message: "",
            keyWords: "",
            order_status: "",
            comment_status: "",
            start_time: "",
            end_time: "",
            flag: true,
            evaluateStatus: []
        };
    },
    created() {

        this.evaluateStatus = ConstJsData.orderCommentConst();

        this.Order();
    },
    methods: {
        // 确认收货
        confirmReceipt(item) {
            this.$confirm("确认收货", "提示", {
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                type: "warning",
                closeOnClickModal: false,
                lockScroll: false,
                center: true
            })
                .then(() => {
                    this.HTTP(
                        this.$httpConfig.OrdinaryGoods,
                        {
                            id: item.id
                        },
                        "post",
                        false
                    )
                        .then(res => {
                            console.log(res);
                            let that = this;
                            setTimeout(that.Order(), 1000);
                        })
                        .catch(e => {
                            console.log(e);
                        });
                })
                .catch(() => {});
        },

        //记录每个订单的商品数量

        //跳转至订单详情
        state(item) {
            console.log(item);
            this.HTTP(this.$httpConfig.regularOrders, { id: item.id }, "post")
                .then(res => {
                    this.$message.success(res.message);
                    if (res.status === 1) {
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
                .catch(e => {
                    this.$message.success(e.data.message);
                });
        },
        filter() {
            this.filterShow = !this.filterShow;
        },
        cancelOrder(id) {
            //取消订单
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
                        if (this.flag) {
                            this.Order();
                        } else {
                            this.search(1);
                        }
                    });
                })
                .catch(() => {});
        },
        deleteOrder(id) {
            //删除订单
            this.$confirm("您确定要删除该订单吗?", "提示", {
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                type: "warning",
                lockScroll: false,
                center: true,
                closeOnClickModal: false
            })
                .then(() => {
                    this.HTTP(
                        this.$httpConfig.delOrder,
                        {
                            id: id
                        },
                        "post"
                    ).then(res => {
                        if (this.flag) {
                            this.Order();
                        } else {
                            this.search(1);
                        }
                    });
                })
                .catch(() => {});
        },
        search(v) {
            if (v === 1) {
                this.currentPage = 1;
            }
            this.flag = false;

            let param = OrderRelevant.buildOrderSearch(this);

            this.HTTP(this.$httpConfig.orderSearch, param, "post", false)
                .then(res => {
                    this.data = res.data.order;
                    this.orderGoodsData = res.data.order_goods;
                })
                .catch(() => {
                    this.data = [];
                    this.orderGoodsData = res.data.order_goods;
                });

            console.log(this.order_status);
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.Order();
        },
        handleCurrentChange1(val) {
            this.currentPage = val;
            this.search();
        },
        prevClick(val) {
            console.log(1, val);
        },

        /**
         * 查看物流
         */
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
                    item.order_status +
                    "&type=0"
            );
        },
        Order() {
            this.HTTP(
                this.$httpConfig.fullOrder,
                {
                    page: this.currentPage
                },
                "post",
                false
            )
                .then(res => {
                    this.data = res.data.order;
                    this.orderGoodsData = res.data.order_goods;
                })
                .catch(res => {
                    this.orderGoodsData = res.data.order_goods;
                    this.data = [];
                });
        },
        Status(status) {
            switch (~~status) {
                case -1:
                    return "取消订单";
                case 0:
                    return "立即付款";
                case 1:
                    return "已支付";
                case 2:
                    return "发货中";
                case 3:
                    return "已发货";
                case 4:
                    return "已收货";
                case 5:
                    return "退货审核中";
                case 6:
                    return "审核失败";
                case 7:
                    return "审核成功";
                case 8:
                    return "退款中";
                case 9:
                    return "退款成功";
                default:
                    return "";
            }
        },
        status(status) {
            switch (~~status) {
                case -1:
                    return "取消订单";
                case 0:
                    return "未支付";
                case 1:
                    return "已支付";
                case 2:
                    return "发货中";
                case 3:
                    return "已发货";
                case 4:
                    return "已收货";
                case 5:
                    return "退货审核中";
                case 6:
                    return "审核失败";
                case 7:
                    return "审核成功";
                case 8:
                    return "退款中";
                case 9:
                    return "退款成功";
                case 10:
                    return "退货中";
                case 11:
                    return "卖家已收货";
                default:
                    return "";
            }
        }
    }
};
</script>

<style lang="less" scoped>
.el-date-editor.el-input {
    width: 178px;
}

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

.el-input__inner {
    color: red !important;
}

.all-order {
    .filter {
        .search {
            margin: 23px 12px 15px 17px;
            width: 314px;
        }
        .tiaojian {
            font-size: 12px;
            color: #333;
            margin-top: 28px;
            cursor: pointer;
            .delete-order {
                cursor: pointer;
            }
        }
        .ipn {
            display: block;
            width: 90%;
            margin: 0 0 14px 17px;
            .leixing {
                font-size: 12px;
                color: #333;
                select {
                    width: 148px;
                    height: 26px;
                    border-color: #ccc;
                    color: #a0a0a0;
                    outline: none;
                }
            }
            .data {
                margin-left: 115px;
                font-size: 12px;
                color: #333;
                input {
                    height: 26px;
                    padding-left: 20px;
                    border: 1px solid #bfbfbf;
                }
            }
        }
    }
    .thead {
        overflow: hidden;
        height: 38px;
        background: #f5f5f5;
        border: 1px solid #e7e6e6;
        margin: 0 17px 20px 17px;
        width: 956px;
        line-height: 38px;
        p {
            font-size: 12px;
            color: #474747;
            i {
                color: #999;
                margin-left: 9px;
            }
        }
        p:nth-of-type(1) {
            margin: 0 205px 0 134px;
        }
        p:nth-of-type(3) {
            margin: 0 70px 0 50px;
        }
        p:nth-of-type(5) {
            margin: 0 65px 0 74px;
        }
        p:nth-of-type(7) {
            margin-left: 51px;
        }
    }
    .alike {
        overflow: hidden;
        border: 1px solid #e7e6e6;
        margin: 0 17px 10px;
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
            padding-left: 10px;
            height: 42px;
            line-height: 42px;
            background: #f1f1f1;
            i {
                cursor: pointer;
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
                    margin: 17px auto 8px;
                    width: 72px;
                    height: 28px;
                    line-height: 28px;
                    color: #fff;
                    background: #cbcaca;
                    cursor: default;
                    border-radius: 3px;
                }
            }
            .quxiao {
                background: #ff6000 !important;
                cursor: pointer !important;
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
}
</style>


