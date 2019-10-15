<template>
    <div class="my-charge l">
        <div class="top">
            <span class="l">充值记录</span>
            <span class="r">在线充值</span>
        </div>

        <p class="l inp">
            充值类型：
            <el-select v-model="type_id" placeholder="请选择">
                <el-option
                    v-for="item in rechargeType"
                    :key="item.id"
                    :label="item.type_name"
                    :value="item.id"
                ></el-option>
            </el-select>
        </p>

        <p class="l inp">
            充值日期：
            <el-date-picker
                v-model="value"
                type="datetimerange"
                value-format="yyyy-MM-dd HH:mm:ss"
                range-separator="至"
                start-placeholder="开始日期"
                end-placeholder="结束日期"
            ></el-date-picker>
        </p>

        <p @click="search" class="l search">搜索</p>

        <ul>
            <li @click="Chongzhi('')" :class="{line:Line===''}">全部记录</li>
            <li @click="Chongzhi(1)" :class="{line:Line===1}">已支付记录</li>
            <li @click="Chongzhi(0)" :class="{line:Line===0}">未支付记录</li>
        </ul>

        <div class="under">
            <div class="thead">
                <p>充值时间</p>

                <p>充值金额(元)</p>

                <p>留言</p>

                <p>状态</p>

                <p>支付方式</p>
            </div>

            <div class="down" v-for="(item,index) in rechargeList" :key="index">
                <p>{{item.ctime |formatDate}}</p>
                <p>
                    <span>{{item.account}}</span>
                </p>
                <p>{{item.message}}</p>
                <p>{{rechargeStatus[item.pay_status]}}</p>
                <p>{{item.type_name}}</p>
            </div>
        </div>

        <div class="fenye" v-show="page>=15">
            <div class="box2">
                <el-pagination
                    @current-change="handleCurrentChange"
                    background
                    layout="total,prev, pager, next,jumper"
                    :page-size="page_size"
                    :total="page"
                ></el-pagination>
            </div>
        </div>
    </div>
</template>

<script>
import { MapTool } from "../../../../es6/tool.js";
export default {
    data() {
        return {
            value: null,

            rechargeList: [],

            rechargeStatus: ["待支付", "充值成功", "交易关闭"],

            Line: "",

            rechargeType: [],

            type_id: "",

            page: 0, //共多少条
            currentPage: 1, //当前页
            page_size: 15 //每页显示多少条数据
        };
    },

    created() {
        this.getRechargeList();

        this.getRechargeType();
    },

    methods: {
        //跳转分页
        handleCurrentChange(currentPage) {
            console.log(currentPage);
            this.currentPage = currentPage;
            this.search();
        },
        search() {
            // 时间
            let timegp = null;
            if (this.value === null) {
                timegp = null;
            } else {
                timegp = this.value.join(" - ");
            }

            let param = {
                pay_status:  this.Line,
                pay_id: this.type_id,
                timegp: timegp,
                page: this.currentPage
            };
            MapTool.deleteEmptyValue(param);
            this.HTTP(this.$httpConfig.rechargeList, param, "post")
                .then(res => {
                    console.log(res);
                    if (res.message == "") {
                        this.$message.error("暂无数据");
                    } else {
                        this.rechargeList = res.data.data;
                        this.page = Number(res.data.count);
                        this.page_size = Number(res.data.page_size);
                        console.log(this.rechargeList);
                    }
                })
                .catch(e => {
                    console.log(e);
                });
        },

        getRechargeList() {
            this.HTTP(
                this.$httpConfig.rechargeList,
                {
                    page: this.currentPage
                },
                "post"
            )

                .then(res => {
                    console.log(res);

                    this.rechargeList = res.data.data;
                    this.page = Number(res.data.count);
                    this.page_size = Number(res.data.page_size);
                })
                .catch(() => {});
        },

        getRechargeType() {
            this.HTTP(this.$httpConfig.getPayRechargeResult, {}, "post")

                .then(res => {
                    this.rechargeType = res.data;
                    console.log(this.rechargeType);
                })
                .catch(() => {});
        },

        Chongzhi(index) {
            this.Line = index;

            this.search();
        }
    },

    getpayStates() {
        for (var item of this.rechargeList.data) {
            if (item.pay_status == 0) {
            }
        }
    }
};
</script>

<style lang="less" scoped>
.l {
    float: left;
}

.fenye {
    width: 100%;
    overflow: hidden;

    .box2 {
        display: flex;
        justify-content: center;
        flex-wrap: nowrap;
        width: 23%;
        margin: 0 auto;
    }
}

.r {
    float: right;
}

.center {
    width: 1200px;

    margin: 0 auto;

    height: 100%;
}

.my-charge {
    height: 956px;

    width: 980px;

    background: #fff;

    margin: 16px 0;

    .top {
        overflow: hidden;

        margin: 14px 17px 0px;

        border-bottom: 1px solid #e7e7e7;

        line-height: 37px;

        span.l {
            width: 104px;

            text-align: center;

            border-bottom: 2px solid red;

            font-size: 14px;

            color: red;
        }

        span.r {
            width: 80px;

            height: 28px;

            text-align: center;

            line-height: 28px;

            background: red;

            color: #fff;

            border-radius: 4px;

            margin-top: 4px;
        }
    }

    p.inp {
        margin: 21px 10px 0 18px;

        font-size: 12px;

        color: #333;

        select {
            width: 205px;

            height: 40px;

            outline: none;

            color: #666;
            appearance: none;
            padding: 0px 7px 0 9px;
        }
    }

    p.search {
        width: 54px;

        height: 28px;

        text-align: center;

        line-height: 28px;

        color: #fff;

        border-radius: 4px;

        background: #27a9e3;

        cursor: pointer;

        margin-top: 21px;
    }

    ul {
        overflow: hidden;

        margin: 64px 17px 15px;

        border-bottom: 1px solid #e7e7e7;

        li {
            cursor: pointer;

            float: left;

            line-height: 40px;

            width: 104px;

            text-align: center;

            font-size: 13px;

            color: #666;
        }

        .line {
            border-bottom: 2px solid red;

            color: red;
        }
    }

    .under {
        overflow: hidden;

        border: 1px solid #e7e6e6;

        margin: 0 17px;

        .thead {
            line-height: 42px;

            background: #f1f1f1;

            overflow: hidden;
        }

        p {
            height: 100%;

            text-align: center;

            float: left;

            font-size: 12px;

            color: #333;
        }

        p:nth-of-type(1) {
            width: 317px;

            margin-right: 54px;
        }

        p:nth-of-type(2) {
            width: 127px;
        }

        p:nth-of-type(3) {
            width: 171px;
        }

        p:nth-of-type(4) {
            width: 112px;

            margin-right: 24px;
        }

        p:nth-of-type(5) {
            width: 139px;
        }

        .down {
            line-height: 39px;

            height: 39px;

            border-top: 1px solid #e7e6e6;

            span {
                color: #e31939;
            }
        }
    }
}
</style>