<template>
  <div class="exchange">
    <common-header></common-header>
    <my-header></my-header>
    <div class="center">
      <div class="top"><span>您的位置： </span> <span>交易中心</span> > <span>我的订单 </span> > <span>申请售后</span> > <span>仅换货</span></div>
      <img class="logo" src="../../assets/img/huanhuo.png" />
      <div class="middle">
        <div class="left l">
          <div class="up"><span>换货</span></div>
          <div class="down">
            <!-- <div class="yuanyin">换货原因：<span>*</span><select name="">
                            							<option value="">大小尺寸与商品描述不相符</option><option value="">大小尺寸与商品描述不相符</option><option value="">大小尺寸与商品描述不相符</option>
                            						</select></div> -->
            <div class="shuoming">
              <p class="l">换货原因：</p>
              <i class="l">*</i>
              <textarea class="l" maxlength="200" v-model="explain"></textarea><span>({{explain.length}}/200字)</span>
            </div>
            <div class="pingzheng">上传凭证：<span>选择凭证图片(最多三张)</span>
            </div>
            <div class="jiahao clearfix">
              <div class="image-list l" v-show="upload_list.length != 0">
                <ul class="clearfix">
                  <li class="l" v-for="(item,index) in upload_list" :key="index">
                    <span class="close-ico" @click="del(index)"></span>
                    <img :src="URL + item" alt="">
                  </li>
                </ul>
              </div>
              <div v-show="upload_list.length < 3" class="upload-btn l">
                <input @change="imgChange($event)" accept="image/*" type="file">
                <i class="el-icon-plus"></i>
              </div>
            </div>
            <div class="but" @click="submit"><button>提交申请</button>
            </div>
          </div>
        </div>
        <div class="right r">
          <div class="xiangqing">订单详情</div>
          <div class="shangpin"><img :src="URL + goods.pic_url" /><span>{{goods.title}}</span></div>
          <ul class="ul">
            <li>卖 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 家：{{store_info.shop_name}}</li>
            <li>联系电话：{{store_info.mobile}}</li>
            <li>订单编号：<span class="lanse">{{order_info.order_sn_id}}</span></li>
            <li>单 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 价：<span>{{goods.price_member}}</span> 元* {{goods.goods_num}} (数量)</li>
            <li>邮 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 费：<span>{{order_info.shipping_monery}}</span> 元</li>
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
        explain: '',
        upload_list: [],
        configInfo: {}
  
      }
    },
    created() {
      this.orderInfo();
      this.getImageConfig();
    },
    components: {
      myHeader
    },
    methods: {
      submit() {
        if (!this.explain) {
          this.$message({
            showClose: true,
            message: '请填写换货理由！',
            type: 'error',
            duration: 1000
          });
          return false;
        }
        if (this.upload_list.length === 0) {
          this.$message({
            showClose: true,
            message: '请上传凭证！',
            type: 'error',
            duration: 1000
          });
          return false;
        }
        this.HTTP(this.$httpConfig.customerService, {
          order_id: this.$route.query.id,
          goods_id: this.$route.query.goods_id,
          explain: this.explain,
          apply_img: this.upload_list,
          store_id: this.order_info.store_id
        }, 'post', false).then(res => {
          this.$router.push({
            path: '/disposeChange',
            query: {
              id: this.$route.query.id,
              goods_id: this.$route.query.goods_id
            }
          });
        }).catch((res) => {
  
        })
      },
      del(index) {
        this.upload_list.splice(index, 1);
      },
      getImageConfig() {
        this.HTTP(this.$httpConfig.getCommentImageConfig, {
          id: this.$route.query.id,
  
        }, 'post', false).then(res => {
          this.configInfo = res.data.data;
        }).catch((res) => {
  
        })
      },
      imgChange(e) {
        let  reader  = new  FileReader();  
        let  img1 = e.target.files[0];  
        let  form  =  new  FormData();
        form.append('fileData', img1, img1.name);
        form.append('imageToken', this.configInfo.token);
        form.append('sessionToken', this.configInfo.s_token);
        let config = {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        };   
        this.$ajax.post(this.$httpConfig.uploadImageByImageComment, form, config)
          .then(res => {
            if (res.data.status == 10001) {
              this.$router.push("/passwordLogin");
            } else {
              if (res.data.status === 1) {
                this.upload_list.push(res.data.data);
              } else {
                alert(res.data.message);
              }
            }
          });
      },
      orderInfo() {
        this.HTTP(this.$httpConfig.orderDetails, {
          id: this.$route.query.id
        }, 'post', false).then(res => {
          for (let index = 0; index < res.data.data.goods.length; index++) {
            if (res.data.data.goods[index].goods_id === this.$route.query.goods_id) {
              this.goods = res.data.data.goods[index];
            }
          }
          this.store_info = res.data.data.store;
          this.order_info = res.data.data.order;
        })
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
      height: 437px;
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
          margin: 25px 0 0 55px;
          // margin: 10px 0 0 79px;
          i {
            color: #f14343;
            font-style: normal;
          }
          p {
            font-size: 12px;
          }
          textarea {
            padding: 5px 0 0 5px;
            width: 468px;
            height: 60px;
            margin-left: 11px;
          }
          span {
            margin-left: 5px;
          }
        }
        .pingzheng {
          margin: 19px 0 0 55px;
          font-size: 12px;
          color: #484848;
          span {
            display: inline-block;
            height: 28px;
            text-align: center;
            padding: 0 10px;
            line-height: 28px;
            background: #f9f9f9;
            border: 1px solid #ccc;
            margin-left: 17px;
          }
        }
        .jiahao {
          margin: 21px 0 23px 133px;
          .image-list {
            ul {
              li {
                position: relative;
                margin-right: 10px;
                width: 98px;
                height: 98px;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                -ms-border-radius: 4px;
                -o-border-radius: 4px;
                border-radius: 4px;
                .close-ico {
                  position: absolute;
                  width: 24px;
                  height: 24px;
                  right: -6px;
                  top: -6px;
                  cursor: pointer;
                  z-index: 2;
                  background: url(../../assets/img/clone-icon.png) center center no-repeat;
                }
                img {
                  height: 100%;
                }
              }
            }
          }
          .upload-btn {
            width: 98px;
            border: 1px dashed #ccc;
            height: 98px;
            line-height: 116px;
            text-align: center;
            position: relative;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            -ms-border-radius: 4px;
            -o-border-radius: 4px;
            border-radius: 4px;
          }
          input {
            cursor: pointer;
            opacity: 0;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
          }
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
            a {
              font-size: 13px;
            }
          }
        }
      }
    }
    .right {
      width: 289px;
      height: 437px;
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
          width: 52px;
          height: 52px;
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
</style>