<template>
  <div class="inroyaldrink">
    <head-com></head-com>
    <div class="center">
      <div class="header">
        <img class="l" src="../../assets/img/fangzi.jpg" />
        <span class="shouye">
          <router-link to="home">首页</router-link>>
        </span>
        <a @click="GoTo" class="xiala">
          {{getTopClass(goodsData.class_id)}}
          <i class="el-icon-arrow-down"></i>
        </a>
        <span>{{goodsData.title}}</span>
      </div>
      <div class="top">
        <div class="left l">
          <div class="bigImg">
            <img v-if="defaultPicture" :src="URL + defaultPicture" />
            <div id="winSelector"></div>
          </div>
          <div class="smallImg spec-scroll">
            <div class="scrollbutton smallImgUp disabled l">
              <i class="el-icon-caret-left"></i>
            </div>
            <div id="imageMenu" class="img-list">
              <ul :style="{width:imgList.length * 75+'px'}">
                <li
                  @mouseover="styleChange(index,li.pic_url)"
                  :key="index"
                  v-for="(li,index) in imgList"
                >
                  <img :class="{active:sign == index}" :src="URL + li.pic_url" />
                </li>
              </ul>
            </div>
            <div class="scrollbutton smallImgDown r" :class="{disabled:imgList.length<5}">
              <i class="el-icon-caret-right"></i>
            </div>
          </div>
          <div id="bigView">
            <div class="big-img">
              <img :src="URL + defaultPicture" />
            </div>
          </div>
          <div class="fenxiang l">
            <span class="share">
              <i class="el-icon-share"></i>分享
              <div class="bdsharebuttonbox share_content">
                <a class="qzone_share share_btn" data-cmd="qzone"></a>
                <a class="weibo_share share_btn" data-cmd="tsina"></a>
                <a class="qq_share share_btn" data-cmd="sqq"></a>
                <a class="weixin_share share_btn" data-cmd="weixin"></a>
              </div>
            </span>
            <span @click="goodsCollection">
              <i class="el-icon-star-on"></i>
              {{collection_text1}}
            </span>
          </div>
        </div>
        <div class="central l">
          <p class="goods-title">{{goodsData.title}}</p>
          <p class="description">{{goodsData.description}}</p>
          <div class="price">
            <p class="l">
              市场价
              <span>￥{{goodsData.price_market || '0.00'}}</span>
            </p>
            <p class="l">
              售 &nbsp;&nbsp;价
              <span>￥{{goodsData.price_member||0.00}}</span>
            </p>
            <p class="l">
              促&nbsp;&nbsp;&nbsp;销
              <span class="man">满赠</span>
              <span class="both">{{info.countHtml}}</span>
              <br />
              <span class="man jian">满减</span>
              <span class="both">{{info.giftHtml}}</span>
            </p>
          </div>
          <div class="dizhi">
            <div class="spec-group" v-for="(item,index) in spec.spec_group" :key="index">
              <span class="group-name">{{item.name}}</span>
              <div class="spec-term-list">
                <span
                  class="spec-term-name"
                  v-if="item.id == d.spec_id"
                  @click="addClass(index,item.id,d.id)"
                  v-for="(d,i) in spec.spec_children"
                  :key="i"
                  :class="{active:d.default_spec}"
                >{{d.item}}</span>
              </div>
            </div>
            <p class="send-to">
              <span class="gp-label l">配送至</span>
              <receiving-address></receiving-address>
              <span class="yunfei">运费：￥10.00</span>
            </p>
            <p class="g-service">
              服 &nbsp;&nbsp;务
              <span class>
                由
                <span class="yellow">{{shop_data.shop_name}}</span>负责发货，并提供售后服务
              </span>
            </p>
          </div>
          <div class="leiji">
            <p>
              累计评价
              <span>{{info.comment_number}}人评价</span>
            </p>
            <p>
              累计销量
              <span>{{goodsData.selling || 0}}</span>
            </p>
            <p>赠送积分</p>
          </div>
          <div class="shuliang">
            <span class="l">数量</span>
            <div class="inp l">
              <input class="l" @input="setAmount" v-model="goodsNumber" type="text" />
              <span class="r btn-plus" :class="{disabled:plusState}" @click="plus">
                <i class="el-icon-plus"></i>
              </span>
              <span class="r btn-reduce" :class="{disabled:reduceState}" @click="reduce">
                <i class="el-icon-minus"></i>
              </span>
            </div>
            <span class="l">件 库存{{goodsData.stock}}件</span>
          </div>
          <div class="buy">
            <span @click="purchase">立即购买</span>
            <span @click="addCar(goodsData.price_member, goodsData.store_id)">
              <img src="../../assets/img/buycar1.jpg" />加入购物车
            </span>
            <div class="r">
              手机购买
              <img src="../../assets/img/samllerweima.jpg" alt />
            </div>
          </div>
        </div>
        <keep-alive>
          <store-detail></store-detail>
        </keep-alive>
      </div>
      <keep-alive>
        <package-purchase></package-purchase>
      </keep-alive>
      <div class="bottom">
        <div class="left l">
          <div class="zhongxin l">
            <p class="l kefu">
              <span>客服中心</span>
              <br />CUSTOMER
            </p>
            <p class="l zixun">在线咨询</p>
            <div class="l qq">
              <p>
                售前客服
                <img src="../../assets/img/qq.jpg" alt />张三
              </p>
              <p>
                售后客服
                <img src="../../assets/img/qq.jpg" alt />张三
              </p>
              <p>
                在线客服
                <img src="../../assets/img/zaixian.jpg" alt />
              </p>
            </div>
            <p class="l zixun">工作时间</p>
            <p class="l time">AM 8:00-PM 18:00</p>
          </div>
          <div class="fenlei l">
            <p>商品分类</p>
            <ul class="outer">
              <li class="outerli" v-for="(outers,index) in storeClassArr" :key="index">
                <span v-if="outers.level === 0" @click="GoTos(outers)">{{outers.class_name}}</span>
                <span
                  @click="GoTos(outers)"
                  :style="{marginLeft:outers.level*8 + 'px'}"
                  v-else
                >> &nbsp; &nbsp;{{outers.class_name}}</span>
              </li>
            </ul>
          </div>
          <div class="l paihang">
            <p class="shangpin">店内排行榜</p>
            <ul class="l">
              <li
                class="l"
                v-if="Ranking instanceof Array"
                v-for="(pno,index) in Ranking"
                :key="index"
                @click="JumpForDetails(pno.id)"
              >
                <img class="l goodsinfo" v-lazy="pno.pic_url === null ? error : URL + pno.pic_url" />
                <p class="l">{{pno.title=== null ? '标题暂无数据' : pno.title}}</p>
                <p class="l">{{pno.goods_price === null ? '价格暂无数据' : '￥' + pno.goods_price}}</p>
              </li>
            </ul>
          </div>
          <div class="l liulan">
            <p class="zuijin">最近浏览</p>
            <ul>
              <li
                class="l"
                :key="index"
                v-if="browser instanceof Array"
                v-for="(item, index) in browser"
                @click="JumpForDetails(item.id)"
              >
                <img class="l" v-lazy="item.pic_url === null ? error : URL + item.pic_url" />
                <p class="l">{{item.title === null ? '标题暂无数据' : item.title}}</p>
                <p class="l">{{item.price_member === null ? '价格暂无数据' : '￥' + item.price_member}}</p>
              </li>
            </ul>
          </div>
        </div>
        <div class="right r">
          <div class="l tab">
            <ul class="l">
              <li @click="undo(0)" :class="{bg:isbg==0}" class="l">商品介绍</li>
              <li @click="undo(1)" :class="{bg:isbg==1}" class="l">
                商品评价
                <span>{{info.comment_number}}</span>
              </li>
              <li @click="undo(2)" :class="{bg:isbg==2}" class="l">
                商品咨询
                <span></span>
              </li>
            </ul>
            <div class="l line"></div>
          </div>
          <div class="subpage l">
            <div v-show="only==0" class="jieshao">
              <div class="up" v-show="introduce.length==0">
                <p class="p">商家货号：96004746</p>
                <p class="p">品牌：</p>
                <p class="p">类别：不限</p>
                <p class="p">材料：不限</p>
                <p class="p">工艺：不限</p>
                <p class="p">窑口：不限</p>
              </div>
              <div class="down" id="detail-img" v-html="shopImage"></div>
            </div>
            <div v-show="only==1" class="pingjia">
              <div class="up">
                <div class="evaluate-info">
                  <div class="l evaluate-degree">
                    <div class="commhigh-opinionent l">
                      <div class="percent">100%</div>
                      <p class="percent-tit">好评度</p>
                    </div>
                    <ul class="l jindu">
                      <li>
                        <span>好评({{nice100}}%)</span>
                        <i>
                          <b class="skitt-line"></b>
                        </i>
                      </li>
                      <li>
                        <span>中评({{center100}}%)</span>
                        <i>
                          <b class="skitt-line"></b>
                        </i>
                      </li>
                      <li>
                        <span>差评({{bad100}}%)</span>
                        <i>
                          <b class="skitt-line"></b>
                        </i>
                      </li>
                    </ul>
                  </div>

                  <ul class="clearfix yinxiangul list">
                    <li class="impress-tit">买家印象：</li>
                    <li class="l tag-info" :key="index" v-for="(yinxiang,index) in yinxiangs">
                      <span>{{yinxiang.p}}</span>
                      <span>({{yinxiang.span}})</span>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="down">
                <div class="l top">
                  <ul class="l">
                    <li
                      class="l"
                      :class="isCurrentComment == 0 ? 'active' : ''"
                      @click="getAllCommentContent(0)"
                    >
                      全部评价
                      <span>({{comments.allCount||0}})</span>
                    </li>
                    <li
                      class="l"
                      :class="isCurrentComment == 1 ? 'active' : ''"
                      @click="getAllCommentContent(1)"
                    >
                      好评
                      <span>({{comments.allNice||0}})</span>
                    </li>
                    <li
                      class="l"
                      :class="isCurrentComment == 2 ? 'active' : ''"
                      @click="getAllCommentContent(2)"
                    >
                      中评
                      <span>({{comments.allHeight||0}})</span>
                    </li>
                    <li
                      class="l"
                      :class="isCurrentComment == 3 ? 'active' : ''"
                      @click="getAllCommentContent(3)"
                    >
                      差评
                      <span>({{comments.allBad||0}})</span>
                    </li>
                    <li
                      class="l"
                      :class="isCurrentComment == 4 ? 'active' : ''"
                      @click="getAllCommentContent(4)"
                    >
                      有图
                      <span>({{comments.allImg||0}})</span>
                    </li>
                  </ul>
                </div>
                <div class="l dibian" v-for="(item,index) in comments.list" :key="index">
                  <div class="name l">
                    <p>
                      {{item.nick_name}}
                      <span>(匿名)</span>
                    </p>

                    <p class="score">{{item.score|filtScore}}</p>
                    <p>{{item.create_time | formatDate}}</p>
                  </div>
                  <div class="right">
                    <p class="l talk">{{item.content}}</p>
                    <div class="l photo">
                      <img :src="URL+item.path" />
                    </div>
                    <div class="bigImg" v-if="ctrlBigImg">
                      <img :src="URL+item.path" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-show="only==2">
              <div class="refer">
                <p class="zixuntop">商品咨询</p>
                <div class="tiwen">
                  <p>查看全部咨询</p>
                  <div class="inp">
                    <input type="text" v-model="addCommitProblemValue" />
                    <span @click="addCommitProblem">我要提问</span>
                  </div>
                </div>
                <div class="consult clearfix">
                  <div class="yunfei">
                    <p>
                      <span class="huang">Q</span> 满多少免运费?
                      <span class="r day">11月20日 09:20</span>
                    </p>
                    <p>
                      <span class="huang">A</span> 公司承诺符合以下情况，公司承诺符合以下情况,公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况
                      <span
                        class="r day"
                      >11月20日 09:20</span>
                    </p>
                  </div>
                  <div class="yunfei">
                    <p>
                      <span class="huang">Q</span> 满多少免运费?
                      <span class="r day">11月20日 09:20</span>
                    </p>
                    <p>
                      <span class="huang">A</span> 公司承诺符合以下情况，公司承诺符合以下情况,公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况
                      <span
                        class="r day"
                      >11月20日 09:20</span>
                    </p>
                  </div>
                  <div class="yunfei" v-for="(item, index) in consultationList.data" :key="index">
                    <p>
                      <span class="huang">Q</span>
                      {{item.content}}
                      <span
                        class="r day"
                      >{{~~item.create_time | formatDate}}</span>
                    </p>
                    <p>
                      <span class="huang">A</span>
                      {{item.answer ? item.answer : '暂无回答'}}
                      <span
                        class="r day"
                      >暂无</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <keep-alive>
        <like-and-history></like-and-history>
      </keep-alive>
    </div>
    <keep-alive>
      <foot-com></foot-com>
    </keep-alive>
  </div>
