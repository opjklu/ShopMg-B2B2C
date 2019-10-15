<template>
  <div class="collect">
    <logo-component></logo-component>
    <div class="center">
      <!-- 商品收藏 -->
      <div class="top">
        <div class="l">
          <span @click="fun(0)" :class="{active:isactive==0}">商品收藏 ({{goodsList.length||0}})</span>
          <span @click="fun(1)" :class="{active:isactive==1}">店铺收藏 ({{shopList.length||0}})</span>
        </div>
        <div class="r">
          <div v-if="goodsList.length != 0" class="l">
            <div class="l" v-show="operationStyle">
              <p class="l all" @click="choose" v-show="show">
                <input class="l" :checked="checked" type="checkbox" />全选
              </p>
              <p class="l del" @click="batchDelet" v-show="show">
                <img src="../../assets/img/delete_z1.png" />删除
              </p>
              <p class="l operation" @click="manage">{{operation}}</p>
            </div>
          </div>
          <p class="l inp">
            <input type="text" @keyup.enter="search" v-model="content" />
            <span @click="search">
              <i class="el-icon-search"></i>
            </span>
          </p>
        </div>
      </div>
      <!-- 店铺收藏 -->
      <div class="bottom">
        <div class="unit" v-for="(store,index) in shopList" :key="index" v-show="isactive==1">
          <div class="left l">
            <img class="l shop-logo" :src=" URL + store.store_logo" />
            <div class="name l">
              <p>{{store.shop_name}}</p>
              <p class="l">
                <span class="huise l">区域：</span>
                <span class="l region">{{store.prov}} {{store.city}}</span>
              </p>
              <br />
              <p class="l">
                <span class="huise l">主营：</span>
                <!-- <ul class="l"><li class="l lanse" v-for="zhuying in store.zhuying">{{zhuying}}</li></ul> -->
              </p>
              <br />
              <div class="btn l">
                <span class="button" @click="toStore(store.id)">进入店铺</span>
                <span class="button">联系我们</span>
              </div>
            </div>
            <div class="l del" @click="storeDel(store.store_id)">
              <p class="l">
                <i class="del-img"></i>取消收藏
              </p>
            </div>
          </div>
          <div class="right r">
            <ul class="clearfix">
              <li
                @click="toDetail(goods.id)"
                class="l"
                v-for="(goods,index) in store.goods"
                :key="index"
              >
                <img v-lazy="URL + goods.pic_url" />
                <p class="text2-hidden">{{goods.title}}</p>
                <span>￥ {{goods.price_member}}</span>
              </li>
            </ul>
          </div>
        </div>
        <div v-show="isactive==0" class="c-goods-list">
          <ul class="clearfix">
            <li
              :class="{active:items.isSelected}"
              v-for="(items,index) in goodsList"
              :key="items.id"
              @click="choice(items,index)"
            >
              <div class="del-g" v-if="prevent" @click.stop="deletCollection(items,index)">
                <div class="storey"></div>
                <i class="s-check"></i>
              </div>
              <div v-show="mask_show" class="item-mask"></div>
              <i v-show="mask_show" class="check"></i>
              <div class="goods-info">
                <img class="img" @click="toDetail(items.goods_id)" v-lazy=" URL+ items.pic_url" />
                <p @click="toDetail(items.goods_id)">{{items.title}}</p>
                <p>￥{{items.price_member}}</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="base">
        <div class="up">
          <span class="l border">猜您喜欢</span>
          <div class="r change" @click="getLikeGoods">
            <span class="r">换一批</span>
            <img class="r" src="../../assets/img/huanyipi.jpg" />
          </div>
        </div>
        <div class="down">
          <ul class="clearfix">
            <li @click="toDetail(like.gid)" v-for="(like,index) in likeList" :key="index">
              <img v-lazy=" URL +like.pic_url" />
              <p class="text2-hidden title">{{like.title}}</p>
              <p>￥{{like.price_member}}</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>
import { TimeInterval } from "../../../es6/time.js";

