<template>
  <!-- 最佳组合 -->
  <div class="l taocan class_three">
    <span
      class="nullData"
      v-show="optimalPortfolio.data.length === 0"
    >{{optimalPortfolio.data.length === 0 ? '暂无数据!!' : ''}}</span>
    <div class="GoodsAccessories">
      <div class="l shangpin" :key="index" v-for="(item,index) in optimalPortfolio.data">
        <img :src="URL + item.pic_url" />
        <p :title="item.title">{{item.title}}</p>
        <p>￥{{item.goods_price}}</p>
      </div>
    </div>
    <div class="l all" v-show="optimalPortfolio.data.length !== 0">
      <p class="buy same" @click="goodsComboBuyNow()">立即购买</p>
      <p class="car same" @click="recommendAndGroup()">加入购物车</p>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      // 最佳组合
      optimalPortfolio: {
        data: []
      }
    };
  },

  mounted() {
    this.getGoodsCombo();
  },
  methods: {
    // 推荐配件 最佳组合加入购物车
    recommendAndGroup(index) {
      this.HTTP(
        this.$httpConfig.recommendAndGroup,
        {
          contrast_id: this.addCarToString(this.optimalPortfolio.data)
        },
        "post",
        false
      )
        .then(res => {
          if (res.data.status) {
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
    // 推荐配件 最佳组合立即购买
    goodsComboBuyNow() {
      this.$router.push({
        name: "recommendAndGroupAccout",
        query: {
          id: this.addCarToString(this.optimalPortfolio.data)
        }
      });
    },

    //最佳组合
    getGoodsCombo() {
      let id = this.$parent.$parent.getGoodsId();
      console.log(111);
      this.HTTP(
        this.$httpConfig.GoodsCombo,
        {
          goods_id: id
        },
        "post"
      )
        .then(res => {
          this.optimalPortfolio.data = res.data.data;
        })
        .catch(() => {});
    }
  }
};
</script>