</template>

<script>
import { magnify } from "@/assets/js/magnify.js";
export default {
  data() {
    return {
      ctrlBigImg: null,
      introduce: {}, //商品介绍,

      specKey: this.$route.query.id,
      spec: {},
      specData: {},

      collection_text1: "收藏商品",
      goodsData: {},
      shop_data: {},
      defaultPicture: "",
      imgList: [],
      sign: 0,
      goodsNumber: 1,
      plusState: false,
      reduceState: true,
      info: {},

      items: [],
      outer: ["皇家御饮", "御贡赠品", "滋补养身"],
      core: [
        "绿茶",
        "红茶",
        "乌龙茶",
        "花茶",
        "绿茶",
        "红茶",
        "乌龙茶",
        "花茶"
      ],
      addCommitProblemValue: "测试",
      isactive: "",
      imgs: [],
      isbg: "",
      only: "",
      basebox: [],
      base: [],
      isborder: "",
      yinxiangs: [
        {
          p: "物流很快",
          span: "200"
        },
        {
          p: "客服很亲切",
          span: "321"
        },
        {
          p: "质量很好",
          span: "543"
        },
        {
          p: "便宜，性价比高",
          span: "1002"
        },
        {
          p: "好看",
          span: "185"
        }
      ],
      pingjias: ["商品不错", "腰果很好吃", "特价买的", "商品很便宜"],
      comments: {},
      isCurrentComment: 0, //是否在当前评价选项（好评差评切换）
      nice100: 0, //好评
      bad100: 0,
      center100: 0,
      consultationList: "",
      storeClassArr: "",
      fun: "",

      shopImage: "", // 商品详情
      browser: [], // 最近浏览
      ShoppingRank: [],
      Ranking: [],
      g: 0,
      t: 0,
      consultationList: []
    };
  },
  beforeCreate() {
    window._bd_share_main = "";
  },
  watch: {
    goodsNumber() {
      this.reduceState = this.goodsNumber > 1 ? false : true;
      this.plusState =
        parseInt(this.goodsNumber) >= parseInt(this.goodsData.stock)
          ? true
          : false;
    }
  },

  components: {
    "store-detail": () => import("./components/storeDetailByGoods"),
    "package-purchase": () => import("./components/ packagePurchase")
  },
  mounted() {
    let n = 0;
    let isChange = false;
    window.onscroll = () => {
      clearTimeout(timer);
      let timer = setTimeout(() => {
        clearTimeout(timer);
        let scrollTop =
          document.documentElement.scrollTop || document.body.scrollTop;
        // console.log(scrollTop);
        if (scrollTop > 600 && n < 1) {
          this.ShopImageDetail(this.goodsData.p_id);
          n++;
        }
      }, 500);
    };
  },
  created() {
    this.getGoodsDetails();
    this.getMyFootFrint();
    if (this.isbor === 0) {
      this.getGoodsAccessories(this.goodsData.id);
    }
    this.GetUrlRelativePath();
  },

  filters: {
    filtScore: function(value) {
      return "★★★★★☆☆☆☆☆".slice(5 - value, 10 - value);
    }
  },
  methods: {
    getStoreId() {
      return this.goodsData.store_id;
    },

    getGoodsId() {
      return this.$route.query.id;
    },
    // 获取url地址,当未登录时购买商品时，记录地址
    GetUrlRelativePath() {
      var url = document.location.toString();
      var arrUrl = url.split("//");

      var start = arrUrl[1].indexOf("/");
      var relUrl = arrUrl[1].substring(start);

      sessionStorage.setItem("site", relUrl);
    },
    undo(index) {
      this.isbg = index;
      this.only = index;
      if (index == 0) {
        this.getAllCommentContent(0);
      } else if (index == 1) {
        this.getGoodsConsultation();
      } else if (index === 2) {
        this.consultationData();
      }
    },
    // 获取咨询列表
    consultationData() {
      this.HTTP(
        this.$httpConfig.consult.goodsConsultation,
        {
          goods_id: this.$route.query.id,
          page: 1
        },
        "post"
      ).then(res => {
        if (res.data.status) this.consultationList = res.data.data;
        console.log(res.data);
      });
    },
    // 我要提问
    addCommitProblem() {
      this.HTTP(
        this.$httpConfig.consult.userCommitProblem,
        {
          goods_id: this.$route.query.id,
          content: this.addCommitProblemValue
        },
        "post"
      ).then(res => {
        console.log(res.data);
      });
    },
    GoTos(item) {
      this.g++;
      window.open(
        window.location.origin +
          "/goodsClass?class_id=" +
          item.id +
          "&id=" +
          this.g +
          "&class_name=" +
          item.class_name
      );
    },
    GoTo() {
      sessionStorage.setItem(
        "crumbs",
        this.getTopClass(this.goodsData.class_id)
      );
      this.t++;

      this.$router.push({
        path: "/goodsClass",
        query: {
          class_id: this.goodsData.class_id,
          id: this.t
        }
      });
    },
    //店内排行，最近浏览跳转详情页
    JumpForDetails(id) {
      this.$router.push({
        path: "/inroyaldrink",
        query: {
          id: id
        }
      });
    },

    // 店内商品排行
    getHotCommodities() {
      this.HTTP(this.$httpConfig.getHotCommodities, {}, "post").then(res => {
        this.ShoppingRank = res.data.data.slice(0, 3);
        console.log(res.data);
      });
    },
    // 最近浏览
    getMyFootFrint() {
      this.HTTP(this.$httpConfig.getMyFootFrint, {}, "post", false)
        .then(res => {
          if (res.data.data.list) {
            this.browser = res.data.data.data.slice(0, 3);
          }
        })
        .catch(() => {});
    },
    //商品收藏
    goodsCollection() {
      this.HTTP(
        this.$httpConfig.setCollectionGoods,
        {
          goods_id: this.goodsData.id
        },
        "post",
        false
      )
        .then(res => {
          if (res.data.message == "收藏成功") {
            this.collection_text1 = "已收藏";
            this.icon_color = true;
          } else {
            this.collection_text1 = "收藏商品";
            this.icon_color = false;
          }
        })
        .catch(() => {});
    },
    addCar(price, storeId) {
      var params = {
        goods_id: this.$route.query.id,
        goods_num: this.goodsNumber,
        price_new: price,
        store_id: storeId
      };
      this.HTTP(this.$httpConfig.addGoodToCart, params, "post", false).then(
        res => {
          this.$confirm("", "已成功加入购物车", {
            confirmButtonText: "查看购物车",
            cancelButtonText: "继续购物",
            type: "success",
            center: true,
            lockScroll: false,
            closeOnClickModal: false,
            confirmButtonClass: "to-shopping-cart",
            cancelButtonClass: "continue-shopping"
          })
            .then(() => {
              this.$router.push("/buyCar");
            })
            .catch(() => {});
        }
      );
    },
    setup() {
      let that = this;
      window._bd_share_config = {
        common: {
          bdSnsKey: {},
          bdText: that.goodsData.title,
          bdMini: "2",
          bdPic: that.URL + that.defaultPicture,
          bdStyle: "0",
          bdSize: "16"
        },
        share: {}
      };
      const s = document.createElement("script");
      s.type = "text/javascript";
      s.src =
        "http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=" +
        ~(-new Date() / 36e5);
      document.body.appendChild(s);
    },

    //去购买
    purchase() {
      let MaskBox = document.getElementById("bdshare_weixin_qrcode_dialog");
      if (MaskBox) {
        MaskBox.parentNode.removeChild(MaskBox);
      }
      this.$router.push({
        name: "confirmOrder",
        params: {
          goods_id: this.goodsData.id,
          num: this.goodsNumber
        }
      });
    },
    styleChange(index, url) {
      this.sign = index;
      this.defaultPicture = url;
    },
    //商品数量加
    plus() {
      if (parseInt(this.goodsNumber) >= parseInt(this.goodsData.stock)) {
        return;
      }
      this.goodsNumber++;
    },
    //商品数量减
    reduce() {
      if (!this.goodsNumber || parseInt(this.goodsNumber) <= 1) {
        this.goodsNumber = 1;
        return;
      }
      this.goodsNumber--;
    },
    //设置数量
    setAmount() {
      let num = this.goodsNumber;
      let stock = parseInt(this.goodsData.stock);
      let reg = /(^([1-9])([0-9]*)$|^[1-9]$)/;
      if (!num) {
        this.goodsNumber = "";
      } else {
        if (!reg.test(num)) {
          this.goodsNumber = 1;
          return;
        }
      }
      if (num >= stock) {
        this.goodsNumber = this.goodsData.stock;
      }
    },

    //选择规格
    addClass(key, group_id, term_id) {
      let selectList = [],
        sortList = "",
        str = "",
        goodsId = "";
      for (let i in this.spec.spec_children) {
        if (group_id === this.spec.spec_children[i].spec_id) {
          this.$set(this.spec.spec_children[i], "default_spec", false);
          if (term_id === this.spec.spec_children[i].id)
            this.$set(this.spec.spec_children[i], "default_spec", true);
        }
      }
      $addressData;
      //获取选择的规格
      for (let j in this.spec.spec_children) {
        if (this.spec.spec_children[j].default_spec === true) {
          selectList.push(this.spec.spec_children[j].id);
        }
      }
      //排序
      sortList = selectList.sort((a, b) => {
        return a > b ? 1 : -1;
      });
      //字符串拼接
      str = sortList.join("_");
      //对比
      console.log(this.specData.goods);
      for (let i in this.specData.goods) {
        if (str === this.specData.goods[i].key) {
          goodsId = this.specData.goods[i].goods_id;
        }
      }
      this.$router.push({
        path: "/inroyaldrink",
        query: {
          id: goodsId
        }
      });
    },
    //获取商品规格
    getGoodsSpec(id) {
      this.HTTP(
        this.$httpConfig.goodsSpecs,
        {
          id: id
        },
        "post"
      )
        .then(res => {
          this.specData = res.data.data;
          this.spec = res.data.data.spec;
          for (let key in this.spec.spec_children) {
            if (
              this.specData.goods[this.specKey].key.indexOf(
                this.spec.spec_children[key].id
              ) > -1
            ) {
              this.$set(this.spec.spec_children[key], "default_spec", true);
            } else {
              this.$set(this.spec.spec_children[key], "default_spec", false);
            }
          }
          // console.log(this.spec);
        })
        .catch(() => {});
    },
    getTopClass(data) {
      //  console.log(data)
      let obj = JSON.parse(localStorage.getItem("class"));

      if (!obj) {
        return "";
      }

      let item = obj.filter(item => {
        if (item.id === data) {
          return item;
        }
      });

      return item.length === 1 ? item[0].class_name : "";
    },
    //获取商品信息
    async getGoodsDetails() {
      let res = await this.HTTP(
        this.$httpConfig.getGoodsDetails,
        {
          id: this.$route.query.id
        },
        "post"
      );
      if (res.data.status) {
        this.goodsData = res.data.data;
        console.log(this.goodsData);
        this.imgList = this.goodsData.images;
        this.defaultPicture = this.goodsData.images[0].pic_url;
        await this.getGoodsSpec(this.goodsData.id);
        await this.setup();
        await this.getGoodsStoreClass(this.goodsData.store_id); // 店铺导航商品分类
        await this.inStoreRanking();
        this.$nextTick(() => {
          this.magnify();
        });
      }
    },
    //店内排行榜
    inStoreRanking() {
      this.HTTP(
        this.$httpConfig.getGoodsStoreRankingsList,
        {
          store_id: parseInt(this.goodsData.store_id)
        },
        "post"
      )
        .then(res => {
          this.Ranking = res.data.data;
        })
        .catch(() => {});
    },
    ShopImageDetail(id) {
      this.HTTP(
        this.$httpConfig.ShopImageDetail,
        {
          goods_id: id
        },
        "post"
      )
        .then(res => {
          if (res.data.status) this.shopImage = res.data.data;
        })
        .catch(() => {});
    },
    getAllCommentContent(type) {
      this.isCurrentComment = type;
      this.HTTP(
        this.$httpConfig.getAllCommentContent,
        {
          goods_id: this.$route.query.id,
          type: type,
          page: 1
        },
        "post"
      )
        .then(res => {
          this.comments = res.data.data;
          this.nice100 = (this.comments.allNice / this.comments.allCount) * 100;
          this.center100 =
            (this.comments.allHeight / this.comments.allCount) * 100;
          this.bad100 = (this.comments.allBad / this.comments.allCount) * 100;

          this.$set($(".skitt-line")[0].style, "width", this.nice100 + "%");
          this.$set($(".skitt-line")[1].style, "width", this.center100 + "%");
          this.$set($(".skitt-line")[2].style, "width", this.bad100 + "%");
        })
        .catch(() => {
          this.comments = [];
        });
    },
    getGoodsConsultation() {
      this.HTTP(
        this.$httpConfig.getAllCommentContent,
        {
          goods_id: this.$route.query.id,
          page: 1
        },
        "post"
      )
        .then(res => {
          this.consultationList = res.data.data;
        })
        .catch(() => {});
    },
    getGoodsStoreClass(id) {
      this.HTTP(
        this.$httpConfig.getGoodsStoreClass,
        {
          id: id
        },
        "post"
      )
        .then(res => {
          this.storeClassArr = res.data.data;
        })
        .catch(() => {});
    },
    block(index) {
      this.fun = index;
      this.isactive = index;
    },

    cut(index) {
      this.isborder = index;
      this.basebox = this.base[index];
    }
  }
};
</script>

