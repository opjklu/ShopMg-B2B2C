<template>
  <div class="fullOrde">
    <div class="alike" v-for="(item, index) in data.list" :key="index">
      <div class="both"><input class="l" type="checkbox" />
        <p class="l">{{item.create_time | formatDate}}</p>
        <p class="l">订单号： {{item.order_sn_id}}</p><span></span>
        <p class="l">店铺：
          <router-link target="_blank" :to="{path:'/storehome',query:{id:item.store_id}}">{{item.store.shop_name}}</router-link>
        </p><img src="../../../../assets/img/qq.jpg" />
        <i v-if="item.order_status == 4" class="el-icon-delete r"></i>
      </div>
      <div class="order-item clearfix">
        <div class="order-info l">
          <div class="zuo" v-for="(goods,i) in item.goods" :key="i">
            <div class="huowu">
              <router-link target="_blank" class="a-block" :to="{path:'/inroyaldrink',query:{id:goods.goods_id}}">
                <img :src="URL + goods.pic_url" />
              </router-link>
              <p>
                <router-link target="_blank" class="a-block" :to="{path:'/inroyaldrink',query:{id:goods.goods_id}}">{{goods.title}}</router-link>
              </p>
              <p>￥{{goods.goods_price}}</p>
              <p>{{goods.goods_num}}</p>
              <router-link class="goods-operate" target="_blank" to="apply">售后处理</router-link>
            </div>
          </div>
        </div>
        <div class="right r" :style="{height:item.goods.length * 110 + 'px'}">
          <p>
            <span>￥{{item.price_sum|keep2Num}}</span><span>（含运费：￥{{item.shipping_monery|keep2Num}}）</span>
          </p>
          <p>
            <span v-if="item.order_status == 1">等待卖家发货</span>
            <router-link class="a-block" :to="{path: '/orderDetail', query: {id: item.goods[0].goods_id}}">订单详情</router-link>
          </p>
          <p><span ref="msg" class="quxiao">{{Status[Number(item.order_status)]}}</span><span></span></p>
        </div>
      </div>
    </div>
    <div class="pagation" v-if="data.length != 0">
      <el-pagination background layout="prev, pager, next" :total="~~data.count" :page-size="data.page_size"  @current-change="handleCurrentChange">
      </el-pagination>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        data: [],
        currentPage:1,
        h: true,
        dingDan: false,
        message: '',
        Status:['取消订单','立即付款','已支付','发货中','已发货','已收货','退货审核中','审核失败','审核成功','退款中','退款成功'],
      }
    },
    created() {
      this.Order()
    },
    methods: {
      Order() {
        this.HTTP(this.$httpConfig.pendingDelivery, {
           page:this.currentPage
        }, 'post').then(res => {
          this.data = res.data.data
          this.$emit('pendingDeliveryCount', ~~this.data.count)
        })
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.Order();
      },
      xiangqing() {
        this.h = false;
        this.dingDan = true;
      },
    }
  }
</script>

<style lang="less" scoped>
  .pagation {
    display: flex;
    justify-content: center;
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
  
  .alike {
    overflow: hidden;
    border: 1px solid #e7e6e6;
    margin: 0 17px 10px;
    .goods-operate {
      display: inline-block;
      margin-top: 20px;
    }
    .a-block {
      display: block;
    }
    a {
      font-size: 12px;
      color: #333;
    }
    a:hover {
      color: red;
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
        text-align: center;
        span {
          display: block;
          font-size: 12px;
          color: #333;
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
      p:nth-of-type(2)> :first-child {
        margin-top: 20px;
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
        cursor: default!important;
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
</style>


