<template>
  <div id="commonFooter">
    <div class="center">
      <ul>
        <li class="l">关于我们</li>
        <li class="l">帮助中心</li>
        <li class="l">商家入驻</li>
        <li class="l">联系我们</li>
      </ul>
      <p class="online">{{websiteInfo.record_number}}|有任何问题联系我们在线客服电话：{{websiteInfo.intnet_phone}}</p>
      <p class="onlines">{{websiteInfo.intnet_copyright}}版权所有 ，并保留所有权</p>
    </div>
  </div>
</template>

<script>
import { TimeInterval } from "../../es6/time.js";

export default {
  data() {
    return {
      websiteInfo: {}
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.getFootData();
    });
  },

  methods: {
    getFootData() {
      this.websiteInfo = TimeInterval.getItem("web_info");
      if (!this.$parent.tel) {
          return;
      }
      this.$emit('tel', this.websiteInfo.intnet_phone);
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
.center {
  width: 1200px;
  height: 100%;
  margin: 0 auto;
}
#commonFooter {
  width: 100%;
  height: 90px;
  .center {
    height: 90px;
    ul {
      width: 100%;
      height: 12px;
      line-height: 12px;
      margin-top: 20px;
      margin-left: 470px;
      li {
        width: 70px;
        height: 12px;
        border-right: 1px solid #8b8b8b;
        font-size: 12px;
        text-align: center;
      }
      li:last-child {
        border-right: 0;
      }
    }
    .online {
      width: 100%;
      height: 26px;
      line-height: 26px;
      text-align: center;
      font-size: 12px;
      margin-top: 5px;
    }
    .onlines {
      width: 100%;
      height: 26px;
      line-height: 26px;
      text-align: center;
      font-size: 12px;
    }
  }
}
</style>