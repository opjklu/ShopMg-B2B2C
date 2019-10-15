<template>
  <div class="inroyaldrink">
    <head-com></head-com>
    <div class="center" style="margin-top:10px">
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
                <li @mouseover="styleChange(index,li.pic_url)" :key="index" v-for="(li,index) in imgList"><img :class="{active:sign == index}" :src="URL + li.pic_url" /></li>
              </ul>
            </div>
            <div class="scrollbutton smallImgDown r" :class="{disabled:imgList.length<4}">
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
            <span @click="goodsCollection"><i class="el-icon-star-on"></i>{{collection_text1}}</span>
          </div>
        </div>
        <div class="central l">
          <p class="goods-title">{{goodsData.title}}</p>
          <p class="description">{{goodsData.description}}</p>
          <div class="price">
            <p class="l">市场价
              <span>￥{{goodsData.price_market || '0.00'}}</span>
            </p>
            <p class="l">售 &nbsp;&nbsp;价
              <span> ￥{{this.$route.query.integral||0.00}}积分</span>
            </p>
            <p class="l">
              促&nbsp;&nbsp;&nbsp;销
              <span class="man">满赠</span>
              <span class="both">{{info.countHtml}}</span><br />
              <span class="man jian">满减</span>
              <span class="both">{{info.giftHtml}}</span>
            </p>
          </div>
          <div class="dizhi">
            <div class="spec-group" v-for="(item,index) in spec.spec_group" :key="index">
              <span class="group-name">{{item.name}}</span>
              <div class="spec-term-list">
                <span class="spec-term-name" v-if="item.id == d.spec_id" @click="addClass(index,item.id,d.id)" v-for="(d,i) in spec.spec_children" :key="i" :class="{active:d.default_spec}">{{d.item}}</span>
              </div>
            </div>
            <p class="send-to">
              <span class="gp-label l">配送至</span>
              <receiving-address></receiving-address>
              <span class="yunfei">运费：￥10.00</span>
            </p>
            <p class="g-service">服 &nbsp;&nbsp;务
              <span class="">由
              <span class="yellow">{{shop_data.shop_name}} </span>负责发货，并提供售后服务</span>
            </p>
          </div>
          <div class="leiji">
            <p>累计评价
              <span>{{info.comment_number}}人评价</span>
            </p>
            <p>累计销量
              <span>{{goodsData.selling || 0}}</span>
            </p>
            <p>赠送积分
            </p>
          </div>
          <div class="buy">
            <span @click="$router.push({name: 'Settlement', params: {id:Number($route.query.id)}})" style="margin-left:10px">立即兑换</span>
            <!-- <span @click="addCar(goodsData.price_member, goodsData.store_id)"><img src="../../assets/img/buycar1.jpg" />加入购物车</span>
            <div class="r">手机购买<img src="../../assets/img/samllerweima.jpg" alt="" /></div> -->
          </div>
        </div>
        <div class="r right">
          <div class="header l">{{shop_data.shop_name}}</div>
          <div class="l zonghe">
            <p class="left l">
              <span>{{(shop_data.desccredit + shop_data.servicecredit + shop_data.deliverycredit) / 3}} </span><br />综合</p>
            <p class="first">描述相符
              <span>{{shop_data.desccredit}}</span>
            </p>
            <p>服务态度
              <span>{{shop_data.servicecredit}}</span>
            </p>
            <p>发货速度
              <span>{{shop_data.deliverycredit}}</span>
            </p>
          </div>
          <div class="kefu l">
            <p>所在地：
              <span>{{shop_data.address}}</span>
            </p>
            <p>客服：
              <span><img class="l" src="../../assets/img/kefu.jpg" />在线客服</span>
            </p>
          </div>
          <div class="l dian">
            <p>
              <span @click="toStore">进店逛逛</span>
              <span @click="shopCollection">{{collection_text}}</span>
            </p>
          </div>
          <div class="instore l">
            <input class="l guanjianzi" type="text" v-model="storeSearchData.keyword" placeholder="关键字" />
            <div class="l picdiv">
              <input class="l pic" type="text" v-model="storeSearchData.minMoney" placeholder="最小价格" />
              <span>~</span>
              <input class="r pic" type="text" v-model="storeSearchData.maxMoney" placeholder="最大价格" /></div>
            <p @click="storeSearch">店内搜索</p>
            <el-dialog title="提示" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
              <span>搜索内容不能为空</span>
              <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
              </span>
            </el-dialog>
          </div>
        </div>
      </div>
      <div class="bottom">
        <div class="left l">
          <div class="zhongxin l">
            <p class="l kefu">
              <span>客服中心</span><br />CUSTOMER</p>
            <p class="l zixun">在线咨询</p>
            <div class="l qq">
              <p>售前客服<img src="../../assets/img/qq.jpg" alt="" />张三</p>
              <p>售后客服<img src="../../assets/img/qq.jpg" alt="" />张三</p>
              <p>在线客服<img src="../../assets/img/zaixian.jpg" alt="" /></p>
            </div>
            <p class="l zixun">工作时间</p>
            <p class="l time">AM 8:00-PM 18:00</p>
          </div>
          <div class="fenlei l">
            <p>商品分类</p>
            <ul class="outer">
              <li class="outerli" v-if="outers.level == 0" v-for="(outers,index) in storeClassArr" :key="outers.id" @click="block(index)" :class="{active:isactive==index}">
                <span>{{outers.class_name}}</span>
                <ul class="core" v-if="fun==index">
                  <li class="coreli" v-if="cores.level==1 && cores.fid == outers.id" v-for="(cores, i) in storeClassArr" :key="i">
                    <span>>{{cores.class_name}}</span>
                    <ul class="core" v-if="fun==index">
                      <li class="coreli2" v-if="core.level==2 && core.fid == cores.id" v-for="(core,j) in storeClassArr" :key="j">
                        <span>>{{core.class_name}}</span>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="l paihang">
            <p class="shangpin">店内排行榜</p>
            <span>没有接口</span>
            <ul class="l">
            </ul>
          </div>
          <div class="l liulan">
            <p class="zuijin">最近浏览</p>
            <ul>
              <li class="l" :key="index" v-if="browser instanceof Array" v-for="(item, index) in browser">
                <img class="l" :src="item.pic_url === null ? 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1542620438617&di=934a6c42aa8fc70f89d333365c9bf7e8&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimgad%2Fpic%2Fitem%2Fb21c8701a18b87d69f0ccc220c0828381f30fd45.jpg' : URL + item.pic_url"
                />
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
              <li @click="undo(1)" :class="{bg:isbg==1}" class="l">商品评价
                <span>{{info.comment_number}}</span>
              </li>
              <li @click="undo(2)" :class="{bg:isbg==2}" class="l">商品咨询
                <span>89</span>
              </li>
            </ul>
            <div class="l line"></div>
          </div>
          <div class="subpage l">
            <div v-show="only==0" class="jieshao">
              <div class="up">
                <p class="p">商家货号：96004746</p>
                <p class="p">品牌：</p>
                <p class="p">类别：不限</p>
                <p class="p">材料：不限</p>
                <p class="p">工艺：不限</p>
                <p class="p">窑口：不限</p>
              </div>
              <div class="down" id="detail-img" v-html="shopImage">
              </div>
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
                    <li class="l" :class="isCurrentComment == 0 ? 'active' : ''" @click="getAllCommentContent(0)">全部评价
                      <span>({{comments.allCount||0}})</span>
                    </li>
                    <li class="l" :class="isCurrentComment == 1 ? 'active' : ''" @click="getAllCommentContent(1)">好评
                      <span>({{comments.allNice||0}})</span>
                    </li>
                    <li class="l" :class="isCurrentComment == 2 ? 'active' : ''" @click="getAllCommentContent(2)">中评
                      <span>({{comments.allHeight||0}})</span>
                    </li>
                    <li class="l" :class="isCurrentComment == 3 ? 'active' : ''" @click="getAllCommentContent(3)">差评
                      <span>({{comments.allBad||0}})</span>
                    </li>
                    <li class="l" :class="isCurrentComment == 4 ? 'active' : ''" @click="getAllCommentContent(4)">有图
                      <span>({{comments.allImg||0}})</span>
                    </li>
                  </ul>
                </div>
                <div class="l dibian" v-for="(item,index) in comments.list" :key="index">
                  <div class="name l">
                    <p>{{item.nick_name}}
                      <span> (匿名) </span>
                    </p>
  
                    <p class="score">{{item.score|filtScore}}</p>
                    <p>{{item.create_time | formatDate}}</p>
                  </div>
                  <div class="right">
                    <p class="l talk">{{item.content}}</p>
                    <div class="l photo"><img :src="URL+item.path" /></div>
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
                  <p>查看全部 89 条咨询</p>
                  <div class="inp"><input type="text" />
                    <span>我要提问</span>
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
                      <span class="r day">11月20日 09:20</span>
                    </p>
                  </div>
                  <div class="yunfei">
                    <p>
                      <span class="huang">Q</span> 满多少免运费?
                      <span class="r day">11月20日 09:20</span>
                    </p>
                    <p>
                      <span class="huang">A</span> 公司承诺符合以下情况，公司承诺符合以下情况,公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况，公司承诺符合以下情况
                      <span class="r day">11月20日 09:20</span>
                    </p>
                  </div>
                </div>
  
              </div>
            </div>
          </div>
        </div>
      </div>
      <like-and-history></like-and-history>
    </div>
    <foot-com></foot-com>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        storeSearchData: {
          keyword:'',
          minMoney: '0',
          maxMoney: 500
        },
        dialogVisible: false,
        specKey: this.$route.query.goods_id,
        spec: {},
        specData: {},
        collection_text: "收藏本店",
        collection_text1: "收藏商品",
        goodsData: {},
        shop_data: {},
        defaultPicture: "",
        imgList: [],
        sign: 0,
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
        isactive: "",
        imgs: [],
        isbg: "",
        only: "",
        basebox: [],
        base: [],
        isborder: "",
        yinxiangs: [{
            p: "空气清新",
            span: "185"
          },
          {
            p: "空气清新",
            span: "185"
          },
          {
            p: "空气清新",
            span: "185"
          },
          {
            p: "空气清新",
            span: "185"
          },
          {
            p: "空气清新",
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
       

        shopImage: '', // 商品详情
        browser: [], // 最近浏览
        ShoppingRank: []
      };
    },
    beforeCreate() {
      window._bd_share_main = "";
    },

    
    mounted() {
      this.magnify();
      let n = 0;
      let isChange = false;
      window.onscroll = () => {
        clearTimeout(timer);
        let timer = setTimeout(() => {
          clearTimeout(timer);
          let scrollTop =
            document.documentElement.scrollTop || document.body.scrollTop;
          console.log(scrollTop);
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
    },
  
    filters: {
      filtScore: function(value) {
        return "★★★★★☆☆☆☆☆".slice(5 - value, 10 - value);
      }
    },
    methods: {
      //向店内搜索页传参数
      storeSearch () {
         if(this.storeSearchData.keyword!=""){
          this.$router.push({
					name:'TheStoreSearch',
					query:{
            id:this.$route.query.id,
            keyword:this.storeSearchData.keyword,
            minMoney:this.storeSearchData.minMoney,
            maxMoney:this.storeSearchData.maxMoney,
            type:0
					}
				})
        }else{
            this.dialogVisible=true;
        }
      },
      handleClose(done) {
        this.$confirm('确认关闭？')
          .then(_ => {
            done();
          })
          .catch(_ => {});
      },
      computedTotalPrice(data) {
        let totalPrice = 0;
        if (!(data instanceof Array)) {
          return;
        } else {
          data.map((item, index) => {
            totalPrice += ~~item.price_member;
          });
        }
        return totalPrice;
      },
      // 计算原价
      computedTotal(data) {
        let totalPrice = 0;
        if (!(data instanceof Array)) {
          return;
        } else {
          data.map((item, index) => {
            totalPrice += ~~item.goods_discount;
          });
        }
        return totalPrice;
      },
      // 店内商品排行
      getHotCommodities() {
        this.HTTP(this.$httpConfig.getHotCommodities, {}, "post").then(res => {
          this.ShoppingRank = res.data;
          console.log(res.data);
        });
      },
      // 最近浏览
      getMyFootFrint() {
        this.HTTP(this.$httpConfig.getMyFootFrint, {}, "post").then(res => {
          if (res.data.list) {
            this.browser = res.data.list
          }
        });
      },
      //商品收藏
      goodsCollection() {
        this.HTTP(
            this.$httpConfig.setCollectionGoods, {
              goods_id: this.goodsData.id
            }, "post", false).then(res => {
              if (res.message == "收藏成功") {
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
          price_new: price,
          store_id: storeId
        };
        this.HTTP(this.$httpConfig.addGoodToCart, params, "post").then(res => {
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
        });
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
   
     
      //去店铺
      toStore() {
        window.open(
          window.location.origin + "/storehome?id=" + this.shop_data.store_id
        );
      }, 
      styleChange(index, url) {
        this.sign = index;
        this.defaultPicture = url;
      },
      //收藏店铺
      shopCollection() {
        if (this.collection_text == "收藏本店") {
          this.HTTP(
            this.$httpConfig.setAttenStore, {
              id: this.shop_data.store_id
            },
            "post",
            false
          ).then(res => {
            this.collection_text = res.status == 1 ? "取消收藏" : "收藏本店";
          });
        } else {
          this.HTTP(
            this.$httpConfig.setCancelAttenStore, {
              id: this.shop_data.store_id
            },
            "post",
            false
          ).then(res => {
            this.collection_text = res.status == 1 ? "收藏本店" : "取消收藏";
          });
        }
      },
      //店铺信息
      getShopData(id) {
        this.HTTP(
          this.$httpConfig.getStoreDetails, {
            id: id
          },
          "post"
        ).then(res => {
          this.shop_data = res.data;
          this.collection_text =
            res.data.if_atten == 0 ? "收藏本店" : "取消收藏";
        });
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
          this.$httpConfig.goodsSpecs, {
            id: id
          },
          "post"
        ).then(res => {
          this.specData = res.data;
          this.spec = res.data.spec;
          console.log(res.data)
          console.log(this.specKey)
          for (let key in this.spec.spec_children) {
            console.log(typeof key, key)
            console.log(this.spec)
            if (this.specData.goods[this.specKey].key.indexOf(this.spec.spec_children[Number(key)].id) > -1) {
              this.$set(this.spec.spec_children[key], "default_spec", true);
            } else {
              this.$set(this.spec.spec_children[key], "default_spec", false);
            }
          }
          console.log(this.spec);
        });
      },
       
      //获取商品信息
      async getGoodsDetails() {
        let res = await this.HTTP(
          this.$httpConfig.getGoodsDetails, {
            id: this.$route.query.goods_id
          },"post");
        if (res.status) {
          this.goodsData = res.data;
          this.imgList = this.goodsData.images;
          this.defaultPicture = this.goodsData.images[0].pic_url;
          await this.getGoodsSpec(this.goodsData.id);
          await this.setup();
          await this.getGoodsStoreClass(this.goodsData.store_id); // 店铺导航商品分类
          await this.getShopData(this.goodsData.store_id);
          }
      },
      ShopImageDetail (id) {
        this.HTTP(
          this.$httpConfig.ShopImageDetail, {
            goods_id: id
          }, "post").then(res => {
          if (res.status) this.shopImage = res.data;
        })
      },
      getAllCommentContent(type) {
        this.isCurrentComment = type;
        this.HTTP(this.$httpConfig.getAllCommentContent, {
          goods_id: this.$route.query.id,
          type: type
        }, "post").then(res => {
          this.comments = res.data;
          this.nice100 = (this.comments.allNice / this.comments.allCount) * 100;
          this.center100 =
            (this.comments.allHeight / this.comments.allCount) * 100;
          this.bad100 = (this.comments.allBad / this.comments.allCount) * 100;
  
          this.$set($(".skitt-line")[0].style, "width", this.nice100 + "%");
          this.$set($(".skitt-line")[1].style, "width", this.center100 + "%");
          this.$set($(".skitt-line")[2].style, "width", this.bad100 + "%");
        }).catch(() => {
          this.comments = [];
        });
      },
      getGoodsConsultation() {
        this.HTTP(
          this.$httpConfig.getAllCommentContent, {
            goods_id: this.$route.query.id
          },
          "post"
        ).then(res => {
          this.consultationList = res.data;
        });
      },
      getGoodsStoreClass(id) {
        this.HTTP(
          this.$httpConfig.getGoodsStoreClass, {
            id: id
          },
          "post"
        ).then(res => {
          this.storeClassArr = res.data;
        });
      },
      block(index) {
        this.fun = index;
        this.isactive = index;
      },
      undo(index) {
        this.isbg = index;
        this.only = index;
        if (index == 1) {
          this.getAllCommentContent(0);
        } else if (index == 2) {
          this.getGoodsConsultation();
        }
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
 
  .class_one,
  .class_three {
    .all {
      p:nth-of-type(2) {
        text-decoration: none !important;
        color: white !important;
      }
    }
  }
  
  @color: #ff5601;
  .l {
    float: left;
  }
  
  .r {
    float: right;
  }
  
  .nullData {
    font-size: 35px;
    color: #999999;
    font-weight: 400;
    display:flex;
    flex: 1;
    justify-content: center;
    text-shadow: 0 1px 0 #ccc, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9, 0 5px 0 #aaa, 0 6px 1px rgba(0, 0, 0, 0.1), 0 0 5px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.3), 0 3px 5px rgba(0, 0, 0, 0.2), 0 5px 10px rgba(0, 0, 0, 0.25);
  }
  
  .center {
    width: 1200px;
    margin: 0 auto;
    height: 100%;
  }
  
  .header {
    height: 46px;
    line-height: 46px;
    font-size: 12px;
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
        width: 405px;
        height: 60px;
        .scrollbutton {
          cursor: pointer;
          width: 15px;
          height: 52px;
          border: 1px solid #dcdcdc;
          text-align: center;
          line-height: 52px;
          margin-top: 4px;
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
          width: 375px;
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
              img .active {
                border-color: #a89b4c;
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
          color: #b8a698;
        }
        span {
          display: inline-block;
          cursor: pointer;
          font-size: 12px;
          color: #abafb0;
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
      margin-left: 10px;
      .goods-title {
        font-size: 14px;
        color: #303030;
        margin: 0 0 18px 9px;
      }
      .description {
        font-size: 12px;
        color: #afa04b;
        margin: 0 0 9px 9px;
      }
      .price {
        width: 100%;
        height: 160px;
        background: url(../../assets/img/beijing.jpg) no-repeat center;
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
          background: #ce9e18;
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
                border-color: #ae984d;
              }
            }
            .active {
              border-color: #ae984d;
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
            color: #eaca73;
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
            color: #b7a661;
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
          background: #f5e9cf;
          border: 1px solid #b19651;
          display: inline-block;
          color: #b5a11e;
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
    .right {
      width: 210px;
      border: 1px solid #d2d2d2;
      min-height: 474px;
      .header {
        height: 40px;
        line-height: 40px;
        background: #f9f9f9;
        width: 100%;
        padding-left: 14px;
        font-size: 14px;
        color: #3b3b3b;
      }
      .zonghe {
        width: 192px;
        height: 111px;
        border-bottom: 1px solid #f2f2f2;
        margin-left: 11px;
        p.left {
          width: 88px;
          text-align: center;
          height: 100%;
          font-size: 12px;
          color: #7c7c7c;
          margin-top: 0;
          span {
            font-size: 26px;
            color: #d29e30;
            margin: 26px 0 0 0;
            display: block;
          }
        }
        p {
          float: left;
          height: 17px;
          font-size: 12px;
          color: #646464;
          margin-top: 14px;
          margin-left: 2px;
          span {
            color: #caa973;
            margin-left: 11px;
          }
        }
        p.first {
          margin-top: 19px;
        }
      }
      .kefu {
        min-height: 99px;
        border-bottom: 1px solid #f2f2f2;
        width: 192px;
        margin-left: 11px;
        p {
          line-height: 28px;
          color: #a2a2a2;
          font-size: 12px;
          margin-left: 13px;
        }
        p:first-child {
          margin: 16px 0 7px 13px;
        }
        p:nth-of-type(2) {
          span {
            width: 88px;
            height: 26px;
            line-height: 26px;
            border: 1px solid #eeeeee;
            background: #fbfbf1;
            display: inline-block;
            color: #5f6772;
            margin-left: 14px;
            img {
              margin: 5px 6px 0 10px;
            }
          }
        }
      }
      .dian {
        height: 76px;
        border-bottom: 1px solid #d3d3d3;
        margin-left: 11px;
        width: 192px;
        p {
          margin-top: 29px;
          span {
            width: 90px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            display: inline-block;
            font-size: 12px;
            border-radius: 5px;
            cursor: pointer;
          }
          span:nth-of-type(1) {
            background: red;
            color: #fff;
            border: 1px solid red;
          }
          span:nth-of-type(2) {
            background: #fafafa;
            color: #656565;
            border: 1px solid #e4e4e4;
          }
        }
      }
      .instore {
        .guanjianzi {
          width: 168px;
          height: 28px;
          border: 1px solid #d2d2d2;
          margin: 20px 0 10px 20px;
          padding-left: 5px;
        }
        .picdiv {
          margin-left: 20px;
          span {
            width: 20px;
            float: left;
            line-height: 28px;
            text-align: center;
            color: #d1d1d1;
          }
        }
        .pic {
          width: 73px;
          height: 28px;
          border: 1px solid #d2d2d2;
          padding-left: 5px;
        }
        p {
          cursor: pointer;
          float: left;
          width: 170px;
          height: 30px;
          text-align: center;
          line-height: 30px;
          color: #fff;
          font-size: 12px;
          background: #d19e2b;
          border-radius: 3px;
          margin: 10px 0 0 20px;
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
            background: url(../../assets/img/jiahao.jpg) no-repeat top 8px left 29px;
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
            background: url(../../assets/img/jianhao.jpg) no-repeat top 8px left 29px;
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
            border-top-color: #ba9f67;
            color: #d5b348;
            background: url(../../assets/img/xiasanjiao.jpg) no-repeat top 0 left 50%;
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
        // .jieshao {
        //   .up {
        //     height: 93px;
        //     border: 1px solid #e8e8e8;
        //     width: 100%;
        //     border-top: 0;
        //     p {
        //       float: left;
        //       margin-top: 25px;
        //       font-size: 12px;
        //       color: #5d5d5d;
        //     }
        //     p:nth-of-type(1) {
        //       width: 365px;
        //       margin-left: 16px;
        //     }
        //     p:nth-of-type(2) {
        //       width: 342px;
        //     }
        //     p:nth-of-type(3) {
        //       width: 234px;
        //     }
        //     p:nth-of-type(4) {
        //       width: 365px;
        //       margin-left: 16px;
        //       margin-top: 15px;
        //     }
        //     p:nth-of-type(5) {
        //       width: 342px;
        //       margin-top: 15px;
        //     }
        //     p:nth-of-type(63) {
        //       width: 234px;
        //       margin-top: 15px;
        //     }
        //   }
        //   .down {
        //     overflow: hidden;
        //     border: 1px solid #e8e8e8;
        //     img {
        //       margin-left: 16px;
        //     }
        //     img:last-child {
        //       margin-bottom: 76px;
        //     }
        //     img:first-child {
        //       margin-top: 15px;
        //     }
        //   }
        //   #detail-img {
        //     text-align: center;
        //     margin-top: 5px;
        //     img {
        //       width: 100% !important;
        //     }
        //   }
        // }
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
                color: #d19f2c;
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
                    color: #d29e30;
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
                    >span {
                      width: 63px;
                      font-size: 11px;
                      color: #464646;
                      display: inline-block;
                      margin-right: 0.1rem;
                    }
                    >i {
                      width: 100px;
                      height: 8px;
                      background: #b8b8b8;
                      display: inline-block;
                      position: relative;
                      overflow: hidden;
                      margin-left: 5px;
                      >b {
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
                color: #cba840;
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
                  color: #d29e30;
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
                  color: #d2a442;
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
                background: #ff6100;
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
                color: #fe5f01;
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
  }
</style>