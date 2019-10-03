<template>
    <div
        @mouseenter="getCartData"
        @mouseover="addclass"
        @mouseout="removeclass"
        class="dropdown r"
        :class="{hover:addStyle}"
    >
        <div class="myCar">
            <i class="car"></i>
            <a @click="toLink">我的购物车</a>
            <i class="el-icon-arrow-right qt"></i>
            <i class="shopping-amount">{{countTotal.totalNum||0}}</i>
        </div>
        <div class="dropdown-layer">
            <!-- <div class="g-cart-pop" v-if="cartData && cartData.length != 0"> -->
            <div class="g-cart-pop">
                <!-- <div class="cart-header">
                    <h4 class="cart-tit">新加入的商品</h4>
                </div> -->
                <p class="to-login" v-if="noLogin">未登录，<span @click="toLogin()">点击登录</span></p>
                <div class="cart-goods">
                    <div class="cart-goods-list" v-for="(item,i) in storeInfo" :key="item.id">
                        <p class="store-tit">
                            店铺：
                            <router-link
                                target="_blank"
                                :to="{path:'/storehome',query:{id:item.id}}"
                            >{{item.shop_name}}</router-link>
                        </p>
                        <ul class="cart-list-bx">
                            <li
                                class="cart-item"
                                v-for="(cartItem,index) in  cartData"
                                :key="index"
                            >
                                <div class="cart-goods-info clearfix" v-if="item.id === cartItem.store_id">
                                    <div
                                        class="cart-gs-img l"
                                        @click="toDetails(cartItem.goods_id)"
                                    >
                                        <img :src="URL + cartItem.pic_url" alt>
                                    </div>
                                    <div class="cart-name l" @click="toDetails(cartItem.goods_id)">
                                        <span class="gp-s">{{cartItem.title}}</span>
                                    </div>
                                    <div class="cart-info r">
                                        <div
                                            class="goods-price text1-hidden r"
                                        >¥{{cartItem.price_member}}×{{cartItem.goods_num}}</div>
                                        <p
                                            class="cart-delete gp-s r"
                                            @click="delGoods(i,index,cartItem.id)"
                                        >删除</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cart-ft">
                    <div class="cart-ft-info">
                        共
                        <span class="cart-num">{{countTotal.totalNum}}</span>件商品 共计
                        <span class="cart-num">￥{{countTotal.totalPrice|keep2Num}}</span>
                    </div>
                    <a class="to-cart" @click="toLink">去购物车</a>
                </div>
            </div>
            <div class="cart-empty" v-if="onoff">购物车中还没有商品，赶紧选购吧 !</div>
            <div class="loading" v-if="onoff1">
                <i class="rotate"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            addStyle: false,
            onoff: false,
            onoff1: true,
            noLogin: false,
            cartData: [],
            storeInfo: []
        };
    },
    watch: {
        cartData() {
            if (typeof this.cartData === "undefined") {
                return;
            }
            if (this.cartData.length == 0) {
                this.onoff = true;
            }
        }
    },
    mounted() {
        // this.getCartData();
    },
    computed: {
        countTotal() {
            let totalNum = 0;
            let totalPrice = 0;

            if (this.cartData  instanceof Array)  {
                for (let index = 0; index < this.cartData.length; index++) {
                    totalNum += parseInt(this.cartData[index].goods_num);
                    totalPrice +=
                        parseInt(this.cartData[index].goods_num) *
                        parseFloat(this.cartData[index].price_member);
                }
            }
            return {
                totalNum,
                totalPrice
            };
        }
    },
    methods: {
        toLogin() {
            this.$router.push({
            name: 'passwordLogin'
            })
        },
        toDetails(id) {
            window.open(window.location.origin + "/inroyaldrink?id=" + id);
        },
        toLink() {
            window.open(window.location.origin + "/buyCar");
        },
        addclass() {
            this.addStyle = true;
        },
        removeclass() {
            this.addStyle = false;
        },
        //购物车数据
        getCartData() {
            this.HTTP(this.$httpConfig.cartGoodsList, {}, "post", true)
                .then(res => {
                    if(res.data.status==10001){
                        this.noLogin = true;
                    }
                    this.cartData = res.data.data.cart;

                    this.storeInfo = res.data.data.store;
                    if (this.cartData && this.cartData.length == 0) {
                        this.onoff = true;
                        this.onoff1 = false;
                    } else {
                        this.onoff = false;
                        this.onoff1 = false;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        //购物车删除
        delGoods(index, index1, id) {
            this.HTTP(
                this.$httpConfig.delGoodsCart,
                {
                    id: id
                },
                "post"
            ).then(res => {
                console.log(res);
                if (res.data.status == 1) {
                    this.cartData[index].goods.splice(index1, 1);
                    if (this.cartData[index].goods.length == 0) {
                        this.cartData.splice(index, 1);
                    }
                }
            });
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

.dropdown:hover .myCar {
    border-color: #ccc;
    border-bottom: none;
    padding-bottom: 2px;
}

.dropdown.hover .dropdown-layer {
    display: block;
}

.dropdown.hover .myCar {
    border-color: #ccc;
    border-bottom: none;
    padding-bottom: 2px;
}

.dropdown:hover .dropdown-layer {
    display: block;
}

.dropdown {
    position: relative;
    z-index: 20;
    .myCar {
        width: 139px;
        height: 32px;
        border: 1px solid #e0e0e0;
        background-color: #fff;
        line-height: 32px;
        position: relative;
        z-index: 101;
        box-sizing: content-box;
        .qt {
            margin-left: 10px;
        }
        .car {
            width: 30px;
            height: 30px;
            float: left;
            background: url(../assets/img/ShoppingCart.png) no-repeat;
            background-size: 30px 30px;
            margin: 2px 5px 0 10px;
        }
        i {
            font-size: 12px;
        }
        a {
            color: #959595;
            font-size: 12px;
        }
        .shopping-amount {
            position: absolute;
            font-style: normal;
            background-color: red;
            display: inline-block;
            min-width: 16px;
            text-align: center;
            line-height: 14px;
            padding: 1px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            border-bottom-left-radius: 0;
            top: -6px;
            right: auto;
            left: 103px;
            color: #fff;
        }
    }
    .dropdown-layer {
        position: absolute;
        display: none;
        top: 34px;
        right: 0;
        width: 308px;
        z-index: 100;
        border: 1px solid #ccc;
        background-color: #fff;
        // -webkit-box-shadow: 1px 2px 1px rgba(0, 0, 0, 0.1);
        // -moz-box-shadow: 1px 2px 1px rgba(0, 0, 0, 0.1);
        // box-shadow: 1px 2px 1px rgba(0, 0, 0, 0.1);
        .g-cart-pop {
            position: relative;
            width: 100%;
            z-index: 100;
            background: #fff;
            .to-login{
                width: 100%;
                font-size: 14px;
                text-align: center;
                margin-top: 20px;
                margin-bottom: 20px;
                span{
                    cursor: pointer;
                    &:hover {
                        color: red;
                    }
                }
            }
            .cart-header {
                height: 25px;
                padding: 6px 8px;
                line-height: 25px;
                box-sizing: content-box;
                .cart-tit {
                    color: #666;
                    font-size: 12px;
                    font-weight: bold;
                }
            }
            .cart-goods {
                height: auto !important;
                height: 340px;
                max-height: 344px;
                overflow-y: auto;
                .cart-goods-list {
                    background: #fff;
                    .store-tit {
                        padding: 6px 8px;
                        font-size: 12px;
                        a {
                            color: #4a4a4a;
                        }
                        a:hover {
                            color: red;
                        }
                    }
                    .cart-list-bx {
                        .cart-item {
                            line-height: 17px;
                            .cart-goods-info {
                                padding: 8px 10px;
                                .cart-gs-img {
                                    width: 50px;
                                    height: 50px;
                                    border: 1px solid #ddd;
                                    margin-right: 10px;
                                    cursor: pointer;
                                    img {
                                        width: 100%;
                                        height: 100%;
                                    }
                                }
                                .cart-name {
                                    width: 120px;
                                    height: 52px;
                                    overflow: hidden;
                                    cursor: pointer;
                                    span {
                                        display: inline-block;
                                        font-size: 12px;
                                    }
                                }
                                .cart-name:hover span {
                                    color: red;
                                }
                                .cart-info {
                                    text-align: right;
                                    width: 85px;
                                    .goods-price {
                                        clear: both;
                                        font-size: 12px;
                                        font-weight: 700;
                                        max-width: 85px;
                                    }
                                    .cart-delete {
                                        cursor: pointer;
                                        clear: both;
                                        max-width: 85px;
                                        font-size: 12px;
                                    }
                                    .cart-delete:hover {
                                        color: red;
                                    }
                                }
                            }
                        }
                        .cart-item:hover {
                            background: #f5f5f5;
                        }
                    }
                }
            }
            .cart-ft {
                padding: 8px;
                background: #f5f5f5;
                text-align: right;
                overflow: hidden;
                font-size: 12px;
                .cart-ft-info {
                    float: left;
                    line-height: 29px;
                    .cart-num {
                        font-weight: 700;
                    }
                }
                .to-cart {
                    float: right;
                    height: 29px;
                    padding: 0 10px;
                    background: red;
                    color: #fff;
                    text-align: center;
                    font-weight: 700;
                    line-height: 29px;
                    border-radius: 3px;
                    -moz-border-radius: 3px;
                    -webkit-border-radius: 3px;
                }
            }
        }
        .cart-empty {
            height: 49px;
            margin: auto;
            padding: 10px 0;
            text-align: center;
            line-height: 49px;
            overflow: hidden;
            color: #999;
            font-size: 12px;
            box-sizing: content-box;
        }
        .loading {
            height: 70px;
            position: relative;
            .rotate {
                position: absolute;
                top: 50%;
                left: 50%;
                margin-left: -13px;
                margin-top: -13px;
                display: inline-block;
                width: 26px;
                height: 26px;
                border-radius: 50%;
                border: 1px solid gray;
                border-bottom-color: transparent;
            }
            .rotate {
                -webkit-animation: rotate 0.6s linear infinite;
                animation: rotate 0.6s linear infinite;
            }
            @-webkit-keyframes rotate {
                0% {
                    -webkit-transform: rotate(0deg);
                }
                100% {
                    -webkit-transform: rotate(360deg);
                }
            }
            @keyframes rotate {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
        }
    }
}
</style>
