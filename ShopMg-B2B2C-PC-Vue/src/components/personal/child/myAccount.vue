<template>
    <div class="myaccount l">
        <div v-show="myZhanghu">
            <div class="top">
                <ul class="l">
                    <li @click="Zhanghu(0)" :class="{line:isline==0}">
                        <p>交易明细</p>
                    </li>
                    <li @click="Zhanghu(1)" :class="{line:isline==1}">
                        <p>收入</p>
                    </li>
                    <li @click="Zhanghu(2)" :class="{line:isline==2}">
                        <p>支出</p>
                    </li>
                </ul>
                <p class="r">
                    <router-link to="recharge">在线充值</router-link>
                    <router-link to="drawMoney" class="spa">申请提现</router-link>
                </p>
            </div>
            <div class="zijin">
                可提现资金：
                <span>{{tradeList.data[0].account_balance||'0.00'}}</span> 元
            </div>
            <div class="base" v-show="isline == 0">
                <div class="thead">
                    <p>来源/用途</p>
                    <p>收入/支出</p>
                    <p>时间</p>
                    <p>备注</p>
                </div>
                <div class="same clearfix" v-for="(item,index) in tradeList.data" :key="index">
                    <p>{{item.description}}</p>
                    <p>{{balanceStatus[Number(item.type)]}}{{item.changes_balance}}</p>
                    <p>{{item.recharge_time|formatDate}}</p>
                    <p>{{item.description}}</p>
                </div>
                <div class="pagation" v-if="tradeList.count">
                    <el-pagination
                        background
                        layout="total, prev, pager, next"
                        :total="parseInt(tradeList.count)"
                        @current-change="currentPage"
                    ></el-pagination>
                </div>
            </div>
            <div class="base" v-show="isline == 1">
                <div class="thead">
                    <p>来源/用途</p>
                    <p>收入/支出</p>
                    <p>时间</p>
                    <p>备注</p>
                </div>
                <div class="same clearfix" v-for="(item,index) in incomeList.data" :key="index">
                    <p>{{item.description}}</p>
                    <p>{{balanceStatus[Number(item.type)]}}{{item.changes_balance}}</p>
                    <p>{{item.recharge_time|formatDate}}</p>
                    <p>{{item.description}}</p>
                </div>
                <div class="pagation" v-if="incomeList.count">
                    <el-pagination
                        background
                        layout="total, prev, pager, next"
                        :total="parseInt(incomeList.count)"
                        @current-change="currentPage1"
                    ></el-pagination>
                </div>
            </div>
            <div class="base" v-show="isline == 2">
                <div class="thead">
                    <p>来源/用途</p>
                    <p>收入/支出</p>
                    <p>时间</p>
                    <p>备注</p>
                </div>
                <div
                    class="same clearfix"
                    v-for="(item,index) in expenditureList.data"
                    :key="index"
                >
                    <p>{{item.description}}</p>
                    <p>{{item.changes_balance}}</p>
                    <p>{{item.recharge_time|formatDate}}</p>
                    <p>{{item.description}}</p>
                </div>
                <div class="pagation" v-if="expenditureList.count">
                    <el-pagination
                        background
                        layout="total, prev, pager, next"
                        :total="parseInt(expenditureList.count)"
                        @current-change="currentPage2"
                    ></el-pagination>
                </div>
            </div>
        </div>
        <div class="inner" v-show="inner">
            <div class="top">
                <p>绑定提现账号</p>
            </div>
            <div class="spa">
                <p>
                    <span>*</span>请输入您要提现的金额:
                    <input type="text">
                    <span>
                        <img src="../../../assets/img/weixian.png"> 请输入您要提现的金额不能为空
                    </span>
                </p>
                <p class="huise">提现金额必须大于0，不得大于您的可提现资金</p>
            </div>
            <div class="spa">
                <p>
                    <span>*</span>请输入您要提现的账户:
                    <select name>
                        <option value>中国建设银行 尾号0895</option>
                    </select>
                    <span class="lanse" @click="Bangding">绑定提现账户</span>
                </p>
                <p class="huise">提现，需要绑定您的银行卡或者支付宝等账户，网站方会将提现金额打入您绑定的提现账户中</p>
            </div>
            <div class="submit">提交申请</div>
        </div>
        <div class="Tixian" v-show="Tixian">
            <div class="top">
                <p>绑定提现账号</p>
            </div>
            <img class="logo" v-show="Img1" src="../../../assets/img/buzhou1.png">
            <img class="logo" v-show="Img2" src="../../../assets/img/buzhou2.png">
            <img v-show="Img3" class="logo" src="../../../assets/img/buzhou3.png">
            <ul>
                <li class="l" :class="{color:Imgs1}">验证身份</li>
                <li class="l" :class="{color:Imgs2}">绑定提现账户</li>
                <li class="l" :class="{color:Imgs3}">完成</li>
            </ul>
            <div v-show="first">
                <p class="shouji">
                    已绑定的手机：
                    <span>185****3665</span>
                </p>
                <p class="yanzhengma">
                    <span>*</span>验证码：
                    <input type="text">
                    <span></span>
                    <img src="../../../assets/img/yanzhengma1.png">
                </p>
                <p class="dongtai">
                    <span>*</span>
                    <span>手机动态验证码：</span>
                    <input class="l" type="text">
                    <span class="l">获取手机验证码</span>
                </p>
            </div>
            <div v-show="second">
                <div class="fangshi">
                    <p class="l">
                        <span>*</span>请选择提现方式：
                    </p>
                    <p class="l">
                        <input
                            @click="Inp(0)"
                            type="radio"
                            name="chose"
                            value="1"
                            checked="checked"
                        >支付宝
                    </p>
                    <p class="l">
                        <input @click="Inp(1)" type="radio" name="chose" value="2">银行转账
                    </p>
                </div>
                <div class="name">
                    <span>*</span>收款人姓名：
                    <input type="text">
                </div>
                <p class="beizhu">请填写收款人姓名，该收款人姓名=支付宝开户人姓名</p>
                <div v-show="yinhang==1">
                    <div class="kahao">
                        <span>*</span>银行卡号：
                        <input type="text">
                    </div>
                    <div class="kahao kahaos">
                        <span>*</span>开户行：
                        <input type="text">
                    </div>
                </div>
                <div class="zhifu name" v-show="zhifubao==0">
                    <span>*</span>支付宝账号：
                    <input type="text">
                </div>
            </div>
            <div class="third" v-show="third">
                <img class="duihao" src="../../../assets/img/duihao1.png" alt>
                <p class="success">银行卡绑定成功</p>
                <p class="goback" @click="Goback">返回账户安全中心>></p>
            </div>
            <button @click="nextStep" v-show="Btn">下一步</button>
            <button @click="NextStep" v-show="Btns">下一步</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            myZhanghu: true,
            inner: false,
            isline: "",
            Tixian: false,
            first: true,
            second: false,
            third: false,
            Img1: true,
            Img2: false,
            Img3: false,
            Imgs1: true,
            Imgs2: false,
            Imgs3: false,
            yinhang: "",
            zhifubao: "",
            Btn: true,
            Btns: false,
            isShow: false,
            tradeList: {},
            incomeList: {},
            expenditureList: {},
            balanceStatus: ["-", "+", "-"]
        };
    },
    created() {
        this.getDetails();
        this.getIncome();
        this.getExpenditure();
    },
    methods: {
        //交易明细
        getDetails(p) {
            this.HTTP(
                this.$httpConfig.getDetailsType,
                {
                    page: p ? p : 1
                },
                "post"
            )
                .then(res => {
                    this.tradeList = res.data;
                })
                .catch(() => {
                    this.tradeList = [];
                });
        },
        currentPage(val) {
            this.getDetails(val);
        },
        //收入
        getIncome(p) {
            this.HTTP(
                this.$httpConfig.getDetailsIncome,
                {
                    page: p ? p: 1
                },
                "post"
            )
                .then(res => {
                    this.incomeList = res.data;
                })
				.catch(() => {
					  this.incomeList = {};
				});
				
        },
        currentPage1(val) {
            this.getIncome(val);
        },
        //支出
        getExpenditure(p) {
            this.HTTP(
                this.$httpConfig.getDetailsPay,
                {
                    page: p ? p: 1
                },
                "post"
            )
                .then(res => {
                    this.expenditureList = res.data;
                })
                .catch(() => {});
        },
        currentPage2(val) {
            this.getExpenditure(val);
        },
        Zhanghu(index) {
            this.isline = index;
        },
        Bangding() {
            this.Tixian = true;
            this.inner = false;
        },
        nextStep() {
            this.first = false;
            this.second = true;
            this.Img1 = false;
            this.Img2 = true;
            this.Imgs2 = true;
            this.Btn = false;
            this.Btns = true;
        },
        Inp(index) {
            this.yinhang = index;
            this.zhifubao = index;
        },
        NextStep() {
            this.Img2 = false;
            this.Img3 = true;
            this.Imgs3 = true;
            this.third = true;
            this.Btns = false;
            this.second = false;
        },
        Goback() {
            this.Imgs3 = false;
            this.Img3 = false;
            this.Img1 = true;
            this.Btn = true;
            this.first = true;
            this.third = false;
            this.Tixian = false;
            this.inner = true;
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

.center {
    width: 1190px;
    margin: 0 auto;
    height: 100%;
}

.myaccount {
    height: 956px;
    width: 990px;
    background: #fff;
    margin: 16px 0;
    .top {
        overflow: hidden;
        margin: 14px 17px 12px;
        border-bottom: 1px solid #e7e7e7;
        line-height: 37px;
        ul {
            li {
                height: 37px;
                margin-top: 10px;
                cursor: pointer;
                float: left;
                font-size: 14px;
                color: #666;
                p {
                    width: 100%;
                    border-right: 1px solid #e7e7e7;
                    line-height: 16px;
                    text-align: center;
                }
            }
            li:nth-of-type(1) {
                width: 105px;
            }
            li:nth-of-type(2) {
                width: 77px;
            }
            li:nth-of-type(3) {
                width: 77px;
                p {
                    border-right: 0;
                }
            }
            .line {
                border-bottom: 2px solid red;
                font-size: 12px;
                color: red;
            }
        }
        a {
            cursor: pointer;
            display: inline-block;
            width: 80px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            color: #fff;
            border-radius: 3px;
            background: red;
            margin-left: 10px;
        }
        .spa {
            background: #fff;
            color: red;
            border: 1px solid red;
        }
    }
    .zijin {
        height: 55px;
        margin: 0 17px 20px;
        padding-left: 22px;
        background: #fcfcfc;
        line-height: 60px;
        font-size: 12px;
        color: #333;
        span {
            color: #e31939;
            font-weight: 600;
        }
    }
    .base {
        overflow: hidden;
        margin: 0 17px;
        .thead {
            height: 42px;
            // border: 1px solid #e8e8e8;
            line-height: 42px;
            background: #fafafa;
            p {
                float: left;
                font-size: 12px;
                margin-left: 140px;
            }
        }
        .same {
            margin-top: 17px;
            p {
                float: left;
                font-size: 12px;
                color: #333;
                min-height: 17px;
            }
            p:nth-of-type(1) {
                margin-left: 150px;
                width: 100px;
            }
            p:nth-of-type(2) {
                margin-left: 95px;
                width: 100px;
            }
            p:nth-of-type(3) {
                margin-left: 60px;
                width: 200px;
            }
        }
        .pagation {
            text-align: right;
            margin-top: 50px;
        }
    }
    .inner {
        .top {
            overflow: hidden;
            margin: 14px 17px 0px;
            border-bottom: 1px solid #e7e7e7;
            line-height: 37px;
            p {
                width: 104px;
                text-align: center;
                border-bottom: 2px solid red;
                font-size: 12px;
                color: red;
            }
        }
        .spa {
            margin: 30px 17px 0px;
            span {
                color: #ff2424;
                margin-right: 7px;
            }
            input {
                width: 150px;
                height: 30px;
                border: 1px solid #ccc;
                margin: 0 12px 0 10px;
            }
            img {
                display: inline-block;
                margin-top: -3px;
            }
            .huise {
                font-size: 12px;
                color: #999;
                margin: 7px 0 0 165px;
            }
            select {
                width: 268px;
                height: 30px;
                outline: none;
                color: #999;
                margin: 0 12px 0 10px;
            }
            .lanse {
                color: #427ab4;
                cursor: pointer;
            }
        }
        .submit {
            width: 94px;
            height: 32px;
            text-align: center;
            background: red;
            color: #fff;
            line-height: 32px;
            font-size: 12px;
            margin: 33px 0 0 180px;
            cursor: pointer;
            border-radius: 3px;
        }
    }
    .Tixian {
        .top {
            overflow: hidden;
            margin: 14px 17px 0px;
            border-bottom: 1px solid #e7e7e7;
            line-height: 37px;
            p {
                width: 104px;
                text-align: center;
                border-bottom: 2px solid red;
                font-size: 14px;
                color: red;
            }
        }
        .logo {
            margin: 60px 0 0 79px;
        }
        ul {
            overflow: hidden;
            margin: 12px 0 0 171px;
            li {
                font-size: 14px;
                color: #d0d0d0;
            }
            li:nth-of-type(2) {
                margin: 0 182px 0 177px;
            }
            .color {
                color: #bad746;
            }
        }
        input {
            border-radius: 4px;
        }
        p.shouji {
            margin: 60px 0 0 208px;
            span {
                color: #999;
            }
        }
        p.yanzhengma {
            margin: 25px 0 0 230px;
            span:nth-of-type(1) {
                color: #ff3f3f;
                margin-right: 13px;
            }
            input {
                width: 180px;
                height: 38px;
                border: 1px solid #ccc;
                border-radius: 3px;
                margin-right: 15px;
            }
        }
        p.dongtai {
            margin: 21px 0 0 174px;
            overflow: hidden;
            line-height: 38px;
            span {
                float: left;
            }
            span:nth-of-type(1) {
                color: #ff3f3f;
                margin-right: 13px;
            }
            input {
                width: 110px;
                height: 38px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }
            span:nth-of-type(3) {
                cursor: pointer;
                width: 136px;
                height: 38px;
                border: 1px solid #d9d9d9;
                background: #f6f6f6;
                display: inline-block;
                text-align: center;
                line-height: 38px;
                margin: 0 0 0 12px;
            }
        }
        .fangshi {
            overflow: hidden;
            margin: 63px 0 0 158px;
            span {
                color: #ff3f3f;
                margin-right: 13px;
            }
            p {
                font-size: 14px;
                margin-right: 17px;
                input {
                    float: left;
                    margin: 3px 6px 0 0;
                }
            }
        }
        .name {
            margin: 29px 0 0 187px;
            font-size: 14px;
            span {
                color: #ff3f3f;
                margin-right: 13px;
            }
            input {
                width: 180px;
                height: 38px;
                border: 1px solid #ccc;
                margin-left: 17px;
            }
        }
        .beizhu {
            font-size: 14px;
            color: #999;
            margin: 7px 0 15px 308px;
        }
        .kahao {
            margin-left: 201px;
            span {
                color: #ff3f3f;
                margin-right: 13px;
            }
            input {
                width: 260px;
                height: 38px;
                border: 1px solid #ccc;
                margin-left: 17px;
            }
        }
        .kahaos {
            margin: 13px 0 0 215px !important;
        }
        .zhifu {
            margin: 0px 0 0 187px !important;
            input {
                width: 260px;
                height: 38px;
                border: 1px solid #ccc;
                margin-left: 17px;
            }
        }
        .third {
            margin: 60px 0 0 396px;
            position: relative;
            img {
                position: absolute;
                top: -16px;
                left: -74px;
            }
            .success {
                font-size: 17px;
                color: #afd129;
                margin-bottom: 22px;
            }
            .goback {
                cursor: pointer;
                font-size: 14px;
                color: #ff1111;
            }
        }
        button {
            width: 100px;
            height: 38px;
            line-height: 38px;
            text-align: center;
            color: #fff;
            background: #afd129;
            border-radius: 4px;
            margin: 30px 0 0 305px;
            cursor: pointer;
        }
    }
}
</style>