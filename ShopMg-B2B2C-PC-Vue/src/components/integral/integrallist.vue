<template>
    <div class="list">
        <head-com></head-com>
        <div class="center">
            <div class="header">
                <img class="l logo" src="../../assets/img/fangzi.jpg" />
                <ul class="l">
                    <li class="l">
                        <router-link to="home">首页</router-link>
                    </li>
                    <li class="l">></li>
                    <li class="l">
                        <router-link to="integral">积分商城</router-link>
                    </li>
                    <li class="l">></li>
                    <li class="l">
                        <router-link to>所有分类</router-link>
                    </li>
                </ul>
            </div>
            <div class="fenlei">
                <p>积分分类</p>
                <div class="shangpin both">
                    <ul id="zli" ref="brandHeight">
                        <li class="l">商品分类：</li>
                        <li
                            class="l"
                            v-for="(shangpins,index) in TopClassData"
                            :key="index"
                            :style="select.one === index ? 'color: red;' : ''"
                            @click="selectTopClass(shangpins.id, index)"
                        >{{shangpins.class_name}}</li>
                    </ul>
                    <i @click="down" v-show="find" class="el-icon-arrow-down"></i>
                    <i @click="down" v-show="lose" class="el-icon-arrow-up"></i>
                    <div class="duo" @click="opens(1)" v-if="show" :class="{'duo':onoff}">+多选</div>
                </div>
                <div class="both">
                    <ul ref="priceHeight">
                        <li class="l">品 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 牌：</li>
                        <li
                            class="l"
                            v-for="(pinpais,index) in BrandList"
                            :key="index"
                            :style="select.two === index ? 'color: red;' : ''"
                            @click="selectBrand(pinpais.id, index)"
                        >{{pinpais.brand_name}}</li>
                    </ul>
                    <i @click="up" v-show="block" class="el-icon-arrow-down"></i>
                    <i @click="up" v-show="hidden" class="el-icon-arrow-up"></i>
                    <div class="duo" @click="opens(2)" v-if="show1" :class="{'duo':onoff1}">+多选</div>
                </div>
                <div class="both jifen">
                    <ul>
                        <li class="l">积分范围：</li>
                        <li
                            v-for="(item, index) in limit"
                            :key="index"
                            @click="selectIntegral(item, index)"
                            :style="select.three === index ? 'color: red;' : ''"
                        >{{item.replace(',', '-')}}</li>
                    </ul>
                </div>
            </div>
            <div class="thead">
                <ul class="l">
                    <li class="l">排序方式：</li>
                    <li class="l" @click="change(0)" :class="{active:isactive==0}">默认</li>
                    <li class="l" @click="change(1)" :class="{actives:isactive==1}">积分值</li>
                    <li class="l" @click="change(2)" :class="{actives:isactive==2}">上架时间</li>
                </ul>
                <div class="r">
                    <p class="l">
                        <input type="checkbox" v-model="select.queried" @click="checkbox">只查看我能兑换
                    </p>
                    <p class="r">
                        <span @click="hit(0)" :class="{bg:isbg==0}">上一页</span>
                        <span @click="hit(1)" :class="{bg:isbg==1}">下一页</span>
                    </p>
                </div>
            </div>
            <div class="base">
                <ul>
                    <li class="l" v-for="(lis, index) in integralGoodsList" :key="index">
                        <img
                            @click="$router.push({name:'IntegralInside',query: {goods_id: lis.goods_id,id:lis.id,integral:lis.integral}})"
                            :src="URL+lis.pic_url"
                        >
                        <p
                            @click="$router.push({name:'IntegralInside',query: {goods_id: lis.goods_id,id:lis.id,integral:lis.integral}})"
                            class="jieshao"
                        >{{lis.title}}</p>
                        <div class="bottom">
                            <p class="l">
                                价格
                                <span>￥{{lis.price_member}}</span>
                            </p>
                            <p class="r">
                                <span
                                    @click="$router.push({name: 'Settlement', params: {id: lis.id}})"
                                    style="color: white;"
                                >立即兑换</span>
                            </p>
                            <p class="l">积分兑换：{{lis.integral}}积分</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="fenye">
                <!-- <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="2"
          layout="prev, pager, next, jumper"
          :total="totalPages">
                </el-pagination>-->
                <!-- <div class="fenyes">
          <span class="l">上一页</span>
          <ul class="l">
            <li class="l" v-for="(yeshus, index) in yeshu" :key="index">
              <a href="/">{{yeshus}}</a>
            </li>
          </ul>
          <span class="l">下一页></span>
          <div class="l gong">共80页</div>
          <div class="l go">去第 <input type="text" /> 页</div>
                </div>-->
            </div>
        </div>
        <foot-com></foot-com>
    </div>
