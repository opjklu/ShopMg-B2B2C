<template>
    <div class="buycar" ref="buycart">
        <alert :alert-show.sync="alertShow" :store-id="storeId"></alert>
        <buy-header></buy-header>
        <div class="center">
            <div id="cart-goods-list" ref="listHeight">
                <div class="all">
                    <p class="l active">商品列表</p>
                    <p class="l">
                        <router-link to="buyCarPackage">套餐列表</router-link>
                    </p>
                    <div class="r right">
                        <a :class="{active:btnStyle}" class="r jie" @click="buy">结算</a>
                        <div class="r">
                            已选商品（不含运费）
                            <span>￥{{selectedPrice | keep2Num}}</span>
                        </div>
                    </div>
                </div>
                <div class="xinxi">
                    <div class="l left">
                        <div id="check">
                            <input
                                type="checkbox"
                                class="input_check"
                                id="input"
                                :checked="CheckBoxCartGoodsList"
                                @click="checkedAll"
                            >
                            <label for="input"></label>
                        </div>
                        <span @click="checkedAll" class="total-selection">全选</span>
                        <span>商品信息</span>
                    </div>
                    <div class="right r">
                        <span>单价</span>
                        <span>数量</span>
                        <span>金额</span>
                        <span>操作</span>
                    </div>
                </div>
                <div class="dianpu" v-for="(store,index) in storeInfo" :key="index">
                    <div class="top">
                        <div id="check">
                            <input
                                type="checkbox"
                                class="input_check"
                                :id="store.id"
                                :checked="store.CheckBoxShop"
                                @click="allShop(index, store.id)"
                            >
                            <label :for="store.id"></label>
                        </div>
                        <span class="name">
                            店铺：
                            <span
                                class="store-name"
                                @click="toStore(store.id)"
                            >{{store.shop_name}}</span>
                        </span>
                        <img @click="openQQ" src="../../assets/img/qq.jpg">
                        <div class="l voucher" @click="voucher(store.id, index)">优惠券</div>
                    </div>
                    <div class="bottom">
                        <p class="up">
                            <span>满送活动</span>
                            <span>满200，送xxxxxxxxxxxx（送完即止）</span>
                        </p>
                        <div
                            class="down"
                            v-for="(item,i) in cartGoodsList"
                            :key="i"
                            :class="item.CheckBoxGoods ? 'isSelect' : ''"
                            v-if="item.store_id === store.id"
                        >
                            <div id="check">
                                <input
                                    type="checkbox"
                                    class="input_check"
                                    :id="item.id"
                                    :checked="item.CheckBoxGoods"
                                    @click="checkedGoods(index,i, item)"
                                >
                                <label :for="item.id"></label>
                            </div>
                            <img
                                @click="toDetails(item.goods_id)"
                                class="l ctrl-img"
                                :id="item.goods_id"
                                @mouseover="showBigImg(item)"
                                @mouseleave="hideBigImg(item)"
                                :src="URL+item.pic_url"
                            >
                            <p @click="toDetails(item.goods_id)" class="l">{{item.title}}</p>
                            <p class="l">分类</p>

                            <p class="l">
                                <span>￥{{item.price_market}}</span>
                                <br>
                                ￥{{item.price_member}}
                            </p>
                            <div class="l jishu">
                                <el-input-number
                                    size="mini"
                                    v-model="item.goods_num"
                                    @change="cartNumModify(item)"
                                    :min="1"
                                    :max="200"
                                    ref="number"
                                ></el-input-number>
                            </div>
                            <p
                                class="l"
                                ref="money"
                            >￥{{(item.price_new * item.goods_num) | keep2Num}}</p>
                            <div class="r yiru">
                                <span @click="move(i,index,item)">移入收藏夹</span>
                                <br>
                                <span @click="remove(i,index,item)">删除</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="jiesuan"
                :class="{'fixed-bottom':fixedBtn}"
                v-show="cartGoodsList.length != 0"
            >
                <div id="check">
                    <input
                        type="checkbox"
                        class="input_check"
                        id="input"
                        :checked="CheckBoxCartGoodsList"
                        @click="checkedAll"
                    >
                    <label for="input"></label>
                </div>
                <p class="l" @click="checkedAll">全选</p>
                <p class="l" @click="removeAll('del')">删除选中的商品</p>
                <p class="l" @click="removeAll('col')">移入收藏夹</p>
                <p
                    class="r"
                    style="color: white; font-size: 16px;"
                    :class="{active:btnStyle}"
                    @click="buy"
                >结算</p>
                <p class="r">
                    合计（不含运费）：
                    <span>{{this.selectedPrice | keep2Num}}</span>
                </p>
                <p class="r">
                    已选商品
                    <span>{{this.selectedNumber}}</span>件
                </p>
            </div>
            <div class="del" v-show="Object.keys(delGoodsInfo).length != 0">已删除商品，您可以重新购买或加关注</div>
            <div class="cargo" v-show="Object.keys(delGoodsInfo).length != 0">
                <p class="l">{{delGoodsInfo.title}}</p>
                <p class="l">
                    <span>￥{{delGoodsInfo.price_new}}</span>
                    {{delGoodsInfo.goods_num}}
                </p>
                <p class="r">
                    <router-link
                        :to="{path:'/inroyaldrink',query:{id:delGoodsInfo.goods_id}}"
                        style="color:#666;"
                    >重新购买</router-link>
                    <router-link to="/collect" style="color:#666;">移动到我的收藏夹</router-link>
                </p>
            </div>
            <like-and-history></like-and-history>
        </div>

        <foot-com></foot-com>
        <div id="ctrlBidImg">
            <i></i>
            <img id="show-img">
        </div>
    </div>
