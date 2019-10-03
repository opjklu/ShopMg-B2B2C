<template>
    <div class="mywithdrawal l">
        <div class="top">
            <span class="l">提现记录</span>
            <span class="r" @click="getdraw">申请提现</span>
        </div>
        <div class="shixiang">
            <p>我的提现注意事项</p>
            <span>. 您需要先提交您的提现申请信息</span>
            <span>. 您的申请提现信息审核通过后，可在下方操作选项中点击提现，网站方会将款项打入您选定的已绑定账户中</span>
        </div>
        <div class="block pno">
            <el-date-picker
                v-model="value6"
                type="datetimerange"
                value-format="yyyy-MM-dd HH:mm:ss"
                range-separator="至"
                start-placeholder="开始日期"
                end-placeholder="结束日期"
            ></el-date-picker>
            <p class="search" @click="serchMoney">搜索</p>
        </div>

        <div class="under">
            <div class="thead">
                <p>申请日期</p>
                <p>提现金额(元)</p>
                <p>提现账户</p>
                <p>提现方式</p>
                <p>提现平台</p>
                <p>状态</p>
                <p>操作</p>
            </div>
            <div class="down" v-for="(item,index) in withdrawal" :key="index">
                <p>{{item.create_time | formatDate}}</p>
                <p>
                    <span>{{item.money}}</span>
                </p>
                <p>{{item.account}}</p>
                <p :title="item.alipay_order" class="h">{{item.type_name}}</p>
                <p>{{platform[Number(item.platform_type)]}}</p>
                <p>{{state[Number(item.status)]}}</p>
                <p>
                    <input
                        class="t"
                        type="button"
                        value="提现"
                        @click="getMoney(item.id)"
                        v-show="item.status==='1'"
                    >
                    <span v-show="item.status!=='1'">暂无操作</span>
                </p>
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
export default {
    data() {
        return {
            state: ["审核中", "审核成功", "审核失败", "提现成功"],
            withdrawal: [],
            platform: ["pc端", "移动端", "微商城"],
            page: 0, //共多少条
            currentPage: 1, //当前页
            page_size: 20, //每页显示多少条数据
            value6: null
        };
    },
    methods: {
        //日期搜索
        serchMoney() {
            if (this.value6 != null) {
                this.HTTP(
                    this.$httpConfig.loGcashBehavior,
                    {
                        timegp: this.value6.join(" - "),
                        page: this.currentPage
                    },
                    "post"
                )
                    .then(res => {
                        this.withdrawal = res.data.data.data;
                        this.page = Number(res.data.data.count);
                        this.page_size = Number(res.data.data.page_size);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            } else {
                this.$message.error("请先选择再添加!");
            }
        },
        //跳转分页
        handleCurrentChange(currentPage) {
            console.log(currentPage);
            this.currentPage = currentPage;
            this.getcashBehavior();
        },
        //申请提现
        getdraw() {
            this.$router.push({ name: "drawMoney" });
        },
        //获取提现日志
        getcashBehavior() {
            this.HTTP(
                this.$httpConfig.loGcashBehavior,
                { page: this.currentPage },
                "post"
            )
                .then(res => {
                    console.log(res.data.data.data);
                    this.withdrawal = res.data.data.data;
                    this.page = Number(res.data.data.count);
                    this.page_size = Number(res.data.data.page_size);
                })
                .catch(e => {
                    console.log(e);
                });
        },
        //提现
        getMoney(id) {
            this.HTTP(
                this.$httpConfig.cashBehavior,
                {
                    id: id
                },
                "post"
            )
                .then(res => {
                    console.log(res);
                    let status = res.data.message;
                    this.$message({ message: `${status}` });
                })
                .catch(e => {
                    let lstatus = e.data.message;
                    this.$message({ message: `${lstatus}` });
                });
        }
    },
    created() {
        this.getcashBehavior();
    }
};
</script>


<style lang="less" scoped>
.h {
    cursor: pointer;
}
.t {
    padding: 5px;
    cursor: pointer;
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
.shixiang {
    margin: 0 17px 12px;
    border: 1px solid #bce8f1;
    background: #eff8ff;
    height: 115px;
    p {
        font-size: 15px;
        color: #333;
        margin: 15px 0 9px 23px;
    }
    span {
        font-size: 12px;
        color: #a5a7a8;
        line-height: 24px;
        display: block;
        margin-left: 23px;
    }
    span:nth-of-type(2) {
        color: #e31939;
    }
}
.mywithdrawal {
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
            cursor: pointer;
        }
    }
    .t-status:after {
        display: block;
        content: "";
        clear: both;
    }
    p.inp {
        margin: 20px 10px 20px 17px;
        font-size: 12px;
        color: #333;
        select {
            width: 205px;
            height: 27px;
            outline: none;
            color: #666;
            padding: 0 7px 0 9px;
        }
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
            width: 240px;
            //margin-right: 54px;
        }
        p:nth-of-type(2) {
            width: 127px;
        }
        p:nth-of-type(3) {
            width: 171px;
        }
        p:nth-of-type(4) {
            width: 112px;
            //margin-right: 24px;
        }
        p:nth-of-type(5) {
            width: 110px;
        }
        p:nth-of-type(6) {
            width: 107px !important;
        }
        p:nth-of-type(7) {
            width: 75px;
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

.myTixian {
    .under {
        margin: 79px 17px 0;
        p:nth-of-type(4) {
            width: 165px;
            margin-right: 0;
        }
        p:nth-of-type(5) {
            width: 110px;
        }
    }
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
.pno {
    margin: 5px !important;
    margin-left: 15px !important;
    position: relative;
    width: 400px !important;
    .el-date-editor--daterange.el-input__inner {
        width: 400px !important;
    }
}

p.search {
    width: 54px;
    height: 40px;
    line-height: 40px;
    position: absolute;
    right: -22%;
    top: 0px;
    text-align: center;
    color: #fff;
    border-radius: 4px;
    background: #27a9e3;
    cursor: pointer;
}
</style>