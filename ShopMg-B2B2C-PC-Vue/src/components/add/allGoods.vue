<template>
  <div class="yuyin">
    <head-com></head-com>
    <div class="center">
      <div class="header">
        <img class="l" src="../../assets/img/fangzi.jpg" />
        <span class="shouye" @click="$router.push('home')">首页></span>
        <span class="xiala">{{crumbs}}</span>
      </div>
      <!-- 热卖推荐 -->
      <hot-sale></hot-sale>
      <div class="choose">
        <div class="g-main-n l">
          <span class="l">品 &nbsp;牌：</span>
          <div class="q_class_list l" :class="{active:onoff}">
            <ul class="l" ref="brandHeight">
              <li
                class="l text1-hidden"
                v-for="(item, index) in selectGoods.brand"
                :key="index"
                @click="selectBrand(item.id, index)"
                :class="selected.brandIndex === index ? 'active' : '' "
              >{{item.brand_name}}</li>
            </ul>
          </div>
          <i
            @click="open(1)"
            v-if="show"
            :class="{'el-icon-arrow-up':onoff}"
            class="el-icon-arrow-down g-btn"
          ></i>
        </div>
        <div class="g-main-n l">
          <span class="l">价 &nbsp;格：</span>
          <div class="q_class_list l" :class="{active:onoff1}">
            <ul class="l" ref="priceHeight">
              <li
                class="l"
                v-for="(item, index) in selectGoods.price"
                :key="index"
                @click="getPrice(item, index)"
                :class="selected.priceIndex === index ? 'active' : '' "
              >{{item}}</li>
            </ul>
          </div>
          <i
            @click="open(2)"
            v-if="show1"
            :class="{'el-icon-arrow-up':onoff1}"
            class="el-icon-arrow-down g-btn"
          ></i>
        </div>
        <div class="g-main-n l" v-if="drinkNo&& drinkNo.length">
          <span class="l">分 &nbsp;类：</span>
          <div class="q_class_list l">
            <ul class="l">
              <li
                class="l"
                v-for="(classData, index) in drinkNo"
                :key="index"
                @click="searchByClass(index, classData)"
                :class="selected.colorIndex === index ? 'active' : '' "
              >{{classData.class_name}}</li>
            </ul>
          </div>
          <i class="el-icon-arrow-down g-btn"></i>
        </div>
      </div>
      <div class="new">
        <div class="left l">
          <!-- 新品推荐 -->
          <new-product></new-product>
        </div>
        <div class="right r">
          <div class="top">
            <ul class="theard l">
              <li>排列方式：</li>
              <li @click="tab(3)" :class="{actives:isactive == 3}">默认</li>
              <li
                class="li"
                v-for="(orderBy,index) in selectGoods.theard"
                @click="tab(index, orderBy)"
                :key="index"
                :class="[isactive === index ? 'active' : '']"
              >
                <span>{{orderBy.name}}</span>
                <img
                  v-if="isactive === index"
                  src="../../assets/img/Xiajiantou1.png"
                  :style="selected.theard[index] ? 'transform: rotate(0deg)' : 'transform: rotate(180deg)'"
                  alt
                />
                <img v-if="isactive !== index" src="../../assets/img/xiajiantou.png" alt />
              </li>
            </ul>
            <div class="ziying l">
              <input class="l" type="checkbox" :checked="selfSupportChecked" @click="selfSupport" />平台自营
            </div>
            <div class="l shangpin">
              商品所在地：
              <select class="r" name>
                <option value>不限地区</option>
                <option v-for="(item, index) in city" :key="index">{{item.name}}</option>
              </select>
            </div>
          </div>
          <div class="goodsArea">
            <ul class="l">
              <li class="bagli l" v-for="(li,i) in list" :key="i">
                <img class="bag" :src="URL+li.pic_url" @click="toDetail(li.id)" />

                <p @click="toDetail(li.id)" class="l">{{li.title}}</p>
                <div class="l pice">
                  <span>￥{{li.price_member}}</span>
                  <span>￥{{li.price_market}}</span>
                </div>
                <div class="buy l">
                  <span @click.stop="compare(li.id)">
                    <label>
                      <input class="l" type="checkbox" />
                      <span>对比</span>
                    </label>
                  </span>
                  <span
                    v-if=" !li.hasOwnProperty('is_collect') || li.is_collect == 0"
                    @click.stop="toCollect(li.id,i)"
                    class="g-collection"
                  >
                    <i class="l like"></i>
                    <span>收藏</span>
                  </span>
                  <span
                    v-else-if="li.is_collect == 1"
                    class="g-collection"
                    @click.stop="toCollect(li.id,i)"
                  >
                    <i class="l like cancel"></i>
                    <span>已收藏</span>
                  </span>
                </div>
                <i class="r car" @click.stop="addCar(li.id, li.price_member, li.store_id)"></i>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="fenye" v-show="list.length !== 0">
        <div class="box2">
          <el-pagination
            @current-change="handleCurrentChange"
            background
            layout="total,prev, pager, next,jumper"
            :page-size="page_size"
            :total="page_count"
          ></el-pagination>
        </div>
      </div>
      <like-and-history></like-and-history>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>
