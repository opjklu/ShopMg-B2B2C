<template>
    <div class="list">
        <common-header></common-header>
        <store-header></store-header>
        <div class="center header">
            <div class="left">
                <div class="fenlei l">
                    <p>商品分类</p>
                    <ul class="outer">
                        <li class="outerli" v-for="(outers,index) in storeClassArr" :key="index">
                            <span
                                v-if="outers.level === 0"
                                @click="GoTos(outers)"
                            >{{outers.class_name}}</span>
                            <span
                                @click="GoTos(outers)"
                                :style="{marginLeft:outers.level*8 + 'px'}"
                                v-else
                            >> &nbsp; &nbsp;{{outers.class_name}}</span>
                        </li>
                    </ul>
                </div>
                <div class="paihang l">
                    <p class="top">热销排行</p>
                    <ul class="l">
                        <li
                            v-for="(paixus,index) in storeTopSellingList"
                            :key="index"
                            @click="goTO(paixus.id)"
                        >
                            <img class="l" :src="URL+paixus.pic_url">
                            <p class="l">{{paixus.title}}</p>
                            <p class="l">{{paixus.price_member}}</p>
                            <p class="l">
                                售出：
                                <span>{{paixus.sales_sum}}</span>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="right">
                <div class="l top">
                    <ul class="theard l">
                        <li class="l">排列方式：</li>
                        <li class="l" @click="tab(3)" :class="{colors:iscolor == 3}">默认</li>
                        <li
                            class="l li"
                            :key="index"
                            v-for="(theards,index) in theard"
                            @click="tab(index)"
                            :class="{color:iscolor == index}"
                        >{{theards}}</li>
                    </ul>
                    <div class="r zongji">
                        共
                        <span>{{goodsLength}}</span>个商品
                    </div>
                </div>
                <div class="bottom l">
                    <ul class="bottomul l">
                        <li v-for="(li,index) in storeGoodsAllList" :key="index" class="l">
                            <img class="storefuzhu" :src="URL+li.pic_url" @click="goTO(li.id)">
                            <p @click="goTO(li.id)">{{li.title}}</p>
                            <p>
                                <span class="pic1">{{li.goods_price}}</span>
                                <span class="pic2">{{li.goods_price}}</span>
                            </p>
                            <div class="collection" @click="getenshrine(li.id,index)">
                                <i :class="['l like', addenshrine[index] === 1 ? 'cancel' : '']"></i>
                                <span>{{addenshrine[index] === 1 ? '已收藏' : '收藏'}}</span>
                            </div>
                            <img
                                class="r bycar"
                                @click="append(li)"
                                src="../../assets/img/bycar.jpg"
                            >
                        </li>
                    </ul>
                    <div class="paging">
                        <el-pagination
                            background
                            layout="prev, pager, next,jumper"
                            :page-size="page_size"
                            @current-change="handleCurrentChange"
                            :total="page"
                        ></el-pagination>
                    </div>
                </div>
            </div>
        </div>
        <foot-com></foot-com>
    </div>
</template>

<script>

