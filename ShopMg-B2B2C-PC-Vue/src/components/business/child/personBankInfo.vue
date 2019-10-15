<template>
  <div id="interview">
    <logo-component></logo-component>
    <openStoreLogo></openStoreLogo>

    <div class="middle">
      <div class="center">
        <div class="Box">
          <img src="../../../assets/img/deng.png" />
          <span class="spa">注意事项</span>
          <span>请填写正确的帐户信息，否则影响收款和结算。</span>
        </div>
        <div class="show">
          <div class="Top">
            <h1>结算（银行卡）账号信息</h1>
            <p class="four">
              <span class="span">*</span>银行开户名 :
              <input @change="changeWarning(1)" v-model="person_name" type="text" />
              <el-alert v-if="tip.tip1" title="请填写银行开户名" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="four">
              <span class="span">*</span>银行卡账号 :
              <input @change="changeWarning(2)" v-model="bank_account" type="text" />
              <el-alert v-if="tip.tip2" title="请填写银行账号" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="eight">
              <span class="span">*</span>开户银行支行名称 :
              <input @change="changeWarning(3)" v-model="bank_name" type="text" />
              <el-alert
                v-if="tip.tip3"
                title="请填写开户银行支行名称"
                type="error"
                show-icon
                :closable="false"
              ></el-alert>
            </p>
            <p class="there">
              <span class="span">*</span>微信帐号 :
              <input @change="changeWarning(4)" v-model="wechatNum" type="text" />
              <el-alert v-if="tip.tip4" title="请填写微信帐号" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="four">
              <span class="span">*</span>支付宝帐号 :
              <input @change="changeWarning(5)" v-model="alipayNum" type="text" />
              <el-alert v-if="tip.tip5" title="请填写支付宝帐号" type="error" show-icon :closable="false"></el-alert>
            </p>
            <button @click="next">下一步</button>
          </div>
        </div>
      </div>
    </div>
    <sign></sign>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: 0,
      person_name: "",
      bank_account: "",
      bank_name: "",
      wechatNum: "",
      alipayNum: "",
      tip: {
        tip1: false,
        tip2: false,
        tip3: false,
        tip4: false,
        tip5: false
      }
    };
  },
  components: {
    sign: () => import("../../../common/sign"),
    openStoreLogo: () => import("../../../common/opStoreLogo")
  },
  mounted() {
    this.id = this.$route.params.id;
  },
  methods: {
    getStoreType() {
      return "个人开店申请";
    },
    getTitle() {
      return "招商入住";
    },
    changeWarning(sign) {
      switch (sign) {
        case 1:
          if (this.person_name != "") {
            this.$set(this.tip, "tip1", false);
          }
          break;
        case 2:
          if (/^\d{16}|\d{19}$/.test(this.bank_account)) {
            this.$set(this.tip, "tip2", false);
          }
          break;
        case 3:
          if (this.bank_name != "") {
            this.$set(this.tip, "tip3", false);
          }
          break;
        case 4:
          if (this.wechatNum != "") {
            this.$set(this.tip, "tip4", false);
          }
          break;
        case 5:
          if (this.alipayNum != "") {
            this.$set(this.tip, "tip5", false);
          }
          break;
      }
    },
    next() {
      this.$router.push({
        name: "personShopInfo"
        // params:{
        // 	id:1
        // }
      });
      if (this.person_name == "") {
        this.$set(this.tip, "tip1", true);
      }
      if (!/^\d{16}|\d{19}$/.test(this.bank_account)) {
        this.$set(this.tip, "tip2", true);
      }
      if (this.bank_name == "") {
        this.$set(this.tip, "tip3", true);
      }
      if (this.wechatNum == "") {
        this.$set(this.tip, "tip4", true);
      }
      if (this.alipayNum == "") {
        this.$set(this.tip, "tip5", true);
      }
      for (const key in this.tip) {
        if (this.tip[key] == true) {
          return;
        }
      }
      var params = {
        id: this.id,
        person_name: this.person_name,
        bank_account: this.bank_account,
        bank_name: this.bank_name,
        wechatNum: this.wechatNum,
        alipayNum: this.alipayNum
      };
      console.log(params);
      this.HTTP(this.$httpConfig.enterCardInfo, params, "post").then(res => {
        if (res.status) {
          this.$router.push({
            name: "personShopInfo",
            params: {
              id: res.data
            }
          });
        }
      });
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
.l {
  float: left;
}
.r {
  float: right;
}
.middle {
  background: #fafafa;
  height: 600px;
  padding: 20px 0;
  .center {
    background: #fff;
    overflow: hidden;
    .Box {
      height: 97px;
      border: 1px solid #bce8f1;
      background: #eff8ff;
      margin: 51px 110px 33px;
      img {
        margin: 27px 16px 0 40px;
        float: left;
      }
      span {
        font-size: 12px;
        color: #b1b4b6;
        float: left;
        width: 70%;
      }
      .spa {
        color: #333;
        font-size: 14px;
        margin: 25px 0 3px;
      }
    }
    input {
      padding-left: 8px;
      width: 286px;
      height: 30px;
      border: 1px solid #ccc;
      margin-left: 31px;
    }
    select {
      margin-left: 31px;
      width: 286px;
      height: 30px;
      border: 1px solid #ccc;
      outline: none;
      color: #888;
    }
    .span {
      color: #ff3f3f;
      margin-right: 5px;
    }
    .show {
      margin: 0 110px;
      h1 {
        font-size: 14px;
        color: #333;
        margin-bottom: 22px;
      }
      p {
        font-size: 12px;
        color: #555;
        margin-bottom: 20px;
        line-height: 32px;
      }
      p.four {
        margin-left: 118px;
      }
      p.there {
        margin-left: 130px;
      }
      p.two {
        margin-left: 142px;
      }
      p.eight {
        margin-left: 83px;
      }
      .Top {
        height: 272px;
        button {
          cursor: pointer;
          width: 94px;
          height: 32px;
          border-radius: 4px;
          text-align: center;
          line-height: 32px;
          color: #fff;
          font-size: 12px;
          background: red;
          margin-left: 225px;
        }
      }
      .el-alert {
        display: inline;
        margin-left: 15px;
        padding: 0;
      }
      .el-alert--error {
        background-color: transparent;
      }
    }
  }
}
</style>