export default {
  data() {
    return {
      content: "",
      operationStyle: true,
      checked: false,
      prevent: true,
      mask_show: false,
      show: false,
      operation: "批量操作",
      isactive: "",
      count: {},
      goodsList: [],
      shopList: [],
      likeList: [],
      logo_name: "",
      current_page: 1,
      page_param: {
        count: 0,
        page_size: 0
      }
    };
  },
  created() {
    this.getGoods();
    this.getLikeGoods();
    this.getStoreCollection();
    // this.collectionNumber();
    let data = TimeInterval.getItem("web_info");

    if (data) {
      this.logo_name = this.URL + data.logo_name;
    }
  },
  mounted() {},
  methods: {
    getTitle() {
      return "我的收藏";
    },
    // 去详情页
    toDetail(id) {
      window.open(window.location.origin + "/inroyaldrink?id=" + id);
    },
    //商品搜索和店铺搜索
    search() {
      if (this.content == "") return;
      if (this.operationStyle == true) {
        this.HTTP(
          this.$httpConfig.commoditySearch,
          {
            title: this.content,
            page: 1
          },
          "post"
        ).then(res => {
          this.goodsList = res.data;
          for (var i in this.goodsList) {
            this.goodsList[i].isSelected = false;
          }
        });
      } else {
        console.log(this.content);
        this.HTTP(
          this.$httpConfig.myStoreFollowSearch,
          {
            shop_name: this.content
          },
          "post"
        ).then(res => {
          this.shopList = res.data;
        });
      }
    },
    //店铺删除
    storeDel(id) {
      this.$confirm("是否取消收藏该店铺?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning",
        lockScroll: false,
        center: true,
        closeOnClickModal: false
      })
        .then(() => {
          this.HTTP(
            this.$httpConfig.myStoreFollowDel,
            {
              id: id
            },
            "post"
          ).then(res => {
            this.getStoreCollection();
            // this.collectionNumber();
          });
        })
        .catch(() => {});
    },
    //单个删除收藏
    deletCollection(item, index) {
      this.$confirm("是否取消收藏该商品?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning",
        lockScroll: false,
        center: true,
        closeOnClickModal: false
      })
        .then(() => {
          this.HTTP(
            this.$httpConfig.collectionDel,
            {
              id: item.id
            },
            "post"
          ).then(res => {
            this.getGoods();
            // this.collectionNumber();
          });
        })
        .catch(() => {});
      console.log(item);
    },
    //批量删除
    batchDelet() {
      let goodsId = [];
      for (let index = 0; index < this.goodsList.length; index++) {
        if (this.goodsList[index].isSelected == true) {
          goodsId.push(this.goodsList[index].id);
        }
      }
      if (goodsId.length == 0) {
        return;
      } else {
        this.$confirm("是否删除选中的商品?", "提示", {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
          lockScroll: false,
          center: true,
          closeOnClickModal: false
        })
          .then(() => {
            this.HTTP(
              this.$httpConfig.collectionDel,
              {
                id: goodsId.join()
              },
              "post"
            ).then(res => {
              // this.collectionNumber();
              this.getGoods();
            });
          })
          .catch(() => {});
      }

      console.log(goodsId.join());
    },
    //选中多个
    choice(items, index) {
      if (this.mask_show == false) {
        return;
      }
      //手动更新视图
      this.$forceUpdate();
      if (items.isSelected == false) {
        items.isSelected = true;
        this.$set(this.goodsList[index], "isSelected", true);
      } else {
        this.$set(this.goodsList[index], "isSelected", false);
      }
    },
    //全选
    choose() {
      if (this.checked == false) {
        for (let index = 0; index < this.goodsList.length; index++) {
          this.goodsList[index].isSelected = true;
        }
        this.checked = true;
      } else {
        for (let index = 0; index < this.goodsList.length; index++) {
          this.goodsList[index].isSelected = false;
        }
        this.checked = false;
      }
    },
    manage() {
      if (this.operation === "批量操作") {
        this.operation = "完成";
        this.show = true;
        this.mask_show = true;
        this.prevent = false;
      } else {
        this.operation = "批量操作";
        this.checked = false;
        this.initList(); //初始化列表
        this.show = false;
        this.mask_show = false;
        this.prevent = true;
      }
    },
    initList() {
      for (let index = 0; index < this.goodsList.length; index++) {
        if (this.goodsList[index].isSelected == true) {
          this.goodsList[index].isSelected = false;
        }
      }
    },
    fun(index) {
      this.content = "";
      this.isactive = index;
      if (index == 0) {
        this.operationStyle = true;
        this.getGoods();
      } else {
        this.operationStyle = false;
        this.getStoreCollection();
      }
    },
    toStore(id) {
      window.open(window.location.origin + "/storehome?id=" + id);
    },

    //商品收藏
    getGoods() {
      this.HTTP(
        this.$httpConfig.myCollectionGoods,
        {
          page: this.current_page
        },
        "post"
      )
        .then(res => {
          this.goodsList = res.data.data;
          for (var i in this.goodsList) {
            this.goodsList[i].isSelected = false;
          }

          this.page_param = {
            count: res.data.count,
            page_size: res.data.page_size
          };
        })
        .catch(res => {
          this.goodsList = [];
        });
    },
    //店铺收藏
    getStoreCollection() {
      this.HTTP(this.$httpConfig.myCollectionStore, {}, "post")
        .then(res => {
          this.shopList = res.data;
        })
        .catch(() => {
          this.shopList = [];
        });
    },
    //猜你喜欢
    getLikeGoods() {
      this.HTTP(this.$httpConfig.myCollectionLike, {}, "post").then(res => {
        this.likeList = res.data;
      });
    }
  }
};
</script>

