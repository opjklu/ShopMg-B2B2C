<template>
  <div id="interview">
    <logo-component></logo-component>
    <openStoreLogo></openStoreLogo>
    <div class="middle">
      <div class="center">
        <div class="Box">
          <h1>您的开店申请已成功提交</h1>
          <p>我们将在3个工作日内（不包括国家法定假日）完成审核并短信或邮件的方式通知您;</p>
          <p>
            您也可以登录
            <router-link to="progress" class="kit">商家入驻中心</router-link>及时查看审核状态;
          </p>
          <p>店铺使用费及保证金需线下缴费，请您联系{{telphone}}进行确认打款事宜</p>
          <p>如有疑问请联系网站客服</p>
          <button @click="back">撤销申请</button>
          <button @click="look">查看进度</button>
        </div>
      </div>
    </div>
    <sign ref="sign" @tel="tel"></sign>
  </div>
</template>

<script>
export default {
  data() {
    return {
      telphone: '',
    };
  },
  mounted() {
  
  },
  
  beforeUpdate() {
  },
  components: {
    sign: () => import("../../common/sign"),
    openStoreLogo: () => import("../../common/opStoreLogo")
  },
  methods: {
    back() {
      this.$router.go(-1);
    },
    getTitle() {
      return "招商入住";
    },
    getStoreType() {
      return '开店申请';
    },
    tel(tel) {
      this.telphone = tel;
    },
    look() {
      this.$router.push("/progressLook");
    }
  }
};
</script>

<style lang='less' scoped>
.center {
  width: 1200px;
  height: 100%;
  margin: 0 auto;
}

.middle {
  background: #fafafa;
  padding: 20px 0;
  height: auto;
  .center {
    background: #fff;
    height: 405px;
    overflow: hidden;
    .Box {
      height: 271px;
      border: 1px solid #bce8f1;
      background: #eff8ff;
      margin: 51px 110px 0;
      h1 {
        line-height: 72px;
        margin-left: 73px;
        font-size: 14px;
        color: #333;
      }
      p {
        font-size: 12px;
        color: #999;
        margin-left: 73px;
        line-height: 24px;
        .kit {
          color: #0579c6;
        }
      }
      button {
        cursor: pointer;
        width: 94px;
        height: 32px;
        text-align: center;
        line-height: 32px;
        color: #fff;
        font-size: 12px;
        border-radius: 4px;
        background: #ccc;
        margin-top: 20px;
      }
      button:nth-of-type(1) {
        margin: 20px 16px 0 73px;
        background: red;
      }
    }
  }
}
</style>