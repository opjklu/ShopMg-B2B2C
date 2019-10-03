<template>
    <div class="myintegral l">
        <div class="top">
            <div class="l">
                <ul>
                    <li @click="Jifen(0)" :class="{color:isColor==0}">
                        <p>积分规则</p>
                    </li>
                    <li @click="Jifen(1)" :class="{color:isColor==1}">
                        <p>我的积分</p>
                    </li>
                </ul>
            </div>
            <div class="r">
                <p>
                    我的积分：
                    <span>{{myIntegral.current_integral || 0}}</span>
                </p>
                <p>
                    会员等级：
                    <span>{{myIntegral.current_level_name}}</span>
                </p>
                <p>
                    再积累
                    <span>{{myIntegral.next_integral}}</span>积分
                </p>
                <p>可升级{{myIntegral.next_level_name}}</p>
            </div>
        </div>
        <div class="under" v-show="isColor==0">
            <div class="thead">
                <p>积分介绍</p>
            </div>
            <ul>
                <li>1、积分是商城会员通过购物获得</li>
                <li>2、累积的积分总额决定会员等级，积分越高，会员等级越高。会员积分 ≈ 累计购物金额</li>
                <li>3、积分值：购物获得的积分是根据确认收货时间计算，积分按照交易金额的个位数取整计算：例如会员的订单是88.0元，则确认收货后并且无退款退货即可得到88积分</li>
                <li>4、确认收货后退款退货，会扣减积分，扣除的积分与当时获得的积分相同</li>
            </ul>
            <div class="thead">
                <p>升级条件</p>
            </div>
            <table>
                <tr>
                    <th class="dengji">会员等级</th>
                    <th class="jifen">积分</th>
                    <th class="tubiao">等级图标</th>
                </tr>
                <tr v-if="ruleInfo" v-for="(info,index) in ruleInfo" :key="info.id">
                    <td>{{info.level_name}}</td>
                    <td>{{info.integral_small}}--{{info.integral_big}}</td>
                    <td>
                        <img :src="rankIcons[index]">
                    </td>
                </tr>
            </table>
        </div>
        <div class="unders" v-show="isColor==1">
            <div class="up">
                <p>来源/用途</p>
                <!-- <p>订单号/退款编号</p> -->
                <p>实付款</p>
                <p>积分</p>
                <p>获取时间</p>
            </div>
            <div class="intergral_box">
                <div class="down">
                    <p>标题</p>
                    <p>价格</p>
                    <p>积分</p>
                    <p>交易时间</p>
                </div>
                <div class="down" v-for="(item, i) in integralLog.data" :key="i">
                    <p>{{item.order_sn_id}}</p>
                    <p>{{item.price_sum}}</p>
                    <p>{{integralType[item.type]}}{{item.integral}}</p>
                    <p>{{item.trading_time | formatDate}}</p>
                </div>
                <div class="pagation" v-if="integralLog.count">
                    <el-pagination
                        background
                        layout="total, prev, pager, next"
                        :total="parseInt(integralLog.count)"
                        @current-change="handelPage"
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
            ruleInfo: [],
            myIntegral: {},
            levelList: [],
            rankIcons: [
                require("@/assets/img/lv1.png"),
                require("@/assets/img/lv2.png"),
                require("@/assets/img/lv3.png"),
                require("@/assets/img/lv4.png")
            ],
            integralType: {
                0: "-",
                1: "+"
            },
            //我的积分
            isColor: 0,
            integralLog: [],
            currentPage: 1
        };
    },
    created() {
        this.getRule();
        this.getMyIntegral(1);
    },
    methods: {
        getRule() {
            this.HTTP(this.$httpConfig.integralRule, { page: 1 }, "post").then(
                res => {
                    this.ruleInfo = res.data.data;
                    console.log(res.data.data);
                }
            );
        },
        getMyIntegral(page) {
            this.HTTP(this.$httpConfig.myIntegral, { page: page }, "post").then(
                res => {
                    this.myIntegral = res.data.data;
                    console.log(res.data.data);
                }
            );
        },
        handleCurrentChange1(val) {
            this.currentPage = val;
            this.getMyIntegral(val);
        },
        Jifen(index) {
            this.isColor = index;

            this.HTTP(this.$httpConfig.integralLog, { page: 1 }, "post")
                .then(res => {
                    this.integralLog = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>

<style lang="less" scoped>
.l {
    float: left;
}
.pagation {
    display: flex;
    justify-content: center;
}
.r {
    float: right;
}
.down {
    border: 1px solid #f5f5f5;
    overflow: hidden;
    height: 55px;
    padding: 0px 10px;
    display: flex;
}
.intergral_box {
    border: 2px solid #f5f5f5;
    margin-top: 20px;
    box-sizing: border-box;
    p {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        border-right: 2px solid #f5f5f5;
    }
    p:nth-of-type(1) {
        width: 273px;
    }
    p:nth-of-type(2) {
        width: 100px;
    }
    p:nth-of-type(3) {
        width: 100px;
    }
    p:nth-of-type(4) {
        width: 150px;
    }
}
.intergral_box div:first-child {
    border-top: 0px solid transparent;
}
.intergral_box div:last-child {
    border-bottom: 0px solid transparent;
}
.center {
    width: 1190px;
    margin: 0 auto;
    height: 100%;
}

.myintegral {
    height: 956px;
    width: 990px;
    background: #fff;
    margin: 16px 0;
    .top {
        overflow: hidden;
        margin: 14px 17px 0px;
        border-bottom: 1px solid #e7e7e7;
        line-height: 37px;
        div.l {
            ul {
                li {
                    cursor: pointer;
                    float: left;
                    width: 104px;
                    height: 37px;
                    color: #333;
                    p {
                        margin-top: 10px;
                        font-size: 14px;
                        text-align: center;
                        line-height: 16px;
                        border-right: 1px solid #e8e8e8;
                    }
                }
                .color {
                    border-bottom: 2px solid red;
                    color: red !important;
                }
            }
        }
        div.r {
            p {
                float: left;
                font-size: 14px;
                color: #333;
                margin-left: 21px;
                span {
                    color: red;
                }
            }
        }
    }
    .under {
        margin: 0 17px;
        .thead {
            margin-top: 17px;
            height: 26px;
            border-bottom: 1px solid #fdb9af;
            p {
                width: 136px;
                line-height: 26px;
                background: url(../../../assets/img/jifen.png) no-repeat center;
                padding-left: 35px;
                color: #fff;
                font-size: 14px;
            }
        }
        ul {
            border: 1px solid #fdb9af;
            padding: 20px 22px;
            margin: 9px 0 20px 0;
            li {
                line-height: 24px;
                font-size: 12px;
                color: #666;
            }
        }
        table {
            margin-top: 10px;
            border: 1px solid #fdb9af;
            border-bottom: 0;
            th {
                width: 278px;
                text-align: center;
                line-height: 44px;
                background: #fbdbd6;
                font-size: 14px;
                font-weight: 500;
                border-right: 1px solid #f4d3d3;
            }
        }
        .jifen {
            width: 359px;
        }
        .tubiao {
            width: 305px;
            border-right: 0;
        }
        td {
            line-height: 38px;
            border-bottom: 1px solid #fbdbd6;
            text-align: center;
            border-right: 1px solid #f4d3d3;
            font-size: 12px;
            color: #666;
        }
        .up {
            overflow: hidden;
            line-height: 44px;
            background: #f5f5f5;
            border: #e8e8e8;
            margin-top: 20px;
            p {
                float: left;
            }
        }
    }
    .unders {
        margin: 0 17px;
        .up {
            overflow: hidden;
            line-height: 44px;
            background: #f5f5f5;
            border: #e8e8e8;
            margin-top: 20px;
        }
        p {
            float: left;
            text-align: center;
            font-size: 12px;
            color: #333;
        }
    }
}
</style>