<style lang="less" scoped>
.logo {
  margin-top: 26px;
  float: left;
  width: 143px;
  height: 50px;
}
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
}

.header {
  height: 108px;
  img {
    margin: 28px 20px 0 0;
    float: left;
  }
  span {
    font-size: 23px;
    font-weight: 600;
    float: left;
    margin-top: 39px;
  }
}

.top {
  height: 43px;
  line-height: 41px;
  border-bottom: 2px solid #e6e6e6;
  div.l {
    span {
      display: inline-block;
      width: 132px;
      text-align: center;
      margin-right: 8px;
      cursor: pointer;
    }
    .active {
      border-bottom: 2px solid red;
      color: red;
    }
  }
  div.r {
    overflow: hidden;
    .all {
      font-size: 12px;
      color: #666;
      margin-right: 24px;
      cursor: pointer;
      input {
        margin: 14px 6px 0 0;
      }
    }
    .del {
      font-size: 12px;
      color: #666;
      margin-right: 19px;
      cursor: pointer;
      img {
        float: left;
        margin: 13px 6px 0 0;
      }
    }
    .operation {
      width: 68px;
      height: 27px;
      text-align: center;
      border: 1px solid #dcdcdc;
      font-size: 12px;
      color: #666;
      line-height: 27px;
      margin-top: 7px;
      cursor: pointer;
    }
    .inp {
      width: 157px;
      height: 27px;
      border: 1px solid #dcdcdc;
      line-height: 27px;
      margin: 7px 0 0 11px;
      input {
        width: 128px;
        height: 25px;
        float: left;
        border-right: 1px solid #dcdcdc;
        padding-left: 10px;
      }
      span {
        cursor: pointer;
        float: left;
        width: 27px;
        height: 25px;
        background: #f5f5f5;
        text-align: center;
        line-height: 25px;
      }
    }
  }
}

