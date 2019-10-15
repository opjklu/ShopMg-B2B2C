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
      <img v-show="logo1" class="logo" src="../../assets/img/quantui.png">
      <img v-show="logo2" class="logo" src="../../assets/img/quantui1.png">
      <img v-show="logo3" class="logo" src="../../assets/img/quantui2.png">
      <img v-show="logo4" class="logo" src="../../assets/img/quantui3.png">
      <div class="middle">
        <div class="left l" v-show="logo1">
          <div class="up">
            <span>仅退款</span>
          </div>
          <div class="down">
            <div class="yuanyin">退款原因：
              <span>*</span>
              <select name>
                <option value>请选择仅退款原因</option>
                <option value>大小尺寸与商品描述不相符</option>
                <option value>大小尺寸与商品描述不相符</option>
              </select>
            </div>
            <div class="shuoming">
              <p class="l">说明：</p>
              <textarea class="l"></textarea>
              <span>(2/200字)</span>
            </div>
            <div class="jine">退款金额：
              <span>*</span>
              <input type="text"/> 元（最多
              <span>288.68</span>元，含发货邮费
              <span>0.00</span>元）
              <span class="huise">退款金额说明</span>
            </div>
            <div class="pingzheng">上传凭证：
              <span>选择凭证图片</span>
            </div>
            <div class="jiahao">
              <i class="el-icon-plus"></i>
            </div>
            <div class="but">
              <button @click="open">提交申请</button>
            </div>
          </div>
        </div>
        <!--拒绝退货处理-->
        <div class="left l logo2" v-show="logo2">
          <div class="Box">
            <div class="chuli">
              <p class="l">卖家已拒绝，请修改退款申请</p>倒计时：
              <span>04</span>天
              <span>23</span>时
              <span>59</span>分
              <span>48</span>秒
            </div>
            <p
              class="same"
            >. 拒绝原因：你好，经过供应商核实这笔订单为您充值成功！亲，请登录网上营业厅查询缴费记录或者用手机拨打客服查询缴费记录，谢谢。如果查询没到账，麻烦您提供一下手机号的服务密码，我们提交供货商为您进一步核实。</p>
            <p class="same">. 您修改退款申请后，卖家会重新处理。</p>
            <p class="same">. 你逾期未修改，退款申请将自动关闭</p>
          </div>
          <p class="xiugai">您好可以：
            <a @click="xiugai">修改退货退款申请</a>
            <a @click="hit">取消退货退款申请</a>
          </p>
        </div>
        <!--等待卖家确认收货并退款-->
        <!--<div class="left l logo3" v-show="logo3">
					<div class="Box"> 
						<div class="chuli">等待卖家确认收货并退款 </div>
						<p class="same">.  如果卖家收到货并验货无误，将操作退款给您。</p> 
						<p class="same">.  如果卖家拒绝，需要您修改退货退款申请</p><p class="same">. 如果卖家在<span>04</span>天<span>23</span>时<span>41</span>分<span>51</span>秒内未处理，系统将自动退款给您</p>
					</div>
					<p class="xiugai">您好可以：<a @click="xiugai">修改退货退款申请</a></p>
					
        </div>-->
        <!--卖家同意退款退货申请-->
        <div class="left l Logo3" v-show="logo3">
          <div class="up">
            <span>退货地址</span>
          </div>
          <div class="Box">
            <p class="same">未经过卖家同意，请不要使用到付或平邮寄。</p>
            <p class="same">退货信息：闵行区江凯路199号蕾特商务中心311室（收件人：张三，185926548）</p>
          </div>
          <div class="up">
            <span>物流信息</span>
          </div>
          <div class="wuliu">物流公司
            <span>*</span> ：
            <select name>
              <option value>请选择物流公司</option>
              <option value>顺丰</option>
              <option value>圆通</option>
            </select>
          </div>
          <div class="haoma">运单号码
            <span>*</span> ：
            <input type="text">
          </div>
          <div class="shuoming">
            <p class="l">退款说明 ：</p>
            <textarea class="l"></textarea>
            <span class="l">(0/200字)</span>
          </div>
          <div class="pingzheng">上传凭证 ：
            <span>选择凭证图片</span>
          </div>
          <div class="div">
            <div class="jiahao l">
              <i class="el-icon-plus"></i>
            </div>
            <span class="l">每张图片大小不超过5M，最多3张，支持GIF、JPG、PNG、BMP格式</span>
          </div>
          <div class="but">
            <button @click="open">提交申请</button>
          </div>
        </div>
        <!--退款成功-->
        <div class="left l logo4" v-show="logo4">
          <div>退款成功</div>
          <p class="same">. 售后达成时间 2017-06-20-10：50</p>
          <p class="same">. 退款金额：
            <span>230.00</span>元
          </p>
        </div>
        <div class="right r">
          <div class="xiangqing" v-text="title"></div>
          <div class="shangpin">
            <img src="../../assets/img/apply.png">
            <span>小熊电热饭盒保温可插电蒸煮器加热真空保鲜双层不锈钢内胆便当盒</span>
          </div>
          <ul class="ul">
            <li>卖 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 家：bojiechina</li>
            <li>联系电话：0510-87486600</li>
            <li>订单编号：
              <span class="lanse">3215375429258336</span>
            </li>
            <li>单 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 价：
              <span>688.00</span>元*1（数量）
            </li>
            <li>邮 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 费：
              <span>0.00</span>元
            </li>
          </ul>
          <ul class="ul uL" v-show="ul">
            <li>退款编号：827790197963683</li>
            <li>退款金额：
              <span>668.68</span>元
            </li>
            <li>原 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 因：大小尺寸与商品描述不相符</li>
            <li>要 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 求：退货退款</li>
            <li>货物状态：已收到货</li>
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
        <span class="spa">申请条件：若您未收到货，或已收到货且与卖家达成一致不退货仅退款时，请选择“仅退款”选项。</span>
        <span class="spa">退款流程：1.申请退款>2.卖家同意退款申请>3.退款成功</span>
        <p>3.换货</p>
        <span class="spa">申请条件：若您未收到货，或已收到货且与卖家达成一致不退货仅退款时，请选择“仅退款”选项。</span>
        <span class="spa">退款流程：1.申请退款>2.卖家同意退款申请>3.退款成功</span>
      </div>
    </div>
    <modal
      title="撤销申请"
      :width="625"
      :is-show="isopen"
      transition="fadeDown"
      @close="isopen=false"
      :show-footer="false"
    >
      <div class="contents">
        <p class="top">目前售后申请仅有一次机会。为确保您的利益，请您告知撤销申请是由于：</p>
        <p>
          <input type="radio" name="if">卖家要求先撤销，然后才肯提供售后服务
        </p>
        <p>
          <input type="radio" name="if">和卖家协商一致。已解决售后问题
        </p>
        <p>
          <input type="radio" name="if">其他
        </p>
        <button>放弃撤销</button>
        <button>确认撤销</button>
      </div>
    </modal>
    <foot-com></foot-com>
  </div>
