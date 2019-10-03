<template>
    <div class="r right">
        <div class="header l">{{shop_data.shop_name}}</div>
        <div class="l zonghe">
            <p class="left l">
                <span>{{(shop_data.desccredit + shop_data.servicecredit + shop_data.deliverycredit) / 3}}</span>
                <br>综合
            </p>
            <p class="first">
                描述相符
                <span>{{shop_data.desccredit}}</span>
            </p>
            <p>
                服务态度
                <span>{{shop_data.servicecredit}}</span>
            </p>
            <p>
                发货速度
                <span>{{shop_data.deliverycredit}}</span>
            </p>
        </div>
        <div class="kefu l">
            <p>
                所在地：
                <span>{{address.prov_name}}-{{address.city_name}}-{{address.prov_name}}-{{address.address}}</span>
            </p>
            <p>
                客服：
                <span>
                    <img class="l" src="../../../assets/img/kefu.jpg">在线客服
                </span>
            </p>
        </div>
        <div class="l dian">
            <p>
                <span @click="toStore">进店逛逛</span>
                <span @click="shopCollection">{{collection_text}}</span>
            </p>
        </div>
        <div class="instore l">
            <input
                class="l guanjianzi"
                type="text"
                v-model="storeSearchData.keyword"
                placeholder="关键字"
            >
            <div class="l picdiv">
                <input
                    class="l pic"
                    type="text"
                    v-model="storeSearchData.minMoney"
                    placeholder="最小价格"
                >
                <span>~</span>
                <input
                    class="r pic"
                    type="text"
                    v-model="storeSearchData.maxMoney"
                    placeholder="最大价格"
                >
            </div>
            <p @click="storeSearch">店内搜索</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            shop_data: {},
            address: {},
            collection_text: "收藏本店",
            storeSearchData: {
                keyword: "",
                minMoney: "0",
                maxMoney: 500
            }
        };
    },

    mounted() {
        
       let id =  setTimeout(() => {
             this.getShopData();
        }, 1000);

        setTimeout( () => {
            clearTimeout(id)
        }, 1000);
    },
    methods: {
        //去店铺
        toStore() {
            if (this.shop_data.store_id != undefined) {
                window.open(
                    window.location.origin +
                        "/storehome?id=" +
                        this.shop_data.store_id
                );
            }
        },
        //店铺信息
        async getShopData() {
            this.HTTP(
                this.$httpConfig.getStoreDetails,
                {
                    id: this.$parent.getStoreId()
                },
                "post"
            )
                .then(res => {
                    this.shop_data = res.data.data.store;

                    if (
                        typeof res.data.data.address == "object" &&
                        Object.prototype.toString
                            .call(res.data.data.address)
                            .toLowerCase() == "[object object]" &&
                        !res.data.data.address.length
                    ) {
                        this.address = res.data.data.address;
                    }

                    this.collection_text =
                        res.data.data.if_atten == 0 ? "收藏本店" : "取消收藏";
                })
                .catch(() => {});
        },
        //收藏店铺
        shopCollection() {
            if (this.collection_text == "收藏本店") {
                this.HTTP(
                    this.$httpConfig.setAttenStore,
                    {
                        id: this.shop_data.store_id
                    },
                    "post",
                    false
                )
                    .then(res => {
                        this.collection_text =
                            res.data.status == 1 ? "取消收藏" : "收藏本店";
                    })
                    .catch(e => {
                        console.log(e);
                    });
            } else {
                this.HTTP(
                    this.$httpConfig.setCancelAttenStore,
                    {
                        id: this.shop_data.store_id
                    },
                    "post",
                    false
                )
                    .then(res => {
                        this.collection_text =
                            res.data.status == 1 ? "收藏本店" : "取消收藏";
                    })
                    .catch(() => {});
            }
        },
        storeSearch() {
            if (this.storeSearchData.keyword != "") {
                this.$router.push({
                    name: "TheStoreSearch",
                    query: {
                        id: this.$route.query.id,
                        keyword: this.storeSearchData.keyword,
                        minMoney: this.storeSearchData.minMoney,
                        maxMoney: this.storeSea$addressDatarchData.maxMoney,
                        type: 0 //带价格搜索
                    }
                });
            } else {
                this.dialogVisible = true;
            }
        }
    }
};
</script>

<style lang="less" scoped>
.right {
    width: 210px;
    border: 1px solid #d2d2d2;
    min-height: 474px;
    .header {
        height: 40px;
        line-height: 40px;
        background: #f9f9f9;
        width: 100%;
        padding-left: 14px;
        font-size: 14px;
        color: #3b3b3b;
    }
    .zonghe {
        width: 192px;
        height: 111px;
        border-bottom: 1px solid #f2f2f2;
        margin-left: 8px;
        p.left {
            width: 88px;
            text-align: center;
            height: 100%;
            font-size: 12px;
            color: #7c7c7c;
            margin-top: 0;
            span {
                font-size: 26px;
                color: red;
                margin: 26px 0 0 0;
                display: block;
            }
        }
        p {
            float: left;
            height: 17px;
            font-size: 12px;
            color: #646464;
            margin-top: 14px;
            margin-left: 2px;
            span {
                color: #757575;
                margin-left: 11px;
            }
        }
        p.first {
            margin-top: 19px;
        }
    }
    .kefu {
        min-height: 99px;
        // border-bottom: 1px solid #f2f2f2;
        width: 192px;
        margin-left: 8px;
        p {
            line-height: 28px;
            color: #a2a2a2;
            font-size: 12px;
            margin-left: 13px;
        }
        p:first-child {
            margin: 16px 0 7px 13px;
        }
        p:nth-of-type(2) {
            span {
                width: 88px;
                height: 26px;
                line-height: 26px;
                border: 1px solid #eeeeee;
                background: #fbfbf1;
                display: inline-block;
                color: #5f6772;
                margin-left: 14px;
                img {
                    margin: 5px 6px 0 10px;
                }
            }
        }
    }
    .dian {
        height: 41px;
        border-bottom: 1px solid #f2f2f2;
        margin-left: 8px;
        width: 192px;
        p {
            margin-top: 29px;
            span {
                width: 90px;
                height: 30px;
                line-height: 30px;
                text-align: center;
                display: inline-block;
                font-size: 12px;
                border-radius: 5px;
                cursor: pointer;
            }
            span:nth-of-type(1) {
                background: red;
                color: #fff;
                border: 1px solid red;
            }
            span:nth-of-type(2) {
                background: #fafafa;
                color: #656565;
                border: 1px solid #e4e4e4;
            }
        }
    }
    .instore {
        .guanjianzi {
            width: 168px;
            height: 28px;
            border: 1px solid #d2d2d2;
            margin: 20px 0 10px 20px;
            padding-left: 5px;
        }
        .picdiv {
            margin-left: 20px;
            span {
                width: 20px;
                line-height: 20px;
                text-align: center;
                color: #d1d1d1;
            }
        }
        .pic {
            width: 74px;
            height: 28px;
            border: 1px solid #d2d2d2;
            padding-left: 5px;
        }
        p {
            cursor: pointer;
            float: left;
            width: 170px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            color: #fff;
            font-size: 12px;
            background: red;
            border-radius: 3px;
            margin: 10px 0 0 20px;
        }
    }
}
</style>


