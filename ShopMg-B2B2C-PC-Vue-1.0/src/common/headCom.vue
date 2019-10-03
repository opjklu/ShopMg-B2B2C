<template>
    <div class="head-com" id="head">
        <common-header></common-header>

        <div class="line">
            <nav>
                <div class="top l">
                    <router-link to="/home">
                        <img class="logo" :src="logo_name">
                    </router-link>
                    <!-- 搜索框 -->
                    <div class="middle">
                        <div class="inp">
                            <span class="store">
                                <el-dropdown trigger="click" size="small" @command="handleCommand">
                                    <span class="el-dropdown-link">
                                        {{currentSearch}}
                                        <i class="el-icon-arrow-down el-icon--right"></i>
                                    </span>
                                    <el-dropdown-menu slot="dropdown">
                                        <el-dropdown-item
                                            v-for="(value, i) in searchType"
                                            :key="i"
                                            :command="i"
                                        >{{value}}</el-dropdown-item>
                                    </el-dropdown-menu>
                                </el-dropdown>
                            </span>
                            <input type="text" v-model="search_value" @keyup.enter="search">
                            <span class="search" @click="search">搜索</span>
                        </div>
                        <ul>
                            <li v-for="(value,index) in keyWords" :key="index">
                                <a @click="hotSearch(value)">{{value.hot_words}}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- 我的购物车 -->
                    <div class="dropdown-content r">
                        <my-shopping-cart></my-shopping-cart>
                    </div>
                </div>
                <div class="bottom l">
                    <div
                        class="all l"
                        @mouseover="showClass"
                        @mouseleave="hideClass"
                        @click="ctrlClass"
                    >
                        <div
                            class="all-class-ctrl"
                            @click="$router.push({path:'/allGoods', index: 0})"
                        >
                            <span class="shangpin">所有分类</span>
                        </div>
                        <div class="nav-class" v-show="showClassNav" @mouseleave="hideClass">
                            <!-- <div class="nav-class"> -->
                            <ul class="allul l">
                                <li
                                    @click.stop.prevent="GoTo(item, 1)"
                                    class="li"
                                    v-for="(item, index) in iTem"
                                    @mouseover="mouseover(item,index,1)"
                                    :key="item.id"
                                >
                                    <!-- <img src="../assets/img/header-ionic.jpg"> -->
                                    <a>{{item.class_name}}</a>
                                    <i class="el-icon-arrow-right"></i>
                                </li>
                            </ul>
                            <!-- <div class="banner-image-box" v-show="showClassNav" @mouseleave="hideClass"> -->
                            <div class="all-child" v-show="showClassNav" @mouseleave="hideClass">
                                <ul class="l second" v-for="(item2,i) in childData" :key="i">
                                    <p @click="GoTo(item2, 2)">{{item2.class_name}}</p>
                                    <div class="third-wrap">
                                        <li
                                            class="l third"
                                            v-for="(item3,j) in item2.children"
                                            :key="j"
                                        >
                                            <p @click="GoTo(item3)">{{item3.class_name}}</p>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                            <!-- <div class="banner-image-box" >
                                <div class="allul-child">
                                    <ul class="show">
                                        <li class="li-class2" v-for="(item2,i) in condata" :key="i">
                                            <p
                                                @mouseover="mouseover(item2,i,2)"
                                                @click="GoTo(item2, 2)"
                                                :key="item2.id"
                                            >{{item2.class_name}}</p>
                                        </li>
                                    </ul>
                                    <ul class="show3">
                                        <li
                                            @click="GoTo(item3)"
                                            class="li-class3"
                                            v-for="(item3,i) in condata2"
                                            :key="i"
                                        >
                                            <p>{{item3.class_name}}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <ul class="navul">
                        <li v-for="(item,index) in items" :key="index">
                            <!-- {{arr[index][1] == item.link.substr(22).match(arr[index][1])}} -->
                            <a
                                @click="toLink(item,index)"
                                :class="{active:index == off}"
                            >{{item.nav_titile}}</a>
                            <!-- {{~~item.link.match(`currentId=${index}`)[0].match(/\d+/g)}} -->
                            <!-- <a :href="item.link">{{item.nav_titile}}</a> -->
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</template>
<script>
import { TimeInterval } from "../../es6/time.js";

