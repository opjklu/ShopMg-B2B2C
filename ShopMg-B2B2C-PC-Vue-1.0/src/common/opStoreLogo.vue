<template>
    <div id="logo">
      <div class="center">
        <div class="nake l">
          <p class="iphone l">
            <span class="hot l">招商热线</span>
            <span class="shuzi l">{{telphone}}</span>
          </p>
        </div>
        <div class="gold r">
          <img src="../assets/img/zhaoshang.png" />
          <ul>
            <li>{{$parent.getStoreType()}}</li>
            <li>网门审核</li>
            <li>支付开店款项</li>
            <li>创建店铺</li>
          </ul>
        </div>
      </div>
    </div>
</template>
<script>
import { TimeInterval } from "../../es6/time.js";

export default {
  data() {
    return {
      telphone: '',
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.getFootData();
    });
  },

  methods: {
    getFootData() {
      this.telphone = TimeInterval.getItem("web_info").intnet_phone;
    }
  }
};
</script>
<style lang="less" scoped>
.center {
  width: 1200px;
  height: 100%;
  margin: 0 auto;
}
.l {
  float: left;
}
.r {
  float: right;
}
#logo {
  width: 100%;
  height: 104px;
  .center {
    height: 104px;
    .Gongpin {
      width: 186px;
      height: 104px;
      img {
        margin-top: 20px;
        padding-right: 20px;
        height: 60px;
        border-right: 1px solid #dedede;
      }
    }
    .iphone {
      width: 240px;
      height: 104px;
      .hot {
        display: inline-block;
        width: 70px;
        height: 104px;
        line-height: 104px;
        font-size: 13px;
        margin-left: 20px;
      }
      .shuzi {
        display: inline-block;
        height: 104px;
        line-height: 104px;
        font-size: 16px;
        color: #d53738;
        font-weight: 500;
      }
    }
    .gold {
      margin-top: 34px;
      margin-left: 162px;
      ul {
        overflow: hidden;
        margin-top: 7px;
        li {
          float: left;
          font-size: 12px;
          color: #666;
        }
        li:nth-of-type(1) {
          margin: 0 72px 0 35px;
          color: red;
        }
        li:nth-of-type(3) {
          margin: 0 56px 0 56px;
        }
      }
    }
  }
}
</style>