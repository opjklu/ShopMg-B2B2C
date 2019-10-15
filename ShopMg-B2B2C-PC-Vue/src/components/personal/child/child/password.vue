<template>
  <div class="only">
    <ul class="ul">
      <li>设置登录密码</li>
    </ul>
    <img v-show="img" class="logo" src="../../../../assets/img/buzhou1.png" />
    <img v-show="imgs" class="logo" src="../../../../assets/img/buzhou2.png" />
    <img v-show="imgss" class="logo" src="../../../../assets/img/buzhou3.png" />
    <ul>
      <li class="l" :class="{colour:isok}">验证身份</li>
      <li :class="{colour:isoks}" class="l">设置登录密码</li>
      <li :class="{colour:isokss}" class="l">完成</li>
    </ul>
    <div v-show="first">
      <p class="slet">
        <span>*</span>请选择验证身份方式：
        <select id="id" @change="dianji" v-model="judge">
          <option value="1">登录密码验证</option>
          <option value="2">手机验证</option>
        </select>
      </p>
      <div v-show="fangshi" name="verification">
        <p class="shouji">
          已验证的手机：
          <span v-if="getuser.mobile">{{getuser.mobile | phoneEncryption}}</span>
        </p>
        <p class="dongtai">
          <span>*</span>
          <span>手机动态验证码：</span>
          <input class="l" type="text" v-model="verification" />
          <span class="l" :class="{active:isActive}" @click="abtain">{{btnText}}</span>
        </p>
      </div>
      <div v-show="fangshis" name="usery">
        <p class="name">
          用户名：
          <span v-if="getuser.user_name">{{getuser.user_name}}</span>
        </p>
        <p class="denglu">
          <span>*</span>登录密码：
          <input type="password" v-model="usery" />
        </p>
        <p class="yanzhengma">
          <span>*</span>验证码：
          <input type="text" v-model="usery1" />
          <span></span>
          <img @click="getrefresh" :src="refresh" />
        </p>
      </div>
      <button @click="next">下一步</button>
    </div>
    <div v-show="second">
      <p class="pass">
        <span>*</span>新密码：
        <input type="password" v-model="newCode" />
        <span>
          <img src="../../../../assets/img/weixian.png" />请设置新密码
        </span>
      </p>
      <button @click="last">下一步</button>
    </div>
    <div v-show="third" class="samll">
      <img class="duihao" src="../../../../assets/img/bigduihao.png" />
      <p class="success">恭喜您！新登录密码设置成功</p>
      <p class="bangding">
        您绑定的手机号码：
        <span>18570623665</span>
      </p>
      <p class="goback" @click="goback">返回账户安全中心>></p>
    </div>
  </div>
</template>

