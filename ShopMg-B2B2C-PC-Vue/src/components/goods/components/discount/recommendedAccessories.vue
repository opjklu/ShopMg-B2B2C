<template>
    <!-- 推荐配件 -->
    <div class="l taocan class_one">
        <span
            class="nullData"
            v-show="GoodsAccessories.data.length === 0"
        >{{GoodsAccessories.data.length === 0 ? '暂无数据!!' : ''}}</span>
        <div class="GoodsAccessories">
            <div class="l shangpin" v-for="(item, index) in GoodsAccessories.data" :key="index">
                <img
                    :src="URL + item.pic_url"
                    @click="$router.push({path: '/inroyaldrink', query: {id: item.goods_id}})"
                >
                <p :title="item.title">{{item.title}}</p>
                <p>￥{{item.goods_price}}</p>
            </div>
        </div>

        <div class="l all" v-show="GoodsAccessories.data.length !== 0">
            <p class="buy same" @click="goodsComboBuyNow()">立即购买</p>
            <p class="car same" @click="recommendAndGroup()">加入购物车</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            // 推荐配件
            GoodsAccessories: {
                data: []
            }
        };
    },

    mounted() {
        this.getGoodsAccessories();
    },

    methods: {
        //推荐配件
        getGoodsAccessories() {
            let id = this.$parent.$parent.getGoodsId();
            this.HTTP(
                this.$httpConfig.GoodsAccessories,
                {
                    goods_id: id
                },
                "post"
            )
                .then(res => {
                    this.GoodsAccessories.data = res.data;
                })
                .catch(() => {});
        },
        // 推荐配件 最佳组合立即购买
        goodsComboBuyNow() {
            this.$router.push({
                name: "recommendAndGroupAccout",
                query: {
                    id: this.$parent.addCarToString(this.GoodsAccessories.data)
                }
            });
        },

        recommendAndGroup(index) {
            this.HTTP(
                this.$httpConfig.recommendAndGroup,
                {
                    contrast_id: this.$parent.addCarToString(this.GoodsAccessories.data)
                },
                "post",
                false
            ).then(res => {
                if (res.status) {
                    this.$confirm("", "已成功加入购物车", {
                        confirmButtonText: "查看购物车",
                        cancelButtonText: "继续购物",
                        type: "success",
                        center: true,
                        lockScroll: false,
                        closeOnClickModal: false,
                        confirmButtonClass: "to-shopping-cart",
                        cancelButtonClass: "continue-shopping"
                    })
                        .then(() => {
                            this.$router.push("/buyCar");
                        })
                        .catch(() => {});
                }
            });
        }
    }
};
</script>