</template>
<script>
import myHeader from "./header/myHeader.vue"; //个人中心的头部
export default {
  data() {
    return {
      logo1: true,
      logo2: false,
      logo3: false,
      logo4: false,
      isopen: "",
      title: "订单详情",
      ul: false
    };
  },
  methods: {
    open() {
      this.logo1 = false;
      this.logo2 = true;
      this.title = "退款退货申请";
      this.ul = true;
    },
    xiugai() {
      this.logo1 = true;
      this.logo2 = false;
    },
    hit() {
      this.isopen = !this.isopen;
    }
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
    .down {
      .yuanyin {
        margin: 25px 0 0 55px;
        font-size: 12px;
        color: #484848;
        span {
          color: #f14343;
          margin-right: 13px;
        }
        select {
          width: 250px;
          height: 30px;
          outline: none;
          color: #484848;
        }
      }
      .shuoming {
        overflow: hidden;
        font-size: 12px;
        color: #484848;
        margin: 10px 0 0 79px;
        textarea {
          width: 468px;
          height: 60px;
          margin-left: 11px;
        }
        span {
          margin-left: 5px;
        }
      }
      .jine {
        font-size: 12px;
        margin: 10px 0 0 57px;
        span {
          color: #f14343;
        }
        input {
          margin-left: 11px;
          width: 78px;
          height: 30px;
          border: 1px solid #ccc;
        }
        .huise {
          color: #afafaf;
        }
      }
      .pingzheng {
        margin: 19px 0 0 55px;
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
          margin-left: 17px;
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
      .but {
        margin-left: 133px;
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
  }
  .Logo3 {
    height: 703px;
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
      input {
        width: 250px;
        height: 30px;
        color: #9c9c9c;
        border: 1px solid #ccc;
      }
    }
    .shuoming {
      overflow: hidden;
      font-size: 12px;
      color: #484848;
      margin: 10px 0 0 51px;
      p {
        font-size: 12px;
        color: #484848;
      }
      textarea {
        width: 677px;
        height: 104px;
      }
      span {
        margin-left: 5px;
        margin-top: 87px;
      }
    }
    .pingzheng {
      margin: 19px 0 0 51px;
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
      }
    }
    .div {
      overflow: hidden;
      span {
        color: #999;
        margin: 100px 0 0 15px;
      }
      .jiahao {
        width: 98px;
        height: 98px;
        border: 1px dashed #ccc;
        margin: 21px 0 23px 117px;
        line-height: 116px;
        text-align: center;
        i {
          font-size: 45px;
          color: #e4e4e4;
        }
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