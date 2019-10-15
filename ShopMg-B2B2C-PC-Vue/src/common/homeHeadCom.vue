<template>
  <div id="head">
    <common-header></common-header>

    <div class="line">
      <nav>
        <div class="top l">
          <router-link to="/home">
            <img class="logo" :src="URL+logo" />
          </router-link>
          <!-- 搜索框 -->
          <div class="middle">
            <div class="inp">
              <span class="store">
                <el-dropdown trigger="click" size="small" @command="handleCommand">
                  <span class="el-dropdown-link">
                    {{currentSearch}}
                    <i class="el-icon-arrow-down el-icon--right"></i>
                  </span>
                  <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item
                      v-for="(value, i) in searchType"
                      :key="i"
                      :command="i"
                    >{{value}}</el-dropdown-item>
                  </el-dropdown-menu>
                </el-dropdown>
              </span>
              <input type="text" v-model="search_value" @keyup.enter="search" />
              <span class="search" @click="search">搜索</span>
            </div>
            <ul>
              <li v-for="(value,index) in keyWords" :key="index">
                <a @click="hotSearch(value)">{{value.hot_words}}</a>
              </li>
            </ul>
          </div>
          <!-- 我的购物车 -->
          <div class="dropdown-content r">
            <my-shopping-cart></my-shopping-cart>
          </div>
        </div>
        <div class="bottom l">
          <div class="all l" @click="ctrlClass">
            <div class="all-class-ctrl" @click="$router.push({path:'/allGoods', index: 0})">
              <span class="shangpin">所有分类</span>
            </div>
            <!-- <div class="nav-class" v-show="showClassNav" @mouseleave="hideClass"> -->
            <div class="nav-class" @mouseover="showClass" @mouseleave="hideClass">
              <ul class="allul l">
                <li
                  @click.stop.prevent="GoTo(item, 1)"
                  class="li"
                  v-for="(item, index) in iTem"
                  @mouseover="mouseover(item,index,1)"
                  :key="item.id"
                >
                  <a>{{item.class_name}}</a>
                  <i class="el-icon-arrow-right"></i>
                </li>
              </ul>
              <div class="all-child" v-show="showClassNav" @mouseleave="hideClass">
                <ul class="l second" v-for="(item2,i) in childData" :key="i">
                  <p @click="GoTo(item2, 2)">{{item2.class_name}}</p>
                  <div class="third-wrap">
                    <li class="l third" v-for="(item3,j) in item2.children" :key="j">
                      <p @click="GoTo(item3)">{{item3.class_name}}</p>
                    </li>
                  </div>
                </ul>
              </div>
            </div>
          </div>
          <ul class="navul">
            <li v-for="(item,index) in items" :key="index">
              <a @click="toLink(item,index)" :class="{active:index == off}">{{item.nav_titile}}</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      off: 0,
      all: false,
      no: true,
      ok: false,
      items: [],
      cartData: [],
      class_id: 0, //分类ID
      iTem: [],
      condata: [],
      condata2: [],
      condata3: [],
      showClassNav: false,
      searchType: ["宝贝", "店铺"],
      search_value: "",
      currentIndex: 0,
      zGoTo: [],
      childData: [],
      t: 0,
      keyWords: [],
      currentSearch: "",
      searchTypeRouter: ["/goodsSearch", "/storeSearch"]
    };
  },
  computed: {
    ...mapGetters(["logo"])
  },
  created() {
    //搜索类型
    this.currentSearch = this.$route.query.hasOwnProperty("p")
      ? this.searchType[this.$route.query.p]
      : this.searchType[0];

    this.search_value = this.$route.query.title;

    this.getClass();
    //导航
    this.HTTP(this.$httpConfig.nav, {}, "post", false)
      .then(res => {
        this.items = res.data;
      })
      .catch(e => {
        console.log(e);
      });
    this.$route.query.num === undefined
      ? (this.off = 0)
      : (this.off = this.$route.query.num);
  },

  mounted() {
    this.getKeySearchList();
  },

  methods: {
    toLink(item, num) {
      window.location.href = item.link;
    },
    //热词搜索(商品搜索)
    hotSearch(value) {
      this.$router.push({
        path: this.searchTypeRouter[0],
        query: {
          title: value.hot_words,
          class_id: value.goods_class_id,
          types: "hotSearch",
          type: 0
        }
      });
    },

    //搜索栏底部关键词
    getKeySearchList() {
      this.HTTP(this.$httpConfig.getKeyWordsList, {}, "post")
        .then(res => {
          this.keyWords = res.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    GoTo(item, index) {
      this.t++;
      this.$router.push({
        path: "/allGoods",
        query: {
          id: item.id,
          level: item.fid,
          index: index,
          name: encodeURIComponent(item.class_name)
        }
      });
    },
    to(index, url) {},
    handleCommand(command) {
      this.currentSearch = this.searchType[command];

      this.currentIndex = command;
    },
    /**
     * 搜索
     */
    search() {
      if (this.search_value === this.$route.query.title) {
        this.$message("页面已加载");
        this.$router.replace({
          path: this.searchTypeRouter[this.currentIndex],
          query: {
            type: this.currentIndex,
            title: this.search_value
          }
        });
      } else {
        this.$router.replace({
          path: this.searchTypeRouter[this.currentIndex],
          query: {
            type: this.currentIndex,
            title: this.search_value
          }
        });
      }
    },
    showClass() {
      this.showClassNav = true;
    },
    hideClass() {
      this.showClassNav = false;
    },
    ctrlClass() {
      this.showClassNav = !this.showClassNav;
    },
    mouseover(item, index, once) {
      this.showClassNav = true;
      this.succ(item.id, once);
    },
    getClass() {
      this.HTTP(
        this.$httpConfig.getClass,
        {
          id: this.class_id
        },
        "post"
      )
        .then(res => {
          this.iTem = res.data;
          console.log(this.iTem.length);
          if (this.iTem.length > 12) {
            this.iTem = this.iTem.slice(0, 12);
          }
          localStorage.setItem("class", JSON.stringify(res.data));
        })
        .catch(e => {
          console.log(e);
        });
    },
    succ(id) {
      this.HTTP(this.$httpConfig.getChildrenClass, { id: id }, "post").then(
        res => {
          this.childData = res.data;
          localStorage.setItem("chirld_class", JSON.stringify(res.data));
        }
      );
    },

    getGoods(goods, index) {
      this.display = null;
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
.gp-s:hover {
  color: red;
}
nav .bottom .navul li .active {
  color: red;
}

.gp-s {
  color: #666;
  cursor: pointer;
}
.l {
  float: left;
}
.r {
  float: right;
}
.line {
  background: #f2f2f2;
}
nav {
  width: 1190px;
  height: 156.5px;
  margin: 0 auto;
  .top {
    width: 100%;
    height: 114px;
    .logo {
      float: left;
      width: 190px;
      height: 100%;
      box-shadow: 0px 0px 5px #757575;
    }
    .middle {
      margin: 35px 0 0 132px;
      width: 660px;
      float: left;
      .inp {
        width: 660px;
        height: 40px;
        float: left;
        padding: 0;
        .store {
          height: 40px;
          width: 68px;
          float: left;
          background: #fff;
          border: 1px solid #fff;

          box-sizing: border-box;
          span {
            width: 68px;
            height: 40px;
            line-height: 36px;
            margin-left: 10px;
            cursor: pointer;
          }
          i {
            margin-left: 2px;
          }
        }
        input {
          width: 415px;
          height: 100%;
          border-bottom: 1px solid #fff;
          border-top: 1px solid #fff;
          border-right: 1px solid #fff;
          border-left: 1px solid #f2f2f2;
          float: left;
          padding-left: 5px;
        }
        .search {
          width: 75px;
          height: 100%;
          float: left;
          background-color: red;
          color: #fff;
          font-weight: 500;
          text-align: center;
          line-height: 40px;
          cursor: pointer;
        }
      }
      ul {
        float: left;
        margin-top: 8px;
        li {
          float: left;
          margin-right: 14px;
          cursor: pointer;
          a {
            color: #ababab;
          }
          &:hover a {
            color: red;
          }
        }
      }
    }
    .dropdown-content {
      margin-top: 35px;
    }
  }
  .bottom {
    width: 100%;
    .all {
      height: 43px;
      width: 190px;
      background: red;
      line-height: 44px;
      position: relative;
      text-align: center;
      .all-class-ctrl {
        height: 43px;
        width: 190px;
        background: red;
        line-height: 44px;
        position: relative;
        text-align: center;
        cursor: pointer;
        color: #fff;
        font-weight: 540;
        font-size: 16px;
      }

      .nav-class {
        width: 1190px;
        height: auto;
        margin: 0 auto;
        z-index: 999;
        display: flex;
        min-height: 407px;
        .allul {
          position: relative;
          width: 190px;
          height: 100%;
          background: #fff;
          float: left;
          z-index: 999999999;
          border: 2px solid red;
          border-top: none;
          box-sizing: border-box;
          .li {
            z-index: 999999999;
            height: 34px;
            line-height: 34px;
            position: relative;
            i {
              float: right;
              margin: 11px 25px 0 0;
              color: #333;
            }
            a {
              margin-left: 61px;
              font-size: 16px;
              color: #333;
              float: left;
            }

            &:hover {
              i {
                color: red;
              }
              a {
                color: red;
                margin-left: 60px;
              }
            }
          }
        }
        .all-child {
          position: absolute;
          left: 190px;
          top: 43px;
          z-index: 9999;
          background: #fff;
          width: 800px;
          height: 410px;
          border: 1px solid red;
          border-left: none;
          box-sizing: border-box;
          padding: 0 20px;
          p {
            cursor: pointer;
          }
          .second {
            width: 50%;
            box-sizing: border-box;
            line-height: 28px;
            text-align: left;
            margin-top: 20px;
            p {
              font-size: 16px;
              color: #000;
              font-weight: 500;
              margin-bottom: 10px;
              border-bottom: 1px solid #d5d5d5;
              &:hover {
                color: red;
              }
            }
            .third-wrap {
              width: 80%;

              .third {
                height: 24px;
                margin-right: 20px;
                line-height: 24px;
                p {
                  font-size: 14px;
                  color: #333;
                  font-weight: 400;
                  border: none;
                  &:hover {
                    color: red;
                  }
                }
              }
            }
          }
        }
        .banner-image-box {
          width: 780px;
          height: 407px;
          float: left;
          position: relative;
          cursor: pointer;
          font-size: 11px;

          .allul-child {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            right: 130px;
            z-index: 999;
            background-color: #fff;
            z-index: 9999;
            .show {
              z-index: 9999;
              background: #fff;
              border: 2px solid red;
              border-right: none;
              overflow: hidden;
              width: 150px;
              float: left;
              height: 407px;
              p {
                font-size: 14px;
                color: #333;
                width: 100%;
                float: left;
              }
              .item {
                font-size: 13px;
                color: #333;
                margin: 5px;
                line-height: 15px;
                width: 100px;
                text-align: center;
              }
              .li-class2 {
                width: 150px;
                overflow: hidden;
                padding-right: 12px;
                padding-left: 10px;
                float: left;
                p {
                  position: relative;
                  height: 36px;
                  line-height: 36px;
                  font-size: 13px;
                  color: #111;
                }
              }
            }
            .show3 {
              height: 407px;
              float: left;
              background-color: #fff;
              z-index: 9999;
              width: 500px;
              border: 2px solid red;
              .li-class3 {
                width: 33.3%;
                text-align: center;
                overflow: hidden;
                padding-right: 12px;
                padding-left: 10px;
                float: left;
                p {
                  position: relative;
                  height: 36px;
                  line-height: 36px;
                  font-size: 12px;
                  color: #626262;
                }
              }
            }
          }
        }
      }
    }

    .navul {
      margin-left: 230px;
      margin-top: 12px;
      li {
        float: left;
        margin-right: 45px;
        a {
          color: #2b2b2b;
          font-size: 16px;
        }
        .router-link-exact-active {
          color: #e2c670 !important;
        }
      }
    }
  }
}
</style>
