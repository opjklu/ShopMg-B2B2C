<template>
  <div class="exchange">
    <common-header></common-header>
    <my-header></my-header>
    <div class="center">
      <div class="top"><span>您的位置： </span> <span>交易中心</span> > <span>我的订单 </span> > <span>申请售后</span> > <span>仅换货</span></div>
      <img class="logo" src="../../assets/img/huanhuo1.png" />
      <div class="middle">
        <div class="left l logo2">
          <div>
            <p class="chuli">请等待卖家处理</p>
            <p class="same">. 如果卖家同意，请按照已给出的换货地址退货给卖家，并请记录退货运单号。</p>
            <p class="same"> . 如果卖家拒绝，或在 <span>04</span>天<span>23</span>时<span>58</span>分<span>05</span>秒内未处理，需要您更改换货申请。</p>
          </div>
          <p class="xiugai">您好可以：<a @click="xiugai">修改换货申请</a>
            <router-link to="apply">取消换货申请</router-link>
          </p>
  
        </div>
        <div class="right r">
          <div class="xiangqing">订单详情</div>
          <div class="shangpin"><img :src="URL + goods.pic_url" /><span>{{goods.title}}</span></div>
          <ul class="ul">
            <li>卖 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 家：{{store_info.shop_name}}</li>
            <li>联系电话：{{store_info.mobile}}</li>
            <li>订单编号：<span class="lanse">{{order_info.order_sn_id}}</span></li>
            <li>单 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 价：<span>{{goods.price_member}}</span> 元* {{goods.goods_num}} (数量)</li>
            <li>邮 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 费：<span>{{order_info.shipping_monery}}</span> 元</li>
          </ul>
        </div>
      </div>
      <div class="bottom">
        <div class="jieshao"><span>服务介绍</span></div>
        <p>1.仅退款</p><span class="spa">申请条件：若您未收到货，或已收到货且与卖家达成一致不退货仅退款时，请选择“仅退款”选项。</span><span class="spa">退款流程：1.申请退款>2.卖家同意退款申请>3.退款成功</span>
        <p>2.退货退款</p><span class="spa">申请条件：若为商品问题，或者不想要了且与卖家达成一致退货，请选择“退货退款”选项，退货后请保留物流底单（闲置商品和未加入消保商品仅支持未收到货的退款）。</span><span class="spa">退货流程：1.申请退货>2.卖家发送退货地址给买家>3.买家退货并填写退货物流信息>4.卖家确认收货，退款成功</span>
        <p>3.换货</p><span class="spa">申请条件：若您与卖家协商一致换货，请选择“换货”选项。退货后请保留物流底单</span><span class="spa">换货流程：1.申请换货>2.卖家发送退货地址给买家>3.卖家线下完成换货>4.买家线上确认完成</span>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>
  import myHeader from './header/myHeader.vue' //个人中心的头部
  export default {
    data() {
      return {
        order_info: {},
        store_info: {},
        goods: {}
  
      }
    },
    created() {
      this.orderInfo();
    },
    components: {
      myHeader
    },
    methods: {
      xiugai() {
  
      },
  
      orderInfo() {
        this.HTTP(this.$httpConfig.orderDetails, {
          id: this.$route.query.id
        }, 'post', false).then(res => {
          for (let index = 0; index < res.data.goods.length; index++) {
            if (res.data.goods[index].goods_id === this.$route.query.goods_id) {
              this.goods = res.data.goods[index];
            }
          }
          this.store_info = res.data.store;
          this.order_info = res.data.order;
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
  
  .exchange {
    background: #f6f6f6;
  }
  
  .top {
    line-height: 42px;
    font-size: 12px;
    span {
      color: #474747;
    }
    span:last-child {
      color: red;
    }
  }
  
  .logo {
    margin-bottom: 11px;
  }
  
  .middle {
    overflow: hidden;
    .left {
      width: 902px;
      height: 437px;
      background: #fff;
      .up {
        line-height: 35px;
        margin: 10px;
        border-bottom: 1px solid #e7e7e7;
        span {
          text-align: center;
          display: inline-block;
          width: 104px;
          font-size: 12px;
          color: red;
          border-bottom: 2px solid red;
        }
      }
    }
    .logo2 {
      div {
        margin: 0 15px;
        height: 203px;
        border-bottom: 1px solid #e7e7e7;
        .chuli {
          font-size: 18px;
          margin: 46px 0 22px 43px;
        }
      }
      .same {
        font-size: 14px;
        margin-left: 44px;
        line-height: 26px;
        span {
          color: red;
        }
      }
      p.xiugai {
        margin: 42px 0 0 63px;
        font-size: 14px;
        a {
          padding-right: 29px;
          font-size: 14px;
        }
      }
    }
    .right {
      width: 289px;
      height: 437px;
      background: #fff;
      .xiangqing {
        line-height: 34px;
        margin: 10px 12px 14px;
        border-bottom: 1px solid #e7e7e7;
      }
      .shangpin {
        overflow: hidden;
        margin: 0 12px;
        border-bottom: 1px solid #e7e7e7;
        img {
          margin: 0 11px 15px 0;
          float: left;
          width: 52px;
          height: 52px;
        }
        span {
          font-size: 12px;
          color: #333;
        }
      }
      .ul {
        margin: 9px 12px 0;
        li {
          line-height: 34px;
          font-size: 12px;
          color: #333;
          span {
            color: #ff6000;
          }
          .lanse {
            color: #59c4eb;
          }
        }
      }
      .uL {
        margin-top: 0;
      }
    }
  }
  
  .bottom {
    height: 489px;
    background: #fff;
    margin-bottom: 30px;
    .jieshao {
      line-height: 35px;
      margin: 10px;
      border-bottom: 1px solid #e7e7e7;
      span {
        text-align: center;
        display: inline-block;
        width: 104px;
        font-size: 12px;
        color: red;
        border-bottom: 2px solid red;
      }
    }
    p {
      font-size: 14px;
      color: #333;
      line-height: 73px;
      margin-left: 44px;
    }
    .spa {
      display: block;
      font-size: 14px;
      color: #5a5a5a;
      line-height: 25px;
      margin-left: 44px;
    }
  }
</style>