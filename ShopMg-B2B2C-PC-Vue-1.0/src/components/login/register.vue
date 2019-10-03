<template>
  <div id="page">
    <logo-component></logo-component>
    <div id="topLogo">
      <div class="center">
        <div class="r already">
          <p class="l have">已有账号</p>
          <p class="l please">
            <router-link to="passwordLogin" class="inPage">请登录</router-link>
          </p>
        </div>
      </div>
    </div>
    <div id="inform">
      <div class="center">
        <div class="freeBox"></div>
        <div class="resist">
          <div class="l emptyResist">
            <ul>
              <li class="l" @click="loginEnter(0)" :class="{try:istry==0}">账号注册</li>
              <!-- <li class="l" @click="loginEnter(1)" :class="{try:istry==1}">手机注册</li> -->
            </ul>
            <div class="lab" v-show="onoff==0">
              <div class="check-tips">
                <el-alert
                  v-if="checkText"
                  :title="checkText"
                  :type="checkType"
                  show-icon
                  :closable="false"
                ></el-alert>
              </div>
              <p class="tabname">
                用户名：
                <input type="text" placeholder="请使用6-20个中文  英文 数字或'_'符号" v-model.trim="username" />
              </p>
              <p class="tabname">
                手机号：
                <input type="text" placeholder="请输入手机号" v-model="mobile" />
                <span class="abtain" :class="{active:isActive}" @click="abtain">{{btnText}}</span>
              </p>
              <p class="checks">
                验证码：
                <input type="text" placeholder="输入验证码" v-model="message" />
              </p>
              <p class="tab">
                设置密码：
                <input type="password" placeholder="6-20位大小写英文字母 数字 或符号" v-model="password" />
              </p>
              <p class="tab">
                确认密码：
                <input type="password" placeholder="请再次输入密码" v-model="re_password" />
              </p>
              <p class="tabs">
                邮箱：
                <input type="text" placeholder="请输入常用邮箱" v-model="email" />
              </p>
              <p class="consign">
                <input type="checkbox" v-model="choose" />阅读并同意
                <a>《服务协议》</a>
              </p>
              <p class="button agree" @click="register">立即注册</p>
            </div>
            <!-- <div class="labs" v-show='onoff==1'>
								<div class="check-tips">
									<el-alert v-if="checkText1" :title="checkText1" :type="checkType1" show-icon :closable="false"></el-alert>
								</div>
								<p class="tabsAdd">手机号：<input type="text" placeholder="请输入手机号" maxlength="11" v-model="mobile"/></p>
								<p class="checks">验证码：<input type="text" placeholder="输入验证码" v-model="numbers"/><img src="../../assets/img/register_yanzhengma.png"/></p>
								<p class="correct">确保验证码输入正确，点击<a class="access" @click="send"><img src="../../assets/img/post.png"/></a>并将您手机短信所接收的"六位验证码"输入到下方短信验证，在提交下一步</p>
								<p class="checked">短信验证码：<input type="text" placeholder="输入六位验证码" v-model="ent"/></p>
								<p class="button agree" @click="ipEnter">立即注册</p>
            </div>-->
          </div>
          <div class="l emptyResists">
            <div class="friend">
              <p class="string">使用合作网站账号直接登录</p>
              <p class="circle">
                <a class="l otherPeople">
                  <img src="../../assets/img/login_qq.png" />
                </a>
                <a class="l otherPeople">
                  <img src="../../assets/img/login_weibo.png" />
                </a>
                <a class="l otherPeople">
                  <img src="../../assets/img/login_weixin.png" />
                </a>
              </p>
            </div>
            <div class="haveOk">
              <p class="afters">注册之后您可以</p>
              <div class="full">
                <dl>
                  <dt class="l">
                    <img src="../../assets/img/register_car.png" />
                  </dt>
                  <dd class="l">购买商品支付订单</dd>
                </dl>
                <dl>
                  <dt class="l">
                    <img src="../../assets/img/register_collect.png" />
                  </dt>
                  <dd class="l">收藏商品关注商铺</dd>
                </dl>
                <dl>
                  <dt class="l">
                    <img src="../../assets/img/register_safe.png" />
                  </dt>
                  <dd class="l">安全交易诚信无忧</dd>
                </dl>
                <dl>
                  <dt class="l">
                    <img src="../../assets/img/register_grade.png" />
                  </dt>
                  <dd class="l">积分获取优惠购物</dd>
                </dl>
                <dl>
                  <dt class="l">
                    <img src="../../assets/img/register_enjoy.png" />
                  </dt>
                  <dd class="l">会员等级享受特权</dd>
                </dl>
                <dl>
                  <dt class="l">
                    <img src="../../assets/img/register_pingjia.png" />
                  </dt>
                  <dd class="l">评价晒单站外分享</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isActive: false,
      onoff: "",
      istry: "",
      username: "",
      mobile: "",
      message: "",
      password: "",
      re_password: "",
      email: "",
      btnText: "获取验证码",
      numbers: "",
      ent: "",
      choose: true,
      checkText: "",
      checkText1: "",
      checkType: "error",
      checkType1: "error"
    };
  },
  methods: {
    getTitle() {
      return "注册账号";
    },
    abtain() {
      this.checkType = "error";
      if (this.isActive == true) return;
      if (!/^1[345789]\d{9}$/.test(this.mobile)) {
        this.checkText = "请填写正确的手机号";
        return;
      } else {
        this.checkText = "";
      }
      var N = 60,
        _this = this,
        clear = null;
      _this.isActive = true;
      _this.btnText = "请" + N + "秒后重试";
      _this.isActive = true;
      clear = setInterval(function() {
        _this.btnText = "请" + N-- + "秒后重试";
        if (N < 0) {
          clearInterval(clear);
          _this.btnText = "获取验证码";
          _this.isActive = false;
        }
      }, 1000);
      this.HTTP(
        this.$httpConfig.sms,
        {
          mobile: this.mobile
        },
        "post"
      )
        .then(res => {
          this.token = res.data.data.token;
        })
        .catch(res => {
          this.checkText = res.data.message;
          this.checkType = "warning";
        });
    },
    loginEnter(index) {
      this.onoff = index;
      this.istry = index;
    },
    send() {
      // this.HTTP(this.$httpConfig,{},'post')
      // .then((res) =>{
      // })
    },
    register() {
      this.checkType = "error";
      //
      if (!/^[a-zA-Z0-9]|[\u4E00-\u9FA5_].{6,20}$/.test(this.username)) {
        this.checkText = "请输入6-20个中 英 数字或者符号的用户名";
        return false;
      }
      if (!/^1[345789]\d{9}$/.test(this.mobile)) {
        this.checkText = "请填写正确的手机号";
        return;
      } else {
        this.checkText = "";
      }
      if (this.message.length != 6) {
        this.checkText = "验证码错误";
        return false;
      }
      if (this.password.toString().length < 6) {
        this.checkText = "请输入至少6位的密码";
        return false;
      }
      if (this.re_password != this.password) {
        this.checkText = "两次密码输入不一致";
        return false;
      }
      if (
        !/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(this.email)
      ) {
        this.checkText = "请输入正确的邮箱地址";
        return false;
      }
      if (this.choose == false) {
        this.checkText = "请同意协议";
        return false;
      }

      // this.checkType = 'success';
      // this.checkText = '注册成功,请稍等...';
      // setTimeout(() => {
      // 	this.$router.push('/passwordLogin');
      // }, 3000)
      this.HTTP(
        this.$httpConfig.register,
        {
          user_name: this.username,
          email: this.email,
          password: this.password,
          repassword: this.re_password,
          // token: this.token,
          code: this.message,
          mobile: this.mobile
        },
        "post"
      )
        .then(res => {
          console.log(res.data);
          // if (res.data.message === '手机号验证码错误') {
          // 	this.checkText1 = '验证码有误'
          // } else if (res.data.message === '账号已存在') {
          // 	this.checkText1 = '您已注册'
          // } else if (res.data.message === '邮箱已存在') {
          // 	this.checkText1 = '您已注册该邮箱'
          // }
          if (res.data.status === 1) {
            this.checkType1 = "success";
            this.checkText1 = "注册成功,请稍等...";
            this.$router.push("/passwordLogin");
          }
          this.$message({
            message: `${res.data.message}`
          });
        })
        .catch(e => {
          this.$message({
            message: `${e.data.message}`
          });
        });
    },
    ipEnter() {
      if (this.mobile.length != 11) {
        this.checkText1 = "手机号码有误,请重新输入";
        return false;
      }
      if (this.numbers.length != 4) {
        this.checkText1 = "验证码错误";
        return false;
      }
      if (this.ent.length != 6) {
        this.checkText1 = "短信验证码错误";
        return false;
      }
      this.checkType1 = "success";
      this.checkText1 = "注册成功,请稍等...";
      setTimeout(() => {
        this.$router.push("/passwordLogin");
      }, 3000);
      this.HTTP(
        this.$httpConfig.register,
        {
          mobile: this.mobile,
          user_name: this.username
        },
        "post"
      ).then(res => {
        this.$router.push("/passwordLogin");
      });
    }
  }
};
</script>

