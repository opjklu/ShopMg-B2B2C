<template>
  <div class="myOrder l">
    <div>
      <div class="top">
        <ul class="l">
          <li @click="tab(index)" class="l" v-for="(item,index) in myul" :class="{li:isli==index}" :key="index">
            <span class="line">{{item.li}}
              <!-- <span class="huang">{{item.spa}}</span> -->
            </span>
          </li>
        </ul>
        <p class="r"><img src="../../../assets/img/lajixiang.png" />我的消息<span>(0)</span></p>
      </div>
      <div v-if="isli != 0" class="thead">
        <p class="l">宝贝</p>
        <p class="l">单价</p>
        <p class="l">数量</p>
        <p class="l">商品操作</p>
        <p class="l">实付款</p>
        <p class="l">交易状态<i class="el-icon-caret-bottom"></i></p>
        <p class="l">交易操作</p>
      </div>
      <full-order v-if="isStyle === 0" @changeOrderNum="changeOrderNum"></full-order>
      <pendingPayment v-if="isStyle === 1" @changeOrderNum="changeOrderNum"></pendingPayment>
      <pending-delivery v-if="isStyle === 2" @changeOrderNum="changeOrderNum"></pending-delivery>
      <goodsToBeReceived v-if="isStyle === 3" @changeOrderNum="changeOrderNum"></goodsToBeReceived>
      <to-be-evaluated v-if="isStyle === 4" @changeOrderNum="changeOrderNum"></to-be-evaluated>
      <cancel v-if="isStyle === 5" @changeOrderNum="changeOrderNum"></cancel>
      <confirm v-if="isStyle === 6" @changeOrderNum="changeOrderNum"></confirm>
    </div>
  </div>
</template>

