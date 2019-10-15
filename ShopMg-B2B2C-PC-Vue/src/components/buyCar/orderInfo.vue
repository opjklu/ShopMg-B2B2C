<template>
  <div class="account">
    <div class="logo">
      <img @click="toHome" :src="logo_name" />
      <p>结算页</p>
    </div>
    <div class="center">
      <ul class="buzhou">
        <li class="l active">1</li>
        <li class="l active">2</li>
        <li class="l">3</li>
      </ul>
      <ul class="zhushi">
        <li class="l actives">我的购物车</li>
        <li class="l actives">确认订单信息</li>
        <li class="l">成功提交订单</li>
      </ul>
      <address-operation @transferAddress="transferAddress"></address-operation>
      <div class="xinxi">
        <p class="biaoti">确认订单信息</p>
        <div class="bottom">
          <div class="thead">
            <p class="l">店铺宝贝</p>
            <p class="l">商品属性</p>
            <p class="l">单价</p>
            <p class="l">数量</p>
            <p class="l">优惠方式</p>
            <p class="l">小计</p>
          </div>
          <div class="dianpu" v-for="(item, index) in buyData.store" :key="index">
            <p class="name">
              店铺：
              <span @click="toStore(item.id)">{{item.shop_name}}</span>
              <img src="../../assets/img/qq.jpg" />
            </p>
            <ul class="order-list" v-for="(d,i) in setName" :key="i">
              <p class="set-meal-title">{{d}}</p>
              <li
                class="order-info"
                v-if="ite.store_id == item.id && ite.package_id == i"
                v-for="(ite,inde) in buyData.goods"
                :key="inde"
              >
                <img @click="toDetails(ite.goods_id)" class="l" :src="URL + ite.pic_url" alt />
                <p @click="toDetails(ite.goods_id)" class="l">{{ite.title}}</p>
                <p class="l">{{ite.shuxing}}</p>
                <p class="l">{{ite.goods_discount}}</p>
                <p class="l">{{ite.goods_num}}</p>
                <p class="l">{{ite.youhui}}</p>
                <p class="r">{{Number(ite.goods_discount) * Number(ite.goods_num)}}</p>
              </li>
            </ul>
            <div class="fapiao">
              发票信息：
              <span class="invoice-info" v-if="invoiceTit[item.id]">{{invoiceTit[item.id][0]}}</span>
              <span v-if="invoiceTit[item.id]" class="invoice-info">{{invoiceTit[item.id][1]}}</span>
              <span v-if="invoiceTit[item.id]" class="invoice-info">{{invoiceTit[item.id][2]}}</span>
              <span
                class="invoice-toggle"
                @click="toggle(item.id)"
                v-if="invoiceState[item.id] == 1"
              >修改</span>
              <span class="invoice-toggle" @click="toggle(item.id)" v-else>无需发票</span>
            </div>
            <div class="order-item clearfix">
              <div class="order-memo l">
                <div class="memo l">
                  <span class="memo-title">给卖家留言：</span>
                  <textarea v-model="params_goods[item.id]" class="text-area-input" placeholder></textarea>
                </div>
              </div>
              <div class="order-extInfo r">
                <div class="order-deliveryMethod">
                  <span>运送方式：</span>
                  <span>普通运送</span>
                  <span>快递</span>
                </div>
              </div>
            </div>
          </div>
          <div class="jifen">使用积分</div>
          <div class="dikou l">
            <p class="l">
              账户共
              <span>0</span>积分 本次使用
              <input type="text" /> 积分
            </p>
            <p class="l">
              抵扣
              <span>￥00.00</span>
            </p>
          </div>
          <div class="l helpjf">
            积分抵用
            <span>￥0.00</span>
          </div>
        </div>
      </div>
      <div class="jiesuan">
        <p>
          <span>{{total_num}}</span>
          件商品，商品总金额：￥{{Number(total_price)|keep2Num}}
        </p>
        <p>积分：-￥0.00</p>
        <p>优惠券：-￥0.00</p>
        <p>运费：￥{{freight_price|keep2Num}}</p>
      </div>
      <div class="pay">
        <p class="yingfu r">
          应付金额：
          <span>￥{{(Number(total_price) + Number(freight_price))|keep2Num}}</span>
        </p>
        <div class="r">
          <p class="l">
            寄送至：
            <span>{{addressInfo.prov_name}}{{addressInfo.city_name}}{{addressInfo.dist_name}} {{addressInfo.address}}</span>
          </p>
          <p class="l">
            收货人：
            <span>{{addressInfo.realname}} {{addressInfo.mobile}}</span>
          </p>
        </div>
      </div>
      <div class="submit">
        <p class="r" @click="placeOrder">
          <a>提交订单</a>
        </p>
        <p class="r">
          <router-link to="buyCar">
            <img src="../../assets/img/fanhui.jpg" />返回购物车
          </router-link>
        </p>
      </div>
    </div>
    <!--弹出内容    修改-->
    <invoice ref="invoice" @receive-data="receviveData" @receive-state="receiveState"></invoice>

    <foot-com></foot-com>
  </div>
