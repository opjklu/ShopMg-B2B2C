<template>
  <div class="myOrder l">
    <div class="WuLiu">
      <ul class="top">
        <li>查看15515物0..3203232流</li>
      </ul>
      <div class="qianshou">您的包裹已被签收</div>
      <ul class="WuLiuUl">
        <li v-show="logistics.Traces" v-for="(item,index) in logistics.Traces" :key="index"><span>{{item.AcceptTime}}</span>{{item.AcceptStation}}</li>
        
      </ul>
      <ul class="yundan">
        <li>运单号码： {{logistics.LogisticCode}}</li>
        <li>物流公司： {{express.name}}</li>
        <li>客服电话：{{express.tel}} </li>
      </ul>
      <div class="luyou"><img src="../../../../assets/img/luyou.png" />490.00 x 1</div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        fullOrder: [],
        logistics: {},
        express: {},
      };
    },
    created() {

      this.lookGoodsExpress()
    },
    methods: {
      lookGoodsExpress () {
        this.HTTP(this.$httpConfig.lookGoodsExpress, {
          id:this.$route.query.id,
          exp_id:this.$route.query.exp_id,
          express_id:this.$route.query.express_id,
          order_status:this.$route.query.status
        }, 'post', false).then(res => {

          this.logistics = JSON.parse(res.data.data.logist);

          this.express = res.data.data.express;
          console.log(this.logistics);
        }).catch(res=>{
          console.log(res)
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
    .WuLiuUl {
      margin: 0 51px 60px;
      background: url(../../../../assets/img/wuliu.png) no-repeat top 0 left 0;
      li {
        margin-left: 61px;
        margin-bottom: 9px;
        font-size: 12px;
        color: #333;
        span {
          width: 126px;
          display: inline-block;
        }
      }
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
    margin: 12px 18px 37px;
    width: 82px;
    height: 118px;
    text-align: center;
    font-size: 12px;
    img {
      float: left;
      margin-bottom: 17px;
    }
  }
</style>