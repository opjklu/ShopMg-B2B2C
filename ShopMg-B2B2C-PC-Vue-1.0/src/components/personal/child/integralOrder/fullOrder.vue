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
                            v-for="(item) in evaluateStatus"
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
                            v-for="(item) in evaluateStatus"
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
            <p class="l">积分</p>
            <p class="l">商品操作</p>
            <p class="l">实付款</p>
            <p class="l">
                交易状态
                <i class="el-icon-caret-bottom"></i>
            </p>
            <p class="l">交易操作</p>
        </div>
        <div class="fullOrde">
            <div class="alike" v-for="(item, index) in data.data" :key="index">
                <div class="both">
                    <!-- <input class="l" type="checkbox" /> -->
                    <p class="l" style="margin-left: 10px;">{{item.create_time | formatDate}}</p>
                    <p class="l">订单号： {{item.order_sn}}</p>
                    <p class="l">店铺：
            <router-link target="_blank" :to="{path:'/storehome',query:{id:item.store_id}}">{{item.shop_name}}</router-link>
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
                            <div class="huowu"  v-if="goods.order_id === item.id">
                                <router-link
                                    target="_blank"
                                    class="a-block"
                                    :to="{path:'/inroyaldrink',query:{id:goods.goods_id}}"
                                >
                                    <img :src="URL + goods.pic_url">
                                </router-link>
                                <p>
                                    <router-link
                                        target="_blank"
                                        class="a-block"
                                        :to="{path:'/inroyaldrink',query:{id:goods.goods_id}}"
                                    >{{goods.title}}</router-link>
                                </p>
                                <p>￥{{goods.money}}</p>
                                <p>{{goods.goods_num}}</p>
                                <p>{{goods.integral}}</p>
                                <router-link class="goods-operate" target="_blank" to="apply">售后处理</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="right r">
                        <!-- <div class="right r" :style="{height:item.goods.length * 110 + 'px'}"> -->
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
                                :to="{path: '/integralDetail', query: {id: item.id}}"
                            >订单详情</router-link>
                            <a
                                @click="lookLogistics(item)"
                                class="a-block"
                                v-if="~~item.order_status === 3"
                            >查看物流</a>
                        </p>
                        <p>
                            <span
                                ref="msg"
                                :class="~~item.order_status === 1 ||item.order_status == '-1' ? 'quxiao' : ''"
                                @click="state(item)"
                            >{{Status[Number(item.order_status)]}}</span>
                            <a
                                v-if="item.order_status == 0"
                                class="a-block"
                                @click="cancelOrder(item.id)"
                            >取消订单</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="pagation">
                <el-pagination
                    v-if="flag === true"
                    background
                    layout="prev, pager, next"
                    :current-page.sync="currentPage"
                    :total="~~data.page"
                    :page-size="data.page_size"
                    @current-change="handleCurrentChange"
                ></el-pagination>
                <el-pagination
                    v-if="flag === false"
                    background
                    layout="prev, pager, next"
                    :current-page.sync="currentPage"
                    :total="~~data.page"
                    :page-size="data.page_size"
                    @current-change="handleCurrentChange1"
                ></el-pagination>
            </div>
        </div>
    </div>
</template>

<script>
import { MapTool } from "../../../../../es6/tool.js";
import { OrderRelevant} from "../../../../../es6/order.js";
import { ConstJsData } from "../../../../../es6/const.js";
import { longStackSupport } from "q";
export default {
    data() {
        return {
            data: [],
            filterShow: false,
            currentPage: 1,
            message: "",
            keyWords: "",
            order_status: "",
            comment_status: "",
            start_time: "",
            end_time: "",
            flag: true,
            evaluateStatus: [],
            Status: [],
            orderGoodsData: [],

        };
    },
    created() {
        this.evaluateStatus = ConstJsData.orderMessageConst();

        this.comment_status = ConstJsData.orderCommentConst();
        this.Status = ConstJsData.orderConst();

        this.Order();
    },
    methods: {
        //跳转至订单详情
        state(item) {
            this.HTTP(this.$httpConfig.integralToPay, { id: item.id }, "post")
                .then(res => {
                    //console.log(res.data.status)
                    if (res.data.status === 1) {
                        let total_price =
                            parseFloat(item.price_sum) +
                            parseFloat(item.shipping_monery);
                        total_price = total_price.toFixed(2);
                        console.log(total_price);
                        this.$router.push({
                            path: "/integralPay",
                            query: {
                                total_price: total_price
                            }
                        });
                    }
                })
                .catch(e => {});
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
                        this.$httpConfig.intergral.cancelOrder,
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
            // 删除订单
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
                        this.$httpConfig.intergral.delOrder,
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

            if (param.order_sn_id) {
              param.order_sn = param.order_sn_id;
              delete param.order_sn_id;
            }

            this.HTTP(
                this.$httpConfig.integralSearch,
                param,
                "post",
                false
            ) .then(res => {
                    this.data = res.data.data.order;
                    this.orderGoodsData = res.data.data.order_goods;
                })
                .catch(() => {
                    this.data = [];
                    this.orderGoodsData = res.data.data.order_goods;
                });
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
                    "&type=2"
            );
        },
        Order() {
            this.HTTP(
                this.$httpConfig.integralList ,
                {page: this.currentPage},
                "post",
                false
            )
                .then(res => {
                    this.data = res.data.data.order;
                    this.orderGoodsData = res.data.data.order_goods;
                })
                .catch(res => {
                    this.orderGoodsData = res.data.data.order_goods;
                    this.data = [];
                });
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
            margin: 0 120px 0 134px;
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
        p:nth-of-type(8) {
            margin-left: 51px;
        }
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
                float: left;
                margin: 9px 0 0 35px;
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
                    margin: 18px 30px 0 0;
                }
                p:nth-of-type(3) {
                    margin: 20px 40px 0 44px;
                }
                p:nth-of-type(4) {
                    margin: 20px 80px 0 44px;
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
            .quxiao {
                background: #cbcaca !important;
                cursor: default !important;
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

