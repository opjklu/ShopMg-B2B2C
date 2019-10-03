<template>
    <div class="head">
        <div class="middle center">
            <img
                class="logo l c"
                :src="storeInfo.store_logo === undefined ? 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1542620438617&di=934a6c42aa8fc70f89d333365c9bf7e8&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimgad%2Fpic%2Fitem%2Fb21c8701a18b87d69f0ccc220c0828381f30fd45.jpg' : URL+storeInfo.store_logo"
                @click="bg()"
            >
            <div class="qq l c">
                <span @click="bg()">{{storeInfo.shop_name}}</span>
                <img src="../assets/img/qq.jpg">
            </div>
            <div class="l miaoshu" @click="fun" :class="{jiantou:up}">
                <p class="l">
                    描述
                    <br>
                    <span>{{storeInfo.desccredit ===undefined ? '0' : storeInfo.desccredit | keep2unit}}</span>
                </p>
                <p class="l">
                    服务
                    <br>
                    <span>{{storeInfo.servicecredit ===undefined ? '0' : storeInfo.servicecredit | keep2unit}}</span>
                </p>
                <p class="l">
                    发货
                    <br>
                    <span>{{storeInfo.servicecredit ===undefined ? '0' : storeInfo.servicecredit | keep2unit}}</span>
                </p>
            </div>
            <div class="search l">
                <div class="l top">
                    <input type="text" v-model="search_content">
                    <span @click="SearchOurStore">搜本店</span>
                    <span @click="SeekTotalStation">搜全站</span>
                </div>
                <ul class="l">
                    <li class="l" v-for="(li,index) in arr0" :key="index">
                        <a href="/">{{li}}</a>
                    </li>
                </ul>
            </div>
            <!--美的-->
            <div class="shoucang" v-show="shoucang">
                <div class="left l">
                    <img
                        class="meidi"
                        :src="storeInfo.store_logo === undefined ? 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1542620438617&di=934a6c42aa8fc70f89d333365c9bf7e8&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimgad%2Fpic%2Fitem%2Fb21c8701a18b87d69f0ccc220c0828381f30fd45.jpg' : URL+storeInfo.store_logo"
                    >
                    <div class="bendian">
                        <span v-if="storeInfo.if_atten" @click="collectStore(0)">取消收藏</span>
                        <span v-else @click="collectStore(0)">收藏</span>
                    </div>
                    <div class="shoucangliang">
                        <span>{{storeInfo.storeFans}}</span>收藏
                    </div>
                    <!-- <img class="erweima" :src="URL+storeInfo.store_logo" /> -->
                </div>
                <div class="right l">
                    <div class="l top">
                        <p>店铺动态评分</p>
                        <p>
                            描述相符：
                            <span>{{storeInfo.desccredit ===undefined ? '0' : storeInfo.desccredit| keep2unit}}</span>
                        </p>
                        <p>
                            服务态度：
                            <span>{{storeInfo.servicecredit ===undefined ? '0' : storeInfo.servicecredit | keep2unit}}</span>
                        </p>
                        <p>
                            发货速度：
                            <span>{{storeInfo.servicecredit ===undefined ? '0' : storeInfo.servicecredit | keep2unit}}</span>
                        </p>
                    </div>
                    <div class="l bottom">
                        <p>店铺服务</p>
                        <p>
                            开店时间：
                            <span
                                v-show="storeInfo.update_time"
                            >{{storeInfo.update_time | storeTime}}</span>
                        </p>
                        <p>{{storeInfo.address}}</p>
                    </div>
                </div>
            </div>
            <!--收藏   取消收藏-->
            <div class="collect" v-show="sc">
                <span>收藏成功</span>
                <span>取消收藏</span>
            </div>
        </div>
        <img v-if="!$route.query.keyword" src="../assets/img/hetangyuese.jpg">
        <nav>
            <div class="center">
                <ul class="nav-hot">
                    <li class="l" @click="toAll">全部宝贝</li>
                    <li
                        v-if="!$route.query.keyword"
                        @click="bg(navs)"
                        class="l"
                        v-for="(navs,index) in nav"
                        :key="index"
                        :class="{active:isactives==index}"
                    >{{navs.name}}</li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
