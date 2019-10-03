<template>
  <div id="home" ref="home">
    <home-head-com></home-head-com>
    <div class="banner">
      <div class="banner-center">
        <div class="banner-img">
          <el-carousel :interval="5000" arrow="hover" :height="bannerHeight">
            <el-carousel-item v-for="item in banner" :key="item.id">
              <img :src="URL+item.pic_url" v-on:click="JumpAd(item)" />
            </el-carousel-item>
          </el-carousel>
        </div>
        <keep-alive>
          <right></right>
        </keep-alive>
      </div>
    </div>
    <div class="center">
      <div class="paimai">
        <img class="l" src="../../assets/img/paimai01.jpg" />
        <img class="l" src="../../assets/img/paimai02.jpg" />
        <img class="l" src="../../assets/img/paimai03.jpg" />
        <img class="l" src="../../assets/img/paimai04.jpg" />
        <img class="l" src="../../assets/img/paimai05.jpg" />
      </div>
      <div class="dianpu">
        <div class="left l">
          <img class="l" src="../../assets/img/dianpu.jpg" />
        </div>
        <ul class="r">
          <li class="l right" v-for="(pinpai,index) in pinpais" :key="index">
            <img :src="URL+pinpai.store_logo" />
            <div class="click">
              <span
                @click="$router.push({
                    path: '/storehome',
                    query: {
                      id:pinpai.id
                    }
                  })"
              >点击进入</span>
            </div>
          </li>
          <li class="another" @click="anotherFun">
            <img :src="huanyipi" />
            <p>换一批</p>
          </li>
        </ul>
      </div>
      <div class="gongyi same" v-for="(item,page) in allFloor" :key="page">
        <h1>{{item.floor.class_name}}</h1>
        <div class="floor-wrap">
          <div class="huaping l">
            <img
              class="l classImg"
              v-lazy="item.floor.pic_url === '' ? classImg : URL + item.floor.pic_url"
            />
            <div class="bottom l">
              <ul class="bottomul">
                <li
                  class="l bottomli"
                  @click="entryClass(jingruis)"
                  v-for="(jingruis,index) in item.classTwo"
                  :key="index"
                >{{jingruis.class_name}}</li>
              </ul>
            </div>
          </div>
          <div class="goods-wrap l">
            <div class="goods l">
              <h4>每日上新</h4>
              <img
                v-lazy="!item.goods_news[0] ? noGoodsImg : URL+item.goods_news[0].pic_url"
                @click="entryGoods(item.goods_news[0])"
              />
            </div>
            <div class="goods l">
              <h4>热销爆款</h4>
              <img
                v-lazy="!item.goods_news[1] ? noGoodsImg : URL+item.goods_news[1].pic_url"
                @click="entryGoods(item.goods_news[1])"
              />
            </div>
            <div class="goods l">
              <h4>限时抢购</h4>
              <img
                v-lazy="!item.goods_news[2] ? noGoodsImg : URL+item.goods_news[2].pic_url"
                @click="entryGoods(item.goods_news[2])"
              />
            </div>
            <div class="goods l">
              <h4>猜你喜欢</h4>
              <img
                v-lazy="!item.goods_news[3] ? noGoodsImg : URL+item.goods_news[3].pic_url"
                @click="entryGoods(item.goods_news[3])"
              />
            </div>
          </div>
          <div class="swiper l" @mouseover="stop()" @mouseout="move()">
            <div class="slideshow">
              <el-carousel :interval="5000" arrow="always" :height="imgHeight">
                <el-carousel-item v-for="(img,index) in item.imgArray" :key="index">
                  <img
                    v-lazy="item.middle.length===0 ? img.pic_url : URL + img.pic_url"
                    @click="goto(img)"
                  />
                </el-carousel-item>
              </el-carousel>
            </div>
          </div>
        </div>

        <img
          v-show="(item.button instanceof Array) && item.button.length===0"
          class="bottomnav"
          src="../../assets/img/bottom-img.png"
        />
        <img
          v-show="!item.button.hasOwnProperty('length')"
          class="bottomnav"
          :src="URL+item.button.pic_url"
          @click="goto(item.button)"
        />
      </div>
      <div class="more">
        <span v-show="floorIndex<13" @click="getFloor">加载更多...</span>
      </div>
    </div>
    <foot-com></foot-com>
    <back-top></back-top>
  </div>
