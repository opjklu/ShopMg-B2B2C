<template>
  <div class="yuyin">
    <head-com></head-com>
    <div class="center">
      <div class="header">
        <img class="l" src="../../assets/img/fangzi.jpg" />
        <span class="shouye" @click="$router.push('home')">首页></span>
        <span class="xiala">{{getTopClass($route.query.class_id)}}</span>
    </div>
    <!-- 热卖推荐 -->
    <hot-sale></hot-sale>
    <div class="choose">
      <div class="g-main-n l">
        <span class="l">品 &nbsp;牌：</span>
        <div class="q_class_list l" :class="{active:onoff}">
          <ul class="l" ref="brandHeight">
            <li class="l text1-hidden" v-for="(item, index) in selectGoods.brand" :key="index" @click="selectBrand(item.id, index)" :class="selected.brandIndex === index ? 'active' : '' ">{{item.brand_name}}</li>
          </ul>
        </div>
        <i @click="open(1)" v-if="show" :class="{'el-icon-arrow-up':onoff}" class="el-icon-arrow-down g-btn"></i>
      </div>
      <div class="g-main-n l">
        <span class="l">价 &nbsp;格：</span>
        <div class="q_class_list l" :class="{active:onoff1}">
          <ul class="l" ref="priceHeight">
            <li class="l" v-for="(item, index) in selectGoods.price" :key="index" @click="getPrice(item, index)" :class="selected.priceIndex === index ? 'active' : '' ">{{item}}</li>
          </ul>
        </div>
        <i @click="open(2)" v-if="show1" :class="{'el-icon-arrow-up':onoff1}" class="el-icon-arrow-down g-btn"></i>
      </div>
      <!-- <div class="g-main-n l">
        <span class="l">颜 &nbsp;色：</span>
        <div class="q_class_list l">
          <ul class="l">
            <li class="l" v-for="(color, index) in selectGoods.color" :key="index" @click="selectColor(index)" :class="selected.colorIndex === index ? 'active' : '' ">{{color}}</li>
          </ul>
        </div>
        <i class="el-icon-arrow-down g-btn"></i>
      </div> -->
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
            <li class="li" v-for="(theards,index) in selectGoods.theard" @click="tab(index)" :key="index" :class="[isactive === index ? 'active' : '']">
              <span>{{theards}}</span>
              <img v-if="isactive === index" src="../../assets/img/Xiajiantou1.png" :style="selected.theard[index] ? 'transform: rotate(0deg)' : 'transform: rotate(180deg)'" alt="">
              <img v-if="isactive !== index" src="../../assets/img/xiajiantou.png" alt="">
            </li>
          </ul>
          <div class="ziying l"><input class="l" type="checkbox" :checked="selfSupportChecked" @click="selfSupport" />平台自营</div>
          <div class="l shangpin">
            商品所在地：
            <select class="r" name="">
                  <option value="">不限地区</option>
                  <option v-for="(item, index) in city" :key="index">{{item.name}}</option>
                </select>
          </div>
          <div class="r next">
            <span class="button">上一页</span>
            <span class="button">下一页</span>
          </div>
        </div>
        <div class="bottom">
          <ul class="l">
            <li class="bagli l" v-for='(li,i) in list' :key="i">
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
                <span v-if="li.is_collect == 0" @click.stop="toCollect(li.id,i)" class="g-collection">
                  <i class="l like"></i>
                  <span>收藏</span>
                </span>
                <span v-else class="g-collection" @click.stop="toCollect(li.id,i)">
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
        <el-pagination @current-change="handleCurrentChange" background layout="total,prev, pager, next,jumper" :page-size="page_size" :total="page">
        </el-pagination>
      </div>
    </div>
    <like-and-history></like-and-history>
  </div>
  <foot-com></foot-com>
  </div>
</template>

