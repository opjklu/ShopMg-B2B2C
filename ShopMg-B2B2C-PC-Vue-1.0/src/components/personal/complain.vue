<template>
  <div class="xiangqing">
    <common-header></common-header>
    <my-header></my-header>
    <div class="center">
      <div class="top">
        <span>您的位置：</span>
        <span>交易中心</span> >
        <span>退款退货</span> >
        <span>查看详情</span>
      </div>
      <img class="logo" src="../../assets/img/tousu.png" />
      <div class="bottom">
        <div class="left l">
          <div class="top">
            <p>退款成功</p>
          </div>
          <div class="yuanyin">
            投诉原因：
            <span class="spa">*</span>
            <ul>
              <li class="l">
                <input type="radio" name="why" />未按约定时间发货
              </li>
              <li class="l">
                <input type="radio" name="why" />违背承诺
              </li>
              <li class="l">
                <input type="radio" name="why" />恶性骚扰
              </li>
              <li class="l">
                <input type="radio" name="why" />恶意评价
              </li>
              <li class="l">
                <input type="radio" name="why" />交易违反交易流程
              </li>
              <li class="l">
                <input type="radio" name="why" />未按承销价格交易
              </li>
            </ul>
          </div>
          <div class="haoma">
            手机号码：
            <span class="spa">*</span>
            <input type="text" />
          </div>
          <div class="shuoming">
            <p class="l">
              说明：
              <span class="spa">*</span>
            </p>
            <textarea class="l"></textarea>
            <span>(2/200字)</span>
          </div>
          <div class="pingzheng">
            上传凭证：
            <span>选择凭证图片</span>
          </div>
          <div class="jiahao">
            <i class="el-icon-plus"></i>
          </div>
          <button>提交申请</button>
        </div>

        <div class="right r">
          <div class="head">投诉申请</div>
          <div class="shangpin">
            <img src="../../assets/img/apply.png" />
            <span>小熊电热饭盒保温可插电蒸煮器加热真空保鲜双层不锈钢内胆便当盒</span>
          </div>
          <ul class="ul">
            <li>
              投诉卖家：bojiechina
              <img src="../../assets/img/qq.jpg" alt />
            </li>
            <li>
              订单编号：
              <span class="lanse">3215375429258336</span>
            </li>
            <li>成交时间：2015-12-10 16:16:54</li>
          </ul>
        </div>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>
 
<script>
export default {
  data() {
    return {};
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
.xiangqing {
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
.bottom {
  overflow: hidden;
  margin-bottom: 31px;
  .left {
    width: 902px;
    height: 480px;
    background: #fff;
    .top {
      margin: 11px 16px 0;
      line-height: 33px;
      border-bottom: 1px solid #e7e7e7;
      p {
        width: 104px;
        border-bottom: 2px solid red;
        color: red;
        text-align: center;
      }
    }
    .yuanyin {
      overflow: hidden;
      font-size: 12px;
      color: #484848;
      margin: 34px 0 0 54px;
      ul {
        overflow: hidden;
        display: inline-block;
        margin-left: 11px;
        li {
          font-size: 12px;
          color: #484848;
          margin-right: 16px;
          input {
            float: left;
            margin: 2px 11px 0 0;
          }
        }
      }
    }
    .haoma {
      font-size: 12px;
      color: #484848;
      margin: 19px 0 0px 54px;
      input {
        width: 250px;
        height: 30px;
        border: 1px solid #ccc;
        margin-left: 13px;
      }
    }
    .shuoming {
      overflow: hidden;
      margin: 10px 0 0 79px;
      p {
        font-size: 12px;
        color: #484848;
      }
      textarea {
        width: 468px;
        height: 60px;
        margin-left: 11px;
      }
      span {
        margin-left: 5px;
      }
    }
    .pingzheng {
      margin: 19px 0 0 57px;
      font-size: 12px;
      color: #484848;
      span {
        cursor: pointer;
        display: inline-block;
        width: 121px;
        height: 28px;
        text-align: center;
        line-height: 28px;
        background: #f9f9f9;
        border: 1px solid #ccc;
        margin-left: 14px;
      }
    }
    .jiahao {
      width: 98px;
      height: 98px;
      border: 1px dashed #ccc;
      margin: 21px 0 23px 133px;
      line-height: 116px;
      text-align: center;
      i {
        font-size: 45px;
        color: #e4e4e4;
      }
    }
    button {
      margin-left: 133px;
      cursor: pointer;
      width: 94px;
      height: 32px;
      border-radius: 3px;
      text-align: center;
      line-height: 32px;
      color: #fff;
      background: red;
    }
    .spa {
      color: #f36a6a;
      margin-left: 0 !important;
    }
  }
  .right {
    width: 289px;
    height: 480px;
    background: #fff;
    .head {
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
        img {
          margin-left: 3px;
        }
      }
    }
  }
}
</style>