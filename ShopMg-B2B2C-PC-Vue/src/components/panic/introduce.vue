<template>

  <div id="custom">
    <head-com></head-com>
    <div id="share">
      <div class="center">
        <div class="last">
          <img class="l" src="../../assets/img/qianggou/house.png" />
          <p>
            <router-link to="home" class="l sopt">首页></router-link>
            <router-link to="chase" class="l sopt">抢购></router-link>
            <a class="l special">{{info.title}}</a>
          </p>
        </div>
        <div class="center-page">
        <div class="left l">
          <div class="wood l">
            <p class="funrin"><img :src="URL+bigImg" /></p>
            <div class="bot">
              <p class="l commom" @click="left">
                <!-- <img src="../../assets/img/qianggous/pic2.png" /> -->
                <i class="el-icon-caret-left"></i>
              </p>
              <div class="slideshow">
                <ul id="more-img">
                  <li v-show="smallPics.isShow" v-for="(smallPics, index) in imgArr" :key="index" class="l" :class="index ==selectedIndex?'selected':''">
                    <img @click="getBigImgs(index,smallPics.pic)" :src='URL+smallPics.pic' class="smallImg">
                  </li>
                </ul>
              </div>
              <p class="l commom" @click="right">
                <!-- <img src="../../assets/img/qianggous/pic3.png" /> -->
                <i class="el-icon-caret-right"></i>
              </p>
            </div>
            <p class="l fact">
              <span class="l kuai"><img src="../../assets/img/shuqian.jpg" /></span>
              <span class="l texts">分享</span>
            </p>
            <p class="l fact">
              <span class="l kuai"><img src="../../assets/img/shuqian.jpg" /></span>
              <span class="l texts">收藏商品</span>
            </p>
          </div>
          <div class="middle l">
            <p class="north">{{info.title}}</p>
            <p class="love">{{info.panic_title}}</p>
            <div class="backcolor">
              <p class="price">
                <span class="orgin l">原&nbsp;&nbsp;价:</span>
                <span class="orgins l">￥{{info.price_market}}</span>
              </p>
              <p class="chasePrice">
                <span class="orgin l">抢购价:</span>
                <span class="orgins l">￥{{info.panic_price}}</span>
              </p>
              <p class="rest" v-if="showTimeType!=2">
                <span>{{showTimeTypeArr[showTimeType]}}：</span>
                <span>{{showTime}}</span>
                <span v-show="showTimeType == 1">结束</span>
              </p>
              <p class="rest" v-else>
                <span>已结束</span>
              </p>
              <p class="ownCustom l">
                <span class="l me">本商品已被抢购</span>
                <span class="l blood">{{info.already_num}}</span>
                <span class="l me">件</span>
              </p>
              <p class="quality l">数量有限，预购从速</p>
            </div>
            <div class="peisong">
              <p class="l distance">
                配送至：
                <select name="">
                  <option value="">北京 北京市</option>
                </select>

              </p>
              <p class="distance l">
                <span class="l">运费：</span>
                <span class="l">10元;</span>
              </p>
              <p class="duty">
                <span class="l">服&nbsp;&nbsp;&nbsp;务:</span>
                <span class="l">&nbsp;&nbsp;&nbsp;由</span>
                <span class="l espical" @click="toStore(info.shop_id)">{{info.shop_name}}</span>
                <span class="l">负责发送，并提供售后服务</span>
              </p>
            </div>
            <div class="buyGoods">
              <ul>
                <li class="l">
                  <span class="l chese">累计评价</span>
                  <span class="l numbe">{{info.comment_member}}人</span>
                </li>
                <li class="l">
                  <span class="l chese">累计销量</span>
                  <span class="l numbe">{{info.sales_sum}}人</span>
                </li>
                <li class="l">
                  <span class="l chese">赠送积分</span>
                  <span class="l numbe">0分</span>
                </li>
              </ul>
              <div class="kuCun">
                <span class="l math">数量：</span>
                <input class="l" type="text" value="1" v-model="me" />
                <p class="l addTo">
                  <a class="pane" @click="add(me)">+</a>
                  <a class="pan" @click="dec(me)">-</a>
                </p>
                <p class="l after">件&nbsp;库存&nbsp;{{info.panic_num}}&nbsp;件，限购&nbsp;{{info.quantity_limit}}&nbsp;件</p>
              </div>
              <div class="submit">
                <p class="button el-button--warning appre" v-if="showTimeType == 1" @click="pay(info.id)">立即抢购</p>
                <p class="button el-button--warning appre gray" v-else>{{showTimeTypeArr[showTimeType]}}</p>
                <div id="qrcode" ref="qrcode"></div>
                <p class="r iphone" @mouseover="showCode" @mouseout="hideCode">
                  <span class="buyIphone">手机购买</span>
                  <img style="width: 20px;height: 20px;" src="../../assets/img/samllerweima.jpg" />
                </p>
              </div>
            </div>
          </div>
          <div class="check l">
            <p class="mistake">
              <a class="l sps" @click="introdu(0)" :class="{bg:isbg==0}">商品介绍</a>
              <a class="l sps" @click="introdu(1)" :class="{bg:isbg==1}">商品评价
                <i>{{info.comment_member}}</i>
              </a>
              <a class="l sps" @click="introdu(2)" :class="{bg:isbg==2}">商品咨询
                <i>{{info.count}}</i>
              </a>
              <a class="sp l"></a>
            </p>
            <div class="checkbox">
              <ul class="family" v-show="off==0">
                <li class="l son">商家号：
                  <span>987912</span>
                </li>
                <li class="l son">品牌：
                  <span></span>
                </li>
                <li class="l son">类别：
                  <span>不限</span>
                </li>
                <li class="l son">材料：
                  <span></span>
                </li>
                <li class="l son">工艺：
                  <span></span>
                </li>
                <li class="l son">窑口：
                  <span></span>
                </li>
              </ul>
              <div class="family family1" v-show="off==1">
                <div>{{commentList}}</div>
              </div>
              <div class="family family1" v-show="off==2">
                <div>{{goodsConsulList}}</div>
              </div>
            </div>
            <div class="picimg" v-html="info.detail" v-show="off==0">
            </div>
          </div>
        </div>
        <div class="right l">
          <p class="term">本周热门抢购</p>
          <dl v-for="(rightPics,index) in hotGoods" :key="index">
            <dt><img :src="URL+rightPics.pic_url" /></dt>
            <dd>
              <p class="nature">{{rightPics.title}}</p>
              <p class="l money">{{rightPics.panic_price}}</p>
              <p class="r aim">
                <span class="aims">销量：</span>
                <span class="biggest">{{rightPics.already_num}}</span>
              </p>
            </dd>
          </dl>
        </div>
        </div>
      </div>
    </div>
    <foot-com></foot-com>
  </div>