<script>
  import hotSale from '../../common/hotSale.vue'
  import newProduct from '../../common/newProduct.vue'

  
  export default {
    components: {
      hotSale,
      newProduct
    },
    data() {
      return {
        selfSupportChecked: true,
        selectGoods: {
          brand: [],
          price: ['0-500', '500-1000', '1000-2500'],
          color: ['黑色', '蓝色'],
          theard: ['销量', '人气', '价格'],
        },
        // crumbs_name:sessionStorage.getItem('crumbs'),
        selected: {
          brandIndex: null,
          priceIndex: null,
          colorIndex: null,
          theard: [false, false, false],
        },
        pinpais: [],
        lis: [],
        isactive: 3,
        isbg: '',
        iscolorur: '',
        basebox: [],
        base: [],
        params: {
          class_id: this.$route.query.class_id,
          brand_id: undefined,
          price: undefined,
          sort: undefined,
          page:1,
        },
        city: [],
        list: '',
        hotCommodities: '',
        show: false,
        show1: false,
        onoff: false,
        onoff1: false,
        page: 0, //共多少条
        currentPage: 1, //当前页
        page_size: 20 //每页显示多少条数据
      }
    },
    mounted() {
      this.getCity()
      this.getList()
      this.getBrandList()
      this.getHotCommodities();
        
     
    },
    methods: {
      // 筛选
      selectBrand (brandId, index) {
        this.selected.brandIndex = index
        this.params.brand_id = ~~brandId
        this.getList()
      },
      // 获取品牌
      getBrandList () {
        this.HTTP(this.$httpConfig.getBrandList, {}, 'post').then(res => {
          if (res.status)  {
            this.selectGoods.brand = res.data;

                this.show = this.selectGoods.brand.length > 10 ;
                this.show1 = this.selectGoods.price.length > 55 ;
          }
        })
      },
      // 获取城市
      getCity() {
        this.HTTP(this.$httpConfig.regionLists, {parent_id:0}, 'post').then(res => {
          this.city = res.data
        }).catch(err => {
          throw err
        })
      },
      selfSupport() {
        if (this.selfSupportChecked) {
          this.HTTP(this.$httpConfig.goodsStoreProprietary, {
            brand_id: '1',
            type: 1
          }, 'post').then(res => {
            console.log(res)
          }).catch((e) => {
            console.log(e)
        });
        }
      },
      selectColor(index) {
        alert(index + '暂无api')
      },
      open(s) {
        if (s == 1) {
          this.onoff = !this.onoff;
        } else {
          this.onoff1 = !this.onoff1;
        }
  
      },
      getTopClass(data) {
        let obj = JSON.parse(localStorage.getItem('class'));
        return obj ?  obj[data] .class_name: '';
      },
      // 获取店铺商品排行榜
      getHotCommodities() {
        this.HTTP(this.$httpConfig.getHotCommodities, {}, 'post').then((res) => {
          this.hotCommodities = res.data;
        }).catch(() => {
  
        })
      },
      /*页面跳转*/
      handleCurrentChange(currentPage) {
        console.log(currentPage);
        this.currentPage = currentPage;
        this.getList();
      },
      tab(index) {
        console.log(index)
        this.isactive = index;
        if (index !== 3) {
          this.selected.theard[index] = !this.selected.theard[index]
          this.$set(this.selected.theard, index, this.selected.theard[index])
          
          /*
            1:销量由高到低
            2:销量由低到高
            3:评论次数人气由高到低
            4:评论次数人气由低到高
            5:价格由高到低
            6:价格由低到高
          */
          console.log(this.selected.theard)
          switch (index) {
            case 0:
              this.selected.theard[index] ? this.params.sort = 1 : this.params.sort = 2
              break;
            case 1:
              this.selected.theard[index] ? this.params.sort = 3 : this.params.sort = 4
              break;
            case 2:
              this.selected.theard[index] ? this.params.sort = 5 : this.params.sort = 6
              break;
            default:
              break;
          }
          this.getList();
        } else {
          this.params = {
            class_id: this.$route.query.class_id
          }
          this.getList()
        }
        
      },
      getPrice(item, index) {
        this.params.price = item.replace('-', ',')
        this.selected.priceIndex = index
        this.getList();
      },
      change(index) {
        this.isbg = index
        this.iscolorur = index
      },
      flushCom() {
        this.$router.go(0);
      },
      // 获取列表
      getList() {
        this.HTTP(this.$httpConfig.getGoodsList, this.params, 'post').then((res) => {
          this.list = res.data.list;
        
          this.page = Number(res.data.count);
        }).catch((e) => {
            console.log(e)
        });
      },
      showBigImg(index, value) {
        this.$forceUpdate();
        this.$set(this.list[index], 'selectedIndex', value);
        this.$set(this.list[index], 'oneIMg', this.list[index].pic_url[value].pic_url);
      },
      // 加入收藏夹
      toCollect(id, index) {
        this.HTTP(this.$httpConfig.setCollectionGoods, {
          goods_id: id
        }, 'post').then((res) => {
          console.log(res)
          if (res.message == '收藏成功') {
            this.list[index].is_collect = 1;
          } else {
            this.list[index].is_collect = 0;
          }
          // this.$forceUpdate();
        }).catch((e) => {
            console.log(e)
        });
      },
      // 去详情页
      toDetail(id) {
        window.open(window.location.origin + '/inroyaldrink?id=' + id)
      },
      // 加入购物车
      addCar(id, price, storeId) {
        var params = {
          goods_id: id,
          goods_num: 1,
          price_new: price,
          store_id: storeId
        }
        this.HTTP(this.$httpConfig.addGoodToCart, params, 'post', false).then((res) => {
          this.$confirm('', '已成功加入购物车', {
            confirmButtonText: '查看购物车',
            cancelButtonText: '继续购物',
            type: 'success',
            center: true,
            lockScroll: false,
            closeOnClickModal: false,
            confirmButtonClass: 'to-shopping-cart',
            cancelButtonClass: 'continue-shopping'
          }).then(() => {
            window.open(window.location.origin + '/buyCar');
          }).catch(() => {
  
          });
        })
      },
      // 比较
      compare(id) {
        console.log('暂不做')
      },
  
    }
  }
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
    padding: 13px 30px!important;
  }
  
  .continue-shopping:hover {
    color: #606266;
    border: 1px solid #dcdfe6;
    background-color: #fff;
  }
  
  .to-shopping-cart {
    background-color: red!important;
    border: 1px solid red!important;
    padding: 13px 26px!important;
  }
  
  .to-shopping-cart:hover {
    background-color: red!important;
    color: #fff!important;
  }