</template>

<script>
export default {
    data() {
        return {
            shangpin: [],
            pinpai: [],
            onoff: false,
            onoff1: false,
            show: false,
            show1: false,
            lose: false,
            find: true,
            off: false,
            block: true,
            hidden: false,
            isbg: "",
            isactive: "",
            liarr: [],
            li: [],
            yeshu: [],

            TopClassData: [],
            BrandList: [],
            integralGoodsList: "",
            count: 0,
            totalPages: 0,
            currentPage: 1,
            limit: [
                "0,500",
                "500,1000",
                "1000,2000",
                "2000-5000",
                "5000-10000"
            ],
            select: {
                one: undefined,
                two: undefined,
                three: undefined,
                queried: false
            },
            temporary: [], //临时保存商品分类值
            temporary1: []
        };
    },
    mounted() {
        //获取商品一级分类
        this.getTopClass();
        //获取商品品牌
        this.getBrandList();
        // 获取所有积分商品列表
        this.getIntegralGoodsList();
        this.Sort([1, 2, 6, 123, 4, 6, 8, 4, 7, 3, 8, 8, 12, 34, 15, 63]);

        this.show = this.$refs.brandHeight.clientHeight > 55 ? true : false;
        this.show1 = this.$refs.priceHeight.clientHeight > 55 ? true : false;
    },
    methods: {
        change(index) {
            this.isactive = index;
            this.liarr = this.li[index];
            if (index === 1) {
                let integral = [];
                for (
                    let i = 0, len = this.integralGoodsList.length;
                    i < len;
                    i++
                ) {
                    console.log(
                        this.integralGoodsList.Sort(
                            ~~this.integralGoodsList[i].integral
                        )
                    );
                }
            }
        },
        //多选隐藏
        opens(s) {
            if (s == 1) {
                this.onoff = !this.onoff;
            } else {
                this.onoff1 = !this.onoff1;
            }
        },
        Sort(a, b) {
            return a - b;
        },
        // 查看我能兑换
        checkbox() {
            this.select.queried = !this.select.queried;
            this.HTTP(
                this.$httpConfig.getIntegralGoodsList,
                {
                    queried: this.select.queried
                },
                "post"
            ).then(res => {
                let data = res.data;
                this.integralGoodsList = data.list;
            });
        },
        // 商品分类筛选
        selectTopClass(id, index) {
            this.select.one = index;
            this.HTTP(this.$httpConfig.getIntegralGoodsList, {}, "post").then(
                res => {
                    let data = res.data;
                    this.integralGoodsList = data.list;
                }
            );
        },
        // 品牌筛选
        selectBrand(id, index) {
            this.select.two = index;
            this.HTTP(
                this.$httpConfig.getIntegralGoodsList,
                {
                    brand_id: id
                },
                "post"
            ).then(res => {
                let data = res.data;
                this.integralGoodsList = data.list;
            });
        },
        // 范围筛选
        selectIntegral(item, index) {
            this.select.three = index;
            this.HTTP(
                this.$httpConfig.getIntegralGoodsList,
                {
                    integral: item
                },
                "post"
            ).then(res => {
                console.log(res.data);
                let data = res.data;
                this.integralGoodsList = data.list;
            });
        },
        //获取所有积分商品列表
        getIntegralGoodsList() {
            this.HTTP(this.$httpConfig.getIntegralGoodsList, {}, "post").then(
                res => {
                    let data = res.data;
                    this.integralGoodsList = data.list;
                    this.count = data.count;
                    this.totalPages = data.totalPages;
                }
            );
        },
        down() {
            this.onoff = !this.onoff;
            this.lose = !this.lose;
            this.find = !this.find;
            // 判断商品分类右侧箭头的状态来获取当前显示的值
            if (this.find == true && this.lose == false) {
                this.TopClassData = this.temporary.slice(0, 8);
            } else {
                this.TopClassData = this.temporary;
            }
        },
        up() {
            this.off = !this.off;
            this.block = !this.block;
            this.hidden = !this.hidden;
            if (this.block == true && this.hidden == false) {
                //判断多选之前显示八个，之后显示全部
                this.BrandList = this.temporary1.slice(0, 8);
            } else {
                this.BrandList = this.temporary1;
            }
        },
        hit(index) {
            this.isbg = index;
        },

        //获取商品一级分类
        getTopClass() {
            this.HTTP(this.$httpConfig.getTopClass, {}, "post").then(res => {
                var list = res.data;
                this.temporary = list; //把结果临时保存进临时数组，用于判断
                this.TopClassData = this.temporary.slice(0, 8);
            });
        },
        //获取商品品牌
        getBrandList() {
            this.HTTP(this.$httpConfig.getBrandList, {}, "post").then(res => {
                var list = res.data;
                this.temporary1 = list;
                this.BrandList = this.temporary1.slice(0, 8);
            });
        }
    }
};
</script>

