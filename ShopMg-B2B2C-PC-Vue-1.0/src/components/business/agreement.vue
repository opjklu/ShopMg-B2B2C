<template>
  <div id="interview">
    <logo-component></logo-component>
    <openStoreLogo></openStoreLogo>

    <div class="middle">
      <div class="center">
        <h1>入驻协议</h1>
        <div class="Box">
          <p>使用本公司服务所须遵守的条款和条件。</p>
          <p>1.用户资格</p>
          <p>
            公司的服务仅向适法拿下能够签订具有法律约束力的合同的个人提供并仅由其使用。在不限制前述规定的前提下本公司的服务不向18周岁以下或被临时或无限期中止的
            用户提供。如您不合资格请勿使用本公司的服务。此外您的帐户包括信用评价)和用户名不得向其他方转让或出售。另外本公司保留根据其商愿中止或终止您的帐户权利
          </p>
          <p>2.您的资料(包括但不限于所添加的任何商品)不得:</p>
          <p>* 具有欺作性、虚假，不准确或具误导性:</p>
          <p>* 侵犯任第三方著作权、专利权、商标权、商业秘密或其他专有权利或发表权或隐私权；</p>
          <p>* 违反任适用的法律或法规(包括但不限于有关出口管制、消费者保护、不正当竞争、刑法、反歧视或贸易惯例/公平贸易法律的法律或法规);</p>
          <p>* 有侮辱或者讲谤他人，侵害他人合去权益的内容;</p>
          <p>* 有淫秽、色情赌博、暴力、凶杀，恐怖或者教唆犯罪的内容</p>
          <p>* 包含可能破坏、改变、删除，不利影响、秘密截取、来经授权而接触或征用任可系统数据或个人资料的任何病毒特洛依木马，螺虫、定时如弹删除蝇、复活节彩蛋、间谍软件或其 他电脑程序。</p>
        </div>
        <h2>
          <label>
            <input type="checkbox" v-model="ischeck" /> 我已阅读并同意以上协议
          </label>
          <el-alert
            v-show="tip"
            class="address-tip"
            title="请点击同意以上协议"
            type="error"
            show-icon
            :closable="false"
          ></el-alert>
        </h2>
        <h3>
          <button @click="person">个人入驻</button>
          <button @click="company">企业入驻</button>
        </h3>
      </div>
    </div>
    <sign></sign>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ischeck: false,
      tip: false
    };
  },
  components: {
    sign: () => import("../../common/sign"),
    openStoreLogo: () => import("../../common/opStoreLogo")
  },
  watch: {
    ischeck() {
      if (this.ischeck == true) {
        this.tip = false;
      }
    }
  },
  methods: {
    getStoreType() {
      return "开店申请";
    },
    person() {
      if (this.ischeck == true) {
        this.$router.push("/personAdmission");
      } else {
        this.tip = true;
      }
      console.log(this.ischeck);
    },
    company() {
      if (this.ischeck == true) {
        this.$router.push("/companyAdmission");
      } else {
        this.tip = true;
      }
    },
    getTitle() {
      return "招商入住";
    }
  }
};
</script>

<style lang='less'  scoped>
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
  height: 697px;
  padding: 20px 0;
  .center {
    background: #fff;
    h1 {
      line-height: 85px;
      text-align: center;
      margin-top: 2px;
      font-size: 17px;
      color: #404040;
    }
    .Box {
      margin: 0 100px;
      height: 416px;
      border: 1px solid #eee;
      p {
        font-size: 12px;
        color: #555;
        margin: 0 19px;
        line-height: 23px;
      }
      p:nth-of-type(1) {
        margin: 24px 19px 28px;
      }
      p:nth-of-type(3) {
        margin: 0px 19px 20px;
      }
      p:nth-of-type(8) {
        margin: 0px 19px 20px;
      }
    }
    h2 {
      position: relative;
      text-align: center;
      margin: 40px 0 34px;
      label {
        display: inline-block;
        font-size: 12px;
        color: #555;
      }
      .el-alert {
        position: absolute;
        top: 0px;
        right: 350px;
        margin-left: 15px;
        width: 150px;
        padding: 0;
      }
      .el-alert--error {
        background-color: transparent;
      }
      .el-alert__icon {
        float: left;
      }
      input {
        margin-top: 2px;
        margin-right: 5px;
        float: left;
      }
    }
    h3 {
      text-align: center;
      button {
        display: inline-block;
        width: 94px;
        height: 32px;
        line-height: 32px;
        text-align: center;
        color: #fff;
        background: red;
        border-radius: 4px;
        margin: 0 18px;
        font-size: 12px;
      }
    }
  }
}
</style>