<template>
  <div class="exchange">
    <common-header></common-header>
    <my-header></my-header>
    <div class="center">
      <div class="top">
        <span>您的位置：</span>
        <span>交易中心</span> >
        <span>我的订单</span> >
        <span>申请售后</span> >
        <span>退款退货</span>
      </div>
      <img class="logo" src="../../../../assets/img/quantui3.png">
      <div class="middle">
        <!--退款成功-->
        <div class="left l logo4">
          <div>退款成功</div>
          <p class="same" v-if="info.update_time">. 售后达成时间 {{info.update_time | formatDate}}</p>
          <p class="same" v-if="info.price">. 退款金额：
            <span>{{info.price}}</span>元
          </p>
        </div>
        <div class="right r">
          <div class="xiangqing">订单详情</div>
          <div class="shangpin">
            <img v-lazy="URL + img.pic_url">
            <span>{{goods.title}}</span>
          </div>
          <ul class="ul">
            <li>卖 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 家：{{store_info.shop_name}}</li>
            <li>订单编号：
              <span class="lanse">{{handlingPackageReturns.order_id}}</span>
            </li>
            <li>单 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 价：
              <span>{{order_info.goods_discount}}</span>
              元* {{order_info.package_num}} (数量)
            </li>
          </ul>
        </div>
      </div>
      <div class="bottom">
        <div class="jieshao">
          <span>服务介绍</span>
        </div>
        <p>1.仅退款</p>
        <span class="spa">申请条件：若您未收到货，或已收到货且与卖家达成一致不退货仅退款时，请选择“仅退款”选项。</span>
        <span class="spa">退款流程：1.申请退款>2.卖家同意退款申请>3.退款成功</span>
        <p>2.退货退款</p>
        <span
          class="spa"
        >申请条件：若为商品问题，或者不想要了且与卖家达成一致退货，请选择“退货退款”选项，退货后请保留物流底单（闲置商品和未加入消保商品仅支持未收到货的退款）。</span>
        <span class="spa">退货流程：1.申请退货>2.卖家发送退货地址给买家>3.买家退货并填写退货物流信息>4.卖家确认收货，退款成功</span>
        <p>3.换货</p>
        <span class="spa">申请条件：若您与卖家协商一致换货，请选择“换货”选项。退货后请保留物流底单</span>
        <span class="spa">换货流程：1.申请换货>2.卖家发送退货地址给买家>3.卖家线下完成换货>4.买家线上确认完成</span>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>
import myHeader from "../../header/myHeader.vue"; //个人中心的头部
export default {
  data() {
    return {
      order_info: {},
      store_info: {},
      goods: {},
      info: {}
    };
  },
  beforeRouteLeave(to, from, next) {
    localStorage.removeItem("handlingPackageReturns");
    next();
  },
  mounted() {
    // 关闭浏览器窗口的时候清空浏览器缓存在localStorage的数据
    window.onUnload = function() {
      localStorage.removeItem("handlingPackageReturns");
    };
  },
  created() {
    if (localStorage.getItem("handlingPackageReturns")) {
      this.refundInfo = JSON.parse(localStorage.getItem("handlingPackageReturns"));
    } else {
      this.$router.push("goodSrefund");
    }
    this.orderInfo();
    this.getInfo();
  },
  methods: {
    getInfo() {
      this.HTTP(
        this.$httpConfig.orderReturnDetails,
        {
          id: this.handlingPackageReturns.return_id
        },
        "post"
      ).then(res => {
        this.info = res.data;
      }).catch((e)=>{
          console.log(e)
        });
    },
    orderInfo() {
        this.HTTP(this.$httpConfig.orderDetails, {
          order_id: this.handlingPackageReturns.id,
          goods_id: this.handlingPackageReturns.goods_id,
          package_id: this.handlingPackageReturns.package_id,
        }, 'post', false).then(res => {
          this.goods = res.data.goods;
					this.img = res.data.img;
					this.store_info = res.data.store;
					this.order_info = res.data.order_goods_info;
        }).catch((e)=>{
          this.$message.error(`${e.data.message}`)
        })
      },
  },
  components: {
    "my-header": myHeader
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
    height: 518px;
    background: #fff;
  }
  .logo4 {
    div {
      font-size: 17px;
      margin: 46px 0 20px 44px;
    }
    .same {
      font-size: 14px;
      margin-left: 44px;
      line-height: 26px;
      span {
        color: red;
      }
    }
  }
  .right {
    width: 289px;
    height: 518px;
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
        width: 58px;
        height: 58px;
        margin: 0 11px 15px 0;
        float: left;
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