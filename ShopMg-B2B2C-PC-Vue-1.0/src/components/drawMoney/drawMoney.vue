<template>
  <div id="drawMoney">
    <logo-component></logo-component>
    <div class="login">
      <div class="center d">
        <div class="login-left d">
          <p class="heat">
            <span class="hot">招商热线</span>
            <span class="shuzi">{{$constant.tel}}</span>
          </p>
        </div>
        <div class="login-right d">
          <div class="active">
            <img src="../../assets/img/images/zs2-1.png" alt />
            <p>提交</p>
          </div>
          <div>
            <img src="../../assets/img/images/zs2.png" alt />
            <p>完成</p>
          </div>
        </div>
      </div>
    </div>
    <div class="body">
      <div class="center">
        <h1 class="body-top">我的**提现</h1>
        <div class="body-center">
          <h5>
            您当前的账户余额是
            <span>{{Balance|keep2Num}}</span>元
          </h5>
          <p>
            <span>温馨提示：</span>账户余额是您在*****时可用于支付的金额!
          </p>
          <p style="margin-top:10px">目前只提现方式支持支付宝提现！</p>
        </div>
        <div class="body-bot">
          <p>
            请选择您的提现方式：
            <select v-model="type">
              <option v-if="type == '请选择'" value="请选择">请选择</option>
              <option
                :value="item.id"
                v-for="(item,index) in PayResult"
                :key="index"
              >{{item.type_name}}</option>
            </select>
          </p>
          <div class="money">
            请输入您的提现金额：
            <input
              class="input"
              v-model="money"
              type="text"
              placeholder="请输入"
              @input="change()"
            />
          </div>
        </div>
        <div class="body-fot">
          <div class="accounttext">
            请输入您的提现账户：
            <input class="input" v-model="account" type="text" placeholder="请输入" />
          </div>
          <el-button type="info" plain @click.native="withdrawal">提交</el-button>
        </div>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>
<script>
import { Message } from "element-ui";
export default {
  data() {
    return {
      money: undefined, //提现
      Balance: null, //余额
      PayResult: [],
      type: "请选择",
      account: null
    };
  },
  methods: {
    getTitle() {
      return "招商入住";
    },
    withdrawal() {
      if (this.type == "请选择") {
        Message.warning("请选择提现方式");
      } else if (this.money == null || this.account == null) {
        Message.warning("提现金额或账户名不能为空！");
      } else {
        this.$confirm("请确认您的信息", "提示", {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
          closeOnClickModal: false,
          lockScroll: false,
          center: true
        })
          .then(() => {
            this.HTTP(
              this.$httpConfig.foRcashAppliation,
              {
                pay_type_id: this.type,
                money: this.money,
                payee_account: this.account
              },
              "post"
            )
              .then(res => {
                console.log(res.data.message);
                this.$confirm(`${res.data.message}`, "提示", {
                  confirmButtonText: "确定",
                  cancelButtonText: "取消",
                  type: "warning",
                  closeOnClickModal: false,
                  lockScroll: false,
                  center: true
                })
                  .then(() => {
                    this.$router.push({ name: "myWithdrawal" });
                  })
                  .catch(() => {});
              })
              .catch(e => {
                console.log(e.data.message);
                this.$confirm(`${e.data.message}`, "提示", {
                  confirmButtonText: "确定",
                  cancelButtonText: "取消",
                  type: "warning",
                  closeOnClickModal: false,
                  lockScroll: false,
                  center: true
                })
                  .then(() => {})
                  .catch(() => {});
              });
          })
          .catch(() => {});
      }
    },
    //判断输入的值不能错误，不能为空，不能大于当前余额
    change() {
      //let reg = /(^[\-0-9][0-9]*(.[0-9]+)?)$/;
      let reg = /^\d+(\.\d{0,2})?$/;
      let _this = this;
      if (_this.money === "") {
        Message.error("不能为空");
      } else if (!reg.test(_this.money)) {
        Message.error("不是正确的数字");
        _this.money = null;
      } else if (_this.money > Number(_this.Balance)) {
        console.log(_this.money, Number(_this.Balance));
        Message.error("您输入的价格不能大于当前余额");
        _this.money = null;
      } else if (_this.money <= 0) {
        Message.error("您输入的金额不能为0");
      } else {
        console.log(_this.money);
        return _this.money;
      }
    },

    //获取支付类型
    getPayResult() {
      this.HTTP(this.$httpConfig.getPayRechargeResult, {}, "post")
        .then(res => {
          //console.log(res.data.data)
          this.PayResult = res.data.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    //获取余额
    getBalance() {
      this.HTTP(this.$httpConfig.getBalance, {}, "post")
        .then(res => {
          this.Balance = res.data.data;
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    this.getBalance();
    this.getPayResult();
  }
};
</script>
<style lang='less' scoped>
#drawMoney {
  background: #f7f7f7;
}
.center {
  width: 1200px;
  height: 100%;
  margin: 0 auto;
  background: #ffffff;
}
.d {
  display: flex;
  flex-wrap: nowrap;
}
.active {
  color: #c79a01;
}
.login {
  width: 100%;
  height: 104px;
  background: #ffffff;
  .center {
    justify-content: space-between;
    .login-left {
      height: 104px;
      .sign {
        width: 186px;
        height: 104px;
        img {
          margin-top: 20px;
          padding-right: 20px;
          height: 60px;
          border-right: 1px solid #dedede;
        }
      }
      .heat {
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
    }
    .login-right {
      width: 300px;
      margin-top: 25px;
      div {
        margin-right: 20px;
        img {
          width: 50px;
        }
        p {
          text-align: center;
        }
      }
    }
  }
}
.body {
  margin-top: 20px;
  height: 1000px;
  .body-top {
    text-align: center;
    font-size: 30px;
    background: #ddd;
    margin-bottom: 40px;
  }
  .body-center {
    margin-left: 60px;
    h5 {
      font-size: 25px;
      margin-bottom: 30px;
      span {
        color: #d53738;
      }
    }
    p {
      color: #b3a6c4;
    }
  }
  .body-bot {
    margin-left: 60px;
    margin-top: 30px;
    p {
      font-size: 14px;
      margin-bottom: 30px;
    }
    .money {
      padding-bottom: 20px;
      width: 400px;
      .input {
        border: 1px solid #000;
        width: 200px;
        height: 25px;
        padding-left: 10px;
      }
    }
  }
  .body-fot {
    margin-left: 60px;
    .accounttext {
      padding-bottom: 20px;
      width: 400px;
      .input {
        border: 1px solid #000;
        width: 200px;
        height: 25px;
        padding-left: 10px;
      }
    }
  }
}
</style>
