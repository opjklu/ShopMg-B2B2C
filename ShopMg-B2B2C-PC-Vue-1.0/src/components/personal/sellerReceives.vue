<template>
  <div class="exchange">
    <common-header></common-header>
    <my-header></my-header>
    <div class="center">
      <div class="top"><span>您的位置： </span> <span>交易中心</span> > <span>我的订单 </span> > <span>申请售后</span> > <span>退款退货</span></div>
      <img class="logo" src="../../assets/img/quantui2.png" />
      <div class="middle">
        <!--等待卖家确认收货并退款-->
        <div class="left l logo3">
          <div v-if="goods.status == 10">
            <div class="Box">
              <div class="chuli">等待卖家确认收货并退款 </div>
              <p class="same">. 如果卖家收到货并验货无误，将操作退款给您。</p>
              <p class="same">. 如果卖家拒绝，需要您修改退货退款申请</p>
              <p class="same">. 如果卖家在<span>04</span>天<span>23</span>时<span>41</span>分<span>51</span>秒内未处理，系统将自动退款给您</p>
            </div>
            <p class="xiugai">您好可以：<a @click="xiugai">修改退货退款申请</a></p>
          </div>
          <div v-if="goods.status == 11">
            <div class="Box">
              <div class="chuli">等待卖家退款 </div>
            </div>
          </div>
          <!--卖家同意退款退货申请-->
          <div v-if="goods.status == 7" class="left l Logo3">
            <div class="up"><span>退货地址</span></div>
            <div class="Box">
              <p class="same">未经过卖家同意，请不要使用到付或平邮寄。</p>
              <p class="same">退货信息：{{store_address.provName}} {{store_address.cityName}} {{store_address.distName}} {{store_address.address}}（收件人：{{store_info.person_name}}，{{store_info.mobile}}）</p>
            </div>
            <div class="up"><span>物流信息</span></div>
            <div class="wuliu">物流公司 <span>*</span> ：<el-select size="mini" class="sel" v-model="expressId" placeholder="请选择物流公司">
                <el-option v-for="(item,index) in expressList" :key="index" :label="item.name" :value="item.id"></el-option>
              </el-select>
            </div>
            <div class="haoma">运单号码 <span>*</span> ：<el-input style="width:250px;" size="mini" v-model="waybillNum" placeholder="请输入内容"></el-input></div>
            <div class="but"><button @click="open">提交申请</button></div>
          </div>
        </div>
        <div class="right r">
          <div class="xiangqing">订单详情</div>
          <div class="shangpin"><img :src="URL + img.pic_url" /><span>{{goods.title}}</span></div>
          <ul class="ul">
            <li>卖 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 家：{{store_info.shop_name}}</li>
            <li>订单编号：<span class="lanse">{{refundInfo.order_sn_id}}</span></li>
            <li>单 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 价：<span>{{order_info.goods_price}}</span> 元* {{order_info.goods_num}} (数量)</li>
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
    <modal title="撤销申请" :width="625" :is-show="isopen" transition="fadeDown" @close="isopen=false" :show-footer="false">
      <div class="contents">
        <p class="top">目前售后申请仅有一次机会。为确保您的利益，请您告知撤销申请是由于：</p>
        <p><input type="radio" name="if" />卖家要求先撤销，然后才肯提供售后服务</p>
        <p><input type="radio" name="if" />和卖家协商一致。已解决售后问题</p>
        <p><input type="radio" name="if" />其他</p>
        <button>放弃撤销</button><button>确认撤销</button>
  
      </div>
    </modal>
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
        goods: {},
        waybillNum:'',
        isopen: '',
        ul: false,
        expressList: [],
        expressId: '',
        store_address:{},
        refundInfo:{},
        img:{},
      }
    },
    beforeRouteLeave(to,from,next){
      localStorage.removeItem('refundInfo');
      next();
    },
    mounted(){
        // 关闭浏览器窗口的时候清空浏览器缓存在localStorage的数据
        window.onUnload = function () {
           localStorage.removeItem('refundInfo');
        }
    },
    created() {
       if(localStorage.getItem('refundInfo')){
        this.refundInfo = JSON.parse(localStorage.getItem('refundInfo'));
      }else{
        this.$router.push('goodSrefund');
      }
      this.orderInfo();
      this.getAddress();
      this.getExpress();
    },
    methods: {
      orderInfo() {
        this.HTTP(this.$httpConfig.generalOrderReturnDetails, {
          order_id: this.refundInfo.order_id,
				  goods_id:this.refundInfo.goods_id,
        }, 'post', false).then(res => {
          this.goods = res.data.data.goods;
					this.img = res.data.data.img;
					this.store_info = res.data.data.store;
					this.order_info = res.data.data.order_goods_info;
        })
      },
      getAddress(){
        this.HTTP(this.$httpConfig.getSAtoreAddress, {
          store_id: this.refundInfo.store_id
        }, 'post', false).then(res => {
         this.store_address = res.data.data;
        })
      },
      getExpress(){
        this.HTTP(this.$httpConfig.getExpressList, {}, 'get', false).then(res => {
         this.expressList = res.data.data;
        })
      },
      open() {
        if (this.expressId == '') {
          this.$message({
            showClose: true,
            message: '请选择物流公司！',
            type: 'error',
            duration: 1000
          });
          return false;
        }
        if (!this.waybillNum) {
          this.$message({
            showClose: true,
            message: '请填写运单号码！',
            type: 'error',
            duration: 1000
          });
          return false;
        }
        this.HTTP(this.$httpConfig.courierNumber, {
          id: this.refundInfo.refund_id,
          express_id:this.expressId,
          waybill_id:this.waybillNum,
          order_id:this.refundInfo.order_id,
          goods_id:this.refundInfo.goods_id
        }, 'post', false).then(res => {
            this.orderInfo();
        }).catch((res)=>{
          this.$message({
            showClose: true,
            message: res.data.message,
            type: 'error',
            duration: 1000
          });
        })
        
      },
      xiugai() {
        this.logo1 = true
        this.logo2 = false
      },
      hit() {
        this.isopen = !this.isopen
      }
    },
    components: {
      "my-header": myHeader
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
      height: 518px;
      background: #fff;
    }
    .logo2 {
      .Box {
        margin: 0 15px;
        height: 203px;
        border-bottom: 1px solid #e7e7e7;
        .chuli {
          font-size: 18px;
          margin: 46px 0 22px 43px;
          line-height: 18px;
        }
        .same {
          font-size: 14px;
          line-height: 26px;
          width: 723px;
          margin-left: 44px;
          span {
            color: red;
          }
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
    .logo3 {
      .Box {
        margin: 0 15px;
        height: 203px;
        border-bottom: 1px solid #e7e7e7;
        .chuli {
          font-size: 18px;
          margin: 46px 0 22px 43px;
          line-height: 18px;
        }
        .same {
          font-size: 14px;
          line-height: 26px;
          width: 723px;
          margin-left: 44px;
          span {
            color: red;
          }
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
      .Logo3 {
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
        .Box {
          margin: 0 15px;
          height: 74px;
          .same {
            font-size: 14px;
            line-height: 26px;
            width: 723px;
            margin-left: 44px;
            span {
              color: red;
            }
          }
        }
        .wuliu {
          font-size: 12px;
          color: #484848;
          margin: 29px 0 16px 44px;
          span {
            color: #ff0000;
          }
          select {
            width: 250px;
            height: 30px;
            color: #9c9c9c;
            outline: none;
          }
        }
        .haoma {
          font-size: 12px;
          color: #484848;
          margin: 0 0 16px 44px;
          span {
            color: #ff0000;
          }
        }
        .but {
          margin-left: 117px;
          button {
            cursor: pointer;
            width: 94px;
            height: 32px;
            border-radius: 3px;
            text-align: center;
            line-height: 32px;
            color: #fff;
            background: red;
            margin-right: 18px;
          }
        }
      }
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
  
  .contents {
    height: 294px;
    .top {
      font-size: 15px;
      color: #494949;
    }
    p {
      font-size: 12px;
      color: #484848;
      margin-bottom: 20px;
    }
    input {
      margin-right: 11px;
    }
    button {
      width: 72px;
      height: 32px;
      text-align: center;
      line-height: 32px;
      border-radius: 3px;
      margin-right: 18px;
      cursor: pointer;
    }
    button:nth-of-type(1) {
      background: #ff6000;
      color: #fff;
    }
    button:nth-of-type(2) {
      background: #fafafa;
      border: 1px solid #e7e6e6;
    }
  }
</style>