import hotSale from "../../common/hotSale.vue";
import newProduct from "../../common/newProduct.vue";
export default {
  components: {
    hotSale,
    newProduct
  },
  data() {
    return {
      selfSupportChecked: false,
      selectGoods: {
        brand: [],
        price: ["0-500", "500-1000", "1000-2500"],
        color: ["黑色", "蓝色"],
        theard: [
          { name: "销量", key: "sales_sum" },
          { name: "人气", key: "comment_member" },
          { name: "价格", key: "price_member" }
        ]
      },
      selected: {
        brandIndex: null,
        priceIndex: null,
        colorIndex: null,
        theard: [false, false, false]
      },
      pinpais: [],
      lis: [],
      isactive: 3,
      isbg: "",
      iscolorur: "",
      basebox: [],
      base: [],
      params: {
        brand_id: undefined,
        price: undefined,
        class_id: undefined
      },
      searchData: [],
      city: [],
      list: "",
      show: false,
      show1: false,
      onoff: false,
      onoff1: false,
      page_count: 0, //共多少条
      page_size: 20, //展示几条
      drinkNo: {},
      classArray: [],
      crumbs: "全部商品",
      page: 1
    };
  },
  created() {
    this.drinkNo = JSON.parse(localStorage.getItem("chirld_class"));

    if (this.$route.query.hasOwnProperty("name")) {
      this.crumbs = decodeURIComponent(this.$route.query.name);
      // 兼容具体分类
      this.searchData.push({
        id: this.$route.query.id,
        fid: this.$route.query.level
      });

      this.params.class_id = this.$route.query.id;
    }
  },
  mounted() {
    this.getCity();
    this.getList();
    this.getBrandList();
    this.getHotCommodities();

    this.show = this.$refs.brandHeight.clientHeight > 55 ? true : false;
    this.show1 = this.$refs.priceHeight.clientHeight > 55 ? true : false;
  },
  methods: {
    getClassId() {
      return this.params.class_id;
    },
    // 分类 she
    // 品牌筛选
    selectBrand(brandId, index) {
      this.selected.brandIndex = index;
      this.params.brand_id = ~~brandId;
      this.getList();
    },
    // 获取品牌
    getBrandList() {
      this.HTTP(this.$httpConfig.getBrandList, {}, "post")
        .then(res => {
          if (res.status) this.selectGoods.brand = res.data;
        })
        .catch(err => {
          throw err;
        });
    },
    // 获取城市
    getCity() {
      this.HTTP(this.$httpConfig.regionLists, { parent_id: 0 }, "post")
        .then(res => {
          this.city = res.data;
        })
        .catch(err => {
          throw err;
        });
    },
    selfSupport() {
      this.selfSupportChecked = !this.selfSupportChecked;

      if (this.selfSupportChecked) {
        this.params.type = 1;
      } else {
        delete this.params.type;
      }

      this.getList();
    },

    /**
     * 根据分类搜索
     */
    searchByClass(index, classData) {
      if (this.searchData.length > 0) {
        let flag = 0;

        for (let i = 0; i < this.searchData.length; i++) {
          if (this.searchData[i].id === classData.fid) {
            this.searchData.push({
              id: classData.id,
              fid: classData.fid
            });
          } else {
            flag++;
          }
        }
        let classId = this.searchData
          .map(args => {
            return args.id;
          })
          .join("-");

        if (this.searchData.length >= 3) {
          this.searchData.pop();
        }
        this.params.class_id = classId;
      } else {
        this.searchData.push({
          id: classData.id,
          fid: classData.fid
        });
        this.params.class_id = classData.id;
      }

      this.HTTP(this.$httpConfig.getClass, { id: classData.id }, "post").then(
        res => {
          if (res.status === 1) {
            this.drinkNo = res.data;
          }
        }
      );

      this.getList();
      // console.log(this.searchData );
    },
    open(s) {
      if (s == 1) {
        this.onoff = !this.onoff;
      } else {
        this.onoff1 = !this.onoff1;
      }
    },
    // 获取店铺商品排行榜
    getHotCommodities() {
      
    },
    /*页面跳转*/
    handleCurrentChange(currentPage) {
      this.page = currentPage;
      this.getList();
    },
    tab(index, item) {
      console.log(index);
      this.isactive = index;
      if (index !== 3) {
        this.selected.theard[index] = !this.selected.theard[index];
        this.$set(this.selected.theard, index, this.selected.theard[index]);

        this.params["sort_" + item.key] = Number(this.selected.theard[index]);

        this.getList();
      } else {
        this.params = {
          class_id: this.$route.query.class_id
        };
        this.getList();
      }
    },
    getPrice(item, index) {
      this.params.price_member = item;
      this.selected.priceIndex = index;
      this.getList();
    },
    change(index) {
      this.isbg = index;
      this.iscolorur = index;
    },
    flushCom() {
      this.$router.go(0);
    },
    // 获取列表
    getList() {
      this.params.page = this.page;

      this.HTTP(this.$httpConfig.getGoodsList, this.params, "post")
        .then(res => {
          if (res.status === 0) {
            this.list = [];
            return;
          }

          this.list = res.data.list;
          for (var i in this.list) {
            this.list[i].selectedIndex = 0;
          }
          this.page_count = Number(res.data.count);
          this.page_size = parseInt(res.data.page_size);
        })
        .catch(err => {
          throw err;
        });
    },
    showBigImg(index, value) {
      this.$forceUpdate();
      this.$set(this.list[index], "selectedIndex", value);
      this.$set(
        this.list[index],
        "oneIMg",
        this.list[index].pic_url[value].pic_url
      );
    },
    // 加入收藏夹
    toCollect(id, index) {
      this.HTTP(
        this.$httpConfig.setCollectionGoods,
        {
          goods_id: id
        },
        "post"
      )
        .then(res => {
          console.log(res);
          if (res.message == "收藏成功") {
            this.list[index].is_collect = 1;
          } else {
            this.list[index].is_collect = 0;
          }

          // this.$forceUpdate();
        })
        .catch(err => {
          throw err;
        });
    },
    // 去详情页
    toDetail(id) {
      window.open(window.location.origin + "/inroyaldrink?id=" + id);
    },
    // 加入购物车
    addCar(id, price, storeId) {
      var params = {
        goods_id: id,
        goods_num: 1,
        price_new: price,
        store_id: storeId
      };
      this.HTTP(this.$httpConfig.addGoodToCart, params, "post", false).then(
        res => {
          this.$confirm("", "已成功加入购物车", {
            confirmButtonText: "查看购物车",
            cancelButtonText: "继续购物",
            type: "success",
            center: true,
            lockScroll: false,
            closeOnClickModal: false,
            confirmButtonClass: "to-shopping-cart",
            cancelButtonClass: "continue-shopping"
          })
            .then(() => {
              window.open(window.location.origin + "/buyCar");
            })
            .catch(() => {});
        }
      );
    },
    // 比较
    compare(id) {
      console.log("暂不做");
    }
  }
};
</script>
<style>
.el-message-box--center {
  padding-bottom: 50px;
}