import downjiantou from "@/assets/img/downjiantou.jpg";
export default {
    data() {
        return {
            storeID: 0,
            on: "",
            isactive: "",
            arr0: ["珠宝", "紫砂壶", "苏绣", "贡酒", "翡翠", "字画", "珠宝"],
            nav: [
                {
                    id: "0",
                    name: "首页",
                    url:
                        this.$constant.s_url +
                        "storehome?id=" +
                        this.$route.query.id
                }
            ],
            isactives: "",
            shoucang: "",
            up: "",
            success: true,
            err: false,
            sc: false,
            ctrlClass: false, //控制全部分类是否显示
            storeInfo: {}, //店铺信息
            search_content: ""
        };
    },
    created() {
        console.log(this.$route);
        console.log(this.storeID);
        this.storeID = this.$route.query.id;
        this.getStoreNav();
        this.getBanner();
        this.getStoreInfo();
    },
    methods: {
        //搜本店
        SearchOurStore() {
            //判断是否传参
            if (this.storeID !== "") {
                this.$router.push({
                    name: "TheStoreSearch",
                    query: {
                        store_id: sessionStorage.getItem("store_id"),
                        search_content: this.search_content,
                        type: 1 //不带价格搜索
                    }
                });
            } else {
            }
        },
        //搜全站
        SeekTotalStation() {
            if (this.search_content !== "") {
                this.$router.push({
                    path: "/goodsSearch",
                    query: {
                        p: 0, //0为商品
                        t: this.search_content
                    }
                });
            } else {
                this.$confirm("搜索不能为空", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning",
                    closeOnClickModal: false,
                    lockScroll: false,
                    center: true
                })
                    .then(() => {})
                    .catch(() => {});
            }
        },
        // 点击菜单导航
        bg() {
            window.open(
                this.$constant.s_url + "storehome?id=" + this.$route.query.id
            );
            //window.open(window.location.origin + '/storehome?id='+this.storeID);首页无法点击为路径id为undefined
        },
        // 展开或关闭店铺详情
        fun() {
            this.shoucang = !this.shoucang;
            this.up = !this.up;
        },
        // 获取店铺信息
        getStoreInfo() {
            this.HTTP(
                this.$httpConfig.getStoreDetails,
                { id: this.storeID },
                "post"
            )
                .then(res => {
                    this.storeInfo = res.data.data;
                })
                .catch(() => {});
        },
        // 获取菜单导航
        getStoreNav() {
            this.HTTP(
                this.$httpConfig.getStoreNav,
                { id: this.storeID },
                "post"
            )
                .then(res => {
                    console.log(res);
                    var list = res.data.data;
                    for (var i in list) {
                        this.nav.push(list[i]);
                    }
                    this.nav.splice(9, this.nav.length - 9);
                })
                .catch(() => {});
        },
        // 获取banner图
        getBanner() {
            this.HTTP(
                this.$httpConfig.getStoreBanner,
                { store_id: this.storeID },
                "post"
            )
                .then(res => {})
                .catch(() => {});
        },
        //收藏或取消收藏店铺接口
        collectStore(type) {
            if (type) {
                //关注
                this.HTTP(
                    this.$httpConfig.setAttenStore,
                    { id: this.storeID },
                    "post"
                )
                    .then(res => {
                        this.$message(`${res.data.message}`);
                        console.log(res);
                    })
                    .catch(() => {
                        this.$message(`${e.data.message}`);
                    });
            } else {
                this.HTTP(
                    this.$httpConfig.setCancelAttenStore,
                    { id: this.storeID },
                    "post"
                )
                    .then(res => {
                        this.$message(`${res.data.message}`);
                    })
                    .catch(e => {
                        this.$message(`${e.data.message}`);
                    });
            }
        },
        toAll() {
            this.$router.push({
                path: "/storelist",
                query: {
                    id: this.storeID
                }
            });
        }
    },
    filters: {
        keep2unit(value) {
            return value + ".00";
        },
        storeTime(value) {
            var time = new Date(Number(value) * 1000);
            var Y = time.getFullYear();
            var m = time.getMonth() + 1;
            var d = time.getDate();
            var H = time.getHours();
            var mi = time.getMinutes();
            var s = time.getSeconds();
            if (m < 10) {
                m = "0" + m;
            }
            if (d < 10) {
                d = "0" + d;
            }
            if (H < 10) {
                H = "0" + H;
            }
            if (mi < 10) {
                mi = "0" + mi;
            }
            if (s < 10) {
                s = "0" + s;
            }
            return Y + "-" + m + "-" + d + " " + H + ":" + mi + ":" + s;
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
.c {
    cursor: pointer;
}
.center {
    width: 1200px;
    margin: 0 auto;
    height: 100%;
    position: relative;
    .ul.nav-hot {
        width: 1200px;
        height: 35px !important;
        display: flex;
        flex-direction: row;
    }
}
.class-two {
    width: 150px;
    position: absolute;
    left: 0px;
    top: 35px;
    height: auto;
    margin: 0 auto;
    z-index: 999;
    ul {
        position: relative;
        width: 150px;
        height: 100%;
        background: rgba(231, 193, 66, 0.9);
        padding-top: 5px;
        float: left;
        z-index: 999999999;
        li {
            z-index: 999999999;
            height: 33px;
            line-height: 33px;
            position: relative;
        }
    }
}
.middle {
    height: 130px;
    position: relative;
    .logo {
        width: 100px;
        height: 100px;
        margin: 10px;
    }
    .qq {
        width: 189px;
        height: 36px;
        margin: 44px 0 0 32px;
        border-left: 1px dashed #dddddd;
        border-right: 1px dashed #dddddd;
        font-size: 12px;
        color: #7a7a7a;
        line-height: 36px;
        text-align: center;
        span {
            width: 100px;
            height: 30px;
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        img {
            float: right;
            margin: 6px 12px 0 0;
        }
    }
    .miaoshu {
        margin: 48px 0 0 6px;
        width: 120px;
        cursor: pointer;
        background: url(../assets/img/downjiantou.jpg) no-repeat top 13px right
            0;
        p {
            font-size: 12px;
            margin-left: 9px;
            color: #a0a0a0;
            span {
                color: #d4a541;
            }
        }
        /*img{margin: 13px 0 0 14px;}*/
    }
    .jiantou {
        background: url(../assets/img/upjiantou.jpg) no-repeat top 13px right 0 !important;
    }
    .shoucang {
        z-index: 9999;
        width: 370px;
        height: 260px;
        background: #fff;
        position: absolute;
        top: 86px;
        left: 200px;
        border: 1px solid #e1e1e1;
        .left {
            width: 148px;
            .meidi {
                width: 115px;
                height: 110px;
                margin: 30px auto;
                display: block;
            }
            .bendian {
                cursor: pointer;
                margin: 27px auto 13px;
                width: 74px;
                height: 22px;
                border-radius: 20px;
                text-align: center;
                line-height: 22px;
                background: #d39e29;
                color: #fff;
                font-size: 12px;
            }
            .shoucangliang {
                text-align: center;
            }
            .erweima {
                margin: 18px auto;
                width: 100px;
                height: 100px;
                display: block;
            }
        }
        .right {
            width: 202px;
            span {
                color: #d4a541;
            }
            .top {
                width: 100%;
                margin-top: 20px;
                border-bottom: 1px dashed #e4e4e4;
                p {
                    margin-top: 8px;
                    font-size: 12px;
                }
                p:first-child {
                    font-size: 16px;
                    color: #7a7a7a;
                }
                p:last-child {
                    margin-bottom: 18px;
                }
            }
            .bottom {
                width: 100%;
                cursor: pointer;
                border-bottom: 1px dashed #e4e4e4;
                p {
                    margin-top: 8px;
                    font-size: 12px;
                }
                p:first-child {
                    font-size: 16px;
                    color: #7a7a7a;
                }
                p:last-child {
                    margin-bottom: 18px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }
            }
        }
    }
    .collect {
        position: absolute;
        top: 408px;
        right: 347px;
        span {
            width: 110px;
            height: 46px;
            text-align: center;
            line-height: 46px;
            color: #fff;
            background: rgba(0, 0, 0, 0.6);
            display: inline-block;
            border-radius: 3px;
            margin-right: 20px;
        }
    }
}
.search {
    width: 537px;
    margin: 35px 0 0 142px;
    .top {
        input {
            width: 377px;
            height: 36px;
            border: 2px solid red;
            float: left;
        }
        span {
            width: 74px;
            height: 36px;
            line-height: 36px;
            text-align: center;
            color: #fff;
            float: left;
            cursor: pointer;
        }
        span:nth-of-type(1) {
            background: red;
        }
        span:nth-of-type(2) {
            background: #666666;
            margin-left: 6px;
        }
    }
    ul {
        margin-top: 10px;
        li {
            margin-right: 14px;
            a {
                color: #666;
                font-size: 12px;
            }
            &:hover a {
                color: red;
            }
        }
    }
}
nav {
    height: 35px;
    background: #6b523c;
    ul {
        li {
            cursor: pointer;
            min-width: 88px;
            width: auto;
            line-height: 35px;
            text-align: center;
            color: #fff;
            margin-right: 10px;
        }
        li.l:nth-of-type(1) {
            background: url(../assets/img/baijiantou.png) no-repeat top 17px
                right 5px;
        }
    }
    .active {
        background-color: #d6c8b6 !important;
    }
}
</style>