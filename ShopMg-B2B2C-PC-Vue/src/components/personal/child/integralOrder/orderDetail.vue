<template>
  <div class="myOrder l">
    <div class="dingDan">
      <ul class="top">
        <li>订单详情</li>
      </ul>
      <div class="zhuangtai">
        <p>当前订单状态：{{Status[order.status]}}</p>
        <p>. 如果没有收到货，或收到货后出现问题，您可以联系卖家协商解决 <img src="../../../../assets/img/qq.jpg" /></p>
        <p>. 如果卖家没有履行应尽的承诺，您可以“投诉维权”</p>
      </div>
      <div class="maijia">
        <p>买家信息</p>
        <p>收货地址：{{address.realname}}，{{address.mobile}}, {{address.provName + address.cityName + address.distName + address.address}} {{address.zipcode === null ? '暂无邮政编码信息' : address.zipcode}}</p>
        <p>运送方式：{{order.name || '快递'}}</p>
      </div>
      <div class="Maijai">
        <p>卖家信息</p>
        <ul>
          <li class="l">昵称：{{store.shop_name}}<img src="../../../../assets/img/qq.jpg" /></li>
          <!-- <li class="l">真实姓名：{{store.person_name}}</li>
          <li class="l">城市：{{store.store_address}}</li>
          <li class="l">联系电话：{{store.mobile}}</li>
          <li class="l">邮件：{{store.mobile}}</li>
          <li class="l">支付宝：{{store.alipay_account}}</li> -->
        </ul>
      </div>
      <div class="Maijai">
        <p>订单信息</p>
        <ul>
          <li class="l">订单标志编号：{{order.order_sn}}</li>
          <li class="l">创建时间：{{~~order.create_time | formatDate}}</li>
          <li class="l">发货时间：{{~~order.over_time | formatDate}}</li>
          <li class="l">付款时间：{{~~order.pay_time | formatDate}}</li>
          <li class="l">交货时间：{{~~order.delivery_time | formatDate}}</li>
           <li class="l" v-if="order.type_name">支付方式：{{order.type_name}}</li>
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
        <div class="down">
          <p><img :src="URL + '/' + goods.pic_url" /><span>{{goods.title}}</span></p>
          <p>
            <span>暂无数据</span>
          </p>
          <p>{{Status[Number(goods.status)]}}</p>
          <p>￥{{goods.price_member}}</p>
          <p>{{goods.goods_num}}</p>
          <p>无</p>
          <p><span>￥{{goods.price_member * goods.goods_num}}</span><span>（含运费：￥0.00）</span></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ConstJsData } from "../../../../../es6/const.js";

  export default {
    data() {
      return {
        store: [],
        goods: [],
        address: [],
        order: [],
        Status:[]
      };
    },
    created() {
      this.Status = ConstJsData.orderConst();
      this.Order()
    },
    methods: {
      Order() {
        this.HTTP(this.$httpConfig.orderDetailByIntegral, {
          id: this.$route.query.id
        }, 'post', false).then(res => {
          this.store = res.data.store
          this.goods = res.data.goods[0]
          this.order = res.data.order
          this.address = res.data.address
          console.log(res.data)
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
        height: 109px;
        img {
          float: left;
          margin: 0 11px 0 13px;
          width: 70px;
        }
        p {
          padding-top: 19px;
          height: 100%;
          border-right: 1px solid #e7e6e6;
          span {
            display: block;
          }
        }
        p:nth-of-type(1) {
          text-align: left;
          span {
            width: 149px;
            display: inline-block;
          }
        }
      }
    }
  }
</style>