<script>
import fullOrder from './packageOrderDetail/fullOrder'//所有
import pendingPayment from './packageOrderDetail/pendingPayment'//待付款
import pendingDelivery from './packageOrderDetail/pendingDelivery'//待发货
import goodsToBeReceived from './packageOrderDetail/goodsToBeReceived'//待收货
import toBeEvaluated from './packageOrderDetail/toBeEvaluated'//待评价
import cancel from './packageOrderDetail/cancel'//已取消
import confirm from './packageOrderDetail/confirm'//已完结
import { Message } from 'element-ui'
  export default {
    components: {
      fullOrder,
      pendingPayment,
      goodsToBeReceived,
      pendingDelivery,
      toBeEvaluated,
      cancel,
      confirm
    },
    data() {
      return {
        //我的订单
        myul: [{
            li: "所有订单",
            spa: 0
          },
          {
            li: "待付款",
            spa: 0
          },
          {
            li: "待发货",
            spa: 0
          },
          {
            li: "待收货",
            spa: 0
          },
          {
            li: "待评价",
            spa: 0
          },
          {
            li: "已取消",
            spa: 0
          },
          {
            li: "已完成",
            spa: 0
          }
        ],
        isli: 0,
        isStyle:0,
        searchData: [],
      };
    },
    created () {
       this.orderNumber();
    },
    methods: {
      changeOrderNum(){
        this.orderNumber();
      },
      //订单数
      orderNumber() {
        // this.HTTP(this.$httpConfig.orderStatusNum, {}, 'post')
        //   .then((res) => {
            // this.orderNum = res.data;
            // this.myul[1].spa = this.orderNum.payment;
            // this.myul[2].spa = this.orderNum.delivery;
            // this.myul[3].spa = this.orderNum.received;
            // this.myul[4].spa = this.orderNum.evaluated;
          // })
      },
      tab(index) {
        this.isStyle = '';
        setTimeout(()=>{
          this.isStyle = index;
        },10)
        this.isli = index;
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
  .pagation {
    display: flex;
    justify-content: center;
  }
  .center {
    width: 1190px;
    margin: 0 auto;
    height: 100%;
  }
  
  .myOrder {
    overflow: hidden;
    width: 990px;
    background: #fff;
    margin: 16px 0;
    .top {
      height: 37px;
      border-bottom: 1px solid #e7e7e7;
      margin: 14px 17px 0;
      ul {
        overflow: hidden;
        li {
          width: 104px;
          text-align: center;
          height: 37px;
          color: #666;
          font-size: 14px;
          cursor: pointer;
          .huang {
            color: red;
            margin-left: 3px;
          }
          .line {
            line-height: 16px;
            border-right: 1px solid #e7e7e7;
            display: inline-block;
            width: 104px;
            margin-top: 10px;
          }
        }
        .li {
          border-bottom: 2px solid red;
        }
        li:last-child {
          .line {
            border-right: 0;
          }
        }
      }
      p {
        line-height: 37px;
        font-size: 12px;
        color: #666;
        span {
          color: red;
          margin-left: 2px;
        }
        img {
          float: left;
          margin: 12px 5px 0 0;
        }
      }
    }
    .thead {
      overflow: hidden;
      height: 38px;
      background: #f5f5f5;
      border: 1px solid #e7e6e6;
      margin:20px 17px;
      width: 956px;
      line-height: 38px;
      p {
        font-size: 12px;
        color: #474747;
        i {
          color: #999;
          margin-left: 9px;
        }
      }
      p:nth-of-type(1) {
        margin: 0 205px 0 134px;
      }
      p:nth-of-type(3) {
        margin: 0 70px 0 50px;
      }
      p:nth-of-type(5) {
        margin: 0 65px 0 74px;
      }
      p:nth-of-type(7) {
        margin-left: 51px;
      }
    }
    .alike {
      overflow: hidden;
      border: 1px solid #e7e6e6;
      margin: 0 17px 10px;
      span {
        cursor: pointer;
      }
      a {
        font-size: 12px;
        color: #333;
        margin-top: 20px;
        display: inline-block;
      }
      .both {
        height: 42px;
        line-height: 42px;
        background: #f1f1f1;
        i {
          font-size: 16px;
          margin: 13px 16px 0 0;
          color: #999;
          font-weight: 900;
        }
        input {
          margin: 16px 14px 0 13px;
        }
        p {
          font-size: 12px;
          color: #333;
        }
        p:nth-of-type(2) {
          margin: 0 67px 0 25px;
        }
        img {
          float: left;
          margin: 9px 0 0 35px;
        }
      }
      .zuo {
        overflow: hidden;
        width: 613px;
        .huowu {
          height: 110px;
          img {
            width: 70px;
            height: 70px;
            float: left;
            margin: 15px 10px 0 13px;
          }
          p {
            float: left;
            font-size: 12px;
            color: #333;
            margin-top: 20px;
          }
          p:nth-of-type(1) {
            width: 147px;
            margin: 18px 117px 0 0;
          }
          p:nth-of-type(3) {
            margin: 20px 83px 0 44px;
          }
        }
      }
      .right {
        height: 110px;
        overflow: hidden;
        p {
          float: left;
          border-left: 1px solid #e7e6e6;
          height: 100%;
          span {
            display: block;
            text-align: center;
            font-size: 12px;
            color: #333;
            cursor: pointer;
          }
        }
        p:nth-of-type(1) {
          width: 120px;
          span:nth-of-type(1) {
            margin-top: 20px;
          }
        }
        p:nth-of-type(2) {
          width: 105px;
          span:nth-of-type(1) {
            margin-top: 20px;
          }
        }   

        
        p:nth-of-type(3) {
          width: 106px;
          span:nth-of-type(1) {
            margin: 17px auto 8px;
            width: 72px;
            height: 28px;
            line-height: 28px;
            color: #fff;
            background: #ff6000;
            border-radius: 3px;
          }
        }
        .quxiao {
          background: #cbcaca !important;
        }
        .queren {
          background: #66b6ff !important;
        }
      }
      .youhui {
        line-height: 35px;
        color: #333;
        font-size: 12px;
        margin-left: 13px;
        span {
          color: red;
        }
      }
    }
    .alikeTwo {
      .huowu {
        border-bottom: 1px solid #e7e6e6;
        p:nth-of-type(1) {
          width: 202px !important;
          margin-right: 49px !important;
        }
      }
      .right {
        height: 220px;
        p {
          border-bottom: 1px solid #e7e6e6;
        }
        p:nth-of-type(3) {
          text-align: center;
          line-height: 55px;
          font-size: 12px;
          span.pingjia {
            line-height: 23px;
            width: 47px;
            height: 23px;
            border: 1px solid #e7e6e6;
            background: #fff;
            color: #333;
          }
        }
      }
    }
    .alikeFour {
      .baozhangjin {
        width: 946px;
        overflow: hidden;
        height: 49px;
        border-top: 1px solid #e7e6e6;
        p {
          font-size: 12px;
          color: #333;
          text-align: center;
          height: 49px;
          padding-top: 20px;
        }
        p:nth-of-type(1) {
          margin: 0 262px 0 13px;
        }
        p:nth-of-type(3) {
          margin-left: 43px;
        }
        .kong {
          width: 108px;
          border-left: 1px solid #e7e6e6;
          span {
            width: 73px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            color: #fff;
            border-radius: 3px;
            display: block;
            background: #ff6000;
            margin: -10px auto 0;
            cursor: pointer;
          }
        }
        .qian {
          width: 120px;
          border-left: 1px solid #e7e6e6;
        }
        .wancheng {
          padding-top: 15px;
          width: 105px;
          border-left: 1px solid #e7e6e6;
          span {
            display: block;
            margin-top: -3px;
          }
        }
      }
    }
  }
</style>