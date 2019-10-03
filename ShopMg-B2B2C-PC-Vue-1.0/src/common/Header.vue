<template>
  <div class="head">
    <header>
      <div class="header">
        <div class="div-one l">
          <div class="l youhello">
            <div v-if="ok" class="us-n clearfix">
              <span class="l" v-if="ok">你好，</span>
              <span
                class="user_name text1-hidden"
                @click="topersonal('personalData')"
                v-if="ok"
                v-text="user_name"
              ></span>
              <span class="sign_out r" @click="signOut">退出登录</span>
            </div>
            <span v-if="no" class="jumpTo" @click="logIn">请登录</span>
            <span v-if="no" class="jumpTo" @click="register">免费注册</span>
          </div>
          <div class="l div-two" @click="toAddress">
            <i class="el-icon-location-outline"></i>
            配送至:
            <span class="shanghai">{{site}}</span>
            <span>[切换]</span>
          </div>
        </div>

        <ul class="r ul">
          <li class="l shortcut">
            <div class="dt">
              <a href="JavaScript:;" @click="toLink(1)">我的订单</a>
            </div>
          </li>
          <li class="l shortcut">
            <div class="dt">
              <a href="JavaScript:;" @click="toLink(2)">个人中心</a>
            </div>
          </li>
          <li class="l shortcut">
            <div class="cw-icon">
              关注商城
              <i class="lower-icon"></i>
            </div>
            <div class="erweima dropdown-layer">
              <img :src="URL + init_qr_code" />
              <p>扫一扫</p>
            </div>
          </li>
          <li class="l shortcut">
            <div class="cw-icon">
              客户服务
              <i class="lower-icon"></i>
            </div>
            <ul class="uls dropdown-layer">
              <li v-for="(item,index) in articleType" :key="index">
                <a @click="goHelp(item.id)">{{item.name}}</a>
              </li>
            </ul>
          </li>
          <li class="l shortcut">
            <div class="cw-icon">
              商家管理
              <i class="lower-icon"></i>
            </div>
            <ul class="uls dropdown-layer">
              <li>
                <a href="javascript:;" @click="toLink(3)">招商入驻</a>
              </li>
              <li>
                <a href="javascript:;" @click="custorLogin">商家登录</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </header>
  </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      no: true,
      ok: false,
      user_name: "",
      user_img: "",
      articleType: [],
      x: null,
      site: null
    };
  },
  computed: {
    ...mapGetters(["init_qr_code"])
  },
  mounted() {
    this.user_name = sessionStorage.getItem("userName");
    this.user_img = sessionStorage.getItem("userHeaderImg");
    if (this.user_name != null) {
      this.no = false;
      this.ok = true;
    } else {
      this.no = true;
      this.ok = false;
    }
    this.getArticleType();
  },
  created() {
    this.getaddressLists();
  },
  methods: {
    //获取默认地址addressLists
    getaddressLists() {
      this.HTTP(this.$httpConfig.addressLists, {}, "post", false)
        .then(res => {
          this.site = res.data.data[0].dist_name;
        })
        .catch(e => {
          console.log(e);
        });
    },
    //退出登录
    signOut() {
      this.HTTP(this.$httpConfig.outLogin, {}, "post").then(res => {
        if (res.data.status == 1) {
          localStorage.clear();
          sessionStorage.clear();
          this.$router.push("/passwordLogin");
        }
        console.log(res);
      });
    },
    topersonal(r) {
      this.x++;
      window.open(window.location.origin + "/" + r + "?x=" + this.x);
    },
    toLink(n) {
      if (n == 1) {
        window.open(window.location.origin + "/myOrder" + "?id=2");
      } else if (n == 2) {
        window.open(window.location.origin + "/greet" + "?id=1");
      } else if (n == 3) {
        window.open(window.location.origin + "/progress");
      }
    },

    goHelp(id) {
      this.$router.push({
        name: "guide",
        params: {
          type: "class",
          id: id
        }
      });
    },
    getArticleType() {
      this.HTTP(this.$httpConfig.getArticleType, {}, "post").then(res => {
        this.articleType = res.data.data;
      });
    },
    custorLogin() {
      window.open(this.$constant.agentURL);
    },
    logIn() {
      this.$router.push({ name: "passwordLogin" });
    },
    register() {
      this.$router.push({ name: "register" });
    },
    toAddress() {
      this.$router.push({ name: "receive" });
    },
    getNav() {
      this.HTTP(this.$httpConfig.commonHeader, {}, "post").then(res => {
        console.log(res);
      });
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
header {
  background: #000;
}
.header {
  width: 1190px;
  margin: 0 auto;
  height: 30px;
  line-height: 30px;
  .div-one {
    color: #ccc;
    font-weight: 500;
    font-size: 12px;
    cursor: pointer;
    .bookmark:hover {
      color: #333333;
    }

    img {
      margin: 0 12px;
    }
    .div-two {
      margin-left: 20px;
      &:hover {
        color: #fff;
        font-weight: 600;
      }

      a {
        color: #999;
        margin-left: 3px;
      }
    }
  }
}
.phone {
  height: 38px;
  line-height: 38px;
  position: relative;
  .mobile {
    position: absolute;
    top: 12px;
  }
  span {
    font-size: 20px;
    color: red;
    padding-left: 20px;
  }
}
.ul {
  margin-right: 18px;
  .active {
    background: #fff url(../assets/img/down010.png) no-repeat top 15px right 5px !important;
  }

  .shortcut {
    position: relative;
    text-align: center;
    height: 30px;
    .cw-icon {
      color: #ccc;
      font-weight: 500;
      font-size: 12px;
      position: relative;
      z-index: 1;
      float: left;
      border: 1px solid #000;
      border-bottom: none;
      border-top: none;
      box-sizing: border-box;
      width: 100px;
      height: 30px;
      padding-left: 7px;
      padding-right: 14px;
      &:hover {
        color: #000;
      }
      .lower-icon {
        position: absolute;
        float: left;
        top: 14px;
        right: 16px;
        width: 7px;
        height: 4px;
        background: url(../assets/img/down010.png) no-repeat;
      }
      a:hover {
        color: red;
      }
    }
    .dt {
      padding: 0 0;
      height: 30px;
      width: 80px;
      font-size: 12px;
      font-weight: 500;
      line-height: 30px;
      a {
        color: #ccc;
        &:hover {
          color: #fff;
        }
      }
      color: #ccc;
      &:hover {
        color: #fff;
      }
    }
    .erweima {
      width: 100px;
      background: #fff;
      border: 1px solid #ccc;
      border-top: none;
      position: absolute;
      z-index: 9999;
    }
    .uls {
      width: 100px;
      background: #fff;
      position: absolute;
      left: 0;
      border: 1px solid #ccc;
      border-top: none;
      z-index: 999;
      li {
        width: 100%;
        height: 24px;
        line-height: 24px;
        a {
          border-right: 0;
          color: #656565;
          font-size: 12px;
        }
        a:hover {
          color: red;
        }
      }
      li:last-child {
        margin-bottom: 5px;
      }
    }

    .dropdown-layer {
      display: none;
      width: 100px;
      top: 30px;
    }
  }
  .shortcut:hover .cw-icon {
    color: #000;
    background-color: #fff;
  }
  .shortcut:hover .dropdown-layer {
    display: block;
  }
}
.youhello {
  position: relative;
  font-size: 12px;
  line-height: 30px;
  .user_name {
    cursor: pointer;
    margin-right: 15px;
    float: left;
    max-width: 90px;
    color: #ccc;
    &:hover {
      color: #ffffff;
      font-weight: 600;
    }
  }
  .sign_out {
    cursor: pointer;
    margin-right: 15px;
    color: #ccc;
    &:hover {
      color: #fff;
      font-weight: 600;
    }
  }
  .jumpTo {
    color: #ccc;
    font-weight: 500;
    padding: 0 5px;
    cursor: pointer;
    &:hover {
      color: #fff;
      font-weight: 600;
    }
  }
}
</style>