<style>
::-webkit-scrollbar {
  display: none;
}

.bd_weixin_popup_foot {
  display: none;
}

.p {
  display: inline-block;
}

.el-message-box--center {
  padding-bottom: 50px;
}

.el-message-box--center .el-message-box__header {
  padding-top: 50px;
}

.el-button {
  font-size: 14px;
  font-weight: inherit;
}

.continue-shopping {
  padding: 13px 30px !important;
}

.continue-shopping:hover {
  color: #606266;
  border: 1px solid #dcdfe6;
  background-color: #fff;
}

.to-shopping-cart {
  background-color: red !important;
  border: 1px solid red !important;
  padding: 13px 26px !important;
}

.to-shopping-cart:hover {
  background-color: red !important;
  color: #fff !important;
}
</style>

<style lang="less" scoped>
.inroyaldrink {
  background: #fff;
}

@color: #ff5601;
.l {
  float: left;
}
.l  > .goodsinfo {
    height: 10rem;
}
.r {
  float: right;
}

.center {
  width: 1190px;
  margin: 0 auto;
  height: 100%;
}

.header {
  height: 46px;
  line-height: 46px;
  font-size: 14px;
  color: #636260;
  a {
    color: #636260;
  }
  img {
    margin: 17px 7px 0 0;
  }
  .xiala {
    display: inline-block;
    width: 82px;
    height: 23px;
    border: 1px solid #d1d1d1;
    text-align: center;
    line-height: 23px;
    margin-left: 7px;
    position: relative;
    .yincang {
      border-right: 1px solid #d1d1d1;
      border-left: 1px solid #d1d1d1;
      position: absolute;
      top: 22px;
      left: -1px;
      span {
        width: 80px;
        height: 23px;
        border-bottom: 1px solid #d1d1d1;
        display: inline-block;
        background: #fff;
      }
    }
  }
}