</style>

<style lang="less" scoped>
  .active{
    color: #c79a01;
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
    height: 46px;
    line-height: 46px;
    font-size: 12px;
    color: #636260;
    img {
      margin: 17px 7px 0 0;
    }
    .xiala {
      display: inline-block;
      width: 82px;
      height: 23px;
      border: 1px solid #d1d1d1;
      text-align: center;
      line-height: 23px;
      margin-left: 7px;
      position: relative;
      cursor: pointer;
      a {
        color: #636260;
      }
      .yincang {
        border-right: 1px solid #d1d1d1;
        border-left: 1px solid #d1d1d1;
        position: absolute;
        top: 22px;
        left: -1px;
        span {
          width: 80px;
          height: 23px;
          border-bottom: 1px solid #d1d1d1;
          display: inline-block;
          background: #fff;
        }
      }
    }
  }
  
  .choose {
    overflow: hidden;
    border: 1px solid #e5e5e5;
    margin: 10px 0;
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
              color: #c79a01;
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
          color: #c79a01;
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
        height: 40px;
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
            width: 60px;
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
          }
          .actives {
            background: #fff;
            color: #ddbf69;
            height: 39px;
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
      .bottom {
        margin-top: 20px;
        overflow: hidden;
        ul {
          .bagli {
            width: 230px;
            height: 388px;
            border: 1px solid #f1f1f1;
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
                border: 1px solid #ddd;
                img {
                  width: 28px;
                  height: 28px;
                }
              }
              li.active {
                border-color: #ddbf69;
              }
              li:last-child{
                margin-right: 0;
              }
            }
            .pice {
              width: 100%;
              margin-top: 10px;
              margin-left: 5px;
              span:nth-of-type(1) {
                color: #de2d35;
                font-size: 16px;
              }
              span:nth-of-type(2) {
                color: #9c9c9c;
                font-size: 9px;
                text-decoration: line-through;
              }
            }
            p {
              cursor: pointer;
              width: 206px;
              height: 40px;
              line-height: 20px;
              font-size: 12px;
              color: #5f5f5f;
              margin-left: 5px;
              display: -webkit-box;
              overflow: hidden;
              white-space: normal !important;
              text-overflow: ellipsis;
              word-wrap: break-word;
              -webkit-line-clamp: 2;
              -webkit-box-orient: vertical;
              &:hover {
                color: #c79a01;
              }
            }
            .buy {
              margin: 10px 0 0 9px;
              input {
                margin: 2px 7px 0 0;
              }
              span {
                color: #717171;
                font-size: 12px;
                float: left;
                cursor: pointer;
              }
              .g-collection{
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
              border-color: #ac9a4e;
              box-shadow: 1px 2px 3px #999;
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