<template>
    <div class="buycar" ref="buycart">
        <buy-header></buy-header>
        <div class="center">
            <div id="cart-goods-list" ref="listHeight">
                <div class="all">
                    <p class="l">
                        <router-link to="buycar">商品列表</router-link>
                    </p>
                    <p class="l active">套餐列表</p>
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
                <div class="dianpu" v-for="(item,i) in cartGoodsList.cart" :key="i">
                    <div v-for="(store,index) in cartGoodsList.store" :key="index">
                        <div class="top">
                            <div id="check" v-if="item.store_id == store.id">
                                <!-- <input type="checkbox" class="input_check" :id="store" :checked="store.CheckBoxShop" @click="allShop(index)"> -->
                                <label :for="store"></label>
                            </div>
                            <span class="name">
                                店铺：
                                <span
                                    @click="toStore(store.store_id)"
                                    class="store-name"
                                >{{store.shop_name}}</span>
                            </span>
                            <img @click="openQQ" src="../../assets/img/qq.jpg">
                        </div>
                        <div class="bottom">
                            <!-- <p class="up"><span>满送活动</span><span>满200，送xxxxxxxxxxxx（送完即止）</span></p> -->
                            <div class="down" :class="item.CheckBoxGoods ? 'isSelect' : ''">
                                <div class="meal-name clearfix">
                                    <div id="check">
                                        <input
                                            type="checkbox"
                                            class="input_check"
                                            :id="item.id"
                                            :checked="item.CheckBoxGoods"
                                            @click="checkedGoods(index,i)"
                                        >
                                        <label :for="item.id"></label>
                                    </div>
                                    <div class="l meal-tit">{{item.package_title}}</div>
                                    <div class="l jishu">
                                        <el-input-number
                                            size="mini"
                                            v-model="item.package_num"
                                            @change="cartNumModify(item)"
                                            :min="1"
                                            :max="100"
                                            ref="number"
                                        ></el-input-number>
                                    </div>
                                    <div
                                        class="l dis-price"
                                    >{{parseFloat(item.discount)*item.package_num |keep2Num}}</div>
                                    <div class="r yiru">
                                        <span @click="remove(i,index,item)">删除</span>
                                    </div>
                                </div>
                                <div
                                    class="meal-goods-list clearfix"
                                    v-for="(g,k) in cartGoodsList.goods"
                                    :key="k"
                                >
                                    <div v-if="g.package_id === item.package_id">
                                        <img
                                            @click="toDetails(g.goods_id)"
                                            class="l ctrl-img"
                                            :id="item.g"
                                            @mouseover="showBigImg(item)"
                                            @mouseleave="hideBigImg(item)"
                                            :src="URL+g.pic_url"
                                        >
                                        <p @click="toDetails(g.goods_id)" class="l">{{g.title}}</p>
                                        <p class="l">分类</p>
                                        <p class="l">
                                            <span>￥{{g.price_member|keep2Num}}</span>
                                            <br>
                                            ￥{{g.goods_discount|keep2Num}}
                                        </p>
                                    </div>
                                </div>
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
                <p class="l" @click="removeAll()">删除选中的商品</p>
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
                    <span>重新购买</span>
                    <span>移动到我的收藏夹</span>
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
export default {
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
            fixedBtn: false
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
            this.btnStyle = this.goods.length > 0 ? true : false;
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
        buy() {
            let list = [];
            if (this.btnStyle) {
                for (let index = 0; index < this.goods.length; index++) {
                    list.push(this.goods[index].id);
                }
                sessionStorage.setItem("cart_id", list.join());
                this.$router.push("orderInfo");
            }
        },
        // 套餐购物车商品列表
        getCartList() {
            this.HTTP(this.$httpConfig.cartPackageList, {}, "post")
                .then(res => {
                    // this.cartGoodsList = [];
                    let storeData = res.data;
                    let newData = {};
                    for (
                        let index = 0;
                        index < storeData.store.length;
                        index++
                    ) {
                        newData[storeData.store[index].id] =
                            storeData.store[index];
                        storeData.store = newData;
                    }

                    for (let i = 0; i < storeData.cart.length; i++) {
                        storeData.cart[i].CheckBoxGoods = false;
                    }
                    this.cartGoodsList = storeData;
                    console.log(this.cartGoodsList);
                })
                .catch(e => {
                    console.log(e);
                });
        },

        // 购物车商品数量修改
        cartNumModify(item) {
            console.log(item);
            if (this.flag === true) {
                return;
            } //避免点击过快
            this.flag = true;
            this.HTTP(
                this.$httpConfig.packageNumModify,
                {
                    id: item.id,
                    package_num: item.package_num
                },
                "post"
            )
                .then(res => {
                    this.flag = false;
                    if (item.CheckBoxGoods === true) {
                        this.allPriceNum();
                    }
                })
                .catch(res => {
                    this.flag = false;
                    alert(res.message);
                    item.package_num--;
                });
        },

        // 从购物车中删除商品
        remove(index, key, item) {
            this.delGoodsInfo = item;
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
                        this.$httpConfig.cartPackageDel,
                        {
                            id: ~~item.id
                        },
                        "post"
                    )
                        .then(res => {
                            console.log(2213213);
                            this.getCartList();
                            if (res.status == 1) {
                                this.delGoodsInfo = item;
                                this.delGoodsFun(index, key, item);
                            }
                        })
                        .catch(err => {
                            console.log(err);
                            console.log("我的");
                        });
                })
                .catch(() => {});
        },

        //删除商品和移动商品共用的删除方法

        delGoodsFun(index, key, item) {
            this.cartGoodsList[key].goods.splice(index, 1);
            if (this.cartGoodsList[key].goods.length == 0) {
                this.cartGoodsList.splice(key, 1);
            }
            if (this.cartGoodsList.length == 0) {
                this.cartGoodsList = [];
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
            console.log(this.cartGoodsList);
            for (var index in this.cartGoodsList.cart) {
                // this.cartGoodsList[index].CheckBoxShop = this.CheckBoxCartGoodsList;
                this.cartGoodsList.cart[
                    index
                ].CheckBoxGoods = this.CheckBoxCartGoodsList;
                // for (var i in this.cartGoodsList[index].cart) {
                // this.cartGoodsList[index].cart[i].CheckBoxGoods = this.CheckBoxCartGoodsList;
                if (this.CheckBoxCartGoodsList) {
                    this.addgoods(this.cartGoodsList.cart[index]);
                } else {
                    this.deletegoods(this.cartGoodsList.cart[index]);
                }
                // }
            }
            this.allPriceNum();
        },
        //选中的总价和数量
        allPriceNum() {
            this.selectedNumber = 0;
            this.selectedPrice = 0;
            console.log(this.goods);
            for (var j = 0; j < this.goods.length; j++) {
                this.selectedNumber += this.goods[j].package_num;
                this.selectedPrice +=
                    parseFloat(this.goods[j].discount) *
                    this.goods[j].package_num;
            }
        },
        // 店铺全选
        allShop(index) {
            this.cartGoodsList[index].CheckBoxShop = !this.cartGoodsList[index]
                .CheckBoxShop;
            let list = this.cartGoodsList[index].cart;
            for (let i = 0; i < list.length; i++) {
                if (this.cartGoodsList[index].CheckBoxShop) {
                    list[i].CheckBoxGoods = true;
                    this.addgoods(list[i]);
                } else {
                    list[i].CheckBoxGoods = false;
                    this.deletegoods(list[i]);
                }
            }
            this.allPriceNum();
            this.testingSelectedShop();
        },
        // 检测是否所有的店铺都选择了
        testingSelectedShop() {
            var selectedNum = 0;
            for (let i = 0; i < this.cartGoodsList.cart.length; i++) {
                if (this.cartGoodsList.cart[i].CheckBoxGoods === true) {
                    selectedNum++;
                }
            }
            this.CheckBoxCartGoodsList =
                selectedNum == this.cartGoodsList.cart.length ? true : false;
            console.log(this.CheckBoxCartGoodsList);
        },
        // 商品单选
        checkedGoods(index, i) {
            this.cartGoodsList.cart[i].CheckBoxGoods = !this.cartGoodsList.cart[
                i
            ].CheckBoxGoods;
            let selectedState = this.cartGoodsList.cart[i].CheckBoxGoods;
            if (selectedState) {
                this.addgoods(this.cartGoodsList.cart[i]);
            } else {
                this.deletegoods(this.cartGoodsList.cart[i]);
            }
            this.allPriceNum();
            var goodsLength = 0; //// 判断是否选择当前店铺的全选
            for (let k = 0; k < this.cartGoodsList.cart.length; k++) {
                if (this.cartGoodsList.cart[k].CheckBoxGoods === true) {
                    goodsLength++;
                }
            }
            this.cartGoodsList.CheckBoxCartGoodsList =
                goodsLength == this.cartGoodsList.cart.length ? true : false;
            console.log(this.cartGoodsList.CheckBoxCartGoodsList);
            this.testingSelectedShop();
        },
        /*
         * 删除所选数据商品
         */
        delSelectedData() {
            for (var index in this.cartGoodsList) {
                for (var k in this.selectedGoodsArr) {
                    if (
                        this.cartGoodsList[index].store_id ==
                        this.selectedGoodsArr[k].store_id
                    ) {
                        for (var i in this.cartGoodsList[index].goods) {
                            if (
                                this.cartGoodsList[index].goods[i].goods_id ==
                                this.selectedGoodsArr[k].goods_id
                            ) {
                                this.cartGoodsList[index].goods.splice(i, 1);
                                if (
                                    this.cartGoodsList[index].goods.length == 0
                                ) {
                                    this.cartGoodsList.splice(index, 1);
                                }
                                if (this.cartGoodsList.length == 0) {
                                    this.cartGoodsList = [];
                                }
                            }
                        }
                    }
                }
            }
        },
        /*
         * 移动所有商品到收藏夹、删除所有商品
         */
        removeAll() {
            var arr = [];
            for (var i in this.goods) {
                arr.push(this.goods[i].id);
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
                                id: arr.join(",")
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
            }
        },
        /*
         * 显示大图
         */
        showBigImg(item) {
            // var top = 0;
            // var leftImg = $(".ctrl-img");
            // for (var i in leftImg) {
            // 	if (leftImg[i].id == item.goods_id) {
            // 		top = leftImg.eq(i).offset().top;
            // 	}
            // }
            // $("#ctrlBidImg").css({
            // 	"display": "block",
            // 	"top": Number(top - 35) + "px"
            // });
            // $("#show-img").attr("src", this.URL + item.puc_url);
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
    background:#fff;
}
.center {
    width: 1200px;
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
        width: 130px;
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
                cursor: pointer;
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
            border-bottom: 1px solid #eee;
            position: relative;
            .meal-goods-list {
                margin-left: 40px;
            }
            #check {
                margin: 10px 20px;
            }
            .meal-tit {
                width: 130px;
                line-height: 38px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .dis-price {
                font-size: 12px;
                color: #c4555c;
                margin: 14px 0px 0 7px;
                width: 150px;
                text-align: center;
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
                margin: 29px 25px 0 55px;
                width: 170px;
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
                margin-left: 545px;
                margin-top: 10px;
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
            .yiru {
                font-size: 12px;
                color: #a0a0a0;
                margin-top: 16px;
                margin-right: 74px;
                cursor: pointer;
                span:hover {
                    color: red;
                }
            }
        }
        .down.isSelect {
            background-color: #fff8e1;
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
    z-index: 1200;
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
    p:nth-of-type(3) {
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
    p:nth-of-type(3).active {
        background-color: #f40;
    }
    p:nth-of-type(4) span:before {
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