.el-message-box--center .el-message-box__header {
  padding-top: 50px;
}

.el-button {
  font-size: 14px;
  font-weight: inherit;
}

.continue-shopping {
  padding: 13px 30px !important;
}

.continue-shopping:hover {
  color: #606266;
  border: 1px solid #dcdfe6;
  background-color: #fff;
}

.to-shopping-cart {
  background-color: red !important;
  border: 1px solid red !important;
  padding: 13px 26px !important;
}

.to-shopping-cart:hover {
  background-color: red !important;
  color: #fff !important;
}
</style>

<style lang="less" scoped>
.active {
  color: red;
}
.l {
  float: left;
}

.r {
  float: right;
}

.center {
  width: 1190px;
  margin: 0 auto;
  height: 100%;
}

.header {
  height: 46px;
  line-height: 46px;
  font-size: 14px;
  color: #636260;
  img {
    margin: 17px 7px 0 0;
  }
  .xiala {
    display: inline-block;
    width: 82px;
    height: 23px;
    // border: 1px solid #d1d1d1;
    color: #333;
    text-align: center;
    line-height: 23px;
    // margin-left: 7px;
    position: relative;
    cursor: pointer;
    a {
      color: #636260;
    }
  }
}

.choose {
  overflow: hidden;
  background: #fff;
  border: 1px solid #e5e5e5;
  margin-bottom: 10px;
  .g-main-n:last-child {
    border-bottom: none;
  }
  .g-main-n {
    width: 100%;
    overflow: hidden;
    padding-left: 24px;
    border-bottom: 1px dashed #f5f5f5;
    position: relative;
    .q_class_list {
      height: 55px;
      width: 90%;
      overflow: hidden;
      ul {
        li {
          // margin-right: 47px;
          line-height: 55px;
          margin-right: 20px;
          cursor: pointer;
          &:hover {
            color: red;
          }
        }
      }
    }
    .q_class_list.active {
      height: auto;
    }
    .g-btn {
      position: absolute;
      top: 22px;
      right: 50px;
      cursor: pointer;
      &:hover {
        color: red;
      }
    }
  }
  span {
    line-height: 55px;
    font-size: 12px;
    color: #bababa;
  }
}
.new {
  overflow: hidden;
  /*height: 300px;*/
  .right {
    width: 982px;
    .top {
      height: 42px;
      background: #f9f9f9;
      border: 1px solid #e3e3e3;
      .theard {
        li {
          float: left;
          text-align: center;
          line-height: 40px;
          font-size: 12px;
          color: #555;
          border-right: 1px solid #e3e3e3;
          // box-sizing: border-box;
          width: 60px;
          height: 40px;
          cursor: pointer;
        }
        li:nth-of-type(1) {
          width: 74px;
        }
        li:nth-of-type(2) {
          width: 49px;
        }
        // .li {
        //   background: url(../../assets/img/xiajiantou.png) no-repeat top 17px
        //     right 8px;
        // }
        .active {
          // background: #fff url(../../assets/img/Xiajiantou1.png) no-repeat top
          //   17px right 8px !important;
          background: white;
          color: red;
        }
        .actives {
          background: #fff;
          color: red;
          // height: 39px;
        }
      }
      .ziying {
        margin-left: 52px;
        line-height: 40px;
        font-size: 12px;
        input {
          margin: 14px 7px 0 0;
        }
      }
      .shangpin {
        line-height: 40px;
        margin-left: 78px;
        font-size: 12px;
        select {
          height: 20px;
          width: 78px;
          margin-top: 10px;
          outline: none;
          option {
            font-size: 12px;
          }
        }
      }
      .next {
        margin: 9px 16px 0 0;
        span {
          width: 48px;
          height: 20px;
          border: 1px solid #e5e5e5;
          font-size: 12px;
        }
      }
    }
    .goodsArea {
      margin-top: 20px;
      overflow: hidden;
      ul {
        .bagli {
          width: 230px;
          height: 360px;
          background: #fff;
          border: 1px solid #fff;
          box-sizing: border-box;
          margin-bottom: 15px;
          margin-left: 20px;
          .bag {
            margin: 5px;
            width: 220px;
            height: 220px;
            cursor: pointer;
          }
          .samllul {
            margin: 6px 5px;
            height: 30px;
            display: block;
            width: 100%;
            overflow: hidden;
            box-sizing: border-box;
            li {
              box-sizing: border-box;
              margin-right: 8px;
              // border: 1px solid #ddd;
              img {
                width: 28px;
                height: 28px;
              }
            }
            li.active {
              border-color: red;
            }
            li:last-child {
              margin-right: 0;
            }
          }
          .pice {
            width: 100%;
            margin-top: 10px;
            margin-left: 10px;
            span:nth-of-type(1) {
              color: #de2d35;
              font-size: 16px;
            }
            span:nth-of-type(2) {
              color: #9c9c9c;
              margin-left: 5px;
              font-size: 9px;
              text-decoration: line-through;
            }
          }
          p {
            cursor: pointer;
            width: 210px;
            height: 40px;
            line-height: 20px;
            font-size: 14px;
            color: #5f5f5f;
            margin-left: 10px;
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
          .buy {
            margin: 10px 0 0 10px;
            input {
              margin: 2px 7px 0 0;
            }
            span {
              color: #717171;
              font-size: 12px;
              float: left;
              cursor: pointer;
            }
            .g-collection {
              margin-left: 10px;
            }
            img {
              width: 17px;
              height: 17px;
            }
          }
          .car {
            margin: 0px 14px 0 0;
            width: 30px;
            height: 30px;
            cursor: pointer;
            background: url(../../assets/img/buyCart.png) no-repeat;
            background-size: 100% 100%;
          }
          &:hover {
            border: 1px solid red;
            box-sizing: border-box;
            box-shadow: 1px 1px 4px #999;
          }
        }
        .bagli:nth-of-type(1) {
          margin-left: 0;
        }
        .bagli:nth-of-type(5) {
          margin-left: 0;
        }
        .bagli:nth-of-type(9) {
          margin-left: 0;
        }
        .bagli:nth-of-type(13) {
          margin-left: 0;
        }
        .bagli:nth-of-type(17) {
          margin-left: 0;
        }
      }
    }
  }
}
.fenye {
  width: 100%;
  overflow: hidden;
  .box2 {
    width: 23%;
    margin: 0 auto;
  }
}
</style>