</template>

<script>
import $ from "jquery";
import hp from "@/assets/img/hp.jpg";
import ns from "@/assets/img/ns.png";
import chun from "@/assets/img/chun.png";
import maotai from "@/assets/img/maotai.png";
import huanyipi from "@/assets/img/huanyipi.jpg";
import banner1 from "@/assets/img/banner1.jpg";
import banner2 from "@/assets/img/banner2.jpg";
import banner3 from "@/assets/img/banner3.jpg";

export default {
  data() {
    return {
      classImg: hp,
      huanyipi: huanyipi,
      animate: false, //广告滚动处控制
      allFloor: [], //所有楼层的数据
      floorIndex: 1,
      all: false,
      onoff: "",
      noGoodsImg: require("@/assets/img/nogoods.jpg"),
      showClassify: false,
      marksArr: [], //比对图片索引的变量
      imgArray: [{ pic_url: ns }, { pic_url: chun }, { pic_url: maotai }],
      pinpais: [],
      arr: [],
      items: [],
      isactive: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      isBottom: false,
      bannerArr: [banner1, banner2, banner3],
      banner: [],
      bannerHeight: "410px",
      imgHeight: "541px",
      Go: 0,
      page: 0
    };
  },

  created() {
    this.getFloor();

    this.anotherFun();
  },
  mounted() {
    this.getHome();

    document.addEventListener("scroll", this.scrollTop);
  },

  destroyed() {
    document.removeEventListener("scroll", this.scrollTop);
  },

  methods: {
   
    scrollTop() {
      var bot = 700;
      if (
        this.isBottom == false &&
        bot + $(window).scrollTop() >= $(document).height() - $(window).height()
      ) {
        this.isBottom = true;
        if (this.floorIndex < 13) {
          this.floorIndex++;
          this.getFloor();
        }
      }
    },

    //轮播跳转
    goto(img) {
      if (img && img.hasOwnProperty("ad_link")) {
        location.href = img.ad_link;
      }
      return;
    },

    JumpAd(item) {
      location.href = item.ad_link;
    },

    Announcement(id) {
      this.$router.push({
        name: "notice",
        params: {
          id: id
        }
      });
    },

    anotherFun() {
      this.page++;
      this.HTTP(this.$httpConfig.randStore, { page: this.page }, "post").then(
        res => {
          this.pinpais = res.data.data;
        }
      );
    },
    entryClass(jingruis) {
      this.Go++;
      window.open(
        window.location.origin +
          "/goodsClass?class_id=" +
          jingruis.id +
          "&id=" +
          this.Go +
          "&class_name=" +
          jingruis.class_name
      );
    },
    entryGoods(goods) {
      window.open(window.location.origin + "/inroyaldrink?id=" + goods.id);
    },

    stop() {},
    move() {},
    getHome() {
      //获取公告
      this.HTTP(this.$httpConfig.home, {}, "post", false)
        .then(res => {
          console.log(res);
          this.items = res.data.data.announcement;
          if (res.data.data.banner.length === 0) {
            this.banner = this.bannerArr;
          } else {
            this.banner = res.data.data.banner;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },
    /*获取楼层*/
    async getFloor() {
      if (this.floorIndex < 13) {
        await this.HTTP(
          this.$httpConfig.homefLoor,
          {
            page: this.floorIndex
          },
          "post",
          false
        )
          .then(res => {
            //判断数组是否为空，空则假数据
            if (res.data.data.middle.length === 0) {
              res.data.data.imgArray = this.imgArray;
            } else {
              res.data.data.imgArray = res.data.data.middle;
            } //console.log(this);
            let floor = res.data.data;
            floor.goods_news = floor.goods_news.concat(floor.hotGoods);
            floor.goods_news = floor.goods_news.concat(floor.loveGoods);
            floor.goods_news = floor.goods_news.concat(floor.rushGoods);

            this.allFloor.push(res.data.data);
            this.marksArr.push(0);
            for (var i = 0; i < this.floorIndex; i++) {
              this.arr[i] =
                this.allFloor[i].goods_news == []
                  ? []
                  : this.allFloor[i].goods_news;
            }
          })
          .catch(e => {
            console.log(e);
          });

        console.log(this.allFloor[0].goods_news);
        this.isBottom = false;
      }
    },
    scroll() {
      this.animate = true;
      setTimeout(() => {
        this.items.push(this.items[0]);
        this.items.shift();
        this.animate = false;
      }, 500);
    },

    tab(index, page) {
      let init = index;
      this.isactive[page] = init;
      switch (index) {
        case 0:
          {
            this.arr[page] = this.allFloor[page].goods_news;
          }
          break;
        case 1:
          {
            this.arr[page] = this.allFloor[page].hotGoods;
          }
          break;
        case 2:
          {
            this.arr[page] = this.allFloor[page].rushGoods;
          }
          break;
        case 3:
          {
            this.arr[page] = this.allFloor[page].loveGoods;
          }
          break;
        default:
          break;
      }
    }
  },
  components: {
    right: () => import("./components/right")
  }
};
</script>

<style type="text/css" scoped>
.another {
  float: left;
  text-align: center;
  cursor: pointer;
}

.another img {
  margin-top: 5px !important;
  width: 20px !important;
  height: 20px !important;
}
</style>

<style lang="less" scoped>
.center {
  width: 1190px;
  height: 100%;
  margin: 0 auto;
  // border: 1px solid green;
  display: flex;
  justify-content: center;
  flex-direction: column;
}

.l {
  float: left;
}

.r {
  float: right;
}
.w_h {
  width: 140px;
  height: 140px;
}
#home {
  position: relative;

  .banner {
    width: 1190px;
    margin: 0 auto;
    height: 410px;
    .banner-center {
      width: 100%;
      height: 100%;
      position: relative;
      .banner-img {
        position: absolute;
        top: 0;
        left: 200px;
        width: 790px;
        height: 410px;
        img {
          width: 100%;
          height: 100%;
          z-index: 0;
        }
      }
    }
  }
  .paimai {
    width: 1190px;
    margin: 0 auto;
    height: 170px;
    margin-top: 14px;
    overflow: hidden;
    display: flex;
    img {
      margin-right: 10px;
      width: 230px;
      cursor: pointer;
    }
    img:last-child {
      margin: 0;
    }
  }
  .dianpu {
    width: 1190px;
    margin: 0 auto;
    height: 300px;
    margin-top: 14px;
    .left {
      width: 425px;
      height: 300px;
    }
    ul {
      margin-left: 9px;
      width: 752px;
      height: 300px;
      border: 1px solid #d5d5d5;
      background: #fff;
      box-sizing: border-box;
      li {
        width: 150px;
        height: 150px;
        border: 0.5px solid #e8e8e8;
        box-sizing: border-box;
        position: relative;
        img {
          width: 100%;
          height: 100%;
        }
        .click {
          display: none;
          width: 100%;
          height: 100%;
          background: rgba(0, 0, 0, 0.6);
          position: absolute;
          top: 0;
          left: 0;
          cursor: pointer;
          span {
            display: block;
            width: 64px;
            height: 22px;
            background: red;
            line-height: 22px;
            text-align: center;
            border-radius: 15px;
            color: #fff;
            font-size: 12px;
            margin: 64px auto;
          }
        }
        &:hover .click {
          display: block;
        }
      }
    }
  }
  .same {
    border-top: 1px solid #d5d5d5;
    padding-top: 20px;

    margin: 0 auto;
    margin-top: 15px;
    h1 {
      font-size: 24px;
      color: #010101;
      float: left;
      font-weight: 600;
      line-height: 35px;
      width: 778px;
    }
    .floor-wrap {
      margin-top: 55px;
      width: 100%;
      height: 541px;

      .huaping {
        height: 541px;
        width: 330px;
        overflow: hidden;

        .classImg {
          width: 330px;
          height: 541px;
          position: relative;
          top: 0;
          left: 0;
        }
        .bottom {
          height: 100px;
          width: 100%;
          position: relative;
          top: -120px;
          padding-left: 24px;
          .bottomul {
            margin-top: 15px;
            .bottomli {
              width: 82px;
              height: 32px;
              background: #fff;
              border: 2px solid #f2f2f2;
              box-sizing: border-box;
              border-radius: 16px;
              line-height: 30px;
              text-align: center;
              font-size: 12px;
              margin-right: 12px;
              margin-bottom: 12px;
              cursor: pointer;
              &:hover {
                color: red;
                background: #f2f2f2;
              }
            }
          }
        }
      }
      .goods-wrap {
        width: 550px;
        height: 100%;
        background: #fff;
        .goods {
          width: 50%;
          height: 50%;
          border: 1px solid #d2d2d2;
          box-sizing: border-box;
          border-left: none;
          padding-top: 20px;
          &:nth-child(3) {
            border-top: none;
          }
          &:nth-child(4) {
            border-top: none;
          }
          h4 {
            width: 100%;
            text-align: center;
            line-height: 30px;
            font-size: 28px;
            color: 333;
            font-weight: 600;
          }
          img {
            cursor: pointer;
            margin-top: 30px;
            margin-left: 55px;
            width: 160px;
            height: 160px;
            &:hover {
              transform: scale(1.1);
              -webkit-transition: all 0.5s ease 0s;
              transition: all 0.5s ease 0s;
              -moz-transition: all 0.5s ease 0s;
              -o-transition: all 0.5s ease 0s;
            }
          }
        }
      }
      .swiper {
        width: 308px;
        height: 541px;
        background: #fff;
        overflow: hidden;
        position: relative;
        .slideshow {
          width: 308px;
          height: 541px;
          cursor: pointer;
          img {
            width: 100%;
            height: 100%;
          }
        }
      }
      .showul {
        width: 611px;
        height: 488px;
        padding-left: 1px;
        border-right: 1px solid #e7e8e3;
        border-bottom: 1px solid #e7e8e3;
        .showli {
          width: 203px;
          height: 244px;
          cursor: pointer;
          img {
            transition: all 300ms linear 300ms;
            -webkit-transition: all 300ms linear 300ms;
          }
          img:hover {
            -webkit-transform: scale(1.1); /*1.1放大值*/
            -moz-transform: scale(1.1);
            -o-transform: scale(1.1);
            -ms-transform: scale(1.1);
          }
          .hp {
            margin: 15px 0 0 31px;
          }
          .jieshao {
            height: 36px;
            width: 147px;
            line-height: 18px;
            margin: 9px 0 0 31px;
            font-size: 12px;
            color: #656565;
            display: -webkit-box;
            overflow: hidden;
            white-space: normal !important;
            text-overflow: ellipsis;
            word-wrap: break-word;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            &:hover {
              color: red;
            }
          }
          .jiage {
            color: #f64e4d;
            font-size: 13px;
            margin: 12px 0 0 31px;
          }
          .gouwuche {
            width: 30px;
            cursor: pointer;
            height: 30px;
            background: url(../../assets/img/buyCart.png) no-repeat;
            background-size: 100% 100%;
            margin: 4px 28px 0 0;
          }
        }
        .showli:nth-child(3n) {
          border-right: 0;
        }
      }
    }
    .bottomnav {
      width: 100%;
      margin-top: 15px;
      margin-bottom: 20px;
      height: 150px;
      overflow: hidden;
      cursor: pointer;
    }
  }
  .tabul {
    margin-top: 20px;
    border-bottom: 1px solid #c5c1b8;
    .tab {
      width: 98px;
      height: 35px;
      line-height: 35px;
      text-align: center;
      border: 1px solid #e6e8e7;
      margin-right: 10px;
      border-bottom: 1px;
      background: #fff;
      cursor: pointer;
    }
    .active {
      border-color: #c5c1b8;
      transform: translateY(1px);
      border-bottom: 0;
      color: #c5c1b8;
    }
    .tab:last-child {
      margin: 0;
    }
  }

  .more {
    text-align: center;
    height: 48px;
    line-height: 48px;
    color: red;
    font-size: 17px;
    font-weight: bold;
  }
}
</style>