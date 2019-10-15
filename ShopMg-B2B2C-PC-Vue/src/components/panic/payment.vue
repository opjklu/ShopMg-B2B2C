<template>
  <div class="pay">
    <logo-component></logo-component>
    <div class="center">
      <div class="middle clearfix" v-if="$route.query.total_price">
        <!-- <p>订单提交成功，请您尽快付款！商品名称：xxxxx <span class="dindan">订单号：B2B20161125000000116-1024080</span><span class="r">应付金额<span class="hong">{{$route.query.total_price|keep2Num}}</span>元</span>
        </p>-->
        <p>
          订单提交成功，请您尽快付款！
          <span class="r">
            应付金额
            <span class="hong">{{$route.query.total_price|keep2Num}}</span>元
          </span>
        </p>
        <p>请您在提交订单后24小时内完成支付。</p>
      </div>
      <div class="middle clearfix" v-else>
        <p>
          <span class="r">
            应付金额
            <span class="hong">{{$route.query.price|keep2Num}}</span>元
          </span>
        </p>
      </div>
      <div class="bottom">
        <p class="l">
          账户当前余额
          <span>{{balance|keep2Num}}</span>元
        </p>
        <ul class="fangshi l">
          <li class="l" @click="change(0)" :class="{line:isline==0}">平台支付</li>
          <li class="l" @click="change(1)" :class="{line:isline==1}">网银支付</li>
        </ul>
        <ul class="method l" v-show="isline==0">
          <li
            @click="toPayment(item.id)"
            v-for="(item,index) in payType"
            :key="index"
            class="l"
            v-if="item.id != 3"
          >
            <img class="l" :src="URL + item.logo" />
            <span class="l">{{item.type_name}}</span>
          </li>
        </ul>
        <ul class="method l" v-show="isline==1">
          <li
            @click="toPayment(item.id)"
            v-for="(item,index) in payType"
            :key="index"
            class="l"
            v-if="item.id == 3"
          >
            <img class="l" :src="URL + item.logo" />
            <span class="l">{{item.type_name}}</span>
          </li>
        </ul>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>
	
<script>
import axios from "axios";
export default {
  data() {
    return {
      isline: "",
      isactive: 0,
      payType: [],
      balance: 0,
      payId: "",
      payMethod: {
        1: "wechatPay",
        2: "aliPay",
        3: "ylPay",
        4: "confirmPay"
      }
    };
  },
  created() {
    this.getPayResult();
    this.getBalance();
  },
  methods: {
    toPayment(id) {
      let that = this;
      this.payId = id;
      eval("that." + that.payMethod[this.payId] + "()");
    },
    getTitle() {
      return "我的收银台";
    },
    getPayResult() {
      //支付类型
      this.HTTP(this.$httpConfig.getPayResult, {}, "post", false)
        .then(res => {
          this.payType = res.data;
        })
        .catch(() => {});
    },
    //获取账号余额
    getBalance() {
      this.HTTP(this.$httpConfig.getBalance, {}, "post")
        .then(res => {
          this.balance = res.data;
        })
        .catch(() => {});
    },
    //支付宝支付
    aliPay() {
      this.HTTP(
        this.$httpConfig.getinitiatePayment,
        {
          pay_type_id: this.payId
        },
        "post"
      )
        .then(res => {
          const oDiv = document.createElement("div");
          oDiv.innerHTML = res.data;
          document.body.appendChild(oDiv);
          document.forms.Alipaysubmit.submit();
        })
        .catch(res => {
          this.$alert(res.message, "提示", {
            confirmButtonText: "确定",
            center: true,
            lockScroll: false,
            type: "warning"
          });
        });
    },
    wechatPay() {
      //微信支付跳转
      if (this.$route.query.total_price) {
        //普通商品
        this.$router.push({
          name: "wxpay",
          params: {
            total_price: this.$route.query.total_price,
            id: this.payId,
            state: "q"
          }
        });
      }
    },
    //余额支付
    confirmPay() {
      this.HTTP(
        this.$httpConfig.getinitiatePayment,
        {
          pay_type_id: this.payId
        },
        "post"
      )
        .then(res => {
          axios.post(res.data).then(res => {
            if (res.data == "SUCCESS") {
              this.$router.push({
                path: "/wxSuccess",
                query: {
                  link: "/myOrder"
                }
              });
            } else {
              this.$alert("支付失败", "提示", {
                confirmButtonText: "确定",
                center: true,
                lockScroll: false,
                type: "warning"
              });
            }
          });
        })
        .catch(res => {
          this.$alert(res.message, "提示", {
            confirmButtonText: "确定",
            center: true,
            lockScroll: false,
            type: "warning"
          });
        });
    },
    change(index) {
      console.log(index);
      this.isline = index;
    }
  }
};
</script>

<style>
.el-message-box--center {
  padding-bottom: 30px !important;
}

.el-message-box--center .el-message-box__header {
  padding-top: 30px !important;
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
  background: #fff;
}

.pay {
  background: #f6f5f5;
  height: 737px;
  .header {
    height: 109px;
    border-bottom: 1px solid #f6f5f5;
    img {
      margin: 31px 0 0 20px;
    }
    p {
      line-height: 30px;
      border-left: 1px solid #cdcfd0;
      font-size: 18px;
      color: #555;
      margin: 45px 0 0 20px;
      padding-left: 17px;
    }
  }
  .middle {
    padding: 40px 0;
    border-bottom: 1px solid #f6f5f5;
    p {
      float: left;
      font-size: 12px;
      margin-left: 21px;
      width: 80%;
    }
    p:nth-of-type(1) {
      color: #333;
      font-weight: 600;
      .dindan {
        font-weight: 500;
        margin-left: 19px;
      }
      span.r {
        font-weight: 500;
        margin-right: 42px;
        .hong {
          color: #d32026;
          font-size: 17px;
          margin: 0 11px;
        }
      }
    }
  }
  .bottom {
    margin: 28px 0 0 22px;
    overflow: hidden;
    p {
      font-size: 12px;
      input {
        float: left;
        margin: 2px 14px 0 0;
      }
      span {
        color: #d32026;
      }
    }
    .fangshi {
      margin-top: 27px;
      height: 36px;
      border-bottom: 1px solid #f6f5f5;
      width: 100%;
      li {
        width: 70px;
        height: 37px;
        line-height: 34px;
        text-align: center;
        font-size: 15px;
        color: #555;
        margin-right: 22px;
        cursor: pointer;
      }
      .line {
        border-bottom: 2px solid red;
        color: red;
      }
    }
    .method {
      height: 99px;
      border-bottom: 1px solid #f6f5f5;
      width: 100%;
      margin-top: 28px;
      li {
        cursor: pointer;
        line-height: 40px;
        width: 100px;
        height: 40px;
        margin-right: 15px;
        img {
          width: 26px;
          height: 26px;
          margin: 7px 5px 7px 0;
        }
      }
      li:hover {
        color: red;
      }
    }
  }
}
</style>