export default {
    data() {
        return {
            logo_name:'',
            off: 0,
            all: false,
            no: true,
            ok: false,
            items: [],
            cartData: [],
            class_id: 0, //分类ID
            iTem: [],
            condata: [],
            condata2: [],
            condata3: [],
            showClassNav: false,
            searchType: ["宝贝", "店铺"],
            search_value: "",
            currentIndex: 0,
            zGoTo: [],
            childData: [],
            t: 0,
            keyWords: [],
            currentSearch: "",
            searchTypeRouter: ["/goodsSearch", "/storeSearch"]
        };
    },
    created() {
        this.getFootData();
        //搜索类型
        this.currentSearch = this.$route.query.hasOwnProperty("p")
            ? this.searchType[this.$route.query.p]
            : this.searchType[0];

        this.search_value = this.$route.query.title;

        this.getClass();
        //导航
        this.HTTP(this.$httpConfig.nav, {}, "post", false)
            .then(res => {
                this.items = res.data.data;
                //console.log(this.items);
            })
            .catch(e => {
                console.log(e);
            });
        this.$route.query.num === undefined
            ? (this.off = 0)
            : (this.off = this.$route.query.num);
    },

    mounted() {
        this.getKeySearchList();
    },

    methods: {
        //logo
        getFootData() {
            let data = TimeInterval.getItem("web_info");
            console.log(data);
            if (data) {
                this.logo_name = this.URL + data.logo_name;
            }
        },
        // toLink(item, num) {
        //     window.location.href = item.link + "&num=" + num;
        // },
        toLink(item, num) {
            window.location.href = item.link;
        },
        //热词搜索(商品搜索)
        hotSearch(value) {
            //console.log(value);
            // return
            this.$router.push({
                path: this.searchTypeRouter[0],
                query: {
                    title: value.hot_words,
                    class_id: value.goods_class_id,
                    types: "hotSearch",
                    type: 0
                }
            });
        },

        //搜索栏底部关键词
        getKeySearchList() {
            this.HTTP(this.$httpConfig.getKeyWordsList, {}, "post")
                .then(res => {
                    this.keyWords = res.data.data;
                    //console.log(this.keyWords);
                })
                .catch(e => {
                    console.log(e);
                });
        },
        GoTo(item, index) {
            //sessionStorage.setItem('crumbs',item.class_name)
            this.t++;
            //this.$router.push({path:'/goodsClass',query:{class_id:item.id,id:this.t}})

            this.$router.push({
                path: "/allGoods",
                query: {
                    id: item.id,
                    level: item.fid,
                    index: index,
                    name: encodeURIComponent(item.class_name)
                }
            });
        },
        to(index, url) {
            //console.log(this);
            // let str = url.match(`currentId=${index}`)[0].match(/\d/g)
            //console.log(this.$router.replace(url));
            // ~~str
            // window.open(url)
            // this.currentIndex = index
        },
        handleCommand(command) {
            this.currentSearch = this.searchType[command];

            this.currentIndex = command;
        },
        /**
         * 搜索
         */
        search() {
            if (this.search_value === this.$route.query.title) {
                this.$message("页面已加载");
                this.$router.replace({
                    path: this.searchTypeRouter[this.currentIndex],
                    query: {
                        type: this.currentIndex,
                        title: this.search_value
                    }
                });
            } else {
                this.$router.replace({
                    path: this.searchTypeRouter[this.currentIndex],
                    query: {
                        type: this.currentIndex,
                        title: this.search_value
                    }
                });
            }

            //this.$router.go(0);
        },
        showClass() {
            this.showClassNav = true;
        },
        hideClass() {
            this.showClassNav = false;
        },
        ctrlClass() {
            this.showClassNav = !this.showClassNav;
        },
        mouseover(item, index, once) {
            this.showClassNav = true;
            this.succ(item.id, once);
        },
        getClass() {
            let classData = localStorage.getItem("class");
            if (classData) {
                this.iTem = JSON.parse(classData);
                return;
            }

            this.HTTP(
                this.$httpConfig.getClass,
                {
                    id: this.class_id
                },
                "post"
            )
                .then(res => {
                    this.iTem = res.data.data;
                    console.log(this.iTem.length);
                    if (this.iTem.length > 12) {
                        this.iTem = this.iTem.slice(0, 12);
                    }
                    // let data = res.data.data;

                    localStorage.setItem(
                        "class",
                        JSON.stringify(res.data.data)
                    );
                })
                .catch(e => {
                    console.log(e);
                });
        },
        succ(id) {
            this.HTTP(
                this.$httpConfig.getChildrenClass,
                { id: id },
                "post"
            ).then(res => {
                this.childData = res.data.data;

                localStorage.setItem(
                    "chirld_class",
                    JSON.stringify(res.data.data)
                );
            });
        },

        getGoods(goods, index) {
            //console.log(goods, index);
            this.display = null;
        },
        open() {
            this.on = true;
            this.isactive = true;
        },
        close() {
            this.on = null;
            this.isactive = null;
        }
    }
};
</script>
<style lang="less" scoped>
.head-com {
    background: #fff;
    width: 100%;
}
.gp-s:hover {
    color: red;
}
nav .bottom .navul li .active {
    color: red;
}