</template>
<script>
import $ from 'jquery'

import QRCode from 'qrcodejs2';
export default {
  data() {
    return {

      impListData: {
        config: {
          value: '网址',
          imagePath: 'pic8',//（需要个图片作为背景）
          filter: 'color',
          size: 500
        }
      },
      id: 0,
      info: {
      },
      bigImg: '',
      hotGoods: [],
      timer: null, //定时器  
      mark: 0, //比对图片索引的变量
      off: false,
      isbg: "",
      val: "",
      me: 1,
      number: 0,//显示最下面的次数
      selectedIndex: 0,
      showTimeType: '',
      showTimeTypeArr: ['距开售还剩', '还剩', '已结束'],
      showTime: '',//要显示在页面上的时间
      intervalid: '',//计时器ID
      commentList: [],//评论列表数据
      goodsConsulList:[],//咨询列表数据
      imgArr: [],

    }
  },
  created() {
    this.id = this.$route.params.id;
    this.getDetails();
    this.intervalid = setInterval(this.comTime, 1000);
  },
  mounted() {
     this.hotBuyThisWeek();
  },
  beforeDestroy() {
    clearInterval(this.intervalid)
  },
  components: {
    QRCode
  },
  methods: {
    // 结算
    pay(id){
      if(this.me!=0){
      this.HTTP(this.$httpConfig.getBuyImmediately, {
        id:id,
        goods_num: this.me
      }, 'post', false).then((res) => {
        sessionStorage.setItem('rusToBuy',JSON.stringify(res.data));
        this.$message.success(res.message);
        if(res.status){
          this.$router.push({path:'/settleAccounts',query:{id:id,num:this.me}})
        }
        
      }).catch((e)=>{
        this.$message.error(e.data.message);
      })
      
      }else{
        this.$message.error('购买数量不能为0');
      }
      
    },
    // 本周热门抢购
    async hotBuyThisWeek()
    {
       this.HTTP(this.$httpConfig.hotBuyThisWeek, {}, 'post').then((res) => {
           this.hotGoods = res.data;
      }).catch((error) => {
        
      });
    },
    toStore(id){
      window.open(window.location.origin+'/storehome/'+id)
    },
    qrcode() {
      let qrcode = new QRCode('qrcode', {
        width: 200,  // 设置宽度 
        height: 200, // 设置高度
        text: 'http://wx.shopqorg.com/product/' + this.id + '/1'
      })
    },
    showCode() {
      console.log('eee')
      this.$nextTick(function () {
        this.qrcode();
      })
    },
    hideCode() {
      $('#qrcode').hide();
    },
    getDetails() {
      this.HTTP(this.$httpConfig.getInnerPanic, { id: this.id }, 'post').then((res) => {
        this.info = res.data.panic;
        this.bigImg = res.data.images[0].pic_url;

        for (let  i = 0;  i < res.data.images.length; i++) {
          var item = { isShow: true, pic: '' };
          item.pic =  res.data.images[i].pic_url;
          this.imgArr.push(item);
        }
        this.hotGoods = res.data.right;
        this.comTime();
      })
    },
    introdu(index) {
      this.off = index;
      this.isbg = index;
      switch (index) {
        case 0:
          
          break;
      
        case 1:
          this.getComment();
          break;
      
        case 2:
        this.getGoodsConsultation();
          break;
      
        default:
          break;
      }
      
    },
    // 增加数量
    add() {
      if (this.me >= Number(this.info.quantity_limit)) {
        return false;
      } else {
        return this.me++;
      }
      //				this.me++;

    },
    // 减少数量
    dec() {
      if (this.me <= 1) {
        return;
      } else {
        return this.me--;
      }

    },
    // 左移动一个图片
    left() {
      console.log(this.number, this.imgArr.length)
      if (this.number < 0) {
        return;
      }
      this.imgArr[this.number].isShow = true;
      if (this.number == 0) {
        return;
      }
      this.number--;
    },
    // 右移动一个图片
    right() {
      console.log(this.number, this.imgArr.length)
      if (this.imgArr.length - this.number == 5) {
        return;
      }
      this.imgArr[this.number].isShow = false;
      this.number++;
    },
    // 点击小图得到大图
    getBigImgs(index, img) {
      this.selectedIndex = index;
      this.bigImg = img;
    },
    //判断并计算时间
    comTime() {
      var now = Math.round(new Date().getTime() / 1000);

   
      if (this.info.start_time > now) {
        // 未开始
        this.showTimeType = 0;
        this.getTime2(this.info.start_time);
      } else if (now > this.info.start_time && now < this.info.end_time) {
        // 进行中
        this.showTimeType = 1;
        this.getTime(this.info.end_time);
      } else {
        // 已结束
        this.showTimeType = 2;

      }
    },
    //获取抢购剩余时间
    getTime(value) {
      var now = Math.round(new Date().getTime() / 1000);
      var nTime = value - now;
      var day = Math.floor(nTime / 60 / 60 / 24);
      var hour = Math.floor(nTime / 60 / 60);
      var minute = Math.floor(nTime / 60) - hour * 60;
      var getSet = nTime - hour * 60 * 60 - minute * 60;
      this.showTime = day + "天" + (hour - day * 24) + "小时" + minute + "分" + getSet + '秒';
    },
    // 未开始，计算还有多少时间 才开始
    getTime2(value) {
      var now = Math.round(new Date().getTime() / 1000);
      var nTime = value - now;
      var day = Math.floor(nTime / 60 / 60 / 24);
      var hour = Math.floor(nTime / 60 / 60);
      var minute = Math.floor(nTime / 60) - hour * 60;
      var getSet = nTime - hour * 60 * 60 - minute * 60;
      this.showTime = day + "天" + (hour - day * 24) + "小时" + minute + "分" + getSet + '秒';
    },
    // 评论列表
    getComment() {
      this.HTTP(this.$httpConfig.problemGoodsComment, { goods_id: this.id }, 'post').then((res) => {
        this.commentList = res.data;
      })
    },
    // 咨询列表
    
    getGoodsConsultation() {
      this.HTTP(this.$httpConfig.getGoodsConsultation, { goods_id: this.id }, 'post').then((res) => {
        this.goodsConsulList = res.data;
      })
    }

  },
  computed: {

  }

}
</script>

