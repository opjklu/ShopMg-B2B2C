<template>
  <div class="myOrder l">
    <div class="dingDan">
      <ul class="top">
        <li>订单详情</li>
      </ul>
      <div class="zhuangtai">
        <p>当前订单状态：{{$Status[order.order_status]}}</p>
        <p>. 如果没有收到货，或收到货后出现问题，您可以联系卖家协商解决 <img src="../../../../assets/img/qq.jpg" /></p>
        <p>. 如果卖家没有履行应尽的承诺，您可以“投诉维权”</p>
      </div>
      <div class="maijia">
        <p>买家信息</p>
        <p>收货地址：{{address.realname}}，{{address.mobile}}，{{address.prov_name}} {{address.city_name}} {{address.dist_name}} {{address.address}} {{address.zipcode === null ? '000000' : address.zipcode}}</p>
        <p>运送方式：{{order.name || '快递'}}</p>
      </div>
      <div class="Maijai">
        <p>卖家信息</p>
        <ul>
          <li class="l">昵称：{{store.shop_name}} <img src="../../../../assets/img/qq.jpg" /></li>
          <li class="l">真实姓名：{{store.person_name}}</li>
          <li class="l">城市：{{store.store_address}}</li>
          <li class="l">联系电话：{{store.mobile}}</li>
        </ul>
      </div>
      <div class="Maijai">
        <p>订单信息</p>
        <ul>
          <li class="l">订单编号: {{order.order_sn_id}}</li>
          <li class="l">创建时间：{{~~order.create_time | formatDate}}</li>
          <li class="l" v-if="order.over_time">发货时间：{{~~order.over_time | formatDate}}</li>
          <li class="l" v-if="order.pay_time">付款时间：{{~~order.pay_time | formatDate}}</li>
          <li class="l" v-if="order.delivery_time">交货时间：{{~~order.delivery_time | formatDate}}</li>
        </ul>
      </div>
      <div class="shangpin">
        <div class="up">
          <p>宝贝</p>
          <p>宝贝属性</p>
          <p>状态</p>
          <p>单价</p>
          <p>数量</p>
          <p>优惠</p>
          <p>商品总价</p>
        </div>
        <div class="order-item clearfix">
          <div class="down l" v-if="goods">
            <div class="order-info clearfix" v-for="(item,index) in goods" :key="index">
              <p>
                <router-link target="_blank" :to="{path:'/inroyaldrink',query:{id:item.goods_id}}">
                  <img :src="URL + item.pic_url" />
                </router-link>
                <router-link target="_blank" :to="{path:'/inroyaldrink',query:{id:item.goods_id}}">
                  <span>{{item.title}}</span>
                </router-link>
              </p>
              <p>
                <span>暂无数据</span>
              </p>
              <p>{{$Status[item.status]}}</p>
              <p>￥{{item.price_member}}</p>
              <p>{{item.goods_num}}</p>
              <p>无</p>
            </div>
          </div>
          <p :style="{height:goods.length * 79 + 'px'}" class="price-num"><span>￥{{parseFloat(order.price_sum) + parseFloat(order.shipping_monery)|keep2Num}}</span><span>（含运费：￥{{order.shipping_monery|keep2Num}}）</span></p>
        </div>
      </div>
      
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
        store: {},
        goods: [],
        address: {},
        order: {},
      };
    },
    created() {
      console.log(this);
      this.Order();
    },
    methods: {
      Order() {
        this.HTTP(this.$httpConfig.orderDetails, {
          id: this.$route.query.id
        }, 'post', false).then(res => {
          this.store = res.data.store;
          this.goods = res.data.goods;
          this.order = res.data.order;
          this.address = res.data.address;
        }).catch((e)=>{
          this.$message(`${e.data.message}`)
        })
      }
    }
  };
</script>

<style lang="less" scoped>
  .l {
    float: left;
  }
  
  .dingDan {
    height: 940px;
    width: 980px;
    background: #fff;
    margin: 16px 0;
    .top {
      height: 37px;
      border-bottom: 1px solid #e7e7e7;
      margin: 14px 17px 0;
      li {
        width: 104px;
        text-align: center;
        line-height: 35px;
        border-bottom: 2px solid red;
        color: red;
        font-size: 14px;
      }
    }
    .zhuangtai {
      height: 127px;
      border: 1px solid #bce8f1;
      background: #eff8ff;
      margin: 18px 17px 11px;
      p {
        font-size: 12px;
        color: #999;
        line-height: 24px;
        margin-left: 23px;
      }
      p:nth-of-type(1) {
        font-size: 15px;
        color: #333;
        margin: 25px 0 9px 24px;
      }
    }
    .maijia {
      margin: 0 17px;
      p:nth-of-type(1) {
        line-height: 30px;
        border-bottom: 1px solid #e7e7e7;
        font-size: 14px;
        color: #333;
        margin-bottom: 11px;
      }
      p {
        font-size: 12px;
        color: #333;
        padding-left: 24px;
        line-height: 24px;
      }
    }
    .Maijai {
      margin: 14px 17px;
      p {
        padding-left: 24px;
        line-height: 30px;
        border-bottom: 1px solid #e7e7e7;
        font-size: 14px;
        color: #333;
        margin-bottom: 11px;
      }
      li {
        line-height: 39px;
        font-size: 12px;
        color: #333;
      }
      ul {
        overflow: hidden;
        margin-left: 23px;
        li:nth-of-type(1) {
          width: 329px;
        }
        li:nth-of-type(4) {
          width: 329px;
        }
        li:nth-of-type(2) {
          width: 356px;
        }
        li:nth-of-type(5) {
          width: 356px;
        }
        li:nth-of-type(3) {
          width: 236px;
        }
        li:nth-of-type(6) {
          width: 236px;
        }
      }
    }
    .shangpin {
      margin: 0 auto;
      border: 1px solid #e7e6e6;
      overflow: hidden;
      width: 896px;
      .up {
        overflow: hidden;
        background: #f1f1f1;
        line-height: 42px;
        background: #f1f1f1;
      }
      p {
        float: left;
        font-size: 12px;
        color: #333;
        text-align: center;
      }
      p:nth-of-type(1) {
        width: 263px;
      }
      p:nth-of-type(2) {
        width: 119px;
      }
      p:nth-of-type(3) {
        width: 114px;
      }
      p:nth-of-type(4) {
        width: 89px;
      }
      p:nth-of-type(5) {
        width: 79px;
      }
      p:nth-of-type(6) {
        width: 99px;
      }
      p:nth-of-type(7) {
        width: 127px;
        border-right: 0 !important;
      }
      .down {
        overflow: hidden;
        img {
          float: left;
          margin: 0 11px 0 13px;
          width: 70px;
          height: 60px;
        }
        p {
          padding-top: 15px;
          height: 79px;
          border-right: 1px solid #e7e6e6;
          span {
            display: block;
          }
        }
        .order-info {
          p:nth-of-type(1) {
            text-align: left;
            span {
              width: 149px;
              display: inline-block;
            }
            a {
              color: #333;
            }
            a:hover {
              color: red;
            }
          }
        }
      }
      .price-num {
        padding-top: 19px;
        width: 127px!important;
        border-right: none;
        float: right;
        span{
          display: block;
        }
        span:nth-child(2){
          padding-top: 10px;
        }
      }
    }
    
    .money{
      float: right;
      margin-right:10%;
      margin-top:-10px;
      background: #c79a01;
      width:100px;
      height:35px;
      color: #fff;
      font-size:130%;
      cursor: pointer;
    }

  }
</style>