</template>

<script>
import $ from "jquery";
import { Message } from "element-ui";
import alert from "./alert.vue";
export default {
    components: {
        alert
    },
    data() {
        return {
            cartGoodsList: [], //所有的商品列表
            CheckBoxCartGoodsList: false, //商品列表是否全选
            delGoodsInfo: {}, //最新删除的商品
            selectedPrice: 0.0, //选择时显示的商品价格
            selectedNumber: 0, //已选商品件数
            selectedGoodsArr: [], //已选择商品
            goods: [],
            flag: false,
            btnStyle: false,
            fixedBtn: false,
            vouchers: [],
            voucherShow: [],
            alertShow: false,
            storeId: undefined,
            storeInfo: []
        };
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    created() {
        this.getCartList();
    },
    watch: {
        goods() {
            this.btnStyle = this.cartGoodsList.length > 0 ? true : false;
        },
        cartGoodsList() {
            this.$nextTick(() => {
                let listHeight =
                    this.$refs.listHeight.clientHeight +
                    this.$refs.listHeight.offsetTop;
                let windowHeight =
                    document.documentElement.clientHeight ||
                    document.body.clientHeight;
                this.fixedBtn = listHeight > windowHeight ? true : false;
            });
        }
    },
    mounted() {
        var that = this;
        $("html,body").animate(
            {
                scrollTop: "0px"
            },
            300
        );
        window.addEventListener("scroll", this.handleScroll);
    },
    methods: {
        voucher(storeId, index) {
            this.alertShow = true;
            this.storeId = Number(storeId);
        },

        handleScroll() {
            let scrollPosition =
                document.body.scrollTop == 0
                    ? document.documentElement.scrollTop
                    : document.body.scrollTop; //滚动条位置
            let windowHeight =
                document.documentElement.clientHeight ||
                document.body.clientHeight; // 可视高度
            let listHeight =
                this.$refs.listHeight.offsetTop +
                this.$refs.listHeight.clientHeight; //位置高度
            this.fixedBtn =
                scrollPosition + windowHeight > listHeight ? false : true;
        },
        toStore(id) {
            window.open(window.location.origin + "/storehome?id=" + id);
        },
        toDetails(id) {
            window.open(window.location.origin + "/inroyaldrink?id=" + id);
        },

        log(arg) {
            console.log(arg);
        },
        buy() {
            let list = [];
            if (this.btnStyle) {
                for (let index = 0; index < this.goods.length; index++) {
                    list.push(this.goods[index].id);
                }
                sessionStorage.setItem("cart_id", list.join());
                this.$router.push("account");
            }
        },
        // 购物车商品列表
        getCartList() {
            this.HTTP(this.$httpConfig.cartGoodsList, {}, "post", false).then(res => {
                if (res.status === 0) {
                    this.cartGoodsList = [];
                    this.storeInfo = [];
                    return;
                }

                this.cartGoodsList = res.data.cart;

                this.storeInfo = res.data.store;

                let index = 0;

                for (index = 0; index < this.storeInfo.length; index++) {
                    this.storeInfo[index].CheckBoxShop = false;
                }

                for (index = 0; index < this.cartGoodsList.length; index++) {
                    this.cartGoodsList[index].CheckBoxGoods = false;
                }
            });
        },

        // 店铺全选
        allShop(index, storeId) {
            this.storeInfo[index].CheckBoxShop = !this.storeInfo[index]
                .CheckBoxShop;

            console.log(this.storeInfo);

            for (let i = 0; i < this.cartGoodsList.length; i++) {
                if (
                    this.cartGoodsList[i].store_id === storeId &&
                    this.storeInfo[index].CheckBoxShop === true
                ) {
                    this.cartGoodsList[i].CheckBoxGoods = true;
                    this.addgoods(this.cartGoodsList[i]);
                } else {
                    this.cartGoodsList[i].CheckBoxGoods = false;
                    this.deletegoods(this.cartGoodsList[i]);
                }
            }
            this.allPriceNum();
            this.testingSelectedShop();
        },

        // 购物车商品数量修改
        cartNumModify(item) {
            if (this.flag === true) {
                return;
            } //避免点击过快
            this.flag = true;
            this.HTTP(
                this.$httpConfig.cartNumModify,
                {
                    id: item.id,
                    num: item.goods_num,
                    goods_id: item.goods_id
                },
                "post"
            )
                .then(res => {
                    this.flag = false;
                    if (item.CheckBoxGoods === true) {
                        this.allPriceNum();
                    }
                })
                .catch(err => {
                    return false;
                });
        },

        // 从购物车中删除商品
        /**
         * @String Index 商品
         *  @Int key  商户
         */
        remove(index, key, item) {
            this.delGoodsInfo = item;
            console.log(this.delGoodsInfo);
            this.$confirm("确认要删除该宝贝吗?", "提示", {
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                type: "warning",
                closeOnClickModal: false,
                lockScroll: false,
                center: true
            })
                .then(() => {
                    this.HTTP(
                        this.$httpConfig.delGoodsCart,
                        {
                            id: ~~item.id
                        },
                        "post"
                    )
                        .then(res => {
                            if (res.status == 1) {
                                this.delGoodsInfo = item;
                                this.delGoodsFun(index, key, item);
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        });
                })
                .catch(() => {});
        },

        //将购物车商品移入收藏夹
        move(index, key, item) {
            this.$confirm("确认要移入收藏夹吗?", "提示", {
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                type: "warning",
                closeOnClickModal: false,
                lockScroll: false,
                center: true
            })
                .then(() => {
                    this.HTTP(
                        this.$httpConfig.cartGoodsCollection,
                        {
                            goods_id: item.goods_id,
                            id: item.id
                        },
                        "post"
                    )
                        .then(res => {
                            if (res.status == 1) {
                                console.log(12345);
                                this.delGoodsInfo = item;
                                this.delGoodsFun(index, key, item);
                                this.$alert("添加成功", "提示", {
                                    confirmButtonText: "确定",
                                    center: true,
                                    lockScroll: false,
                                    type: "warning"
                                });
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        });
                })
                .catch(() => {});
        },

        //删除商品和移动商品共用的删除方法

        delGoodsFun(index, key, item) {
            this.cartGoodsList.splice(index, 1);

            if (this.cartGoodsList.length === 0) {
                this.storeInfo.splice(key, 1);
            }
            if (this.cartGoodsList.length == 0) {
                this.cartGoodsList = [];
                this.storeInfo = [];
            }
        },
        //选中的数据
        addgoods(goods) {
            if (this.goods.length > 0) {
                for (var j = 0; j < this.goods.length; j++) {
                    if (this.goods[j].id === goods.id) {
                        return;
                    } else {
                        this.goods.push(goods);
                        return;
                    }
                }
            } else {
                this.goods.push(goods);
            }
        },
        //取消选中
        deletegoods(goods) {
            if (this.goods.length === 0) {
                return;
            } else {
                for (var j = 0; j < this.goods.length; j++) {
                    if (this.goods[j].id === goods.id) {
                        this.goods.splice(j, 1);
                    }
                }
            }
        },
        // 全选
        checkedAll() {
            this.goods = [];
            this.CheckBoxCartGoodsList = !this.CheckBoxCartGoodsList;
            let index = 0;

            for (let i = 0; i < this.storeInfo.length; i++) {
                this.storeInfo[i].CheckBoxShop = this.CheckBoxCartGoodsList;
            }
            for (index; index < this.cartGoodsList.length; index++) {
                this.cartGoodsList[
                    index
                ].CheckBoxGoods = this.CheckBoxCartGoodsList;

                if (this.CheckBoxCartGoodsList) {
                    this.addgoods(this.cartGoodsList[index]);
                } else {
                    this.deletegoods(this.cartGoodsList[index]);
                }
            }
            this.allPriceNum();
        },
        //选中的总价和数量
        allPriceNum() {
            this.selectedNumber = 0;
            this.selectedPrice = 0;
            for (var j = 0; j < this.goods.length; j++) {
                this.selectedNumber += this.goods[j].goods_num;
                this.selectedPrice +=
                    parseFloat(this.goods[j].price_member) *
                    this.goods[j].goods_num;
            }
        },

        // 检测是否所有的店铺都选择了
        testingSelectedShop() {
            var selectedNum = 0;

            let i = 0;

            for (i; i < this.storeInfo.length; i++) {
                if (this.storeInfo[i].CheckBoxShop === true) {
                    selectedNum++;
                }
            }

            console.log(selectedNum + "->" + this.storeInfo.length);

            this.CheckBoxCartGoodsList =
                selectedNum == this.storeInfo.length ? true : false;
        },
        // 商品单选
        checkedGoods(index, i, item) {
            this.cartGoodsList[i].CheckBoxGoods = !this.cartGoodsList[i]
                .CheckBoxGoods;

            let selectedState = this.cartGoodsList[i].CheckBoxGoods;

            if (selectedState) {
                this.addgoods(this.cartGoodsList[i]);
            } else {
                this.deletegoods(this.cartGoodsList[i]);
            }
            this.allPriceNum();
            var goodsLength = 0; //// 判断是否选择当前店铺的全选
            for (let k = 0; k < this.cartGoodsList.length; k++) {
                if (this.cartGoodsList[k].CheckBoxGoods === true) {
                    goodsLength++;
                }
            }
            this.storeInfo[index].CheckBoxShop =
                goodsLength == this.cartGoodsList.length ? true : false;
            this.testingSelectedShop();
        },
        /*
         * 删除所选数据商品
         */
        delSelectedData() {
            let covert = {};

            for (let index = 0; index < this.goods.length; index++) {
                covert[this.goods[index].id] = this.goods[index];
            }

            let covertByStore = {};

            for (index = 0; index < this.storeInfo.length; index++) {
                covertByStore[this.storeInfo[index].id] = this.storeInfo[index];
            }

            let storeId = 0;

            for (index = 0; index < this.cartGoodsList.length; index++) {
                
                if (covert.hasOwnProperty(this.cartGoodsList[index].id)) {
                    
                    storeId =  this.cartGoodsList[index].store_id;
                    
                    this.cartGoodsList[index].splice(i, 1);

                    delete covert[this.cartGoodsList[index].id];

                    if (this.cartGoodsList.length === 0 && covertByStore.hasOwnProperty(storeId)) {
                        delete covertByStore[storeId];
                    }
                    
                    if (this.cartGoodsList.length == 0) {
                        this.cartGoodsList = [];
                    }
                }
            }

            this.goods = Object.keys(covert);

            this.storeInfo = Object.keys(covertByStore);

        },
        /*
         * 移动所有商品到收藏夹、删除所有商品
         */
        removeAll(type) {
            let arr = [];

            let cartId = [];
            for (let i = 0; i < this.goods.length; i++) {
                arr.push(this.goods[i].goods_id);
                cartId.push(this.goods[i].id);
            }

            if (this.goods.length === 0) {
                this.$alert("请至少选中一件商品！", "提示", {
                    confirmButtonText: "知道了",
                    center: true,
                    lockScroll: false,
                    type: "warning"
                });
                return;
            } else {
                //先判断是删除还是移入
                if (type == "del") {
                    this.$confirm("确认要删除该宝贝吗?", "提示", {
                        confirmButtonText: "确定",
                        cancelButtonText: "取消",
                        type: "warning",
                        closeOnClickModal: false,
                        lockScroll: false,
                        center: true
                    })
                        .then(() => {
                            this.HTTP(
                                this.$httpConfig.deleteManyGoodsCart,
                                {
                                    id: cartId.join(",")
                                },
                                "post"
                            )
                                .then(res => {
                                    this.getCartList();
                                })
                                .catch(err => {
                                    console.log(err);
                                });
                        })
                        .catch(() => {});
                } else {
                    //如果是移入则走这里
                    this.$confirm("确认要移入收藏夹吗?", "提示", {
                        confirmButtonText: "确定",
                        cancelButtonText: "取消",
                        type: "warning",
                        closeOnClickModal: false,
                        lockScroll: false,
                        center: true
                    })
                        .then(() => {
                            this.HTTP(
                                this.$httpConfig.addBatchCollection,
                                {
                                    goods_id: arr.join(","),
                                    id: cartId.join(",")
                                },
                                "post"
                            )
                                .then(res => {
                                    if (res.status == 1) {
                                        this.delGoodsInfo = this.selectedGoodsArr;
                                        this.delSelectedData();
                                        this.$alert("添加成功", "提示", {
                                            confirmButtonText: "确定",
                                            center: true,
                                            lockScroll: false,
                                            type: "warning"
                                        });
                                    }
                                })
                                .catch(err => {
                                    console.log(err);
                                });
                        })
                        .catch(() => {});
                }
            }
        },
        /*
         * 显示大图
         */
        showBigImg(item) {
            var top = 0;
            var leftImg = $(".ctrl-img");
            for (var i in leftImg) {
                if (leftImg[i].id == item.goods_id) {
                    top = leftImg.eq(i).offset().top;
                }
            }
            $("#ctrlBidImg").css({
                display: "block",
                top: Number(top - 35) + "px"
            });

            $("#show-img").attr("src", this.URL + item.pic_url);
        },

        /*
         * 关闭大图
         */
        hideBigImg(item) {
            $("#ctrlBidImg").css({
                display: "none"
            });
        },
        /*
         * 打开qq联系人
         */
        openQQ() {
            var qq = "66600000"; //获取qq号
            window.open(
                "http://wpa.qq.com/msgrd?v=3&uin=" + qq + "&site=qq&menu=yes",
                "_brank"
            );
        }
    }
};
</script>

<style>
.el-input-number__decrease:hover:not(.is-disabled)
    ~ .el-input
    .el-input__inner:not(.is-disabled),
.el-input-number__increase:hover:not(.is-disabled)
    ~ .el-input
    .el-input__inner:not(.is-disabled) {
    border-color: #c0c4cc;
}

.el-input-number__decrease:hover,
.el-input-number__increase:hover {
    color: #606266;
}
</style>

<style lang="less" scoped>
.l {
    float: left;
}

.r {
    float: right;
}
.buycar {
    position: relative;
    background:#fff;
}
.voucherBox {
    border: 2px solid red;
    border-radius: 5px;
    overflow: hidden;
    position: relative;
    left: -160px;
    top: 50px;
    background: white;
    display: flex;
    flex-direction: column;
    z-index: 1;
    width: 500px;
    li {
        display: flex;
        flex-direction: row;
        margin: 5px 0;
        .MoneyBox {
            display: flex;
            align-items: center;
        }
        .money {
            width: 70px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #ccc;
            border-radius: 5px;
        }
        .col {
            flex: 1;
            flex-direction: column;
        }
        .row {
            display: flex;
            flex-direction: row;
            height: 30px;
        }
        div:last-child {
            color: red;
            display: flex;
            align-items: center;
            margin-right: 30px;
        }
    }
}

.voucher {
    width: 110px;
    border: 2px dotted red;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 25px;
}
.center {
    width: 1190px;
    margin: 0 auto;
    height: 100%;
}
#check {
    position: relative;
    float: left;
    .input_check {
        position: absolute;
        visibility: hidden;
    }
    .input_check + label {
        display: inline-block;
        width: 15px;
        height: 13px;
        border: 1px solid #c1c1c1;
    }
    .input_check:checked + label:after {
        content: "";
        position: absolute;
        left: 2px;
        bottom: 20px;
        width: 14px;
        height: 9px;
        border: 2px solid #e92333;
        border-top-color: transparent;
        border-right-color: transparent;
        -ms-transform: rotate(-60deg);
        -moz-transform: rotate(-60deg);
        -webkit-transform: rotate(-60deg);
        transform: rotate(-45deg);
    }
}

.all {
    height: 37px;
    margin-top:50px;
    p {
        height: 37px;
        line-height: 37px;
        color: #555;
        width: 125px;
        text-align: center;
        border-bottom: 2px solid #e5e5e5;
        span {
            font-size: 12px;
        }
        a {
            color: #555;
        }
    }
    p.active {
        color: red;
        border-bottom: 2px solid red;
    }
    .right {
        width: 940px;
        border-bottom: 2px solid #e5e5e5;
        height: 37px;
        .jie {
            width: 56px;
            height: 26px;
            background: #ccc;
            border-radius: 3px;
            text-align: center;
            color: #fff;
            line-height: 26px;
            margin-top: 5px;
            cursor: default;
        }
        .jie.active {
            background: red;
        }
        div.r {
            line-height: 37px;
            color: #7f7f7f;
            margin-right: 22px;
            span {
                color: #af2928;
            }
        }
    }
}

.xinxi {
    height: 45px;
    margin-top: 17px;
    line-height: 45px;
    .left {
        .input_check:checked + label:after {
            bottom: 23px !important;
        }
        .total-selection {
            cursor: pointer;
        }
        span {
            float: left;
            font-size: 12px;
            color: #303030;
            margin-right: 74px;
            margin-left: 10px;
        }
    }
    .right {
        span {
            font-size: 12px;
            color: #303030;
            margin-right: 110px;
        }
    }
}

.dianpu {
    margin-bottom: 6px;
    .top {
        height: 40px;
        line-height: 40px;
        span {
            float: left;
            font-size: 12px;
            margin-left: 10px;
        }
        .name {
            .store-name {
                float: none;
            }
            .store-name:hover {
                color: red;
            }
        }
        img {
            margin: 9px 0 0 10px;
            float: left;
        }
    }
    .bottom {
        border: 1px solid #ccc;
        overflow: hidden;
        width: 1200px;
        .up {
            height: 50px;
            border-bottom: 1px solid #e8e8e8;
            line-height: 50px;
            font-size: 12px;
            span:nth-of-type(1) {
                display: inline-block;
                width: 64px;
                height: 20px;
                background: #da9d28;
                text-align: center;
                line-height: 20px;
                color: #fff;
                margin: 0 9px 0 50px;
            }
        }
        .down {
            height: 120px;
            border-bottom: 1px solid #eee;
            position: relative;
            #check {
                margin: 20px;
            }
            .input_check:checked + label:after {
                bottom: 10px !important;
            }
            img {
                margin-top: 20px;
                width: 80px;
                height: 80px;
                cursor: pointer;
            }
            .goods-name {
                display: -webkit-box;
                overflow: hidden;
                white-space: normal !important;
                text-overflow: ellipsis;
                word-wrap: break-word;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
            }
            p:nth-of-type(1) {
                width: 226px;
                font-size: 12px;
                color: #575757;
                margin-top: 29px;
                margin-left: 11px;
                cursor: pointer;
            }
            p:nth-of-type(1):hover {
                color: red;
            }
            p:nth-of-type(2) {
                font-size: 12px;
                color: #575757;
                line-height: 85px;
                width: 210px;
            }

            p:nth-of-type(3) {
                font-size: 15px;
                margin: 26px 0 0 0;
                font-weight: bold;
                color: #575757;
                text-align: center;
                width: 130px;
                span {
                    font-size: 10px;
                    color: #acacac;
                    text-decoration: line-through;
                }
            }
            .jishu {
                height: 25px;
                margin-top: 29px;
                z-index: 0;
                position: relative;
                span {
                    width: 19px;
                    height: 23px;
                    background: #f0f0f0;
                    float: left;
                    text-align: center;
                    line-height: 25px;
                    border: 1px solid #e6e6e6;
                }
                input {
                    width: 39px;
                    height: 23px;
                    border: 1px solid #aaa;
                    float: left;
                    text-align: center;
                }
            }
            p:nth-of-type(4) {
                font-size: 12px;
                color: #c4555c;
                margin: 33px 0px 0 22px;
                width: 150px;
                text-align: center;
            }
            .yiru {
                font-size: 12px;
                color: #a0a0a0;
                margin-top: 29px;
                margin-right: 74px;
                cursor: pointer;
                span:hover {
                    color: red;
                }
            }
        }
        .down.isSelect {
            background-color: #bbb7ab;
        }
        .bgc {
            background: #fef8e0;
        }
    }
}

.jiesuan {
    height: 50px;
    background: #e5e5e5;
    margin-top: 20px;
    position: relative;
    bottom: 0;
    width: 1200px;
    #check {
        margin: 16px 10px;
    }
    .input_check:checked + label:after {
        bottom: 10px !important;
    }
    p {
        font-size: 12px;
        line-height: 50px;
        span {
            color: #f40;
            font-weight: 700;
            font-size: 18px;
            margin: 0 10px;
        }
    }
    p:nth-of-type(1) {
        margin-right: 21px;
        cursor: pointer;
    }
    p:nth-of-type(2) {
        margin-right: 28px;
        cursor: pointer;
    }
    p:nth-of-type(2):hover {
        color: red;
    }
    p:nth-of-type(3):hover {
        color: red;
    }
    p:nth-of-type(3) {
        cursor: pointer;
    }
    p:nth-of-type(4) {
        width: 120px;
        height: 100%;
        background-color: #ccc;
        text-align: center;
        line-height: 50px;
        cursor: default;
        a {
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }
    }
    p:nth-of-type(4).active {
        background-color: #f40;
    }
    p:nth-of-type(5) span:before {
        content: "￥";
        font-size: 14px;
        font-weight: 400;
    }
}
.fixed-bottom {
    position: fixed;
}
.del {
    margin: 30px 0 16px;
    font-size: 12px;
    color: #323232;
}