</template>

<script>
import { TimeInterval } from "../../../es6/time";
export default {
  data() {
    return {
      addressInfo: {},
      freight_price: 0,
      not_distribution: true,
      buyData: "",
      params_goods: {},
      total_num: 0,
      invoiceData: {},
      invoiceInit: {},
      invoiceGroup: {},
      invoiceState: [],
      invoiceTit: {},
      total_price: 0,
      setName: {},
      logo_name: ""
    };
  },
  components: {
    invoice: () => import("../../common/invoice.vue")
  },
  created() {
    if (!sessionStorage.getItem("cart_id")) {
      this.$router.push("/packageOrder");
      return false;
    }
    this.getcartOrder();
  },
  mounted() {
    let data = TimeInterval.getItem("web_info");

    if (data) {
      this.logo_name = URL + data.logo_name;
    }
  },
  methods: {
    /**
     * @param {{}} invoiceTit
     *  @param {{}} invoiceInit
     *  @param {{}} invoiceGroup
     */
    receviveData(invoiceTit, invoiceInit, invoiceGroup) {
      this.invoiceInit = invoiceInit;

      this.invoiceTit = invoiceTit;

      this.invoiceGroup = invoiceGroup;
    },
    /**
     * @param {Array} invoiceState
     */
    receiveState(invoiceState) {
      this.invoiceState = invoiceState;
    },
    toStore(id) {
      window.open(window.location.origin + "/storehome?id=" + id);
    },
    toDetails(id) {
      window.open(window.location.origin + "/inroyaldrink?id=" + id);
    },
    toHome() {
      window.open(window.location.origin + "/home");
    },
    //提交订单
    placeOrder() {
      if (!this.addressInfo.id) {
        this.$alert("当前收货人信息不对，请修改后再提交", "提示", {
          confirmButtonText: "确定",
          center: true,
          lockScroll: false,
          type: "warning"
        });
        return false;
      }
      if (!this.not_distribution) {
        this.$alert("当前地址部分卖家暂无配送", "提示", {
          confirmButtonText: "确定",
          center: true,
          lockScroll: false,
          type: "warning"
        });
        return false;
      }
      if (Object.keys(this.invoiceGroup).length === 0) {
        for (let index = 0; index < this.buyData.store.length; index++) {
          this.invoiceGroup[this.buyData.store[index].id] = {
            translate: 0
          };
        }
      }
      if (Object.keys(this.params_goods).length === 0) {
        for (let index = 0; index < this.buyData.store.length; index++) {
          this.params_goods[this.buyData.store[index].id] = "";
        }
      }
      let total = parseFloat(this.total_price) + parseFloat(this.freight_price);
      this.HTTP(
        this.$httpConfig.orderBeginByCart,
        {
          goods: this.params_goods, //留言
          address_id: this.addressInfo.id, //收货地址ID
          invoice_id: this.invoiceGroup //发票id
        },
        "post"
      )
        .then(res => {
          sessionStorage.removeItem("cart_id");
          this.$router.push({
            path: "/packagePay",
            query: {
              total_price: total
            }
          });
        })
        .catch(res => {
          this.$alert(res.message, "提示", {
            confirmButtonText: "确定",
            center: true,
            lockScroll: false,
            type: "warning"
          });
        });
    },
    getcartOrder() {
      this.HTTP(
        this.$httpConfig.toSettleAccounts,
        {
          id: sessionStorage.getItem("cart_id")
        },
        "post"
      )
        .then(res => {
          this.buyData = res.data;
          let goodsList = this.buyData.goods;
          for (const key in goodsList) {
            this.total_price +=
              parseInt(goodsList[key].goods_num) *
              parseFloat(goodsList[key].goods_discount);
            this.setName[goodsList[key].package_id] =
              goodsList[key].package_title; //重新整理套餐名字数据
            this.total_num += parseInt(goodsList[key].package_num);
          }
        })
        .catch(res => {});
    },
    //地址
    transferAddress(address) {
      this.addressInfo = address;
      this.getFreight();
    },
    //获取运费
    getFreight() {
      this.HTTP(
        this.$httpConfig.getFreight,
        {
          prov_id: this.addressInfo.prov,
          city_id: this.addressInfo.city,
          dist_id: this.addressInfo.dist
        },
        "post"
      )
        .then(res => {
          this.not_distribution = true;
          this.freight_price = parseFloat(res.data);
        })
        .catch(res => {
          this.not_distribution = false;
          this.$alert("当前地址部分卖家暂无配送", "提示", {
            confirmButtonText: "确定",
            center: true,
            lockScroll: false,
            type: "warning"
          });
        });
    }
  }
};
</script>