<style lang="less" scoped>
.center {
  width: 1000px;
  height: 100%;
  margin: 0 auto;
}

.l {
  float: left;
}

.r {
  float: right;
}

#topLogo {
  width: 100%;
  height: 100px;
  .center {
    height: 100px;
    ul {
      width: 460px;
      height: 100px;
      .logo {
        width: 184px;
        height: 53px;
        margin-top: 21px;
        border-right: 1px solid #ebebeb;
      }
      .category {
        margin-top: 35px;
        margin-left: 15px;
      }
    }
    .already {
      width: 150px;
      height: 100px;
      .have {
        width: 70px;
        height: 100px;
        line-height: 100px;
        font-size: 15px;
        color: #333333;
        font-weight: 500;
        text-align: center;
      }
      .please {
        width: 70px;
        height: 100px;
        line-height: 100px;
        .inPage {
          font-size: 15px;
          color: red;
          font-weight: 500;
        }
      }
    }
  }
}

#inform {
  width: 100%;
  height: 705px;
  background: url(../../assets/img/register_bg.png) no-repeat center;
  .center {
    height: 705px;
    .freeBox {
      height: 66px;
      width: 100%;
    }
    .resist {
      width: 858px;
      height: 570px;
      border: 10px solid #d0d0d0;
      background: #ffffff;
      margin-left: 60px;
      .emptyResist {
        width: 588px;
        height: 550px;
        margin-left: 29px;
        border-right: 1px solid #e6e6e6;
        ul {
          width: 588px;
          height: 62px;
          li {
            width: 293px;
            height: 62px;
            line-height: 62px;
            text-align: center;
            color: #999999;
            font-size: 18px;
            border-bottom: 1px solid #e6e6e6;
          }
          .try {
            background: url(../../assets/img/register_border.png) no-repeat 0
              60px;
            color: red;
          }
        }
        .check-tips {
          height: 40px;
          padding: 6px 0;
          .el-alert {
            padding: 4px 16px;
          }
        }
        .lab {
          width: 396px;
          height: 320px;
          margin-left: 103px;
          // margin-top: 40px;
          .tab {
            width: 396px;
            height: 54px;
            line-height: 54px;
            text-indent: 1em;
            color: #555555;
            font-size: 14px;
            border-left: 1px solid #e6e6e6;
            border-right: 1px solid #e6e6e6;
            border-top: 1px solid #e6e6e6;
            input {
              width: 300px;
              height: 50px;
              font-size: 14px;
              text-indent: 0.5em;
            }
          }
          .tabname {
            width: 396px;
            height: 54px;
            line-height: 54px;
            text-indent: 1.9em;
            color: #555555;
            font-size: 14px;
            border-left: 1px solid #e6e6e6;
            border-right: 1px solid #e6e6e6;
            border-top: 1px solid #e6e6e6;
            position: relative;
            input {
              width: 300px;
              height: 50px;
              font-size: 14px;
              text-indent: 0.5em;
            }
            .abtain {
              text-indent: initial;
              width: 90px;
              height: 24px;
              line-height: 24px;
              border-radius: 12px;
              border: 1px solid #c4c4c4;
              font-size: 10px;
              color: #a9a9a9;
              text-align: center;
              position: absolute;
              top: 16px;
              right: 30px;
              cursor: pointer;
            }
            .active {
              background: #c4c4c4;
              color: #fff;
            }
          }
          .tabs {
            width: 396px;
            height: 54px;
            line-height: 54px;
            text-indent: 3em;
            color: #555555;
            font-size: 14px;
            border: 1px solid #e6e6e6;
            input {
              width: 300px;
              height: 50px;
              font-size: 14px;
            }
          }
          .checks {
            width: 396px;
            height: 54px;
            color: #555555;
            font-size: 14px;
            line-height: 54px;
            text-indent: 1.9em;
            border-left: 1px solid #e6e6e6;
            border-right: 1px solid #e6e6e6;
            border-top: 1px solid #e6e6e6;
            input {
              width: 202px;
              height: 45px;
              font-size: 14px;
              text-indent: 0.5em;
            }
          }
          .consign {
            width: 300px;
            height: 26px;
            line-height: 26px;
            margin-top: 12px;
            input {
              margin-right: 3px;
            }
          }
        }
        // .labs{
        // 	width: 396px;
        // 	height: 290px;
        // 	margin-left: 103px;
        // 	.tabsAdd{
        // 		width: 396px;
        // 		height: 54px;
        // 		line-height: 54px;
        // 		text-indent: 1em;
        // 		color: #555555;
        // 		font-size: 14px;
        // 		border-left: 1px solid #e6e6e6;
        // 		border-right: 1px solid #e6e6e6;
        // 		border-top: 1px solid #e6e6e6;
        // 		/*border-bottom: 1px solid #e6e6e6;*/
        // 		input{
        // 			width: 300px;
        // 			height: 50px;
        // 			font-size: 14px;
        // 		}
        // 	}
        // 	.checks{
        // 		width: 396px;
        // 		height: 54px;
        // 		color: #555555;
        // 		font-size: 14px;
        // 		line-height: 54px;
        // 		text-indent: 1em;
        // 		border: 1px solid #e6e6e6;
        // 		input{
        // 			width: 202px;
        // 			height: 45px;
        // 			font-size: 14px;
        // 		}
        // 		img{
        // 			width: 122px;
        // 			height: 52px;
        // 			margin: 0;
        // 			padding: 0;
        // 		}
        // 	}
        // 	.correct{
        // 		width: 390px;
        // 		height: 83px;
        // 		margin-top: 15px;
        // 		color: #999999;
        // 		font-size: 14px;
        // 		.access{
        // 			width: 115px;
        // 			height: 32px;
        // 		}
        // 	}
        // 	.checked{
        // 		width: 400px;
        // 		height: 52px;
        // 		line-height: 52px;
        // 		text-indent: 1em;
        // 		border: 1px solid #e6e6e6;
        // 		input{
        // 			height: 45px;
        // 			font-size: 14px;
        // 		}
        // 	}
        // }
        .agree {
          width: 398px;
          height: 42px;
          line-height: 42px;
          text-align: center;
          /*margin-left: 10px;*/
          margin-top: 20px;
          background: red;
          color: #ffffff;
          font-size: 17px;
          border: 0;
        }
      }
      .emptyResists {
        width: 200px;
        height: 550px;
        margin-left: 20px;
        .friend {
          width: 200px;
          height: 82px;
          margin-top: 40px;
          border-bottom: 1px dashed #e8e8e8;
          .string {
            width: 200px;
            height: 26px;
            line-height: 26px;
            color: #333333;
            font-size: 14px;
          }
          .circle {
            width: 170px;
            height: 44px;
            margin-top: 10px;
            margin-left: 12px;
            /*margin-bottom: ;*/
            a {
              margin-left: 10px;
            }
          }
        }
        .haveOk {
          width: 200px;
          height: 300px;
          .afters {
            width: 100%;
            height: 28px;
            line-height: 28px;
            font-size: 14px;
            color: #333333;
            margin-top: 20px;
          }
          .full {
            width: 100%;
            height: 127px;
            dl {
              width: 100%;
              height: 38px;
              dt {
                width: 43px;
                height: 38px;
                img {
                  margin: 6px;
                }
              }
              dd {
                height: 38px;
                line-height: 38px;
              }
            }
          }
        }
      }
    }
  }
}
</style>