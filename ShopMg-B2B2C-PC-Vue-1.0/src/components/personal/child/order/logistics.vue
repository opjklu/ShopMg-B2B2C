<template>
  <div class="myOrder l">
    <div class="WuLiu">
      <ul class="top">
        <li>查看物流</li>
      </ul>
      <!-- <div class="qianshou">您的包裹已被签收</div> -->
      <div class="status_list">
        <ul v-if="logistics.Traces" class="WuLiuUl">
          <li v-for="(item,index) in logistics.Traces" :key="index">
            <span class="w-date">{{item.AcceptTime}}</span>
            <span class="w-txt">{{item.AcceptStation}}</span>
          </li>
        </ul>
        <div class="no-logistics" v-if="idLogistics">暂无物流信息</div>
      </div>
  
      <ul class="yundan">
        <li>运单号码： {{logistics.LogisticCode}}</li>
        <li>物流公司： {{express.name}}</li>
        <li>客服电话：{{express.tel}} </li>
        <li>卖家昵称：{{store.shop_name}} </li>
        <li>发货地址：{{store_address.provName}}{{store_address.cityName}}{{store_address.distName}} {{store_address.address}} {{store.person_name}} {{store.mobile}}</li>
        <li>收货地址：{{BuyerAddress.prov}}{{BuyerAddress.city}}{{BuyerAddress.dist}} {{BuyerAddress.address}} {{BuyerAddress.realname}} {{BuyerAddress.mobile}}</li>
      </ul>
      <div class="luyou">
        <ul>
          <li class="l" v-for="(item,index) in goods" :key="index">
            <div class="pic">
              <img v-lazy="URL + item.pic_url" alt="">
            </div>
            <span>{{item.price_member}} x {{item.goods_num}}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        logistics: {},
        express: {},
        BuyerAddress: {},
        order: {},
        goods: {},
        store: {},
        store_address: {},
        idLogistics:false,
        type:Number(this.$route.query.type),//0-普通订单，1-套餐订单，2-积分订单
        Traces:[],
      };
    },
    created() {
      this.orderInfo()
      this.lookGoodsExpress()
    },
    methods: {
      // 查看物流
      lookGoodsExpress() {
        let parms = {
          id: this.$route.query.id,
          exp_id: this.$route.query.exp_id,
          express_id: this.$route.query.express_id,
          order_status: this.$route.query.status
        };
        if(this.type===0){//普通订单
          this.HTTP(this.$httpConfig.lookGoodsExpress,parms, 'post', false).then(res => {
            console.log(res,'sdasdasds s')
            this.logistics = JSON.parse(res.data.data.logist);
            this.Traces = this.logistics.Traces.reverse();
            console.log(this.logistics)
            if(this.logistics.Traces.length === 0){
              this.idLogistics = true;
            }
            this.express = res.data.data.express;
            console.log(this.logistics)
          }).catch(()=>{
            
          })
        }else if(this.type===1){//套餐订单
          this.HTTP(this.$httpConfig.packageLogistics,parms,'post',false).then(res=>{
            this.logistics = JSON.parse(res.data.data.logist);
            if(this.logistics.Traces.length === 0){
              this.idLogistics = true;
            }
            this.express = res.data.data.express;
          }).catch(()=>{
            
          })
        }else{//积分订单
          this.HTTP(this.$httpConfig.integralLogistics,parms,'post',false).then(res=>{
            
            this.logistics = JSON.parse(res.data.data.logist);

          
            if(this.logistics.Traces.length === 0){
              this.idLogistics = true;
            }
            this.express = res.data.data.express;

            console.log(this.logistics);
          }).catch(()=>{

          })
        }
        
      },
      orderInfo() {
        if(this.type===0){//普通订单
          this.HTTP(this.$httpConfig.orderDetails, {
            id: this.$route.query.id
          }, 'post', false).then(res => {
            this.store = res.data.data.store;
            this.goods = res.data.data.goods;
            this.order = res.data.data.order;
            this.BuyerAddress = res.data.data.address;
            this.getAddress(this.order.store_id);
          }).catch(()=>{})
        }else if(this.type===1){//套餐订单
          this.HTTP(this.$httpConfig.package.orderDetail, {
            id: this.$route.query.id,
        }, 'post', false).then(res => {
          console.log(res)
          this.store = res.data.data.store;
          this.goods = res.data.data.goods;
          this.order = res.data.data.order;
          this.BuyerAddress = res.data.data.address;
          this.getAddress(this.order.store_id);
        }).catch(()=>{})
        }else{//积分订单
          this.HTTP(this.$httpConfig.orderDetailByIntegral,{
            id: this.$route.query.id,
          },'post',false).then(res => {
            
            this.store = res.data.data.store;
            this.goods = res.data.data.goods;
            this.order = res.data.data.order;
            this.BuyerAddress = res.data.data.address;
            this.getAddress(this.order.store_id);
          }).catch(()=>{})
        }
        
      },
      getAddress(id) {
        this.HTTP(this.$httpConfig.getSAtoreAddress, {
          store_id: id
        }, 'post', false).then(res => {
          this.store_address = res.data.data;
        })
      },
      tab(index) {
        this.isli = index;
      },
      wuliu() {
        this.h = false;
        this.WuLiu = true;
      },
      xiangqing() {
        this.h = false;
        this.dingDan = true;
      }
    }
  };
</script>

<style lang="less" scoped>
  .l {
    float: left;
  }
  
  .myOrder {
    overflow: hidden;
    width: 980px;
    background: #fff;
    margin: 16px 0;
  }
  
  .WuLiu {
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
    .qianshou {
      line-height: 65px;
      border-bottom: 1px solid #e7e7e7;
      margin: 20px 51px 35px;
    }
    .status_list {
      position: relative;
      margin: 20px 0;
      min-height: 200px;;
      .WuLiuUl {
        margin: 60px 20px;
        padding-left: 10px;
        margin-left: 12px;
        padding-left: 10px;
        li {
          height: auto;
          min-height: 30px;
          border-left: 1px solid #d9d9d9;
          font-size: 12px;
          color: #333;
          span {
            display: inline-block;
          }
          .w-date {
            width: 126px;
          }
          .w-txt{
            width: 550px;
            vertical-align: text-top;
          }
        }
        li::before {
          content: '';
          border: 3px solid #f3f3f3;
          background-color: #d9d9d9;
          display: inline-block;
          width: 11px;
          height: 11px;
          border-radius: 5px;
          margin-left: -6px;
          margin-right: 10px;
        }
        li:last-child {
          border: none;
        }
        li:first-of-type:before {
          background-color: #fe4300;
          border-color: #f8e9e4;
        }
      }
      .no-logistics{
        padding: 20px 51px 35px;
      }
    }
    .status_list:before{
      content: " ";
      background-color: #fff;
      display: block;
      position: absolute;
      top: -2px;
      left: 20px;
      width: 10px;
      height: 4px;
    }
    .yundan {
      border-top: 1px solid #e7e7e7;
      margin: 0 19px;
      padding-top: 20px;
      li {
        font-size: 12px;
        color: #333;
        line-height: 31px;
      }
    }
  }
  
  .luyou {
    margin: 18px;
    ul {
      overflow: hidden;
      li {
        margin-right: 20px;
        .pic {
          border: 1px solid #eee;
          width: 82px;
          height: 82px;
        }
        span {
          font-size: 12px;
        }
      }
    }
  }
</style>