<style>
.el-message-box--center {
  padding-bottom: 30px !important;
}

.el-message-box--center .el-message-box__header {
  padding-top: 30px !important;
}
</style>

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

.logo {
  height: 115px;
  width: 1200px;
  margin: 0 auto;
  img {
    margin-top: 28px;
    float: left;
    cursor: pointer;
  }
  p {
    font-size: 24px;
    float: left;
    margin: 40px 0 0 29px;
  }
}

.buzhou {
  height: 50px;
  background: url(../../assets/img/buzhou.jpg) no-repeat center;
  li {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #878788;
    text-align: center;
    line-height: 42px;
    font-size: 20px;
    color: #fff;
    font-weight: 900;
    margin-top: 4px;
  }
  li:nth-of-type(1) {
    margin-left: 207px;
  }
  li:nth-of-type(2) {
    margin: 4px 353px 0 343px;
  }
  .active {
    background: #d3b73c !important;
  }
}

.zhushi {
  height: 42px;
  li {
    font-size: 14px;
    color: #666;
    line-height: 42px;
  }
  li:nth-of-type(1) {
    margin-left: 192px;
  }
  li:nth-of-type(2) {
    margin: 0 310px 0 313px;
  }
  .actives {
    color: #d3b73c !important;
  }
}

.xinxi {
  overflow: hidden;
  .biaoti {
    font-size: 12px;
    color: #262626;
    margin: 20px 0;
  }
  .bottom {
    border: 1px solid #eaeaea;
    overflow: hidden;
    .thead {
      height: 51px;
      border-bottom: 1px solid #eaeaea;
      margin: 0 38px;
      line-height: 60px;
      float: left;
      width: 1124px;
      p {
        font-size: 12px;
      }
      p:nth-of-type(2) {
        margin: 0 103px 0 300px;
      }
      p:nth-of-type(4) {
        margin: 0 135px 0 131px;
      }
      p:nth-of-type(6) {
        margin-left: 189px;
      }
    }
  }
  .dianpu {
    overflow: hidden;
    margin: 0 38px;
    float: left;
    margin-top: 18px;
    width: 1124px;
    .name {
      font-size: 12px;
      line-height: 32px;
      height: 30px;
      img {
        margin: -5px 0 0 12px;
      }
      span {
        cursor: pointer;
      }
      span:hover {
        color: red;
      }
    }
    .order-list {
      .set-meal-title {
        padding: 10px 0;
        font-size: 13px;
      }
      .order-info {
        height: 80px;
        background: #fcfcfc;
        margin-bottom: 1px;
        img {
          margin: 16px 9px 0 13px;
          width: 60px;
          height: 57px;
          cursor: pointer;
        }
        p {
          font-size: 12px;
          color: #666;
          margin-top: 17px;
        }
        p:nth-of-type(1) {
          width: 192px;
          margin-right: 93px;
          cursor: pointer;
        }
        p:nth-of-type(1):hover {
          color: red;
        }
        p:nth-of-type(3) {
          margin: 17px 147px 0 123px;
        }
        p:nth-of-type(5) {
          margin: 17px 0px 0 141px;
        }
        p:last-child {
          color: #dd2727;
          margin: 17px 47px 0 0;
        }
      }
      select {
        margin: 17px 0 0 108px;
      }
      .sty {
        width: 200px;
        height: 20px;
        border: 1px solid #d9d9d9;
        line-height: 19px;
        background: #fff;
        padding-left: 10px;
      }
    }
    .fapiao {
      height: 45px;
      line-height: 45px;
      font-size: 12px;
      color: #616161;
      padding-left: 15px;
      .invoice-info {
        color: #313131;
        margin-right: 5px;
      }
      .invoice-toggle {
        color: #378ce4;
        cursor: pointer;
      }
      .invoice-toggle:hover {
        color: red;
      }
    }
    .order-item {
      padding-left: 15px;
      .order-memo {
        width: 50%;
        min-height: 79px;
        .memo {
          padding: 10px 0;
          .memo-title {
            color: #3c3c3c;
            font-size: 12px;
          }
          .text-area-input {
            vertical-align: top;
            width: 328px;
            resize: none;
            height: 20px;
            line-height: 18px;
            text-indent: 4px;
            border: 1px solid #ccc;
            outline: 0;
            overflow: auto;
          }
          .text-area-input:focus {
            height: 59px;
          }
        }
      }
      .order-extInfo {
        width: 50%;
        height: 79px;
        text-align: right;
        div {
          padding: 10px 0;
          font-size: 12px;
          .freight {
            color: #dd2727;
            margin: 0 45px 0 53px;
          }
          .total-price {
            font-size: 13px;
            color: #df7344;
            margin: 0 40px 0 10px;
          }
        }
      }
    }
  }
  .jifen {
    margin-top: 31px;
    font-size: 12px;
    color: #363636;
    border-bottom: 1px solid #eaeaea;
    float: left;
    width: 1124px;
    margin-left: 37px;
    height: 21px;
  }
  .dikou {
    height: 44px;
    line-height: 44px;
    width: 1124px;
    margin-left: 37px;
    p {
      font-size: 12px;
      color: #363636;
      margin-right: 21px;
      input {
        width: 86px;
        height: 22px;
        border: 1px solid #e3e3e3;
        margin: 0 10px 0 6px;
      }
      span {
        color: #f28765;
      }
    }
  }
  .helpjf {
    height: 44px;
    line-height: 44px;
    width: 1124px;
    margin-left: 37px;
    background: #fcfcfc;
    padding-left: 16px;
    font-size: 12px;
    color: #363636;
    span {
      color: #dd2727;
    }
  }
}