<style lang="less" scoped >
#custom {
  background: #fff;
}
.center {
  width: 1192px;
  height: 100%;
  margin: 0 auto;
  border: 1px solid #fff;
  // box-sizing: border-box;
}

.l {
  float: left;
}

.r {
  float: right;
}

#share {
  width: 100%;
  height: 100%;
  .center {
    .last {
      width: 100%;
      height: 38px;
      img {
        margin-top: 15px;
        margin-right: 8px;
      }
      .sopt {
        display: inline-block;
        height: 38px;
        line-height: 38px;
        color: #a8a7a5;
      }
      .special {
        display: inline-block;
        height: 38px;
        line-height: 38px;
        color: #515151;
        width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
    }
    .center-page{
      height: auto;
      // min-height: 1320px;
      overflow: hidden;
      display: flex;
    .left {
      width: 995px;
      // min-height: 1320px;
      height: 100%;
      .wood {
        width: 400px;
        height: 528px;
        .funrin {
          width: 400px;
          height: 400px;
          // line-height: 400px;
          // vertical-align: middle;
          // text-align: center;
          border: 1px solid #d3d3d3;
          box-sizing: border-box;
          overflow: hidden;
          img {
            width: 400px;
            height: 400px;
          }
        }
        .bot {
          width: 400px;
          margin-top: 14px;
          height: 60px;
          display: flex;
          flex-direction: row;
          justify-content: space-between;
          .slideshow {
            width: 360px;
            height: 60px;
            position: relative;
            ul {
              position: absolute;
              width: 360px;
              height: 60px;
              overflow: hidden;
              li {
                width: 60px;
                height: 60px;
                margin: 0 6px;
                border: 1px solid #dddddd;
                .smallImg {
                  width: 56px;
                  height: 56px;
                }
              }
              li.selected {
                border: 1px solid #333;
              }
            }
          }
          .commom {
            cursor: pointer;
                width: 25px;
                height: 58px;
                border: 1px solid #dcdcdc;
                box-sizing: border-box;
                text-align: center;
                line-height: 52px;
                // margin-top: 4px;
                i {
                    color: #dcdcdc;
                }
            // width: 25px;
            // height: 58px;
            // img{
            //   width: 100%;
            //   height: 100%;
            // }
          }
        }
        .fact {
          margin: 20px 25px 20px 0;
          cursor: pointer;
          .kuai {
            margin-right: 5px;
          }
          .texts {
            color: #9b9a96;
          }
        }
      }
      .middle {
        width: 570px;
        height: 528px;
        margin-left: 18px;
        position: relative;
        .north {
          width: 100%;
          height: 26px;
          line-height: 26px;
          color: #303030;
          font-size: 18px;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }
        .love {
          width: 100%;
          height: 35px;
          line-height: 35px;
          color: #757575;
          font-size: 11px;
        }
        .backcolor {
          width: 550px;
          height: 160px;
          padding: 17px;
          background: #f7f7f7;
          .price {
            width: 100%;
            height: 30px;
            line-height: 30px;
            .orgin {
              display: inline-block;
              margin-right: 15px;
              color: #9d9d9d;
              font-size: 12px;
            }
            .orgins {
              display: inline-block;
              color: #4e4e4e;
              font-size: 9px;
            }
          }
          .chasePrice {
            width: 100%;
            height: 36px;
            line-height: 36px;
            .orgin {
              display: inline-block;
              margin-right: 15px;
              color: #9d9d9d;
              font-size: 12px;
            }
            .orgins {
              display: inline-block;
              color: #ce3436;
              font-weight: bold;
              font-size: 30px;
            }
          }
          .rest {
            width: 100%;
            height: 36px;
            line-height: 36px;
            color: #9d9d9d;
            span:nth-of-type(2) {
              color: #757575;
            }
          }
          .ownCustom {
            width: 136px;
            height: 34px;
            line-height: 34px;
            margin-left: 35px;
            .me {
              display: inline-block;
              color: #333333;
              font-size: 14px;
            }
            .blood {
              display: inline-block;
              color: #c23d52;
              font-size: 12px;
              margin: 0 2px;
            }
          }
          .quality {
            width: 120px;
            height: 34px;
            line-height: 34px;
            color: #a3a3a3;
            font-size: 12px;
          }
        }
        .peisong {
          width: 100%;
          height: 94px;
          .distance {
            width: 200px;
            height: 44px;
            line-height: 44px;
          }
          .duty {
            width: 400px;
            height: 34px;
            line-height: 34px;
            .espical {
              color: #757575;
              margin: 0 10px;
              cursor: pointer;
            }
          }
        }
        .buyGoods {
          width: 550px;
          height: 40px;
          border-bottom: 1px solid #efefef;
          border-top: 1px solid #efefef;
          ul {
            width: 550px;
            height: 40px;
            li {
              width: 170px;
              height: 22px;
              line-height: 22px;
              text-align: center;
              border-right: 1px solid #efefef;
              margin-top: 10px;
              .chese {
                margin-left: 35px;
                font-size: 11px;
                color: #585858;
              }
              .numbe {
                font-size: 11px;
                color: red;
                margin-left: 7px;
              }
            }
          }
        }
        .kuCun {
          width: 100%;
          height: 57px;
          margin-top: 15px;
          margin-left: 20px;
          input {
            width: 62px;
            height: 32px;
            border: 1px solid #a6a6a8;
            text-indent: 0.5em;
          }
          .math {
            width: 40px;
            height: 31px;
            line-height: 30px;
            font-size: 12px;
          }
          .addTo {
            width: 16px;
            height: 32px;
            border-bottom: 1px solid #a6a6a8;
            border-right: 1px solid #a6a6a8;
            border-top: 1px solid #a6a6a8;
            margin-right: 3px;
            .pan {
              display: block;
              width: 16px;
              height: 16px;
              line-height: 14px;
              text-align: center;
              color: #666666;
            }
            .pane {
              display: block;
              width: 16px;
              height: 16px;
              line-height: 14px;
              text-align: center;
              border-bottom: 1px solid #a6a6a8;
              color: #666666;
            }
          }
          .after {
            height: 30px;
            line-height: 30px;
            font-size: 12px;
          }
        }
        .submit {
          width: 100%;
          height: 100px;
          text-align: center;
          .appre {
            width: 160px;
            height: 37px;
            line-height: 37px;
            margin-left: 65px;
            margin-right: 12px;
          }
          .gray {
            background-color: #9d9d9d;
            color: #fff;
            border-color: #9d9d9d;
            cursor: not-allowed;
          }
          .enter {
            width: 160px;
            height: 37px;
            line-height: 37px;
          }
        }
        #qrcode {
          width: 200px;
          height: 200px;
          position: absolute;
          right: 50px;
        }
        .iphone {
          height: 30px;
          line-height: 30px;
          margin-right: 40px;
          cursor: pointer;
          .buyIphone {
            font-size: 11px;
            color: #737373;
          }
        }
      }
      .check {
        width: 980px;
        height: 100%;
        border: 1px solid #e7e6e6;
        .mistake {
          width: 980px;
          height: 42px;
          line-height: 42px;
          .sps {
            width: 100px;
            height: 42px;
            line-height: 42px;
            text-align: center;
            color: #333333;
            border-right: 1px solid #e7e6e6;
            border-bottom: 1px solid #e7e6e6;
            font-size: 14px;
            i {
              font-size: 12px;
            }
          }
          .sp {
            width: 678px;
            height: 42px;
            border-bottom: 1px solid #e7e6e6;
          }
          .bg {
            border-top: 2px solid red;
            color: red;
            border-bottom: 0;
            background: url(../../assets/img/xiasanjiao.jpg) no-repeat 45px 0;
          }
        }
        .checkbox {
          width: 980px;
          height: auto;
          /*border-top: 1px solid #e7e6e6;*/
          border-bottom: 1px solid #e7e6e6;
          .family {
            width: 980px;
            height: 82px;
            .son {
              text-indent: 1em;
              width: 300px;
              height: 36px;
              line-height: 36px;
            }
          }
          .family1{
            height: 750px!important;
          }
        }
        .picimg {
          width: 100%;
          margin-top: 15px;
          min-height: 650px;
          height: 100%;
          img {
            margin-left: 16px;
          }
        }
      }
    }

    .right {
      width: 202px;
      height: 1320px;
      border: 1px solid #e5e5e5;
      .term {
        width: 100%;
        height: 36px;
        line-height: 36px;
        background: #f9f9f9;
        padding: 0 10px;
      }
      dl {
        width: 100%;
        height: 246px;
        margin: 10px 0;
        dt {
          width: 168px;
          height: 168px;
          margin: 0px 17px;
          img {
            width: 168px;
            height: 168px;
          }
        }
        dd {
          width: 168px;
          height: 70px;
          margin: 0px 17px;
          .nature {
            width: 100%;
            height: 40px;
            line-height: 20px;
            font-size: 12px;
            color: #2a2a2a;
            margin-top: 5px;
            display: -webkit-box;
            overflow: hidden;
            white-space: normal !important;
            text-overflow: ellipsis;
            word-wrap: break-word;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
          }
          .money {
            font-size: 12px;
            color: #aa2238;
          }
          .aim {
            .aims {
              font-size: 12px;
              color: #434343;
            }
            .biggest {
              font-size: 12px;
              color: #b99a30;
            }
          }
        }
      }
    }
    }
  }
}
</style>