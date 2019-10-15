<template>
  <div class="account">
    <logo-component></logo-component>
    <div class="center">
      <ul class="buzhou">
        <li class="l active">1</li>
        <li class="l active">2</li>
        <li class="l">3</li>
      </ul>
      <ul class="zhushi">
        <li class="l actives">立即购买</li>
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
          <div class="dianpu">
            <p class="name">
              店铺：
              <span @click="toStore">{{storeData.shop_name}}</span>
              <img src="../../assets/img/qq.jpg" />
            </p>
            <ul class="order-list">
              <li class="order-info">
                <img @click="toDetails" class="l" :src="URL + goodsImg.pic_url" alt />
                <p @click="toDetails" class="l">{{goodsData.title}}</p>
                <p class="l">无</p>
                <p class="l">{{goodsData.price_member}}</p>
                <p class="l">{{goodsData.goods_num}}</p>
                <p class="l">无</p>
                <p class="r">{{total|keep2Num}}</p>
              </li>
              <li class="fapiao">
                发票信息：
                <span
                  class="invoice-info"
                  v-if="invoiceTit[storeData.id]"
                >{{invoiceTit[storeData.id][0]}}</span>
                <span
                  class="invoice-info"
                  v-if="invoiceTit[storeData.id]"
                >{{invoiceTit[storeData.id][1]}}</span>
                <span
                  class="invoice-info"
                  v-if="invoiceTit[storeData.id]"
                >{{invoiceTit[storeData.id][2]}}</span>
                <span
                  class="invoice-toggle"
                  @click="toggle(storeData.id)"
                  v-if="invoiceState[storeData.id] == 1"
                >修改</span>
                <span class="invoice-toggle" @click="toggle(storeData.id)" v-else>无需发票</span>
              </li>
              <li class="order-item clearfix">
                <div class="order-memo l">
                  <div class="memo l">
                    <span class="memo-title">给卖家留言：</span>
                    <textarea v-model="remarks" class="text-area-input" placeholder></textarea>
                  </div>
                </div>
                <div class="order-extInfo r">
                  <div class="order-deliveryMethod">
                    <span>运送方式：</span>
                    <span>普通运送</span>
                    <span>快递</span>
                    <span>免邮</span>
                    <span class="freight">{{freight_price|keep2Num}}</span>
                  </div>
                  <div class="shop-total">
                    店铺合计（含运费）
                    <span class="total-price">￥{{(total+freight_price)|keep2Num}}</span>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="jifen">使用积分</div>
          <div class="dikou l">
            <p class="l">
              账户共
              <span>200</span>积分 本次使用
              <input type="text" /> 积分
            </p>
            <p class="l">
              抵扣
              <span>￥20.00</span>
            </p>
          </div>
          <div class="l helpjf">
            积分抵用
            <span>￥20.00</span>
          </div>
        </div>
      </div>
      <div class="jiesuan">
        <p>
          <span>{{goodsData.goods_num}}</span>
          件商品，商品总金额：￥{{total|keep2Num}}
        </p>
        <p>积分：-￥0.00</p>
        <p>优惠券：-￥0.00</p>
        <p>运费：￥{{freight_price|keep2Num}}</p>
      </div>
      <div class="pay">
        <p class="yingfu r">
          应付金额：
          <span>￥{{(total+freight_price)|keep2Num}}</span>
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
        <p class="r">
          <a @click="placeOrder">提交订单</a>
        </p>
      </div>
    </div>
    <!--弹出内容    修改-->
    <invoice ref="invoice" @receive-data="receviveData" @receive-state="receiveState"></invoice>
    <foot-com></foot-com>
  </div>
