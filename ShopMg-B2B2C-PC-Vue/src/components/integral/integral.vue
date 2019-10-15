<template>
  <div class="integral">
    <head-com></head-com>
    <div class="banner">
      <el-carousel :interval="5000" arrow="hover" :height="bannerHeight">
        <el-carousel-item v-for="(item, index) in  integralAd" :key="index">
          <img :src="URL + item.pic_url" />
        </el-carousel-item>
      </el-carousel>
      <div class="user-info">
        <div class="l denglu">
          <p class="touxiang l">
            <img v-if="userInfo.user_header" :src="URL+userInfo.user_header"/> 
            <img v-else src="../../assets/img/default-head.png"/>
          </p>
          <p class="name l">Dear：{{userInfo.user_name}}</p>
          <p class="l">欢迎回来</p>
          <p class="l"><img src="../../assets/img/qian.png" />积分</p>
          <p class="l">{{integralNumber}}</p>
          <p class="l">
            <span class="l left"><img src="../../assets/img/dian.png" />我能兑换</span>
            <span class="r right"><img src="../../assets/img/dian.png" />兑换须知</span>
          </p>
        </div>
      </div>
    </div>
    <div class="center">
      <div class="duihuan">
        <p>本周
          <span>热兑商品</span>
        </p>
        <p>
          <span><img src="../../assets/img/upyinhao.png" />购商品返积分，聚惠享不停<img src="../../assets/img/downyinhao.png" /></span>
        </p>
      </div>
      <div class="cargo">
        <ul class="l">
          <li class="l" v-for="(item, index) in AttenStoreData" :key="index">
            <router-link to="integraltext">
              <p class="l">{{item.title}}</p>
              <p class="l">兑换数量：{{item.sales_sum}}</p>
              <img class="right-goods-img" :src="URL + item.pic_url" />
            </router-link>
          </li>
        </ul>
      </div>
      <div class="duihuan">
        <p>
          <span>最新</span>兑换商品</p>
        <p>
          <span><img src="../../assets/img/upyinhao.png" />购商品返积分，聚惠享不停<img src="../../assets/img/downyinhao.png" /></span>
        </p>
      </div>
      <div class="more">
        <router-link to="integrallist">查看更多 ></router-link>
      </div>
      <div class="shangpin">
        <span>{{IntegralGoodsNewList === null ? '暂无数据' : ''}}</span>
        <ul>
          <li class="l" v-for="(item, index) in IntegralGoodsNewList" :key="index" >
            <img :src="URL + item.pic_url" :style="item.pic_url === null ? 'background: gray': 'background: transparent;'" @click="$router.push({name:'IntegralInside',query: {goods_id: item.goods_id,id:item.id,integral:item.integral}})"/>
            <p class="jieshao" @click="$router.push({name:'IntegralInside',query: {goods_id: item.goods_id,id:item.id,integral:item.integral}})">{{item.title}}</p>
            <div class="bottom">
              <p class="l">价格
                <span>￥{{item.price_member}}</span>
              </p>
              <p class="r">
                <span @click="$router.push({name: 'Settlement', params: {id: item.id}})" style="color: white;">立即兑换</span>
              </p>
              <p class="l">积分兑换：{{item.integral}}积分</p>
            </div>
          </li>
          
        </ul>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        bannerHeight: '342px',
        arr: [],
        li: [],
        AttenStoreData: [],
        IntegralGoodsNewList: [],
        userInfo: {
          user_name: '',
          user_header: '',
        },
        integralAd: [],
        integralNumber: 0,
      }
    },
    
    created() {
      //获取用户信息
      this.userInfo.user_name = sessionStorage.getItem('userName');

      this.userInfo.user_header = sessionStorage.getItem('userHeaderImg');

      this.getIntegralAd();

      this.getIntegralNumber();
    },
    mounted(){
       //热兑商品
      this.getAttenStore()
      //最新兑换商品
      this.getGoodsNewList()
    },
    methods: {
  
      /**
       * 积分广告
       */
      getIntegralAd() {
        this.HTTP(this.$httpConfig.IntegraltoAd, {}, 'post').then((res) => {

          this.integralAd = res.data;

        }).catch((e) => {

        })
      },
      /**
       * 获取积分
       */
      getIntegralNumber() {
        this.HTTP(this.$httpConfig.IntegralNumber, {}, 'post').then((res) => {
          
          let data = res.data;

          if(data) {
            this.integralNumber = data.current_integral;
          }

        }).catch((e) => {

        })
      },
      //热兑商品
      getAttenStore() {
        this.HTTP(this.$httpConfig.getAttenStore, {
          id: 1
        }, 'post').then((res) => {
         
            this.AttenStoreData = res.data;
          }
          
        ).catch(e=>{
          console.log(e)
        })
      },
      //最新兑换商品
      getGoodsNewList() {
        this.HTTP(this.$httpConfig.getIntegralGoodsNewList, {}, 'post').then((res) => {
          this.IntegralGoodsNewList = res.data;
        }).catch(e=>{
          console.log(e)
        })
      }
    }
  }
</script>

