<template>
  <div class="head">
    <common-header></common-header>
    <nav>
      <router-link to="/home">
        <img class="logo" :src="URL+logo" />
      </router-link>
      <p class="buyCarText">购物车</p>
      <div class="middle">
        <div class="inp">
          <span class="dianpu">
            <el-dropdown size="small" @command="handleCommand">
              <span class="el-dropdown-link">
                {{search_type}}
                <i class="el-icon-arrow-down el-icon--right"></i>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item command="store">店铺</el-dropdown-item>
                <el-dropdown-item command="goods">宝贝</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </span>
          <input type="text" />
          <span class="search">搜索</span>
        </div>
        <ul>
          <li v-for="(li,index) in search" :key="index">
            <a href="/">{{li}}</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      search: [
        "CPU",
        "GPU",
        "显示器",
        "音响",
        "内存条",
        "固态硬盘"
      ],
      on: "",
      isactive: "",
      no: true,
      ok: false,
      user_name: "",
      search_type: "宝贝"
    };
  },
  mounted() {},
  computed: {
    ...mapGetters(["logo"])
  },
  methods: {
    handleCommand(command) {
      if (command == "store") {
        this.search_type = "店铺";
      } else {
        this.search_type = "宝贝";
      }
    },
    open() {
      this.on = true;
      this.isactive = true;
    },
    close() {
      this.on = null;
      this.isactive = null;
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
  background: #f7f7f7;
  border-bottom: 1px solid #eee;
}
.header {
  width: 1200px;
  margin: 0 auto;
  height: 38px;
  .divOne {
    line-height: 38px;
    color: #9b9b9b;
    font-size: 12px;
    img {
      margin: 0 12px;
    }
    .divTwo {
      margin-left: 20px;
      .shanghai {
        color: red;
      }
      a {
        color: #9b9b9b;
        margin-left: 3px;
      }
    }
  }
}
.phone {
  line-height: 38px;
  span {
    font-size: 20px;
    color: red;
  }
}
.ul {
  margin-top: 3px;
  margin-right: 18px;
  .active {
    background: #fff url(../assets/img/up.jpg) no-repeat top 15px right 5px !important;
  }
  .li {
    width: 78px;
    /*line-height: 28px;*/
    height: 29px;
    /*margin-top: 11px;*/
    position: relative;
    text-align: center;
    background: url(../assets/img/down010.png) no-repeat top 15px right 5px;
    cursor: pointer;
    &:hover a {
      color: red;
    }
    a {
      color: #656565;
      font-size: 12px;
      float: left;
      width: 100%;
      height: 12px;
      line-height: 12px;
      margin-top: 10px;

      border-right: 1px solid #ccc;
    }
    .uls {
      width: 79px;
      background: #fff;
      position: absolute;
      top: 29px;
      left: 0;
      border: 1px solid #f1f1f1;
      border-top: 0;
      li {
        width: 100%;
        height: 24px;
        color: #656565;
        font-size: 12px;
        line-height: 24px;
        a {
          border-right: 0;
          color: #656565;
          font-size: 12px;
        }
        &:hover a {
          color: red;
        }
      }
      li:last-child {
        margin-bottom: 5px;
      }
    }

    .afirst {
      border-left: 1px solid #ccc;
    }
    .alast {
      border-right: 0;
    }
  }
}
.youhello {
  line-height: 38px;
  font-size: 12px;
  .user_name {
    margin-right: 5px;
  }
  .jumpTo {
    color: #333333;
  }
}

nav {
  width: 1200px;
  height: 105px;
  margin: 0 auto;
  position: relative;
  .logo {
    margin-top: 26px;
    float: left;
  }
  .buyCarText {
    font-size: 23px;
    position: absolute;
    top: 36px;
    left: 200px;
  }
  .middle {
    margin-top: 35px;
    width: 540px;
    position: absolute;
    right: 0;
    cursor: pointer;
    .inp {
      width: 540px;
      height: 34px;
      /*border: 2px solid #b5a069;*/
      float: left;
      padding: 0;
      .dianpu {
        height: 34px;
        width: 68px;
        float: left;
        border-right: 1px solid #ccc;
        line-height: 32px;
        border-bottom: 2px solid red;
        border-top: 2px solid red;
        border-left: 2px solid red;
        span {
          margin-left: 10px;
        }
        i {
          margin-left: 2px;
        }
      }
      input {
        width: 385px;
        height: 100%;
        border-bottom: 2px solid red;
        border-top: 2px solid red;
        border-right: 2px solid red;
        float: left;
        padding-left: 8px;
      }
      .search {
        width: 75px;
        height: 100%;
        float: left;
        background-color: red;
        color: #fff;
        text-align: center;
        line-height: 34px;
      }
    }
    ul {
      float: left;
      margin-top: 8px;
      li {
        float: left;
        margin-right: 14px;
        cursor: pointer;
        &:hover a {
          color: red;
        }
        a {
          color: #ababab;
        }
      }
    }
  }
}
</style>