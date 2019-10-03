<template>
  <div class="recharge">
    <logo-component></logo-component>
    <div class="center">
      <ul class="buzhou">
        <li class="l active">1</li>
        <li class="l active">2</li>
        <li class="l">3</li>
      </ul>
      <ul class="zhushi">
        <li class="l actives">填写充值金额</li>
        <li class="l actives">在线支付</li>
        <li class="l">充值完成</li>
      </ul>
      <div class="inline">
        <div class="top">
          <p>充值详情</p>
        </div>
        <div class="jine">
          <span>*</span>您要充值的金额：
          <input v-model="recharge_num" @blur="checkPrice" type="text" />
        </div>
        <p class="huise">
          <span v-show="isShow">充值金额错误</span>
        </p>
        <div class="fangshi">
          <span class="spa">*</span>
          <span>请选择支付方式：</span>
          <ul class="l">
            <li v-for="(item,index) in payType" :key="index">
              <el-radio v-model="radio" :label="item.id">{{item.type_name}}</el-radio>
            </li>
          </ul>
        </div>
        <div class="zhifu" @click="toPay">去支付</div>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>
<script>
export default {
  data() {
    return {
      radio: "",
      payType: [],
      isShow: false,
      payMethod: {
        1: "wechatPay",
        2: "aliPay",
        3: "ylPay"
      },
      payData: "",
      recharge_num: ""
    };
  },
  created() {
    this.getPayResult();
  },
  methods: {
    getTitle() {
      return "填写充值金额";
    },
    wechatPay() {
      //微信支付
      sessionStorage.setItem("payData", JSON.stringify(this.payData));
      this.$router.push({
        name: "wxpay",
        params: {
          total_price: this.recharge_num,
          id: this.radio,
          state: "c"
        }
      });
    },
    aliPay() {
      //支付宝支付
      const oDiv = document.createElement("div");
      oDiv.innerHTML = this.payData;
      document.body.appendChild(oDiv);
      document.forms.Alipaysubmit.submit();
    },
    ylPay() {
      //银联
    },
    getPayResult() {
      this.HTTP(this.$httpConfig.getPayRechargeResult, {}, "post")
        .then(res => {
          this.payType = res.data.data;
        })
        .catch(() => {});
    },
    checkPrice() {
      if (
        !/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/.test(
          this.recharge_num
        )
      ) {
        this.isShow = true;
      } else {
        this.isShow = false;
      }
    },
    toPay() {
      this.checkPrice();
      var that = this;
      if (this.isShow) return false;
      this.HTTP(
        this.$httpConfig.balanceRecharge,
        { pay_type_id: this.radio, money: this.recharge_num },
        "post"
      )
        .then(res => {
          this.payData = res.data.data;
          eval("that." + that.payMethod[this.radio] + "()");
        })
        .catch(() => {});
    }
  }
};
</script>
<style>
.el-radio {
  margin-left: 20px;
}
.el-radio__input.is-checked + .el-radio__label {
  color: #333;
}
</style>
<style lang="less" scoped>
.l {
  float: left;
}

.r {
  float: right;
}

.center {
  width: 1200px;
  margin: 0 auto;
  height: 100%;
}

.logo {
  height: 115px;
  width: 1200px;
  margin: 0 auto;
  img {
    margin-top: 28px;
    float: left;
  }
  p {
    font-size: 24px;
    float: left;
    margin: 40px 0 0 29px;
  }
}

.buzhou {
  height: 50px;
  background: url(../../assets/img/buzhou.jpg) no-repeat center;
  li {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #878788;
    text-align: center;
    line-height: 42px;
    font-size: 20px;
    color: #fff;
    font-weight: 900;
    margin-top: 4px;
  }
  li:nth-of-type(1) {
    margin-left: 207px;
  }
  li:nth-of-type(2) {
    margin: 4px 353px 0 343px;
  }
  .active {
    background: #d3b73c !important;
  }
}

.zhushi {
  height: 42px;
  li {
    font-size: 14px;
    color: #666;
    line-height: 42px;
  }
  li:nth-of-type(1) {
    margin-left: 192px;
  }
  li:nth-of-type(2) {
    margin: 0 335px 0 313px;
  }
  .actives {
    color: #d3b73c !important;
  }
}
.inline {
  .top {
    overflow: hidden;
    margin: 14px 17px 0px;
    border-bottom: 1px solid #e7e7e7;
    line-height: 37px;
    p {
      width: 104px;
      text-align: center;
      border-bottom: 2px solid red;
      font-size: 14px;
      color: red;
    }
  }
  .jine {
    margin: 29px 0 0 16px;
    font-size: 12px;
    color: #333;
    span {
      color: #f34545;
    }
    input {
      padding-left: 5px;
      width: 150px;
      height: 30px;
      border: 1px solid #ccc;
      margin-right: 9px;
    }
  }
  p.huise {
    height: 17px;
    font-size: 12px;
    color: #999;
    margin: 5px 0 18px 123px;
    span {
      color: #f34545;
    }
  }
  .fangshi {
    overflow: hidden;
    margin: 0px 0 0 16px;
    font-size: 12px;
    color: #333;
    span {
      float: left;
    }
    .spa {
      color: #f34545;
    }
    ul {
      width: 658px;
      min-height: 154px;
      border: 1px solid #ccc;
      li {
        line-height: 50px;
        font-size: 12px;
        color: #333;
        border-bottom: 1px solid #ccc;
        input {
          float: left;
          margin: 19px 8px 0 20px;
        }
      }
      li:last-child {
        border-bottom: 0;
      }
    }
  }
  .zhifu {
    width: 94px;
    height: 32px;
    text-align: center;
    background: red;
    color: #fff;
    line-height: 32px;
    font-size: 12px;
    margin: 30px 0 30px 123px;
    cursor: pointer;
    border-radius: 3px;
  }
}
</style>