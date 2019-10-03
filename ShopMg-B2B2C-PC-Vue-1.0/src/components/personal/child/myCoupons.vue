<template>
    <div class="mycoupons l">
        <div class="top">
            <p>我的优惠券</p>
        </div>
        <div class="content-coupon">
            <div class="l youhui youhuis" v-for="(item,index) in couponList.data" :key="index">
                <div class="up">
                    <p>
                        <span class="l">￥</span>
                        <span class="l">{{item.money}}</span>
                        <span class="r">本店通用</span>
                    </p>
                    <p>使用条件:满{{item.condition}}</p>
                    <p>有效时间:{{item.use_start_time| formatDate2}} 至 {{item.use_end_time|formatDate2}}</p>
                    <p>发行店铺:{{item.shop_name}}</p>
                    <ul>
                        <li class="l">
                            <img src="../../../assets/img/youhuihu.png">318.00
                        </li>
                        <li class="l">
                            <img src="../../../assets/img/youhuihu.png">318.00
                        </li>
                        <li class="l">
                            <img src="../../../assets/img/youhuihu.png">318.00
                        </li>
                    </ul>
                </div>
                <div class="down">
                    <img @click="toShop(item.id)" src="../../../assets/img/youhuicar.png" alt> |
                    <img src="../../../assets/img/youhuilajikuang.png">
                </div>
            </div>
            <div class="page" v-show="couponList.count>=15">
                <div class="box2">
                    <el-pagination
                        @current-change="handleCurrentChange"
                        background
                        layout="total,prev, pager, next,jumper"
                        :page-size="Number(couponList.page_size)"
                        :total="Number(couponList.count)"
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
            couponList: [],
            page: 1
        };
    },
    created() {
        this.getCoupon();
    },
    methods: {
        getCoupon() {
            this.HTTP(
                this.$httpConfig.myCouponLists,
                { status: 3, page: this.page },
                "post",
                false
            )
                .then(res => {
                    this.couponList = res.data.data;
                })
                .catch(e => {
                    console.log(e);
                });
        },
        toShop(id) {
            window.open(window.location.origin + "/storehome?id=" + id);
        },
        //跳转分页
        handleCurrentChange(currentPage) {
            this.page = currentPage;
            this.getCoupon();
        }
    }
};
</script>

<style lang="less" scoped>
.page {
    width: 100%;
    overflow: hidden;
    margin-top: 2%;
    .box2 {
        display: flex;
        justify-content: center;
        flex-wrap: nowrap;
        width: 23%;
        margin: 0 auto;
    }
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

.mycoupons {
    min-height: 1100px;
    height: auto;
    width: 990px;
    background: #fff;
    margin: 16px 0;
    float: left;
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
    .content-coupon {
        width: 980px;
        height: auto;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        padding: 0 0 20px 0;
        .youhui {
            margin: 18px 20px 0 0;
            .up {
                width: 243px;
                height: 260px;
                background: url(../../../assets/img/youhui.png) no-repeat center;
                p {
                    float: left;
                    width: 218px;
                    margin-left: 12px;
                    margin-right: 12px;
                    font-size: 11px;
                    color: #fff;
                    line-height: 21px;
                }
                p:nth-of-type(1) {
                    margin: 19px 12px 23px 12px;
                    span:nth-of-type(1) {
                        font-size: 18px;
                    }
                    span:nth-of-type(2) {
                        font-size: 28px;
                    }
                }
                ul {
                    float: left;
                    margin-top: 36px;
                    margin-left: 5px;
                    li {
                        width: 70px;
                        height: 84px;
                        text-align: center;
                        font-size: 10px;
                        color: #666;
                        margin-left: 6px;
                        img {
                            float: left;
                            margin-bottom: 4px;
                        }
                    }
                }
            }
        }
        .youhuis {
            margin-left: 22px !important;
        }
        .down {
            text-align: center;
            margin-top: 12px;
            color: #f3efee;
            img {
                cursor: pointer;
            }
        }
    }
}
</style>