.cargo {
    height: 32px;
    border: 1px solid #fadfe6;
    background: #fef8f8;
    width: 100%;
    line-height: 32px;
    font-size: 12px;
    color: #696564;
    margin-bottom: 5px;
    p:nth-of-type(1) {
        margin-left: 17px;
    }
    p:nth-of-type(2) {
        margin-left: 300px;
        span {
            margin-right: 92px;
            color: #555452;
        }
    }
    p:nth-of-type(3) {
        margin-right: 47px;
        span {
            margin-left: 22px;
        }
    }
}

#ctrlBidImg {
    width: 240px;
    height: 240px;
    position: absolute;
    left: 380px;
    top: 0;
    padding: 10px;
    background-color: #fff;
    z-index: 100;
    border: #ddd solid 1px;
    display: none;
    box-shadow: 0 2px 1px rgba(0, 0, 0, 0.06);
    i {
        width: 10px;
        height: 10px;
        border-width: 10px;
        border-color: transparent #ddd transparent transparent;
        border-style: solid;
        position: absolute;
        left: -20px;
        top: 65px;
    }
    #show-img {
        width: 100%;
        height: 100%;
    }
}

#ctrlBidImg::after {
    content: "";
    width: 10px;
    height: 10px;
    border-width: 10px;
    border-color: transparent #fff transparent transparent;
    border-style: solid;
    position: absolute;
    left: -19px;
    top: 65px;
}
</style>