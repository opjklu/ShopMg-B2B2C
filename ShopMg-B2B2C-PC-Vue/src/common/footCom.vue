<template>
  <footer>
    <div class="top">
      <div class="center">
        <div class="erweima l">
          <img :src="URL + init_qr_code" />
          <p>ShopMG商城官方微信服务号扫一扫，享更多优惠</p>
        </div>
        <div class="phone l">
          <span class="call">{{intnet_phone}}</span>
          <br />
          <span class="workday">工作日(9:00-18:00)</span>
        </div>
        <div class="topul l">
          <div class="l" v-for="(item,k) in article_category" :key="k">
            <span @click="toLink(item.id)" class="c">{{item.name}}</span>
            <ul>
              <li
                @click="hit(data.id)"
                :key="index"
                v-if="data.article_category_id == item.id"
                v-for="(data,index) in article "
              >{{data.name}}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="middle">
      <div class="center">
        <img src="../assets/img/pinpai.jpg" />
      </div>
    </div>
    <div class="bottom">
      <div class="center">
        <p class="pOne l">{{record_number}}号|有任何问题请联系我们在线客服 电话：{{intnet_phone}}</p>
        <p class="pOne l">{{intnet_licence}}</p>
        <p class="pOne l">{{intnet_copyright}}</p>
        <ul class="partner">
          <li v-for="item in partner" :key="item.id">
            <img :src="URL + item.pic_url" />
          </li>
        </ul>
      </div>
    </div>
  </footer>
</template>
<script>
import { TimeInterval } from "../../es6/time.js";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      article_category: [],
      article: [],
      websiteInfo: {},
      partner: []
    };
  },
  computed: {
    ...mapGetters([
      "record_number",
      "intnet_licence",
      "intnet_copyright",
      "init_qr_code",
      "intnet_phone"
    ])
  },
  created() {
    this.getData();
    this.getpartner();
  },

  mounted() {
    this.getFootData();
  },
  methods: {
    //标题跳转
    toLink(id) {
      this.$router.push({
        name: "guide",
        params: {
          type: "article",
          category_id: id
        }
      });
    },
    //底部合作伙伴图
    getpartner() {
      let data = TimeInterval.getItem("partner");

      if (data) {
        this.partner = data;
        return;
      }

      this.HTTP(this.$httpConfig.getCooprativeList, {}, "post")
        .then(res => {
          this.partner = res.data;
          TimeInterval.setTask("partner", JSON.stringify(this.partner));
        })
        .catch(e => {
          console.log(e);
        });
    },

    setSiga(param) {
      this.$store.dispatch("sign/setLogo", param.logo_name);
      this.$store.dispatch("sign/setRecordNumber", param.record_number);
      this.$store.dispatch("sign/setLicence", param.intnet_licence);
      this.$store.dispatch("sign/setCopyright", param.intnet_copyright);
      this.$store.dispatch("sign/setQrcode", param.init_qr_code);
      this.$store.dispatch("sign/setTelphone", param.intnet_phone);
    },

    getFootData() {
	  let websiteInfo = TimeInterval.getItem("web_info");
      if (websiteInfo) {
        this.setSiga(websiteInfo);
        return;
      }

      this.HTTP(this.$httpConfig.aboutEtcetera, {}, "post").then(res => {

        this.setSiga(res.data);
        TimeInterval.setTask("web_info", JSON.stringify(res.data));
      });
    },
    getData() {
      this.HTTP(this.$httpConfig.commonFloor, {}, "post").then(res => {
        this.article = res.data.article;
        this.article_category = res.data.atricle_category;
      });
    },
    hit(id) {
      this.$router.push({
        name: "guide",
        params: {
          type: "article",
          id: id
        }
      });
    }
  }
};
</script>

<style lang="less" scoped>
.c {
  cursor: pointer;
}
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
footer {
  height: 564px;
  background: #fff;
  .top {
    height: 231px;
    border-bottom: 1px solid #e8e8e8;
    .erweima {
      width: 130px;
      img {
        margin: 46px 0 0 13px;
        width: 102px;
        height: 102px;
      }
      p {
        font-size: 12px;
        color: #b4b4b4;
        width: 100%;
        text-align: center;
        margin-top: 15px;
      }
    }
    .phone {
      margin-top: 83px;
      .call {
        color: #e44a56;
        font-size: 14px;
      }
      .workday {
        color: #b0b0b0;
        font-size: 10px;
      }
    }
    .topul {
      margin-top: 58px;
      margin-left: 102px;
      div {
        margin-right: 115px;
        span {
          font-size: 15px;
          color: #494949;
        }
        ul {
          margin-top: 8px;
          li {
            font-size: 12px;
            color: #959595;
            line-height: 24px;
            cursor: pointer;
            &:hover {
              color: red;
            }
          }
        }
      }
    }
  }
  .middle {
    height: 96px;
    border-bottom: 1px solid #e8e8e8;
    img {
      margin-top: 26px;
    }
  }
  .bottom {
    height: 236px;
    text-align: center;
    // ul{
    // 	margin-top: 30px;
    // 	margin-left: 34%;
    // 	text-align: center;
    // 	float: left;
    // 	li{
    // 		width: 75px;
    // 		float: left;
    // 		text-align: center;
    // 		border-left: 1px solid #989898;
    // 		cursor:pointer;
    // 		a{font-size: 12px;color: #a6a6a6;}
    // 		&:hover a{color:red;}
    // 	}
    // 	li:first-child{border: 0;}
    // }
    .pOne {
      width: 100%;
      text-align: center;
      color: #a6a6a6;
      font-size: 12px;
      margin-top: 10px;
    }
    .partner {
      padding-top: 33px;
      min-width: 1088px;
      min-height: 37px;
      display: flex;
      flex-wrap: nowrap;
      justify-content: center;
      flex-direction: row;
      .li {
        border: 0;
      }
    }
    // img{margin:33px 0 0 36px;}
  }
}
</style>