.gp-s {
    color: #666;
    cursor: pointer;
}
.l {
    float: left;
}
.r {
    float: right;
}
.line {
    // border-bottom: 2px solid red;
    // background: #f2f2f2;
}
nav {
    width: 1190px;
    height: 156.5px;
    background: #fff;
    border-bottom: 1px solid red;
    margin: 0 auto;
    .top {
        width: 100%;
        height: 114px;
        // border: 1px solid blue;
        .logo {
            // margin-top: 26px;
            float: left;
            width: 190px;
            height: 100%;
            box-shadow: 0px 0px 5px #757575;
        }
        .middle {
            margin: 35px 0 0 132px;
            width: 660px;
            float: left;
            .inp {
                width: 660px;
                height: 40px;
                // border: 2px solid #b5a069;
                float: left;
                padding: 0;
                .store {
                    height: 40px;
                    width: 68px;
                    float: left;
                    background: #f5f5f5;
                    // line-height: 40px;
                    border: 1px solid #f2f2f2;
                    // border-right: 2px solid red;
                    // box-sizing: border-box;
                    // border-radius: 10px;
                    // border-top-right-radius: 0;
                    // border-bottom-right-radius: 0;
                    // border-right: none;
                    box-sizing: border-box;
                    span {
                        width: 68px;
                        height: 40px;
                        // border: 1px solid yellow;
                        line-height: 36px;
                        margin-left: 10px;
                        cursor: pointer;
                    }
                    i {
                        margin-left: 2px;
                    }
                }
                input {
                    width: 415px;
                    height: 100%;
                    border-bottom: 1px solid #f2f2f2;
                    border-top: 1px solid #f2f2f2;
                    border-right: 1px solid #f2f2f2;
                    border-left: 1px solid #fff;
                    float: left;
                    padding-left: 5px;
                }
                .search {
                    width: 75px;
                    height: 100%;
                    float: left;
                    background-color: red;
                    color: #fff;
                    font-weight: 500;
                    text-align: center;
                    line-height: 40px;
                    cursor: pointer;
                }
            }
            ul {
                float: left;
                margin-top: 8px;
                li {
                    float: left;
                    margin-right: 14px;
                    cursor: pointer;
                    a {
                        color: #ababab;
                    }
                    &:hover a {
                        color: red;
                    }
                }
            }
        }
        .dropdown-content {
            // border: 1px solid red;
            margin-top: 35px;
            // margin-right: 80px;
        }
    }
    .bottom {
        width: 100%;
        // margin-top: 14px;
        .all {
            height: 43px;
            width: 190px;
            background: red;
            line-height: 44px;
            position: relative;
            text-align: center;
            .all-class-ctrl {
                height: 43px;
                width: 190px;
                background: red;
                line-height: 44px;
                position: relative;
                text-align: center;
                cursor: pointer;
                color: #fff;
                font-weight: 540;
                font-size: 16px;
            }
            // .jiazai {
            //     margin: 15px 11px 0 13px;
            //     float: left;
            // }
            // span {
            //     color: #fff;
            //     font-size: 15px;
            //     float: left;
            //     // margin-left: 23%;
            //     // text-align: center;
            //     font-weight: 540;
            // }

            .nav-class {
                width: 1190px;
                height: auto;
                margin: 0 auto;
                z-index: 999;
                display: flex;
                min-height: 407px;
                .allul {
                    position: relative;
                    width: 190px;
                    height: 100%;
                    background: #fff;
                    // padding-top: 5px;
                    float: left;
                    z-index: 999999999;
                    border: 2px solid red;
                    border-top: none;
                    box-sizing: border-box;
                    .li {
                        z-index: 999999999;
                        height: 34px;
                        line-height: 34px;
                        position: relative;
                        i {
                            float: right;
                            margin: 11px 25px 0 0;
                            color: #333;
                        }
                        a {
                            margin-left: 61px;
                            // margin-right: auto;
                            font-size: 16px;
                            color: #333;
                            float: left;
                        }
                        // img {
                        //     margin-left: 29px;
                        //     float: left;
                        //     margin-top: 11px;
                        // }
                        &:hover {
                            // background: rgba(255, 255, 255, 0.5);
                            // border-left: red solid 3px;
                            i {
                                color: red;
                            }
                            a {
                                color: red;
                                margin-left: 60px;
                            }
                        }
                    }
                }
                .all-child {
                    position: absolute;
                    left: 190px;
                    top: 43px;
                    z-index: 9999;
                    background: #fff;
                    width: 800px;
                    height: 410px;
                    border: 1px solid red;
                    border-left: none;
                    box-sizing: border-box;
                    padding: 0 20px;
                    p {
                        cursor: pointer;
                    }
                    .second {
                        width: 50%;
                        // border: 1px solid #757575;
                        box-sizing: border-box;
                        line-height: 28px;
                        text-align: left;

                        margin-top: 20px;
                        p {
                            // border: 1px solid red;
                            font-size: 16px;
                            color: #000;
                            font-weight: 500;
                            margin-bottom: 10px;
                            border-bottom: 1px solid #d5d5d5;
                            &:hover {
                                color: red;
                            }
                        }
                        .third-wrap {
                            width: 80%;
                            // height: 30%;
                            // border: 1px solid blue;
                            // box-sizing: border-box;
                            .third {
                                // width: 50px;
                                height: 24px;
                                margin-right: 20px;
                                line-height: 24px;
                                // border: 1px solid #757575;
                                p {
                                    // border: 1px solid red;
                                    font-size: 14px;
                                    color: #333;
                                    font-weight: 400;
                                    border: none;
                                    // margin-bottom: 10px;
                                    &:hover {
                                        color: red;
                                    }
                                }
                                // &:last-child{
                                //     margin-right: 0;
                                // }
                            }
                        }
                    }
                }
                .banner-image-box {
                    width: 780px;
                    height: 407px;
                    float: left;
                    position: relative;
                    cursor: pointer;
                    font-size: 11px;

                    .allul-child {
                        position: absolute;
                        left: 0;
                        top: 0;
                        bottom: 0;
                        right: 130px;
                        z-index: 999;
                        background-color: #fff;
                        z-index: 9999;
                        .show {
                            z-index: 9999;
                            background: #fff;
                            border: 2px solid red;
                            border-right: none;
                            overflow: hidden;
                            width: 150px;
                            float: left;
                            height: 407px;
                            p {
                                font-size: 14px;
                                color: #333;
                                width: 100%;
                                float: left;
                            }
                            .item {
                                font-size: 13px;
                                color: #333;
                                margin: 5px;
                                line-height: 15px;
                                width: 100px;
                                text-align: center;
                            }
                            .li-class2 {
                                width: 150px;
                                overflow: hidden;
                                padding-right: 12px;
                                padding-left: 10px;
                                float: left;
                                p {
                                    position: relative;
                                    height: 36px;
                                    line-height: 36px;
                                    font-size: 13px;
                                    color: #111;
                                }
                            }
                        }
                        .show3 {
                            height: 407px;
                            float: left;
                            background-color: #fff;
                            z-index: 9999;
                            width: 500px;
                            border: 2px solid red;
                            .li-class3 {
                                width: 33.3%;
                                text-align: center;
                                overflow: hidden;
                                padding-right: 12px;
                                padding-left: 10px;
                                float: left;
                                p {
                                    position: relative;
                                    height: 36px;
                                    line-height: 36px;
                                    font-size: 12px;
                                    color: #626262;
                                }
                            }
                        }
                    }
                }
            }
        }

        .navul {
            margin-left: 230px;
            margin-top: 12px;
            li {
                float: left;
                margin-right: 45px;
                a {
                    color: #2b2b2b;
                    font-size: 16px;
                }
                .router-link-exact-active {
                    color: #e2c670 !important;
                }
            }
        }
    }
}
</style>
