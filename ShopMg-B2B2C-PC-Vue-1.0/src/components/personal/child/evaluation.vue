<template>
    <div class="evaluation l">
        <div v-show="pingjia" class="r evaluate">
            <ul>
                <li class="l" @click="dixian(0)" :class="{downline:downline==0}">
                    <p>
                        我的订单-待评价
                        <span>（{{amount1}}）</span>
                    </p>
                </li>
                <li class="l" @click="dixian(1)" :class="{downline:downline==1}">
                    <p>
                        我的订单-已评价
                        <span>（{{amount2}}）</span>
                    </p>
                </li>
                <li class="l" @click="dixian(2)" :class="{downline:downline==2}">
                    <p>
                        套餐订单-待评价
                        <span>（{{amount3}}）</span>
                    </p>
                </li>
                <li class="l" @click="dixian(3)" :class="{downline:downline==3}">
                    <p>
                        套餐订单-已评价
                        <span>（{{amount4}}）</span>
                    </p>
                </li>
            </ul>
            <!--我的订单-待评价-->
            <div v-show="now==0">
                <div class="down" v-for="(item, index) in toBeEvaluate.data" :key="index">
                    <div class="both">
                        <input class="l" type="checkbox">
                        <p class="l">{{item.create_time | formatDate}}</p>
                        <p class="l">订单号： {{item.order_sn_id}}</p>
                        <p class="l">店铺：{{item.shop_name}}</p>
                        <img src="../../../assets/img/qq.jpg">
                        <i class="el-icon-delete r"></i>
                    </div>
                    <div class="shoppingBox">
                        <div class="zuo l" v-for="(goods, index) in orderGoodsData" :key="index">
                            <div class="huowu" v-if="goods.order_id === item.id">
                                <img :src="URL +  goods.pic_url">
                                <p>{{goods.title}}</p>
                                <p>￥{{goods.goods_price * goods.goods_num}}</p>
                                <p>{{goods.goods_num}}</p>
                                <p>申请售后</p>
                                <p>
                                    <span @click="discuss(item, goods)" class="span">评价</span>
                                </p>
                            </div>
                        </div>
                        <div class="right r">
                            <p>
                                <span>￥{{item.price_sum}}</span>
                                <span>（含运费：￥{{item.shipping_monery}}）</span>
                            </p>
                            <p>
                                <span>交易成功</span>
                                <span>订单详情</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="pagation" v-if="toBeEvaluate.data">
                    <el-pagination
                        background
                        layout="prev, pager, next"
                        :current-page.sync="page"
                        :total="~~toBeEvaluate.count"
                        :page-size="toBeEvaluate.page_size"
                        @current-change="handleCurrentChange"
                    ></el-pagination>
                </div>
            </div>
            <!--我的订单-已评价-->
            <div v-show="now==1">
                <div class="down" v-for="(item, index) in haveComment.data" :key="index">
                    <div class="both">
                        <input class="l" type="checkbox">
                        <p class="l">{{item.create_time | formatDate}}</p>
                        <p class="l">订单号： {{item.order_sn_id}}</p>
                        <p class="l">店铺：{{item.shop_name}}</p>
                        <img src="../../../assets/img/qq.jpg">
                        <i class="el-icon-delete r"></i>
                    </div>
                    <div class="shoppingBox">
                        <div
                            class="zuo l"
                            v-for="(goods, index) in alreadyOrderGoodsData"
                            :key="index"
                        >
                            <div class="huowu" v-if="goods.order_id === item.id">
                                <img :src="URL +  goods.pic_url">
                                <p>{{goods.title}}</p>
                                <p>￥{{goods.goods_price * goods.goods_num}}</p>
                                <p>{{goods.goods_num}}</p>
                                <p>申请售后</p>
                                <p>
                                    <span @click="goDetails(item,  goods)">评价详情</span>
                                </p>
                            </div>
                        </div>
                        <div class="right r">
                            <p>
                                <span>￥{{item.price_sum}}</span>
                                <span>（含运费：￥{{item.shipping_monery}}）</span>
                            </p>
                            <p>
                                <span>交易成功</span>
                                <span>订单详情</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="pagation" v-if="haveComment.data">
                    <el-pagination
                        background
                        layout="prev, pager, next"
                        :current-page.sync="page"
                        :total="~~haveComment.count"
                        :page-size="haveComment.page_size"
                        @current-change="handleCurrentChange"
                    ></el-pagination>
                </div>
            </div>
            <!--套餐订单-待评价-->
            <div v-show="now==2">
                <div class="down" v-for="(item, index) in setForEvaluation.data" :key="index">
                    <div class="both">
                        <input class="l" type="checkbox">
                        <p class="l">{{item.create_time | formatDate}}</p>
                        <p class="l">订单号： {{item.order_sn_id}}</p>
                        <p class="l">店铺：{{item.shop_name}}</p>
                        <img src="../../../assets/img/qq.jpg">
                        <i class="el-icon-delete r"></i>
                    </div>
                    <div class="shoppingBox">
                        <div
                            class="zuo l"
                            v-for="(goods, index) in orderPackageGoodsData"
                            :key="index"
                        >
                            <div class="huowu" v-if="goods.order_id === item.id">
                                <img :src="URL +  goods.pic_url">
                                <p>{{goods.title}}</p>
                                <p>￥{{goods.goods_price * goods.goods_num}}</p>
                                <p>{{goods.goods_num}}</p>
                                <p>申请售后</p>
                                <p>
                                    <span @click="discuss(item,goods)" class="span">评价</span>
                                </p>
                            </div>
                        </div>
                        <div class="right r">
                            <p>
                                <span>￥{{item.price_sum}}</span>
                                <span>（含运费：￥{{item.shipping_monery}}）</span>
                            </p>
                            <p>
                                <span>交易成功</span>
                                <span>订单详情</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="pagation" v-if="setForEvaluation.data">
                    <el-pagination
                        background
                        layout="prev, pager, next"
                        :current-page.sync="page"
                        :total="~~setForEvaluation.count"
                        :page-size="setForEvaluation.page_size"
                        @current-change="handleCurrentChange"
                    ></el-pagination>
                </div>
            </div>
            <!--套餐订单-已评价-->
            <div v-show="now==3">
                <div class="down" v-for="(item, index) in setEvaluated.data" :key="index">
                    <div class="both" v-if="goods.order_id === item.id">
                        >
                        <input class="l" type="checkbox">
                        <p class="l">{{item.create_time | formatDate}}</p>
                        <p class="l">订单号： {{item.order_sn_id}}</p>
                        <p class="l">店铺：{{item.shop_name}}</p>
                        <img src="../../../assets/img/qq.jpg">
                        <i class="el-icon-delete r"></i>
                    </div>
                    <div class="shoppingBox">
                        <div
                            class="zuo l"
                            v-for="(goods, index) in alreadyOrderPackageGoodsData"
                            :key="index"
                        >
                            <div class="huowu">
                                <img :src="URL +  goods.pic_url">
                                <p>{{goods.title}}</p>
                                <p>￥{{goods.goods_price * goods.goods_num}}</p>
                                <p>{{goods.goods_num}}</p>
                                <p>申请售后</p>
                                <p>
                                    <span class="span">评价</span>
                                <span @click="goDetails(item, goods)">评价详情</span>
                                </p>
                            </div>
                        </div>
                        <div class="right r">
                            <p>
                                <span>￥{{item.price_sum}}</span>
                                <span>（含运费：￥{{item.shipping_monery}}）</span>
                            </p>
                            <p>
                                <span>交易成功</span>
                                <span>订单详情</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="pagation" v-if="setEvaluated.data">
                    <el-pagination
                        background
                        layout="prev, pager, next"
                        :current-page.sync="page"
                        :total="~~setEvaluated.count"
                        :page-size="setEvaluated.page_size"
                        @current-change="handleCurrentChange"
                    ></el-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            //信息数量
            amount1: 0,
            amount2: 0,
            amount3: 0,
            amount4: 0,
            //我的评价
            downline: 0,
            pingjia: true,
            dianping: "",
            xiangQing: "",
            now: 0,
            haveComment: [], //我的订单已评价
            toBeEvaluate: [], //我的订单-待评价
            setForEvaluation: [], //套餐订单-待评价
            setEvaluated: [], //套餐订单-已评价
            type: "", //0为我的订单，1为套餐订单
            page: 1,
            orderGoodsData: [],
            alreadyOrderGoodsData: [],
            orderPackageGoodsData: [],
            alreadyOrderPackageGoodsData: []
        };
    },
    created() {
        this.toBeEvaluated();
        this.haveBeenEvaluated();
        this.packageEvaluation();
        this.haveEvaluation();
    },
    methods: {
        goDetails(item, goods) {
            this.$router.push({
                path: "commentDetail",
                query: { id: item.id, goods_id: goods.goods_id }
            });
            //sessionStorage.setItem('goods',JSON.stringify(item))
        },

        handleCurrentChange(val) {
            this.page = val;
            this.toBeEvaluated();
        },
        //跳转
        discuss(item, goods) {
            this.$router.push({
                path: "/publishComment",
                query: {
                    id: item.id,
                    goods_id: goods.goods_id,
                    type: this.type,
                    store_id:goods.store_id,
                    order_sn: item.order_sn_id || item.order_sn,
                    shop_name: encodeURIComponent(item.shop_name)
                }
            });
        },

        /**
         * 跳转评价详情
         */
        jumpCommentDetail(item, goods) {
            this.$router.push({
                path: "/publishComment",
                query: {
                    id: item.id,
                    goods_id: goods.goods_id,
                    type: this.type,
                    order_sn: item.order_sn_id || item.order_sn,
                    shop_name: encodeURIComponent(item.shop_name)
                }
            });
        },
        // 我的订单-待评价
        toBeEvaluated() {
            this.HTTP(
                this.$httpConfig.orderComment,
                { page: this.page },
                "post",
                false
            )
                .then(res => {
                    this.toBeEvaluate = res.data.data.order;
                    this.orderGoodsData = res.data.data.order_goods;

                    this.type = 0;
                    this.amount1 = Number(this.toBeEvaluate.data.length);
                })
                .catch(e => {
                    console.log(e);
                });
        },
        // 我的订单-已评价
        haveBeenEvaluated() {
            this.HTTP(
                this.$httpConfig.haveBeenEvaluated,
                { page: this.page },
                "post",
                false
            )
                .then(res => {
                    if (res.data.status) {
                        this.haveComment = res.data.data.order;
                        this.alreadyOrderGoodsData = res.data.data.order_goods;
                        this.amount2 = Number(this.haveComment.data.length);
                    }
                })
                .catch(e => {
                    console.log(e);
                });
        },
        // 套餐订单-待评价
        packageEvaluation() {
            this.HTTP(
                this.$httpConfig.package.packageToBeEvaluated,
                {
                    page: this.page
                },
                "post"
            )
                .then(res => {
                    this.type = 1;
                    this.setForEvaluation = res.data.data.order;
                    this.orderPackageGoodsData = res.data.data.order_goods;
                    this.amount3 = Number(this.setForEvaluation.data.length);
                })
                .catch(e => {
                    console.log(e);
                    //this.$message.error(`${e.data.message}`)
                });
        },
        // 套餐订单-已评价
        haveEvaluation() {
            this.HTTP(
                this.$httpConfig.package.alreadyEvaluated,
                { page: this.page },
                "post"
            )
                .then(res => {
                    console.log(res);
                    if (res.data.status) {
                        this.setEvaluated = res.data.data.order;
                        this.alreadyOrderPackageGoodsData =
                            res.data.data.order_goods;
                        this.amount4 = Number(this.setEvaluated.data.length);
                    }
                })
                .catch(e => {});
        },
        //我的评价
        dixian(index) {
            this.downline = index;
            this.now = index;
            //index === 0 ? this.toBeEvaluated() : this.haveBeenEvaluated()
            switch (index) {
                case 0:
                    this.toBeEvaluated();
                    break;
                case 1:
                    this.haveBeenEvaluated();
                    break;
                case 2:
                    this.packageEvaluation();
                    break;
                default:
                    this.haveEvaluation();
                    break;
            }
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
.shoppingBox {
    position: relative;
}
.center {
    width: 1200px;
    margin: 0 auto 50px;
    height: 100%;
}
.evaluate {
    width: 990px;
    background: #fff;
    margin: 16px 0;
    ul {
        overflow: hidden;
        margin: 14px 17px 20px;
        border-bottom: 1px solid #e7e7e7;
        height: 37px;
        li {
            cursor: pointer;
            height: 36px;
            color: #666;
            width: 145px;
            p {
                height: 16px;
                border-right: 1px solid #e7e7e7;
                text-align: center;
                margin-top: 10px;
                font-size: 12px;
                span {
                    color: red;
                }
            }
        }
    }
    .downline {
        border-bottom: 2px solid red;
        color: red;
    }

    .pagation {
        display: flex;
        justify-content: center;
    }
    .down {
        overflow: hidden;
        border: 1px solid #e7e6e6;
        margin: 0 17px 10px;
        display: flex;
        flex-direction: column;
        span {
            cursor: pointer;
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
                float: left;
                margin: 10px;
                width: 80px;
            }
        }
        .zuo {
            overflow: hidden;
            width: 720px;

            .huowu {
                height: 110px;
                line-height: 100%;
                align-items: center;
                border-bottom: 1px solid #e7e6e6;
                img {
                    float: left;
                    width: 80px;
                    margin: 15px 10px 0 13px;
                }
                p {
                    float: left;
                    font-size: 12px;
                    margin-top: 15px !important;
                    height: 80px;
                    line-height: 80px;
                    color: #333;
                    margin-top: 20px;
                }
                p:nth-of-type(1) {
                    width: 147px;
                    margin: 0 117px 0 0;
                }
                p:nth-of-type(3) {
                    margin: 0 83px 0 44px;
                }
                p:nth-of-type(4) {
                    margin-right: 20px;
                }
                p:nth-of-type(5) {
                    width: 106px;
                    display: flex;
                    flex-wrap: nowrap;
                    flex-direction: column;
                    align-items: center;
                    .span {
                        padding: 5px;
                        margin-top: 10px;
                        margin-bottom: -30px;
                        width: 37px;
                        height: 25px;
                        line-height: 15px;
                        border-radius: 3px;
                        border: 1px solid #e7e6e6;
                    }
                    span {
                        height: 0;
                    }
                }
            }
            .huowu:last-child {
                border-bottom: 0;
            }
        }
        .right {
            height: 100%;
            overflow: hidden;
            position: absolute;
            right: 0;
            display: flex;
            align-items: center;
            p {
                float: left;
                border-left: 1px solid #e7e6e6;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                span {
                    display: block;
                    text-align: center;
                    font-size: 12px;
                    color: #333;
                    cursor: pointer;
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
            // p:nth-of-type(3) {
            // 	width: 106px;
            // 	.spa {
            // 		margin-top: 20px;
            // 	}
            // 	.span {
            // 		margin: 17px auto 8px;
            // 		width: 47px;
            // 		height: 23px;
            // 		line-height: 23px;
            // 		border-radius: 3px;
            // 		border: 1px solid #e7e6e6;
            // 	}
            // }
        }
    }
}
</style>