export default {
    data() {
        return {
            addenshrine: [],
            storeID: 0,
            storeGoodsAllList: [], //店铺商品列表
            storeTopSellingList: [], //店铺热销排行
            outer: ["皇家御饮", "御贡赠品", "滋补养身"],
            core: [
                "绿茶",
                "红茶",
                "乌龙茶",
                "花茶",
                "绿茶",
                "红茶",
                "乌龙茶",
                "花茶"
            ],
            fun: "",
            isactive: "",
            theard: ["销量", "人气", "价格"],
            iscolor: "",
            yeshu: ["1", "2", "3", "4", "5"],
            isbg: "",
            storeClassArr: [],

            page_size: 0, //每页显示几个
            page: 0, //总页数
            currentPage: 1, //当前页
            goodsLength: 0
        };
    },
    mounted() {
        this.storeID = this.$route.query.id;
        //获取全部宝贝的分类
        this.getStoreClass();
        //店铺商品列表
        this.getStoreGoodsAllFun();
        //店铺热销排行
        this.getStoreTopSellingFun();
    },
    methods: {
        //添加购物车
        append(li) {
            this.HTTP(
                this.$httpConfig.addGoodToCart,
                {
                    goods_id: li.id,
                    goods_num: 1,
                    price_new: li.goods_price,
                    store_id: sessionStorage.getItem("store_id")
                },
                "	post"
            )
                .then(res => {
                    if (
                        res.data.status === 1 &&
                        res.data.message === "添加成功"
                    ) {
                        this.$confirm("", "已成功加入购物车", {
                            confirmButtonText: "查看购物车",
                            cancelButtonText: "继续购物",
                            type: "success",
                            center: true,
                            lockScroll: false,
                            closeOnClickModal: false,
                            confirmButtonClass: "to-shopping-cart",
                            cancelButtonClass: "continue-shopping"
                        }).then(() => {
                            window.open(window.location.origin + "/buyCar");
                        });
                    }
                })
                .catch(e => {});
        },
        //收藏
        getenshrine(id, index) {
            this.enshrine(this.addenshrine, id, index);
        },
        enshrine(arrays, id, index) {
            this.HTTP(
                this.$httpConfig.setCollectionGoods,
                {
                    goods_id: id
                },
                "post",
                false
            )
                .then(res => {
                    res.data.message === "收藏成功"
                        ? this.$set(arrays, index, 1)
                        : this.$set(arrays, index, 0);
                })
                .catch(() => {});
        },
        //跳转
        goTO(id) {
            this.$router.push({
                path: "/inroyaldrink",
                query: {
                    id: id
                }
            });
        },
        /*页面跳转*/
        handleCurrentChange: function(currentPage) {
            console.log(currentPage);
            this.currentPage = currentPage;
            this.getStoreGoodsAllFun();
        },
        block(index) {
            this.fun = index;
            this.isactive = index;
        },
        tab(index) {
            this.iscolor = index;
            this.arr = this.lis[index];
        },
        color(index) {
            this.isbg = index;
        },
        // 获取店铺“全部分类”内容
        getStoreClass() {
            this.HTTP(
                this.$httpConfig.getStoreClass,
                { id: this.storeID },
                "post"
            ).then(res => {
                console.log(res);
                var list = res.data.data;
                for (var i in list) {
                    this.storeClassArr.push(list[i]);
                }
            });
        },
        //店铺商品列表接口
        getStoreGoodsAllFun() {
            this.HTTP(
                this.$httpConfig.getStoreGoodsAll,
                { id: this.storeID, page: this.currentPage },
                "post"
            ).then(res => {
                this.goodsLength = res.data.data.count;
                this.storeGoodsAllList = res.data.data.list;
                console.log(this.storeGoodsAllList);
                this.page_size = res.data.data.page_size;
                this.page = Number(res.data.data.count);
                window.scrollTo(0, 255);
            });
        },
        //店铺热销排行接口
        getStoreTopSellingFun() {
            this.HTTP(
                this.$httpConfig.getStoreRecommendGoods,
                { id: this.storeID },
                "post"
            ).then(res => {
                var list = res.data.data;
                for (var i in list) {
                    this.storeTopSellingList.push(list[i]);
                }
            });
        }
    }
};
</script>

