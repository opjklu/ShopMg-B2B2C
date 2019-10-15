<template>
  <div class="yuyin">
    <head-com></head-com>
    <div class="center">
      <div class="header">
        <img class="l" src="../../assets/img/fangzi.jpg" />
        <span class="shouye"><router-link class="to-link" to="home">首页</router-link>></span>
        <!-- t 搜索值 -->
        <span class="xiala">{{$route.query.title}}</span>
      </div>
      <div class="new">
        <div class="right">
          <div class="top">
            <ul class="theard l">
              <li>排列方式：</li>
              <li class="li active">销量</li>
            </ul>
          </div>
          <div class="bottom">
            <ul v-if="list.length != 0" class="l">
              <li class="bagli l" v-for='(li,i) in list' :key="i">
                <img class="bag" :src="URL + li.pic_url" @click="toDetail(li.id)" />
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
                  <!-- <span v-if="li.is_collect == 0" @click.stop="toCollect(li.id,i)" class="g-collection">
                            <i class="l like"></i>
                            <img class="l" src="../../assets/img/collect_gooods.png" />
                            <span>收藏</span>
                  </span> -->
                  <!-- <span v-else class="g-collection" @click.stop="toCollect(li.id,i)">
                            <i class="l like cancel"></i>
                            <img class="l" src="../../assets/img/collected_goods.png" />
                            <span>已收藏</span>
                  </span> -->
                </div>
                <i class="r car" @click.stop="addCar(li.id, li.price_member, li.store_id)"></i>
              </li>
            </ul>
            <div v-if="list.length === 0" class="no-data">暂无更多</div>
          </div>
        </div>
      </div>
      <div class="fenye" v-if="list.length != 0">
        <div class="box2">
          <el-pagination @current-change="handleCurrentChange" background layout="total,prev, pager, next,jumper" :page-size="page_size" :total="parseInt(page)">
          </el-pagination>
        </div>
      </div>
      <like-and-history></like-and-history>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>

  
  export default {
    data() {
      return {
        selfSupportChecked: true,
        lis: [],
        isactive: '',
        yeshu: ['1', '2', '3', '4', '5', '...'],
        isbg: '',
        iscolorur: '',
        basebox: [],
        base: [],
        params: {
          page: 1,
          price: '0,1000',
          sort: 1
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
        page_size: 10 //每页显示多少条数据
      }
    },
    created() {
      
      console.log(this.$route)
      if (this.$route.query.types === 'hotSearch') {
        this.getHotSearchList({
          p: this.currentPage,
          ...this.$route.query
        })
      } else {
        this.getGoodsList({
          page: this.currentPage,
          ...this.$route.query
        });
      }
    },
    watch: {
      '$route' (to, from) { //监听路由是否变化
        if (this.$route.query.title) {
          console.log(2)
          this.getGoodsList({
            page: this.currentPage,
            ...this.$route.query
          }); //重新请求
          if (this.$route.query.types === 'hotSearch') {
            this.getHotSearchList({
              p: this.currentPage,
              ...this.$route.query
            }); //重新请求
          }
          
        }
      }
    },
    methods: {
      /*页面跳转*/
      handleCurrentChange(currentPage) {
        console.log(currentPage);
        this.currentPage = currentPage;
        this.getGoodsList({
          page: this.currentPage,
          ...this.$route.query
        });
      },
      // 热门搜索
      getHotSearchList(query) {
        this.HTTP(this.$httpConfig.getHotSearchList, query, 'post').then((res) => {
          this.list = res.data.data;
          this.page = res.data.count;
          this.page_size = res.data.page_size;
        }).catch((e)=>{
          console.log(e)
        })
      },
      // 获取列表
      getGoodsList(query) {
        console.log(query);
        let title = query.title,type = query.type,page = query.page;
        this.HTTP(this.$httpConfig.SearchIndex,{
          title:title,
          page:1,
          type:type
        }, 'post').then((res) => {
          this.list = res.data.data;
          this.page = res.data.count;
          this.page_size = res.data.page_size;
          this.$message(`${res.message}`);
        }).catch((e)=>{
          console.log(e);
          this.$message(`${e.data.message}`);
          this.list = '';
          this.page = 0;
          this.page_size = 10;
        })
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
        }).catch((e)=>{
          console.log(e)
        })
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
        this.HTTP(this.$httpConfig.addGoodToCart, params, 'post').then((res) => {
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
  .l {
    float: left;
  }
  
  .r {
    float: right;
  }
  .yuyin{
    background:#fff;
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
    .shouye{
      a{
       color: #a7a7a7;
      }
    }
    .to-link {
				transition: color .2s cubic-bezier(.645, .045, .355, 1);
			}
			.to-link:hover {
				color: #303133;
				transition: color .2s cubic-bezier(.645, .045, .355, 1);
			}
    img {
      margin: 17px 7px 0 0;
    }
    .xiala {
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
  
  .new {
    overflow: hidden;
    /*height: 300px;*/
    .left {
      width: 204px;
      .up {
        overflow: hidden;
        border: 1px solid #e5e5e5;
      }
      .down {
        width: 100%;
        overflow: hidden;
        border: 1px solid #e5e5e5;
        margin-top: 10px;
      }
      .headline {
        height: 34px;
        background: #f9f9f9;
        width: 100%;
        line-height: 34px;
        color: #383838;
        padding-left: 12px;
        font-size: 16px;
      }
      li {
        height: 248px;
        width: 100%;
        cursor: pointer;
        img {
          margin: 10px 19px;
        }
        p {
          font-size: 12px;
          color: #333;
          margin: 0 14px 9px 20px;
        }
        p:nth-of-type(1) {
          &:hover {
            color: red;
          }
        }
        p:nth-of-type(2) {
          color: #e25b55;
        }
        p:last-child {
          margin-bottom: 0;
        }
        .xiaoliang {
          color: red;
        }
      }
      p:nth-of-type(2) {
        margin-bottom: 0;
      }
      li:last-child {
        margin-bottom: 15px;
      }
    }
    .right {
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
          .li {
            background: url(../../assets/img/xiajiantou.png) no-repeat top 17px right 8px;
          }
          .active {
            background: #fff url(../../assets/img/Xiajiantou1.png) no-repeat top 17px right 8px !important;
            // transform: translateY(1px);
            // -webkit-transform: translateY(1px);
            color: red;
            height: 38px;
          }
          .actives {
            background: #fff;
            transform: translateY(1px);
            -webkit-transform: translateY(1px);
            color: red;
            height: 38px;
          }
        }
      }
      .bottom {
        margin-top: 20px;
        overflow: hidden;
        min-height: 375px;
        ul {
          .bagli {
            width: 223px;
            height: 350px;
            border: 1px solid #f1f1f1;
            margin-bottom: 15px;
            margin-right: 20px;
            .bag {
              margin: 5px;
              width: 211px;
              height: 211px;
              cursor: pointer;
            }
            .pice {
              width: 100%;
              margin-top: 10px;
              padding-left: 5px;
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
              width: 201px;
              height: 40px;
              line-height: 20px;
              font-size: 12px;
              color: #5f5f5f;
              margin: 0 10px;
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
              .g-collection {
                margin-left: 10px;
                .like {
                  width: 17px;
                  height: 17px;
                  background: url(../../assets/img/collect_gooods.png) no-repeat;
                  background-size: 100% 100%;
                }
                .cancel {
                  background: url(../../assets/img/collected_goods.png) no-repeat;
                  background-size: 100% 100%;
                }
              }
            }
            .car {
              margin: 0px 14px 0 0;
              width: 30px;
              cursor: pointer;
              height: 30px;
              background: url(../../assets/img/buyCart.png) no-repeat;
              background-size: 100% 100%;
            }
            &:hover {
              border-color: #757575;
              box-shadow: 1px 2px 3px #999;
            }
          }
          .bagli:nth-child(5n) {
            margin-right: 0;
          }
        }
        .no-data {
          text-align: center;
          line-height: 375px;
        }
      }
    }
  }
  
  .fenye {
    width: 100%;
    overflow: hidden;
    text-align: right;
  }
</style>