.bottom {
  min-height: 472px;
  margin-top: 10px;
  .unit {
    height: 230px;
    border-bottom: 1px solid #d8d8d8;
    margin-top: 10px;
    .left {
      // width:702px;
      float: left;
      margin-top: 14px;
      .shop-logo {
        width: 120px;
        height: 120px;
      }
      .name {
        margin-left: 12px;
        p {
          font-size: 12px;
          margin-top: 5px;
          ul {
            width: 384px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
          }
          li {
            font-size: 12px;
            margin-right: 8px;
          }
        }
        p:nth-of-type(1) {
          color: #2d5b96;
          font-size: 14px;
        }
        .huise {
          color: #939393;
        }
        .region,
        .lanse {
          color: #2d5b96;
        }
        .btn {
          margin-top: 23px;
          .button {
            width: 62px;
            height: 22px;
            font-size: 12px;
          }
          .button:nth-of-type(1) {
            background: #feeac5;
            color: #d99156;
            margin-right: 8px;
          }
        }
      }
      .del {
        width: 100%;
        margin-top: 14px;
        p {
          margin-right: 9px;
          cursor: pointer;
          .del-img {
            width: 16px;
            height: 16px;
            float: left;
            margin-right: 13px;
            background: url("../../assets/img/delete_z1.png") no-repeat;
          }
        }
        p:hover {
          color: red;
          .del-img {
            background: url("../../assets/img/delete_z2.png") no-repeat;
          }
        }
      }
    }
    .right {
      margin-top: 21px;
      li {
        width: 136px;
        margin-left: 45px;
        cursor: pointer;
        img {
          width: 136px;
          height: 136px;
        }
        p {
          font-size: 12px;
          color: #676767;
          height: 34px;
          width: 100%;
          line-height: 17px;
          margin-top: 9px;
          &:hover {
            color: red;
          }
        }
        span {
          font-size: 11px;
          color: #e1a147;
          margin-top: 2px;
          display: block;
        }
      }
      li:first-child {
        margin-left: 0;
      }
    }
  }
  .c-goods-list {
    ul {
      li {
        width: 150px;
        margin: 2px 25px 0 0;
        float: left;
        position: relative;
        .del-g {
          display: none;
          .storey {
            position: absolute;
            top: 0px;
            right: 0px;
            width: 25px;
            height: 25px;
            background: #ffd700;
            opacity: 0.6;
          }
          .s-check {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 15px;
            height: 16px;
            background: url("../../assets/img/css_sprites.png") no-repeat -4px -53px;
          }
        }
        .mask-g {
          position: absolute;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          background: transparent;
        }
        .item-mask {
          position: absolute;
          top: 0px;
          right: 0px;
          left: 0;
          bottom: 0;
        }
        .check {
          position: absolute;
          top: 0px;
          right: 0px;
          width: 40px;
          height: 40px;
          background: url("../../assets/img/css_sprites.png") no-repeat -55px -5px;
        }
        .goods-info {
          .img {
            cursor: pointer;
            width: 150px;
            height: 150px;
          }
          p {
            float: left;
            text-align: center;
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-align: center;
          }
          p:nth-of-type(1) {
            margin-top: 12px;
            cursor: pointer;
            &:hover {
              color: red;
            }
          }
          p:nth-of-type(2) {
            margin-top: 9px;
            color: #e31939;
          }
        }
        &:hover .del-g {
          display: block;
        }
      }
      li.active {
        .check {
          background-position: -5px -5px;
        }
      }
      li:nth-child(7n) {
        margin: 22px 0 0 0;
      }
    }
  }
}

.base {
  overflow: hidden;
  margin-bottom: 40px;
  .up {
    height: 37px;
    width: 100%;
    line-height: 37px;
    span.l {
      width: 105px;
      line-height: 37px;
      color: #454545;
      text-align: center;
    }
    img {
      margin: 8px 6px 0 0;
    }
    span.r {
      color: #93919e;
      font-size: 12px;
    }
    .border {
      border-bottom: 2px solid #b89f66;
      color: #ba9635 !important;
    }
    .change {
      cursor: pointer;
      img {
        width: 20px;
        height: 20px;
      }
    }
  }
  .down {
    height: 270px;
    width: 100%;
    border: 1px solid #e5e5e5;
    margin-top: 2px;
    ul {
      li {
        width: 168px;
        margin: 17px 15px 0;
        float: left;
        cursor: pointer;
        img {
          width: 100%;
          height: 178px;
        }
        .title {
          height: 34px;
          width: 100%;
          line-height: 17px;
        }
        p {
          font-size: 12px;
          margin-top: 10px;
          margin-bottom: 0;
          &:hover {
            color: red;
          }
        }
        p:nth-of-type(2) {
          color: #b22e2c;
          margin-top: 5px;
        }
      }
    }
  }
}
</style>