<script>
import refresh from "../../../../common/refreshVerificationCode.js";
export default {
  data() {
    return {
      //验证
      verification: "",
      usery: "",
      usery1: "",
      all: false,
      //新密码
      newCode: "",
      //账户安全
      judge: "1",
      img: true,
      imgs: false,
      imgss: false,
      first: true,
      second: false,
      third: false,
      isok: true,
      isoks: false,
      isokss: false,
      fangshi: "",
      fangshis: true,
      btnText: "获取验证码",
      isActive: "",
      mobile: "",
      refresh: null,
      getuser: []
    };
  },
  created() {
    this.refresh = refresh.refreshVerificationCode();
  },

  mounted() {
    // this.HTTP(this.$httpConfig.userinfo,{
    // 		id: this.class_id
    // 	},'get')
    // 	.then((res) =>{
    // 		this.mobile=res.data.mobile
    // 	})
    this.getuserInfo();
  },
  methods: {
    getrefresh() {
      this.refresh = refresh.refreshVerificationCode();
    },
    //个人信息
    getuserInfo() {
      this.HTTP(this.$httpConfig.userInfo, {}, "post").then(res => {
        this.getuser = res.data;
        console.log(this.getuser);
      });
    },
    abtain() {
      if (this.isActive == true) return;
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
        this.$httpConfig.sendPhoneNumber,
        {
          mobile: this.getuser.mobile
        },
        "post"
      ).then(res => {
        if (res.status == 1) {
          this.token = res.data.token;
        } else {
          clearInterval(clear);
          _this.btnText = "再次获取验证码";
          _this.isActive = false;
        }
      });
    },
    //下一步
    next() {
      //先判断输入框不能为空
      if (this.usery != "" && this.usery1 != "") {
        this.all = true;
      } else if (this.verification != "") {
        this.all = true;
      } else {
        this.all = false;
      }
      //在判断输入值不能错误，
      if (this.judge === "1" && this.all === true) {
        //且是用户名验证修改密码
        try {
          this.HTTP(
            this.$httpConfig.verificationPassword,
            {
              password: this.usery,
              type: 0,
              vertify: this.usery1
            },
            "post"
          )
            .then(res => {
              //如果成功,就可以下一步
              if (res.status === 1) {
                (this.first = false), (this.second = true);
                (this.img = false), (this.imgs = true), (this.isoks = true);
              } else {
                $alert("测试出错");
              }
              //判断是否出错
            })
            .catch(e => {
              console.log(e);
              if (e.data.status === 0) {
                this.$confirm("密码或验证码错误?", "提示", {
                  confirmButtonText: "确定",
                  cancelButtonText: "取消",
                  type: "warning",
                  closeOnClickModal: false,
                  lockScroll: false,
                  center: true
                })
                  .then(() => {
                    this.getrefresh();
                  })
                  .catch(() => {});
              } else {
                console.log("出错啦");
              }
            });
        } catch (e) {
          console.log(e);
        }
      } else if (this.judge === "2" && this.all === true) {
        //手机验证修改密码
        //手机验证
        try {
          this.HTTP(
            this.$httpConfig.verificationPassword,
            {
              type: 1,
              phone_code: this.verification,
              mobile: this.getuser.mobile
            },
            "post"
          )
            .then(res => {
              //如果成功,就可以下一步
              console.log(res);
              if (res.status === 1) {
                (this.first = false), (this.second = true);
                (this.img = false), (this.imgs = true), (this.isoks = true);
              } else {
                $alert("测试出错");
              }
            })
            .catch(e => {
              //如果失败
              console.log(e);
              if (e.data.status === 0) {
                this.$confirm("验证码错误?", "提示", {
                  confirmButtonText: "确定",
                  cancelButtonText: "取消",
                  type: "warning",
                  closeOnClickModal: false,
                  lockScroll: false,
                  center: true
                })
                  .then(() => {
                    this.getrefresh(); //刷新验证码
                  })
                  .catch(() => {});
              } else {
                console.log("出错啦");
              }
            });
        } catch (e) {
          console.log(e);
        }
      }
    },
    last() {
      if (this.newCode != "") {
        this.HTTP(
          this.$httpConfig.modifyPassword,
          {
            newpassword: this.newCode
          },
          "post"
        )
          .then(res => {
            console.log(res);
            if (res.message === "成功") {
              this.third = true;
              this.second = false;
              (this.imgs = false), (this.imgss = true), (this.isokss = true);
            }
          })
          .catch(e => {
            console.log(e);
            this.$confirm("密码修改失败", "提示", {
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
      } else {
        this.$confirm("密码不能为空", "提示", {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
          closeOnClickModal: false,
          lockScroll: false,
          center: true
        })
          .then(() => {})
          .catch(() => {});
      }
    },

    goback() {
      this.third = false;
      (this.first = true), (this.second = false);
      (this.img = true),
        (this.imgs = false),
        (this.imgss = false),
        (this.isok = true),
        (this.isoks = false),
        (this.isokss = false),
        this.$emit("Goback");
    },
    dianji() {
      //判断验证方式
      if (this.judge === "1") {
        this.fangshis = true;
        this.fangshi = false;
      } else {
        this.fangshi = true;
        this.fangshis = false;
      }
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

.only {
  .ul {
    overflow: hidden;
    height: 37px;
    border-bottom: 1px solid #e7e7e7;
    margin: 14px 17px 0;
    li {
      width: 104px;
      text-align: center;
      line-height: 35px;
      border-bottom: 2px solid red;
      color: red;
    }
  }
  img.logo {
    margin: 59px 79px 0;
  }
  ul {
    overflow: hidden;
    margin: 13px 0 64px 79px;
    li {
      width: 241px;
      text-align: center;
      color: #ccc;
      font-size: 14px;
    }
  }
  .colour {
    color: #afd129;
  }
  p {
    font-size: 12px;
    color: #333;
  }
  p.yanzhengma {
    margin: 25px 0 0 230px;
    span:nth-of-type(1) {
      color: #ff3f3f;
      margin-right: 13px;
    }
    input {
      width: 180px;
      height: 38px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-right: 15px;
    }
  }
  p.shouji {
    margin: 25px 0 0 212px;
    span {
      color: #999;
    }
  }
  p.dongtai {
    margin: 21px 0 0 182px;
    overflow: hidden;
    line-height: 38px;
    span {
      float: left;
    }
    span:nth-of-type(1) {
      color: #ff3f3f;
      margin-right: 13px;
    }
    input {
      width: 110px;
      height: 38px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    span:nth-of-type(3) {
      cursor: pointer;
      width: 136px;
      height: 38px;
      border: 1px solid #d9d9d9;
      background: #f6f6f6;
      display: inline-block;
      text-align: center;
      line-height: 38px;
      margin: 0 0 0 12px;
    }
    .active {
      cursor: pointer;
      width: 136px;
      height: 38px;
      border: 1px solid #d9d9d9;
      background: #f6f6f6;
      display: inline-block;
      text-align: center;
      line-height: 38px;
      margin: 0 0 0 12px;
    }
  }
  button {
    cursor: pointer;
    border-radius: 3px;
    width: 110px;
    height: 38px;
    background: #afd129;
    text-align: center;
    line-height: 38px;
    color: #fff;
    font-size: 12px;
    margin: 30px 0 0 296px;
  }
  .samll {
    position: relative;
  }
  .duihao {
    position: absolute;
    top: -13px;
    left: 292px;
  }
  .success {
    font-size: 18px;
    color: #afd129;
    margin: 85px 0 0 375px;
  }
  .bangding {
    font-size: 12px;
    color: #666;
    margin: 19px 0 0 375px;
    span {
      color: #ff0000;
    }
  }
  .goback {
    font-size: 12px;
    color: #ff0000;
    margin: 39px 0 0 375px;
    cursor: pointer;
  }
  .slet {
    margin: 0 0 26px 148px;
    span {
      color: #ff3f3f;
      margin-right: 13px;
    }
    select {
      padding: 10px;
      width: 120px;
      height: 38px;
      border: 1px solid #ccc;
      font-size: 12px;
      color: #ccc;
      border-radius: 3px;
      outline: none;
    }
  }
  .name {
    margin: 0 0 0 240px;
    span {
      color: #ccc;
    }
  }
  .denglu {
    margin: 24px 0 0 215px;
    span {
      color: #ff3f3f;
      margin-right: 13px;
    }
    input {
      width: 280px;
      height: 38px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
  }
  .pass {
    margin: 0 0 0 230px;
    span {
      color: #ff3f3f;
      margin-right: 13px;
    }
    input {
      width: 260px;
      height: 38px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    span:nth-of-type(2) {
      color: #fa4862;
      margin-left: 13px;
      img {
        margin-right: 11px;
      }
    }
  }
}
</style>