.jiesuan {
  margin-top: 30px;
  p {
    text-align: right;
    width: 100%;
    font-size: 12px;
    color: #484848;
    margin-bottom: 7px;
    span {
      color: #df7344;
    }
  }
}

.pay {
  height: 100px;
  background: #eaeaea;
  text-align: right;
  .yingfu {
    font-size: 15px;
    color: #2e2e2e;
    margin: 23px 25px 0 0;
    width: 100%;
    span {
      font-size: 19px;
      color: #e82825;
    }
  }
  div.r {
    margin-top: 20px;
    p {
      font-size: 12px;
      color: #656565;
      margin-right: 23px;
    }
  }
}

.submit {
  overflow: hidden;
  margin-top: 15px;
  margin-bottom: 136px;
  p:nth-of-type(1) {
    width: 182px;
    height: 38px;
    background: #ff5100;
    text-align: center;
    line-height: 38px;
    color: #fff;
    cursor: pointer;
    a {
      color: #fff;
    }
  }
  p:nth-of-type(2) {
    font-size: 12px;
    color: #3969cf;
    margin: 15px 38px 0 0;
    cursor: pointer;
  }
}
.contents {
  margin: 20px 0 143px 0;
  div {
    text-align: left;
    font-size: 12px;
    overflow: hidden;
    span {
      color: #ff2626;
    }
  }
  div:nth-of-type(1) {
    p {
      font-size: 12px;
    }
    select {
      width: 90px;
      height: 24px !important;
      outline: none;
      float: left;
    }
    p:nth-of-type(2) {
      width: 363px;
      height: 24px;
      margin-left: 8px;
      .behind {
        width: 364px;
        height: 24px;
        padding-left: 13px;
        height: 22px;
      }
      i {
        float: right;
        margin: 4px 10px 0 0;
      }
    }
  }
  div:nth-of-type(2) {
    margin-top: 15px;
    p {
      font-size: 12px;
    }
    textarea {
      width: 463px;
      height: 85px;
      padding: 10px 0 0 18px;
    }
  }
  div:nth-of-type(3) {
    padding-left: 5px;
    margin-top: 15px;
    input {
      width: 281px;
      height: 24px;
      border: 1px solid #ccc;
    }
  }
  div:nth-of-type(4) {
    margin-left: -11px;
    margin-top: 15px;
    input {
      width: 281px;
      height: 24px;
      border: 1px solid #ccc;
    }
  }
  div:nth-of-type(5) {
    margin-top: 15px;
    input {
      width: 281px;
      height: 24px;
      border: 1px solid #ccc;
    }
  }
  div:nth-of-type(6) {
    padding-left: 5px;
    margin-top: 15px;
    input {
      width: 281px;
      height: 24px;
      border: 1px solid #ccc;
    }
  }
  .moren {
    margin-top: 21px;
    font-size: 12px;
    margin-left: 64px;
    input {
      margin: 2px 8px 0 0;
      float: left;
    }
  }
  .baocun {
    cursor: pointer;
    font-size: 12px;
    margin-left: 64px;
    height: 32px;
    width: 72px;
    border-radius: 3px;
    background: #ff6000;
    text-align: center;
    line-height: 32px;
    color: #fff;
    margin-top: 15px;
  }
}
</style>