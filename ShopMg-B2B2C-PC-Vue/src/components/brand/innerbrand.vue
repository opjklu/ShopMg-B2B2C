<template>
    <div class="innerbrand">
        <head-com></head-com>
        <div class="center">
            <div class="top">
                <el-breadcrumb separator-class="el-icon-arrow-right">
                    <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                    <el-breadcrumb-item :to="{ path: '/brand' }">品牌</el-breadcrumb-item>
                    <el-breadcrumb-item>{{brandName}}</el-breadcrumb-item>
                </el-breadcrumb>
            </div>

            <div class="middle">
                <ul class="theard l">
                    <li>排列方式：</li>
                    <li @click="tab(3)" :class="{actives:isactive == 3}">默认</li>
                    <li
                        class="li"
                        v-for="(theards,index) in theard"
                        :key="index"
                        @click="tab(index)"
                        :class="[isactive === index ? 'active' : '']"
                    >{{theards}}</li>
                </ul>
                <div class="ziying l">
                    <input
                        class="l"
                        type="checkbox"
                        :checked="selfSupportChecked"
                        @click="selfSupport"
                    >平台自营
                </div>
                <div class="l shangpin">
                    商品所在地：
                    <select class="r" name>
                        <option value>不限地区</option>
                        <option value="济南" v-for="(item, index) in city" :key="index">{{item.name}}</option>
                    </select>
                </div>
            </div>
            <div class="bottom">
                <ul class="l">
                    <li class="bagli l" v-for="(li,index) in goodsListByBrand" :key="index">
                        <img class="bag" :src="URL + li.pic_url" @click="toDetail(li.id)">
                        <!-- <ul class="samllul l">
								<li class="l" v-for="item in li"><img class="samll" :src="item"/></li>
                        </ul>-->
                        <p class="l">{{li.title}}</p>
                        <div class="l pice">
                            <span>{{li.price_market}}</span>
                            <span>{{li.price_market}}</span>
                        </div>
                        <div class="buy l">
                            <input
                                class="l"
                                type="checkbox"
                                @click="contrast(li.id, index)"
                                v-model="contrastArr"
                                :value="li.id"
                                ref="checkbox"
                            >
                            <span>对比</span>
                            <div class="collection" @click="collection(li.id, index)">
                                <i :class="['l like', li.is_coll === 1 ? 'cancel' : '']"></i>
                                <span>{{li.is_coll === 1 ? '已收藏' : '收藏'}}</span>
                            </div>
                        </div>
                        <img class="r car" :src="gouwuche" @click="addCar(li.id, li.price_market)">
                    </li>
                </ul>
            </div>
        </div>
        <div class="fenye" v-show="goodsListByBrand.length !== 0">
            <div class="box2">
                <el-pagination
                    @current-change="handleCurrentChange"
                    background
                    layout="total,prev, pager, next,jumper"
                    :page-size="page_size"
                    :total="page_count"
                ></el-pagination>
            </div>
        </div>
        <foot-com></foot-com>
    </div>
</template>