<style lang="less" scoped>
#zli {
    display: flex;
    flex-wrap: wrap;
    overflow: hidden;
}
.l {
    float: left;
}

.r {
    float: right;
}
ul {
    display: flex;
}
.center {
    width: 1200px;
    margin: 0 auto;
    height: 100%;
}

.header {
    height: 37px;
    line-height: 37px;
    .logo {
        padding: 13px 8px 0 0;
    }
    li {
        font-size: 12px;
        a {
            color: #a1a1a1;
        }
    }
    li:last-child {
        a {
            color: #555;
        }
    }
}

.fenlei {
    overflow: hidden;
    border: 1px solid #e5e5e5;
    margin-top: 2px;
    p {
        height: 36px;
        background: #f4f4f4;
        color: #333;
        font-size: 13px;
        line-height: 36px;
        padding-left: 13px;
    }
    .both {
        width: 1156px;
        margin-left: 25px;
        border-bottom: 1px dashed #f2f2f2;
        overflow: hidden;
        position: relative;

        li {
            height: 40px;
            line-height: 40px;
            margin-right: 53px;
            display: flex;
            cursor: pointer;
            &:hover {
                color: red;
            }
        }
        li:first-child {
            margin-right: 22px;
            color: #999;
        }
        .buxian {
            color: #cfa940;
        }
        i {
            position: absolute;
            top: 12px;
            right: 7px;
            cursor: pointer;
        }
        .duo {
            width: 45px;
            height: 22px;
            background: #f4f4f4;
            position: absolute;
            top: 8px;
            right: 30px;
            text-align: center;
            line-height: 22px;
            font-size: 12px;
            color: #666;
        }
    }
    .shangpin {
        width: 1150px;
        margin-top: 6px;
    }
    .jifen {
        margin-bottom: 10px;
        border-bottom: 0;
    }
}