</template>
<script>
export default {
  data() {
    return {
      storeData: {},
      goodsData: {},
      goodsImg: {},
      total: 0,
      addressInfo: {},
      remarks: "",
      invoiceData: {},
      freight_price: 0,
      not_distribution: true,
      invoiceInit: {},
      invoiceGroup: {},
      invoiceState: [],
      invoiceTit: {}
    };
  },
  created() {
    this.getBuyImmediately();
    this.func();
  },
  components: {
    invoice: () => import("../../common/invoice.vue")
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
    // 禁止浏览器后退
    func() {
      history.pushState(null, null, document.URL);
      window.addEventListener("popstate", function() {
        history.pushState(null, null, document.URL);
      });
    },
    getTitle() {
      return "结算页";
    },
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
        this.$alert("当前地址卖家暂无配送", "提示", {
          confirmButtonText: "确定",
          center: true,
          lockScroll: false,
          type: "warning"
        });
        return false;
      }
      if (Object.keys(this.invoiceGroup).length === 0) {
        this.invoiceGroup[this.storeData.id] = {
          translate: 0
        };
      }
      let total = this.total + this.freight_price;
      this.HTTP(
        this.$httpConfig.orderBeginFromGood,
        {
          invoice_id: this.invoiceGroup,
          address_id: this.addressInfo.id,
          remarks: this.remarks
        },
        "post"
      )
        .then(res => {
          this.$router.push({
            path: "/payment",
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
    toDetails() {
      window.open(
        window.location.origin + "/inroyaldrink/" + this.goodsData.id
      );
    },
    toStore() {
      window.open(window.location.origin + "/storehome/" + this.storeData.id);
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
          this.$alert("当前地址卖家暂无配送", "提示", {
            confirmButtonText: "确定",
            center: true,
            lockScroll: false,
            type: "warning"
          });
        });
    },
    //订单数据
    getBuyImmediately() {
      var res = JSON.parse(sessionStorage.getItem("rusToBuy"));
      this.storeData = res.store;
      this.goodsData = res.goods;
      this.goodsImg = res.image;
      this.total =
        parseFloat(this.goodsData.price_member) *
        parseFloat(this.goodsData.goods_num);
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

.dizhi {
  overflow: hidden;
  .biaoti {
    font-size: 14px;
    margin: 18px 0 20px;
    width: 100%;
  }
  .dizhiul {
    overflow: hidden;
    li {
      width: 279px;
      height: 123px;
      border: 1px solid #dedede;
      margin-right: 25px;
      cursor: pointer;
      margin-bottom: 10px;
      p {
        font-size: 12px;
        color: #333;
        padding-left: 13px;
        padding-right: 13px;
      }
      p:nth-of-type(1) {
        line-height: 38px;
        border-bottom: 1px solid #dedede;
      }
      p:nth-of-type(2) {
        margin: 16px 0 10px;
        height: 34px;
      }
      p:nth-of-type(3) {
        color: gray;
      }
    }
    .hover {
      border-color: red !important;
      background: url(../../assets/img/bg.jpg) no-repeat right 0 bottom 0;
    }
    li:nth-child(4n) {
      margin-right: 0;
    }
  }
  .guanli {
    overflow: hidden;
    margin: 15px 0 12px 0;
    button {
      width: 84px;
      height: 25px;
      text-align: center;
      line-height: 25px;
      float: left;
      font-size: 12px;
      cursor: pointer;
    }
    button:nth-of-type(1) {
      background: red;
      color: #fff;
      margin-right: 18px;
    }
    button:nth-of-type(2) {
      width: 84px;
      height: 25px;
      border: 1px solid #dedede;
      color: #333;
    }
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
      .sty {
        width: 200px;
        height: 20px;
        border: 1px solid #d9d9d9;
        line-height: 19px;
        background: #fff;
        padding-left: 10px;
      }
      .order-item {
        padding-left: 15px;
        .order-memo {
          width: 50%;
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
  p {
    width: 182px;
    height: 38px;
    background: #ff5100;
    text-align: center;
    line-height: 38px;
    color: #fff;
    cursor: pointer;
    a {
      display: block;
      width: 100%;
      height: 100%;
      color: #fff;
    }
  }
}
</style>