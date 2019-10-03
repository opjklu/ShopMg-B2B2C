<template>
  <div id="newPassword">
    <logo-component></logo-component>

    <div id="topLogo"></div>
    <div id="codeNmae">
      <div class="center">
        <div class="numberOne">
          <p>
            <img class="sink" src="../../assets/img/buzhou2.png" />
          </p>
          <div class="part">
            <!-- <p class="bottomOne l">账户名</p> -->
            <p class="bottomTwo l">用户身份</p>
            <p class="bottomTwo l">设置新密码</p>
            <p class="bottomTwo l">完成</p>
          </div>
          <div class="nameCode">
            <p class="l accept">
              <i>*</i>
              新密码：
              <input type="password" v-model="password" />
            </p>
            <p class="l accepts">
              <i>
                <img src="../../assets/img/warn.png" />
              </i>
              <span class="changeColor">请设置密码</span>
            </p>
          </div>
          <span class="button next" @click="to">下一步</span>
        </div>
      </div>
    </div>
    <sign></sign>
  </div>
</template>

<script>
import { Message } from "element-ui";
export default {
  data() {
    return {
      password: ""
    };
  },
  components: {
    sign: () => import("../../common/sign")
  },
  created() {
    console.log(this.$route.params.tel);
  },
  methods: {
    getTitle() {
      return "找回密码";
    },
    to() {
      this.HTTP(
        this.$httpConfig.backPwd,
        {
          mobile: this.$route.params.tel,
          verify: this.$route.params.verify,
          password: this.password,
          re_password: this.password
        },
        "post"
      ).then(res => {
        if (res.data.status === 1 && res.data.data) {
          this.$router.push("findFour");
          // Message({
          // 	message: '',
          // 	type: 'info',
          // 	duration: 1000
          // })
        }

        // console.log(res.data)
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
        height: 38px;
        margin-left: 290px;
        margin-top: 70px;

        .accept {
          width: 330px;
          height: 38px;
          i {
            color: red;
            margin-right: 5px;
          }
          input {
            width: 260px;
            height: 38px;
            text-indent: 0.5em;
            border: 1px solid #cccccc;
          }
        }
        .accepts {
          width: 140px;
          height: 38px;
          line-height: 38px;
          .abtain {
            display: inline-block;
            width: 136px;
            height: 38px;
            border: 1px solid #d9d9d9;
            text-align: center;
            background: #f6f6f6;
            cursor: default;
            margin-right: 15px;
          }
          .changeColor {
            color: red;
          }
        }
      }
      .next {
        width: 100px;
        height: 38px;
        background: #afd129;
        border: 0;
        color: #ffffff;
        font-size: 12px;
        margin-left: 360px;
        margin-top: 20px;
      }
    }
  }
}
</style>