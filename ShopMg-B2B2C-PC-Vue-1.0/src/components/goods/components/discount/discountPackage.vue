<template>
    <!-- 优惠套餐 -->
    <div class="l taocan class_two">
        <span
            class="nullData"
            v-show="GoodsPackage.data.length === 0"
        >{{GoodsPackage.data.length === 0 ? '暂无数据!!' : ''}}</span>
        <div class="GoodsAccessories">
            <div class="l shangpin" :key="index" v-for="(item,index) in GoodsPackage.data">
                <img :src="URL + item.pic_url">
                <p :title="item.title">{{item.title}}</p>
                <p>￥{{item.goods_discount}}</p>
            </div>
        </div>
        <div class="l all" v-show="GoodsPackage.data.length !== 0">
            <p>
                套餐价：
                <span>{{computedTotalPrice(GoodsPackage.package)}}</span>
                <span>省￥{{computedTotal(GoodsPackage.data) - computedTotalPrice (GoodsPackage.package)}}</span>
            </p>
            <p>价格:￥{{computedTotal(GoodsPackage.data)}}</p>
            <p class="buy same" @click="buy">立即购买</p>
            <p class="car same" @click="addPackageCart">加入购物车</p>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            // 优惠套餐
            GoodsPackage: {
                data: [],
                package: []
            }
        };
    },

    mounted() {
        this.getGoodsPackage();
    },
    methods: {
        buy() {
            let str = this.$parent.addCarToString(this.GoodsPackage.package);
            this.$router.push({
                path: "/setMealCar",
                query: {
                    id: str
                }
            });
        },
        addPackageCart() {
            this.HTTP(
                this.$httpConfig.addPackageCart,
                {
                    id: this.$parent.addCarToString(this.GoodsPackage.package)
                },
                "post",
                true
            )
                .then(res => {
                    if (res.data.status === 1) {
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
                            this.$router.push("/buyCar");
                        });
                    }
                })
                .catch(() => {});
        },
        //优惠套餐
        getGoodsPackage() {
            let id = this.$parent.$parent.getGoodsId();

            this.HTTP(
                this.$httpConfig.GoodsPackage,
                {
                    goods_id: id,
                    store_id: this.$parent.$parent.getStoreId()
                },
                "post",
                false
            )
                .then(res => {
                    const { values } = Object;

                    this.GoodsPackage.data = values(res.data.data.goods);
                    this.GoodsPackage.package = values(res.data.data.package);
                    console.log(this.GoodsPackage);
                })
                .catch(() => {});
        },

       
        // 计算原价
        computedTotal(data) {
            let totalPrice = 0;
            if (!(data instanceof Array)) {
                return;
            } else {
                data.map((item, index) => {
                    totalPrice += ~~item.price_member;
                });
            }
            return totalPrice;
        },

        // 计算套餐
        computedTotalPrice(data) {
            let totalPrice = 0;
            if (!(data instanceof Array)) {
                return;
            } else {
                data.map((item, index) => {
                    totalPrice += ~~item.discount;
                });
            }
            return totalPrice;
        }
    }
};
</script>