.line {
  border-bottom: 1px solid #e8e8e8;
  width: 100%;
  height: 40px;
}

.top {
  overflow: hidden;
  .left {
    width: 400px;
    position: relative;
    .bigImg {
      width: 400px;
      height: 400px;
      border: 1px solid #f2f2f2;
      box-sizing: border-box;
      overflow: hidden;
      position: relative;
      img {
        position: absolute;
        top: 0;
        left: 0;
        width: 400px;
        height: 400px;
      }
      #winSelector {
        width: 200px;
        height: 200px;
        position: absolute;
        cursor: crosshair;
        display: none;
        filter: alpha(opacity=15);
        -moz-opacity: 0.15;
        opacity: 0.15;
        background-color: #000;
      }
    }
    #bigView {
      width: 400px;
      height: 400px;
      border: 1px solid #f2f2f2;
      box-sizing: border-box;
      position: absolute;
      top: 0;
      overflow: hidden;
      left: 400px;
      z-index: 999;
      display: none;
      .big-img {
        width: 800px;
        height: 800px;
        position: absolute;
        img {
          width: 100%;
          height: 100%;
        }
      }
    }
    .spec-scroll {
      clear: both;
      margin-top: 14px;
      width: 400px;
      height: 60px;
      .scrollbutton {
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
      }
      .scrollbutton:hover i {
        color: #9b9b9b;
      }
      .scrollbutton.disabled {
        i {
          color: #dcdcdc;
        }
      }
      .img-list {
        float: left;
        position: relative;
        width: 350px;
        height: 60px;
        overflow: hidden;
        ul {
          position: absolute;
          height: 60px;
          li {
            float: left;
            width: 75px;
            height: 58px;
            img {
              width: 58px;
              height: 58px;
              display: block;
              margin: 0 auto;
              border: 1px solid #d1d1d1;
            }
            img.active {
              border-color: #757575;
            }
          }
        }
      }
    }
    .fenxiang {
      height: 40px;
      line-height: 40px;
      position: relative;
      i {
        color: #757575;
      }
      span {
        display: inline-block;
        cursor: pointer;
        font-size: 12px;
        color: #757575;
        margin-right: 25px;
      }
      .share:hover .share_content {
        display: block;
      }
      .share_content {
        display: none;
        background-color: #fff;
        border: solid 1px #e9e9e9;
        padding: 5px;
        width: 43px;
        position: absolute;
        bottom: 40px;
        left: 0;
      }
      .share_btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: none;
        float: left;
        margin: 3px 0;
        box-sizing: content-box;
        padding: 0;
      }
      .share_btn:hover {
        opacity: 0.8;
      }
      .weixin_share {
        background: url(../../assets/img/txweixin.png) no-repeat;
      }
      .weibo_share {
        background: url(../../assets/img/xlweibo.png) no-repeat;
      }
      .qzone_share {
        background: url(../../assets/img/qzone.png) no-repeat;
      }
      .qq_share {
        background: url(../../assets/img/txqq.png) no-repeat;
      }
    }
  }
  .central {
    width: 549px;
    margin-left: 20px;
    .goods-title {
      font-size: 18px;
      color: #303030;
      font-weight: 500;
      // margin: 0 0 18px 0px;
    }
    .description {
      font-size: 12px;
      color: #757575;
      margin: 0 0 9px 9px;
    }
    .price {
      width: 100%;
      height: 160px;
      // background: url(../../assets/img/beijing.jpg) no-repeat center;
      background: #f7f7f7;
      border-top: 1px solid #f2f2f2;
      border-bottom: 1px solid #f2f2f2;
      p {
        font-size: 12px;
        color: #9a9a9a;
        margin-left: 25px;
        width: 100%;
      }
      p:nth-of-type(1) {
        margin-top: 21px;
        span {
          margin-left: 14px;
          font-size: 9px;
          color: #575757;
          text-decoration: line-through;
        }
      }
      p:nth-of-type(2) {
        margin-top: 18px;
        span {
          font-size: 18px;
          color: #d62b3e;
          margin-left: 10px;
        }
      }
      p:nth-of-type(3) {
        margin-top: 25px;
      }
      .man {
        width: 46px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        background: red;
        color: #fff;
        display: inline-block;
        margin-left: 20px;
      }
      .both {
        font-size: 12px;
        color: #616161;
        margin-left: 10px;
      }
      .jian {
        margin: 6px 0 0 58px;
      }
    }
    .dizhi {
      margin-top: 12px;
      p {
        font-size: 12px;
        color: #9a9a9a;
        margin-left: 25px;
        width: 100%;
        .gp-label {
          margin-right: 25px;
          line-height: 22px;
        }
      }
      .spec-group {
        font-size: 12px;
        color: #9a9a9a;
        width: 100%;
        line-height: 20px;
        padding-left: 60px;
        margin-left: 0;
        overflow: hidden;
        .spec-term-list {
          margin-left: 25px;
          float: left;
          .spec-term-name {
            cursor: pointer;
            margin-top: 6px;
            padding: 2px 10px;
            border: 1px solid #c6c6c6;
            margin: 2px 11px 2px 0;
            float: left;
            &:hover {
              border-color: #757575;
            }
          }
          .active {
            border-color: #757575;
          }
        }
        .group-name {
          float: left;
          line-height: 30px;
          width: 60px;
          text-align: right;
          margin-left: -60px !important;
        }
      }
      .spec-group:nth-child(1) {
        margin-top: 6px;
      }
      .send-to {
        margin-top: 14px;
        .yunfei {
          color: #535353;
          margin-left: 16px;
          display: inline-block;
          line-height: 22px;
        }
      }
      .g-service {
        margin-top: 16px;
        span {
          font-size: 10px;
          margin-left: 22px;
        }
        .yellow {
          margin-left: 0;
          color: red;
        }
      }
    }
    .leiji {
      height: 40px;
      border-top: 1px solid #f1f1f1;
      border-bottom: 1px solid #f1f1f1;
      margin-left: 20px;
      p {
        float: left;
        width: 168px;
        height: 20px;
        line-height: 20px;
        line-height: 20px;
        text-align: center;
        border-left: 1px solid #e4e0dd;
        margin-top: 10px;
        span {
          color: #757575;
          margin-left: 7px;
        }
      }
      p:first-child {
        border-left: 0;
      }
    }
    .shuliang {
      margin-top: 13px;
      margin-left: 26px;
      overflow: hidden;
      span {
        font-size: 12px;
        color: #a6a6a6;
        line-height: 32px;
      }
      .inp {
        width: 80px;
        height: 30px;
        border: 1px solid #a7a7a7;
        margin: 0 9px 0 30px;
        input {
          width: 63px;
          height: 100%;
          border-right: 1px solid #a7a7a7;
          padding-left: 10px;
        }
        span {
          width: 15px;
          height: 14px;
          background: #eef4f2;
          color: #666;
          cursor: pointer;
          i {
            font-size: 7px;
            float: left;
            margin-top: 1px;
            margin-left: 2px;
          }
        }
        .btn-plus {
          border-bottom: 1px solid #a7a7a7;
        }
        span.disabled {
          color: #ccc;
          cursor: not-allowed;
        }
      }
    }
    .buy {
      margin-top: 16px;
      span {
        cursor: pointer;
        width: 160px;
        height: 38px;
        line-height: 38px;
        font-size: 16px;
        background: #ffecec;
        border: 1px solid red;
        display: inline-block;
        color: red;
        border-radius: 5px;
      }
      span:nth-of-type(1) {
        margin-left: 80px;
        text-align: center;
      }
      span:nth-of-type(2) {
        margin-left: 9px;
        background: red;
        color: #fff;
        img {
          float: left;
          margin: 8px 10px 0 22px;
        }
      }
      div {
        line-height: 38px;
        font-size: 12px;
        color: #757575;
        img {
          margin-left: 7px;
        }
      }
    }
  }
}
.bottom {
  overflow: hidden;
  margin-top: 11px;
  .left {
    width: 204px;
    overflow: hidden;
    .zhongxin {
      width: 100%;
      height: 400px;
      border: 1px solid #e5e5e5;
      .kefu {
        height: 99px;
        width: 100%;
        text-align: center;
        font-size: 12px;
        color: #828282;
        border-bottom: 1px solid #e5e5e5;
        span {
          font-size: 23px;
          color: #2f2f2f;
          margin: 28px 0 8px 0;
          display: inline-block;
        }
      }
      .zixun {
        line-height: 40px;
        border-bottom: 1px solid #e5e5e5;
        font-size: 12px;
        padding-left: 14px;
        color: #343434;
        width: 100%;
      }
      .qq {
        height: 168px;
        border-bottom: 1px solid #e5e5e5;
        width: 100%;
        p {
          font-size: 12px;
          color: #7f7f7f;
          margin-left: 17px;
          img {
            margin: 0 7px 0 15px;
          }
        }
        p:nth-of-type(1) {
          margin-top: 16px;
        }
        p:nth-of-type(2) {
          margin-top: 21px;
        }
        p:nth-of-type(3) {
          margin-top: 46px;
        }
      }
      p.time {
        color: #343434;
        line-height: 40px;
        padding-left: 14px;
        font-size: 12px;
      }
    }
    .fenlei {
      overflow: hidden;
      margin-top: 10px;
      width: 100%;
      border: 1px solid #e5e5e5;
      p {
        line-height: 40px;
        background: #f9f9f9;
        font-size: 14px;
        color: #555;
        padding-left: 11px;
      }
      .outer {
        margin-top: 16px;
        margin-bottom: 20px;
        .outerli {
          cursor: pointer;
          line-height: 30px;
          // background: url(../../assets/img/jiahao.jpg) no-repeat top 8px left 29px;
          font-size: 12px;
          color: #6b6b6b;
          span {
            padding-left: 53px;
          }
          .coreli {
            font-size: 12px;
            color: #6b6b6b;
            &:hover {
              background: #f5f5f5;
            }
            .coreli2 {
              margin-left: 20px;
              font-size: 12px;
              color: #666;
              &:hover {
                background: #ddd;
              }
            }
          }
        }
        .active {
          background: url(../../assets/img/jianhao.jpg) no-repeat top 8px left
            29px;
        }
      }
    }
    .paihang {
      overflow: hidden;
      margin-top: 10px;
      width: 100%;
      border: 1px solid #e5e5e5;
      .shangpin {
        line-height: 40px;
        background: #f9f9f9;
        font-size: 14px;
        color: #555;
        padding-left: 11px;
      }
      ul {
        li {
          width: 168px;
          margin: 10px 17px;
          p {
            font-size: 12px;
            color: #363636;
            cursor: pointer;
          }
          p:nth-of-type(1) {
            margin: 10px 0;
            width: 100%;
            &:hover {
              color: red;
            }
          }
          p:nth-of-type(2) {
            color: #aa3e4b;
          }
          p:nth-of-type(3) {
            margin-right: 16px;
            span {
              color: #ac9d4a;
            }
          }
        }
      }
    }
    .liulan {
      overflow: hidden;
      margin-top: 10px;
      width: 100%;
      border: 1px solid #e5e5e5;
      .zuijin {
        line-height: 40px;
        background: #f9f9f9;
        font-size: 14px;
        color: #555;
        padding-left: 11px;
      }
      ul {
        overflow: hidden;
        li {
          width: 195px;
          border-bottom: 1px solid #e9e9e9;
          margin: 0 4px;
          img {
            width: 170px;
            margin: 10px 9px 0 6px;
          }
          p {
            font-size: 12px;
            color: #4c4c4c;
            width: 120px;
          }
          p:nth-of-type(1) {
            margin: 12px 0 0 0;
            width: 100%;
          }
          p:nth-of-type(2) {
            color: #ba4e5e;
          }
        }
        li:last-child {
          border-bottom: 0;
        }
      }
    }
  }
  .right {
    width: 982px;
    .tab {
      ul {
        border-left: 1px solid #e8e8e8;
        li {
          height: 40px;
          text-align: center;
          line-height: 40px;
          border: 1px solid #e8e8e8;
          border-left: 0;
          cursor: pointer;
          span {
            color: #595f93;
            margin-left: 4px;
            font-size: 12px;
          }
        }
        li:nth-of-type(1) {
          width: 90px;
        }
        li:nth-of-type(2) {
          width: 128px;
        }
        li:nth-of-type(3) {
          width: 119px;
        }
        .bg {
          border-bottom: 0;
          border-top-color: red;
          color: red;
          background: url(../../assets/img/xiasanjiao.jpg) no-repeat top 0 left
            50%;
        }
      }
      div {
        height: 40px;
        border: 1px solid #e8e8e8;
        border-left: 0;
        width: 644px;
      }
    }
    .subpage {
      overflow: hidden;
      width: 100%;
      .jieshao {
        border: 1px solid #e8e8e8;
        border-top: none;
        .up {
          height: 93px;
          // border: 1px solid #e8e8e8;
          width: 100%;
          // border-top: 0;
          p {
            float: left;
            margin-top: 25px;
            font-size: 12px;
            color: #5d5d5d;
          }
          p:nth-of-type(1) {
            width: 365px;
            margin-left: 16px;
          }
          p:nth-of-type(2) {
            width: 342px;
          }
          p:nth-of-type(3) {
            width: 234px;
          }
          p:nth-of-type(4) {
            width: 365px;
            margin-left: 16px;
            margin-top: 15px;
          }
          p:nth-of-type(5) {
            width: 342px;
            margin-top: 15px;
          }
          p:nth-of-type(63) {
            width: 234px;
            margin-top: 15px;
          }
        }
        .down {
          overflow: hidden;
          // border: 1px solid #e8e8e8;
          img {
            //   margin-left: 16px;
          }
          img:last-child {
            //   margin-bottom: 76px;
          }
          img:first-child {
            //   margin-top: 15px;
          }
        }
        #detail-img {
          text-align: center;
          // margin-top: 5px;
          img {
            width: 100% !important;
          }
        }
      }
      .pingjia {
        .up {
          width: 100%;
          border: 1px solid #e8e8e8;
          border-top: 0;
          .good {
            font-size: 12px;
            color: #333;
            width: 179px;
            text-align: center;
            margin-left: 10px;
            span {
              font-size: 31px;
              color: red;
              margin-top: 45px;
              display: inline-block;
            }
          }
          .evaluate-info {
            padding: 50px 0;
            .evaluate-degree {
              .commhigh-opinionent {
                width: 120px;
                text-align: center;
                .percent {
                  color: red;
                  font-size: 30px;
                  font-weight: bold;
                }
                .percent-tit {
                  font-size: 12px;
                }
              }
              .jindu {
                padding-top: 8px;
                li {
                  display: flex;
                  flex-direction: row;
                  justify-content: center;
                  align-items: center;
                  > span {
                    width: 63px;
                    font-size: 11px;
                    color: #464646;
                    display: inline-block;
                    margin-right: 0.1rem;
                  }
                  > i {
                    width: 100px;
                    height: 8px;
                    background: #b8b8b8;
                    display: inline-block;
                    position: relative;
                    overflow: hidden;
                    margin-left: 5px;
                    > b {
                      background: #e01222;
                      width: 0;
                      position: absolute;
                      left: 0;
                      top: 0;
                      height: 8px;
                    }
                  }
                }
              }
            }
            .yinxiang {
              font-size: 12px;
              color: #333;
              margin: 38px 0 0 30px;
            }
            .yinxiangul {
              height: auto;
              padding: 0 5px 0 325px;
              .impress-tit {
                height: 60px;
                float: left;
                font-size: 13px;
              }
              .tag-info {
                padding: 6px 7px 4px 6px;
                background: #eef2fe;
                font-size: 12px;
                color: #333;
                margin-bottom: 8px;
                margin-right: 5px;
                cursor: pointer;
                span {
                  color: #999;
                }
              }
            }
          }
        }
        .down {
          margin-top: 10px;
          border: 1px solid #e2e2e2;
          border: 1px solid #e8e8e8;
          border-top: 0;
          overflow: hidden;
          .top {
            height: 36px;
            background: #f4f8fb;
            width: 100%;
            p {
              color: red;
              font-size: 12px;
              line-height: 36px;
              margin-left: 18px;
            }
            ul {
              margin-left: 64px;
              li {
                line-height: 36px;
                font-size: 12px;
                color: #333;
                margin-right: 54px;
                cursor: pointer;
              }
              :hover {
                color: red;
              }
              li.active {
                color: red;
              }
            }
            .inp {
              color: #333;
              font-size: 12px;
              line-height: 36px;
              input {
                margin: 11px 11px 0 0;
              }
            }
          }
          .dibian {
            min-height: 180px;
            height: auto;
            display: flex;
            flex-direction: row;
            border-bottom: 1px solid #eee;
            .name {
              width: 149px;
              text-align: center;
              p {
                font-size: 12px;
                color: #333;
                span {
                  color: #9c9c9c;
                }
              }
              .score {
                color: red;
              }
              p:nth-of-type(1) {
                margin-top: 44px;
                margin-bottom: 5px;
              }
              p:nth-of-type(2) {
                margin-top: 8px;
              }
              img {
                width: 20px;
                height: 20px;
              }
            }
            .right {
              display: flex;
              flex-direction: column;
              padding: 10px 0;
              ul {
                margin: 25px 0 20px 0;
                li {
                  padding: 5px 11px 5px 10px;
                  background: #ecf2ff;
                  margin-right: 13px;
                }
              }
              .talk {
                width: 788px;
                font-size: 12px;
                color: #333;
              }
              .photo {
                margin-top: 22px;
                img {
                  border: 2px solid #f2f2f2;
                  margin: 2px;
                  margin-right: 14px;
                  width: 50px;
                  height: 50px;
                }
              }
              .bigImg img {
                max-width: 400px;
                width: 100%;
                height: 100%;
              }
            }
          }
        }
      }
      .refer {
        height: 1278px;
        border: 1px solid #e2e2e2;
        border-top: 0;
        overflow: hidden;
        .zixuntop {
          line-height: 34px;
          border-bottom: 1px solid #e2e2e2;
          margin: 24px 37px 0 18px;
          width: 926px;
          float: left;
        }
        .tiwen {
          height: 119px;
          border-bottom: 1px solid #e2e2e2;
          margin-left: 18px;
          width: 926px;
          float: left;
          p {
            font-size: 12px;
            color: #1958a7;
            margin: 22px 0 17px 0;
          }
          .inp {
            width: 737px;
            height: 36px;
            input {
              width: 651px;
              height: 36px;
              border: 1px solid #e2e2e2;
              border-right: 0;
            }
            span {
              width: 86px;
              height: 36px;
              float: right;
              background: red;
              text-align: center;
              line-height: 36px;
              color: #fff;
            }
          }
        }
        .yunfei {
          width: 926px;
          float: left;
          height: 109px;
          border-bottom: 1px dashed #e2e2e2;
          margin-left: 18px;
          p {
            font-size: 12px;
            color: #333;
            line-height: 25px;
            margin-left: 7px;
            .huang {
              color: red;
            }
            .day {
              color: #989898;
            }
          }
          p:nth-of-type(1) {
            margin-top: 19px;
          }
        }
      }
    }
  }

  .gl {
    width: 12px;

    height: 12px;

    position: absolute;

    border-left: 1px solid #999;

    border-bottom: 1px solid #999;

    -webkit-transform: translate(0, -50%) rotate(-135deg);

    transform: translate(0, -50%) rotate(-135deg);
  }
}
</style>