<style lang="less" scoped>
.collection {
    display: inline-block;
    margin: 10px 10px 0;
    i {
        margin-right: 5px;
    }
    .like {
        width: 25px;
        height: 25px;
        background: url(../../assets/img/collect_gooods.png) no-repeat;
        background-size: 100% 100%;
    }
    .cancel {
        background: url(../../assets/img/collected_goods.png) no-repeat;
        background-size: 100% 100%;
    }
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
.header {
    margin-top: 11px;
    overflow: hidden;
}
.left {
    float: left;
    width: 204px;
    .fenlei {
        overflow: hidden;
        width: 204px;
        /*height: 300px;*/
        border: 1px solid #e5e5e5;
        p {
            line-height: 40px;
            background: #f9f9f9;
            font-size: 14px;
            color: #555;
            padding-left: 11px;
        }
        .outer {
            margin-top: 16px;
            margin-bottom: 20px;
            .outerli {
                cursor: pointer;
                line-height: 30px;

                font-size: 12px;
                color: #6b6b6b;
                span {
                    padding-left: 53px;
                }
                .coreli {
                    font-size: 12px;
                    color: #6b6b6b;
                    &:hover {
                        background: #f5f5f5;
                    }
                    .coreli2 {
                        margin-left: 20px;
                        font-size: 12px;
                        color: #666;
                        &:hover {
                            background: #ddd;
                        }
                    }
                }
            }
            .active {
                background: url(../../assets/img/jianhao.jpg) no-repeat top 8px
                    left 29px;
            }
        }
    }
    .paihang {
        overflow: hidden;
        width: 204px;
        height: 100%;
        margin-top: 12px;
        border: 1px solid #e5e5e5;
        .top {
            line-height: 40px;
            background: #f9f9f9;
            font-size: 14px;
            color: #555;
            padding-left: 11px;
        }
        li {
            height: 69px;
            border-bottom: 1px solid #e8e8e8;
            float: left;
            margin: 0 5px;
            cursor: pointer;
            img {
                margin-top: 10px;
                width: 50px;
                height: 50px;
            }
            p {
                width: 130px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                font-size: 12px;
                margin-left: 10px;
                color: #515151;
            }
            span {
                color: #b69a37;
            }
        }
        p:nth-of-type(1) {
            margin-top: 10px;
            &:hover {
                color: red;
            }
            p:nth-of-type(2) {
                color: #c11918;
            }
        }
        li:last-child {
            margin-bottom: 40px;
        }
    }
}
.right {
    width: 982px;
    float: right;
    .top {
        width: 100%;
        line-height: 40px;
        background: #f9f9f9;
        border: 1px solid #e3e3e3;
        height: 40px;
        .theard {
            li {
                float: left;
                text-align: center;
                line-height: 40px;
                font-size: 12px;
                color: #555;
                border-right: 1px solid #e3e3e3;
                width: 60px;
                cursor: pointer;
            }
            li:nth-of-type(1) {
                width: 74px;
            }
            li:nth-of-type(2) {
                width: 49px;
            }
            .li {
                background: url(../../assets/img/xiajiantou.png) no-repeat top
                    17px right 8px;
            }
            .color {
                background: #fff url(../../assets/img/Xiajiantou1.png) no-repeat
                    top 17px right 8px !important;
                -webkit-transform: translateY(1px);
                color: #ddbf69;
                height: 38px;
            }
            .colors {
                background: #fff;
                -webkit-transform: translateY(1px);
                color: #ddbf69;
                height: 38px;
            }
        }
        .next {
            margin: 9px 16px 0 0;
            span {
                width: 48px;
                height: 20px;
                border: 1px solid #e5e5e5;
                font-size: 12px;
            }
        }
        .zongji {
            font-size: 12px;
            color: #979797;
            margin-right: 15px;
            span {
                color: #f3d08c;
            }
        }
    }
    .bottom {
        .bottomul {
            height: 100%;
            width: 100%;
            margin-bottom: 5%;
            li {
                width: 230px;
                height: 350px;
                border: 1px solid #f5f5f5;
                margin-right: 20px;
                margin-top: 12px;
                cursor: pointer;
                box-sizing: border-box;
                .storefuzhu {
                    margin: 5px;
                    width: 220px;
                    height: 220px;
                }
                p:nth-of-type(1) {
                    font-size: 12px;
                    color: #06060e;
                    margin: 5px;
                    height: 34px;
                    display: -webkit-box;
                    overflow: hidden;
                    white-space: normal !important;
                    text-overflow: ellipsis;
                    word-wrap: break-word;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    &:hover {
                        color: red;
                    }
                }
                p:nth-of-type(2) {
                    margin: 5px;
                }
                .pic1 {
                    font-size: 14px;
                    color: #c0354c;
                }
                .pic2 {
                    font-size: 12px;
                    color: #bbb;
                    text-decoration: line-through;
                    margin-left: 5px;
                }
                .storeheart {
                    margin: 16px 5px 0 8px;
                }
                .shoucang {
                    font-size: 12px;
                    color: #949494;
                    margin-top: 13px;
                }
                .bycar {
                    margin: 5px 12px 0 0;
                }
                &:hover {
                    border-color: #5a564a !important;
                }
            }
            li:nth-of-type(4) {
                margin-right: 0;
            }
            li:nth-of-type(8) {
                margin-right: 0;
            }
            li:nth-of-type(12) {
                margin-right: 0;
            }
            li:nth-of-type(16) {
                margin-right: 0;
            }
        }
        .paging {
            text-align: center;
            padding-left: 37%;
            float: left;
        }
    }
}
</style>