<script>
export default {
    data() {
        return {
            theard: ["销量", "人气", "价格"],
            lis: [],
            isactive: 3,
            goodsListByBrand: [],
            brandName: "",
            gouwuche: '',
            city: [],
            selfSupportChecked: false,
            isCollection: false,
            brand: [],
            contrastArr: [],
			index: null,
			page:1,
			page_size:0,
			page_count:0,
			params:{},
        };
    },
    created() {

		this.params.brand_id =  this.$route.params.id;

		this.params.page = this.page;

        this.getDetail();
    },

	mounted(){
		 this.getCity();
	},
    methods: {
        contrast(id, index) {
            if (this.$refs.checkbox[index].checked) {
                this.contrastArr.push(~~id);

                if (this.contrastArr.length >= 2) {
                    this.$confirm("是否前往对商品", "是否继续?", "提示", {
                        confirmButtonText: "确定",
                        cancelButtonText: "取消",
                        type: "warning"
                    }).then(() => {
                        this.$router.push({
                            name: "compared",
                            params: {
                                id: this.contrastArr + ""
                            }
                        });
                    });
                }
                if (this.contrastArr.length <= 1)
                    return this.$message("请至少选择2种商品");
            } else {
                this.contrastArr.map(item => {
                    if (~~this.$refs.checkbox[index].value === item)
                        this.contrastArr.splice(item, 1);
                });
            }
        },

		
        /*页面跳转*/
        handleCurrentChange(currentPage) {
            this.page = currentPage;
            this.getList();
        },
        collection(id, index) {
            this.HTTP(this.$httpConfig.setCollectionGoods, {
                goods_id: id
            }).then(res => {
                res.message === "收藏成功"
                    ? (this.arr[index].is_coll = 1)
                    : (this.arr[index].is_coll = 0);
            });
        },
        //添加购物车
        addCar(id, money) {
            // return
            this.HTTP(
                this.$httpConfig.addGoodToCart,
                {
                    goods_id: id,
                    goods_num: 1,
                    price_new: money,
                    store_id: this.brand.store_id
                },
                "	post"
            )
                .then(res => {
                    if (
                        res.status === 1 &&
                        res.message === "添加成功"
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
        tab(index) {
            this.isactive = index;
            let arr = this.arr;
            this.index = index;
            arr.sort(this.arrangement);
        },
        //排序
        arrangement(a, b) {
            if (this.index === 0) {
                return a.trade - b.trade;
            } else if (this.index === 1) {
                return a.comment - b.comment;
            } else if (this.index == 2) {
                return a.price_market - b.price_market;
            } else {
                return a.id - b.id;
            }
        },
        toDetail(id) {
            this.$router.push(`/inroyaldrink?id=${id}`);
        },
        getCity() {
            this.HTTP(this.$httpConfig.regionLists, {
                parent_id: 0
            }, "post")
                .then(res => {
                    this.city = res.data;
                })
                .catch(err => {
                    throw err;
                });
        },
        // 商品自营平台搜索（品牌
        selfSupport() {
             this.selfSupportChecked = !this.selfSupportChecked;

            if (this.selfSupportChecked) {
                this.params.type = 1;
            } else {
                delete this.params.type;
            }
            
            this.getDetail();
        },
        // 品牌店详情
        getDetail() {
            this.HTTP(
                this.$httpConfig.getGoodsList,
               this.params,
                "post"
            ).then(res => {
                let arr = res.data.list;

				this.goodsListByBrand = arr.sort(this.arrangement); //记得排序
				
				this.page_size = res.data.page_size;

				this.page_count = parseInt(res.data.count);
            });
        }
    }
};
</script>

<style lang="less" scoped>
.l {
    float: left;
}
.collection {
    display: inline-block;
    margin: 0 10px;
    .like {
        width: 17px;
        height: 17px;
        background: url(../../assets/img/collect_gooods.png) no-repeat;
        background-size: 100% 100%;
    }
    .cancel {
        background: url(../../assets/img/collected_goods.png) no-repeat;
        background-size: 100% 100%;
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

.innerbrand {
    .top {
        font-size: 12px;
        margin: 15px 0;
        img {
            margin: 12px 8px 0 0;
            float: left;
        }
        span:last-child {
            color: #616161 !important;
        }
        span {
            color: #a7a7a7;
        }
    }
    .middle {
        height: 40px;
        background: #f9f9f9;
        border: 1px solid #e3e3e3;
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
            .active {
                background: #fff url(../../assets/img/Xiajiantou1.png) no-repeat
                    top 17px right 8px !important;
                color: #ddbf69;
                height: 38px;
            }
            .actives {
                background: #fff;
                color: #ddbf69;
                height: 38px;
            }
        }
        .ziying {
            margin-left: 52px;
            line-height: 40px;
            font-size: 12px;
            input {
                margin: 14px 7px 0 0;
            }
        }
        .shangpin {
            line-height: 40px;
            margin-left: 78px;
            font-size: 12px;
            select {
                height: 20px;
                width: 78px;
                margin-top: 10px;
                outline: none;
                option {
                    font-size: 12px;
                }
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
    }
    .bottom {
        height: auto;
        margin: 12px 0;
        overflow: hidden;
        ul {
            .bagli {
                width: 230px;
                height: auto;
                border: 1px solid #f1f1f1;
                margin-bottom: 12px;
                margin-left: 12px;
                padding-bottom: 12px;
                cursor: pointer;
                .bag {
                    margin: 5px;
                    width: 220px;
                    height: 220px;
                }
                .samllul {
                    margin: 6px 5px;
                    li {
                        margin-right: 10px;
                    }
                    li:last-child {
                        margin: 0;
                    }
                }
                .pice {
                    width: 100%;
                    margin-top: 15px;
                    margin-left: 5px;
                    span:nth-of-type(1) {
                        color: #de2d35;
                        font-size: 14px;
                        margin: 0 10px 0 0;
                    }
                    span:nth-of-type(2) {
                        color: #9c9c9c;
                        font-size: 9px;
                        text-decoration: line-through;
                    }
                }
                p {
                    width: 206px;
                    font-size: 12px;
                    color: #5f5f5f;
                    margin-left: 5px;
                    height: 30px;
                    &:hover {
                        color: red;
                    }
                }
                .buy {
                    margin: 15px 0 0 9px;
                    input {
                        margin: 2px 7px 0 0;
                    }
                    span {
                        color: #717171;
                        font-size: 12px;
                        float: left;
                    }
                    img {
                        margin-left: 16px;
                        margin-top: 3px;
                    }
                }
                .car {
                    margin: 7px 14px 0 0;
                }
                &:hover {
                    border-color: #ac9a4e;
                }
            }
            .bagli:nth-of-type(1) {
                margin-left: 0;
            }
            .bagli:nth-of-type(6) {
                margin-left: 0;
            }
            .bagli:nth-of-type(11) {
                margin-left: 0;
            }
            .bagli:nth-of-type(16) {
                margin-left: 0;
            }
        }
    }
}
.fenye {
    width: 100%;
    overflow: hidden;
    .box2 {
        width: 23%;
        margin: 0 auto;
    }
}
</style>