.thead {
    height: 41px;
    background: #f9f9f9;
    margin: 12px 0 16px;
    border: 1px solid #e5e5e5;
    border-bottom: 0;
    li {
        line-height: 40px;
        text-align: center;
        border-right: 1px solid #e5e5e5;
        border-bottom: 1px solid #e5e5e5;
        font-size: 12px;
        cursor: pointer;
    }
    li:nth-of-type(1) {
        width: 73px;
    }
    li:nth-of-type(2) {
        width: 49px;
    }
    li:nth-of-type(3) {
        width: 80px;
        background: url(../../assets/img/xiajiantou.png) no-repeat top 17px
            right 10px;
    }
    li:nth-of-type(4) {
        width: 99px;
        background: url(../../assets/img/xiajiantou.png) no-repeat top 17px
            right 10px;
    }
    .active {
        border-bottom: 0;
        background: #fff;
        color: #cfa942;
    }
    .actives {
        color: #cfa942;
        border-bottom: 0;
        background: #fff url(../../assets/img/xiajiantou01.png) no-repeat top
            17px right 10px !important;
    }
    div.r {
        width: 897px;
        border-bottom: 1px solid #e5e5e5;
        height: 41px;
        line-height: 41px;
        color: white;
        p.l {
            font-size: 12px;
            margin-left: 24px;
            input {
                float: left;
                margin: 14px 12px 0 0;
            }
        }
        p.r {
            margin-right: 23px;
            color: white;
            span {
                color: white;
                cursor: pointer;
                width: 48px;
                height: 20px;
                border: 1px solid #e6e6e6;
                float: left;
                margin-top: 9px;
                text-align: center;
                line-height: 20px;
                background: #fafafa;
                font-size: 11px;
                margin-right: 4px;
            }
        }
        .bg {
            color: #2d90dd;
            background: #fff !important;
        }
    }
}

.base {
    overflow: hidden;
    // height: 1200px;
    ul {
        li {
            width: 230px;
            height: 354px;
            border: 1px solid #f4f4f4;
            margin: 5px;
            box-sizing: border-box;
            img {
                display: block;
                display: block;
                margin: 10px;
                width: 210px;
                height: 210px;
            }
            .jieshao {
                font-size: 12px;
                color: #484848;
                margin: 0 11px;
                line-height: 20px;
                cursor: pointer;
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
            .bottom {
                width: 218px;
                height: 54px;
                margin: 0 1px;
                margin-top: 18px;
                p:nth-of-type(1) {
                    font-size: 12px;
                    color: #b4b4b4;
                    margin-top: 13px;
                    margin-left: 13px;
                    span {
                        text-decoration: line-through;
                    }
                }
                p:nth-of-type(2) {
                    cursor: pointer;
                    margin-top: 12px;
                    margin-right: 9px;
                    width: 68px;
                    height: 30px;
                    background: #de414c;
                    text-align: center;
                    line-height: 30px;
                    border-radius: 3px;
                    a {
                        font-size: 12px;
                        color: #fff;
                    }
                }
                p:nth-of-type(3) {
                    font-size: 13px;
                    color: #e64242;
                    margin-left: 13px;
                }
            }
            &:hover {
                box-shadow: 2px 4px 6px #f4f4f4;
            }
        }
        li:nth-child(5n) {
            margin-right: 0;
        }
    }
}

.fenye {
    overflow: hidden;
    display: flex;
    justify-content: center;
    .fenyes {
        margin: 40px 308px;
        overflow: hidden;
    }
    span {
        height: 30px;
        width: 74px;
        border: 1px solid #e6e6e6;
        line-height: 30px;
        text-align: center;
        font-size: 12px;
        color: #838383;
    }
    ul {
        border: 1px solid #e6e6e6;
        margin: 0 10px;
    }
    li {
        width: 30px;
        height: 28px;
        line-height: 28px;
        text-align: center;
        border-right: 1px solid #e6e6e6;
        a {
            color: #838383;
        }
    }
    li:last-child {
        border: 0;
    }
    div {
        line-height: 30px;
        color: #838383;
        font-size: 12px;
    }
    .gong {
        margin: 0 17px;
    }
    .go {
        input {
            width: 50px;
            height: 28px;
            border: 1px solid #e6e6e6;
        }
    }
}
</style>