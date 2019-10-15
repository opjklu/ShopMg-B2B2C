<template>
  <div class="gp-area-wrap" :class="{hover:onoff}" @mouseover="onofftrue" @mouseout="onofffalse">
    <div class="gp-area-text-wrap">
      <!-- {{defaultAddress.prov_name + defaultAddress.city_name}} -->
      <div
        class="gp-area-text"
      >{{defaultAddress.length != 0 ? defaultAddress.prov_name + defaultAddress.city_name + defaultAddress.dist_name + defaultAddress.address : ''}}</div>
      <i class="el-icon-arrow-down"></i>
    </div>
    <div v-show="onoff" class="gp-area-content"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      onoff: false,
      defaultAddress: [],
      n: 0
    };
  },
  methods: {
    onofftrue() {
      this.n++;
      if (this.n <= 1) {
        this.HTTP(this.$httpConfig.addressLists, {}, "post", false).then(
          res => {
            this.defaultAddress = res.data[0];
            console.log(this.defaultAddress);
          }
        );
      }
      this.onoff = true;
    },
    onofffalse() {
      this.onoff = false;
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

.gp-area-wrap {
  position: relative;
  float: left;
  z-index: 5;
  height: 24px;
  cursor: default;
  .gp-area-text-wrap {
    float: left;
    position: relative;
    top: 0;
    height: 22px;
    background: #fff;
    border: 1px solid #cecbce;
    padding: 0 20px 0 4px;
    line-height: 22px;
    overflow: hidden;
    .gp-area-text {
      line-height: 22px;
    }
    i {
      position: absolute;
      top: 5px;
      right: 5px;
    }
  }
  .gp-area-content {
    position: absolute;
    top: 22px;
    width: 460px;
    height: 100px;
    border: 1px solid #cecbce;
    width: 390px;
    padding: 12px 12px 15px;
    background: #fff;
    -webkit-box-shadow: 0 0 5px #ddd;
    box-shadow: 0 0 5px #ddd;
  }
}

.hover {
  .gp-area-text-wrap {
    height: 23px;
    z-index: 8;
    border-bottom: none;
  }
}
</style>