<style lang="less" scoped>
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
  
  .banner {
    height: 342px;
    position: relative;
    .el-carousel {
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
      img {
        width: 100%;
        height: 100%;
      }
    }
    .user-info {
      width: 1200px;
      height: 342px;
      margin: 0 auto;
      position: relative;
      display: block;
      z-index: 2;
      .denglu {
        width: 210px;
        height: 100%;
        background: red;
        p {
          width: 100%;
          text-align: center;
        }
        .touxiang {
          width: 108px;
          height: 108px;
          background: #FF143E;
          border-radius: 50%;
          margin: 23px 53px 0;
          img {
            margin: 5px auto;
            display: block;
            border-radius: 50%;
            width: 98px;
            height: 98px;
          }
        }
        .name {
          font-size: 14px;
          color: #fff;
          margin-top: 23px;
        }
        p:nth-of-type(3) {
          font-size: 12px;
          color: #fae2d5;
        }
        p:nth-of-type(4) {
          font-size: 12px;
          color: #fff;
          margin-top: 17px;
          img {
            margin-right: 6px;
          }
        }
        p:nth-of-type(5) {
          font-size: 22px;
          color: #faff7f;
          margin-top: 11px;
        }
        p:nth-of-type(6) {
          margin-top: 37px;
          .left {
            margin-left: 16px;
            font-size: 14px;
            color: #fcf6e9;
            img {
              margin-right: 15px;
            }
          }
          .right {
            margin-right: 16px;
            font-size: 14px;
            color: #fcf6e9;
            img {
              margin-right: 15px;
            }
          }
        }
      }
    }
  }
  
  .duihuan {
    height: 93px;
    border: 2px dashed #f4f4f4;
    margin: 20px 0;
    p:nth-of-type(1) {
      width: 100%;
      float: left;
      text-align: center;
      font-size: 24px;
      color: #333;
      font-weight: 700;
      margin-top: 15px;
      span {
        color: #ff6000;
      }
    }
    p:nth-of-type(2) {
      width: 100%;
      float: left;
      text-align: center;
      margin-top: 6px;
      span {
        font-size: 12px;
        color: #666;
        img:nth-of-type(1) {
          padding-right: 55px;
        }
        img:nth-of-type(2) {
          padding-left: 55px;
        }
      }
    }
  }
  
  .cargo {
    height: 517px;
    border: 1px solid #f4f4f4;
    margin-bottom: 10px;
    .left-image {
      width: 320px;
      height: 517px;
    }
    ul {
      width: 878px;
      height: 517px;
      li {
        width: 219.5px;
        height: 258px;
        border-right: 1px solid #f4f4f4;
        border-bottom: 1px solid #f4f4f4;
        p {
          width: 100%;
          text-align: center;
          cursor: pointer;
        }
        p:nth-of-type(1) {
          font-size: 16px;
          color: #333;
          font-weight: 600;
          margin-top: 15px;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          &:hover {
            color: red;
          }
        }
        p:nth-of-type(2) {
          font-size: 12px;
          color: #666;
          margin: 5px 0;
          &:hover {
            color: deepskyblue;
          }
        }
        img.right-goods-img {
          margin: 0 auto;
          display: block;
          width: 145px;
          height: 180px;
        }
      }
      li:nth-child(4n) {
        border-right: 0;
      }
      li:nth-of-type(5) {
        border-bottom: 0;
      }
      li:nth-of-type(6) {
        border-bottom: 0;
      }
      li:nth-of-type(7) {
        border-bottom: 0;
      }
    }
  }
  
  .more {
    overflow: hidden;
    margin-bottom: 17px;
    a {
      width: 92px;
      height: 25px;
      background: #b4b4b4;
      font-size: 12px;
      color: #fff;
      text-align: center;
      line-height: 25px;
      float: right;
      display: block;
    }
  }
  
  .shangpin {
    overflow: hidden;
    height: auto;
    padding: 0 0 20px 0;
    ul {
      width: 1200px;
      height: auto;
      min-height: 354px;
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      box-sizing: border-box;
      justify-content: flex-start;
      li {
        box-sizing: border-box;
        width: 230px;
        height: 354px;
        border: 1px solid #f4f4f4;
        margin: 5px;
        img {
          display: block;
          margin: 10px;
          width: 210px;
          height: 210px;
        }
        .jieshao {
          font-size: 12px;
          color: #484848;
          margin: 0 11px;
          line-height: 20px;
          cursor: pointer;
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
        .bottom {
          width: 218px;
          height: 54px;
          margin: 0 1px;
          margin-top: 18px;
          p:nth-of-type(1) {
            font-size: 12px;
            color: #b4b4b4;
            margin-top: 13px;
            margin-left: 13px;
            span {
              text-decoration: line-through;
            }
          }
          p:nth-of-type(2) {
            margin-top: 12px;
            margin-right: 9px;
            width: 68px;
            height: 30px;
            background: #de414c;
            text-align: center;
            line-height: 30px;
            border-radius: 3px;
            cursor: pointer;
            a {
              font-size: 12px;
              color: #fff;
            }
          }
          p:nth-of-type(3) {
            font-size: 13px;
            color: #e64242;
            margin-left: 13px;
            display: -webkit-box;
            overflow: hidden;
            white-space: normal !important;
            text-overflow: ellipsis;
            word-wrap: break-word;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
          }
        }
        &:hover {
          box-shadow: 2px 4px 6px #f4f4f4;
        }
      }
      li:nth-child(5n) {
        margin-right: 0;
      }
    }
  }
</style>