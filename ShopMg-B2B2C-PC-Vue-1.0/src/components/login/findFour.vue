<template>
  <div id="success">
    <logo-component></logo-component>
    <div id="topLogo"></div>
    <div id="codeNmae">
      <div class="center">
        <div class="numberOne">
          <p>
            <img class="sink" src="../../assets/img/buzhou3.png" />
          </p>
          <div class="part">
            <!-- <p class="bottomOne l">账户名</p> -->
            <p class="bottomTwo l">用户身份</p>
            <p class="bottomTwo l">设置新密码</p>
            <p class="bottomTwo l">完成</p>
          </div>
          <div class="nameCode">
            <img src="../../assets/img/login_dui.png" />
            <img src="../../assets/img/set_new.png" />
          </div>
          <router-link to="passwordLogin" class="button backToLogin">立即登录>></router-link>
        </div>
      </div>
    </div>
    <sign></sign>
  </div>
</template>

<script>
export default {
  data() {},
  components: {
    sign: () => import("../../common/sign")
  },
  methods: {
    getTitle() {
      return "找回密码";
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
      width: 100%;
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
  }
}

#codeNmae {
  width: 100%;
  height: 447px;
  .center {
    height: 447px;
    .numberOne {
      width: 100%;
      height: 447px;
      border: 1px solid #dddddd;
      .sink {
        margin-top: 74px;
        margin-left: 150px;
      }
      .part {
        width: 100%;
        height: 24px;
        margin-left: 151px;
        margin-top: 10px;
        .bottomOne {
          width: 178px;
          height: 24px;
          line-height: 24px;
          text-align: center;
          margin-left: 150px;
          color: #afd129;
          font-size: 12px;
        }
        .bottomTwo {
          width: 240px;
          height: 24px;
          line-height: 24px;
          text-align: center;
          color: #d0d0d0;
          font-size: 12px;
        }
      }
      .nameCode {
        width: 714px;
        height: 72px;
        margin-left: 290px;
        margin-top: 70px;
      }
      .backToLogin {
        width: 100px;
        height: 38px;
        border: 0;
        color: red;
        font-size: 12px;
        margin-left: 360px;
        margin-top: 20px;
      }
    }
  }
}
</style>