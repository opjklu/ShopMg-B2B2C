<template>
	<div class="header">
		<common-header></common-header>
		<my-header></my-header>
		<div class="bottom">
			<div class="center">
				<div class="left l">
					<div v-for="(val,k) in data" :key="k">
						<p><img :src="titleArr[k].img"/>{{titleArr[k].p}}</p>
						<ul>
              <li class="l" :key="index" @click="change(item,index,k)" v-for="(item,index) in val" :class="{active:index == parseInt(isactive) && k == parseInt(paractive)}">{{item.title}}
                <i class="el-icon-arrow-right"></i>
              </li>
            </ul>
					</div>		
				</div>
				<!-- 视图 -->
				<router-view v-if="isRouterAlive" :key="$route.path + $route.query.x" class="right-page-view"></router-view>
			</div>
		</div>                                               
		<foot-com></foot-com>
	</div>       
</template>
                                                                                                         
<script>
import myHeader from "./header/myHeader.vue"; //个人中心的头部
import huiyuan from "@/assets/img/tuoyuan.png";
import jiaoyi from "@/assets/img/jiaoyi.png";
import zijin from "@/assets/img/zijin.png";
import fapiao from "@/assets/img/fapiao.png";
import fuwu from "@/assets/img/fuwu.png";
export default {
  provide() {
    // 注册一个方法
    return {
      reload: this.reload
    };
  },
  data() {
    return {
      isRouterAlive: true,
      data: [
        [
          { title: "欢迎页", url: "greet" },
          { title: "个人资料", url: "personalData" },
          { title: "账户安全", url: "security" },
          { title: "账户绑定", url: "bound" },
          { title: "收货地址", url: "receive" },
          { title: "我的消息", url: "myNews" }
        ],
        [
          { title: "我的订单", url: "myOrder" },
          { title: "套餐订单", url: "packageOrder" },
          { title: "积分订单", url: "integralOrder" },
      /*    { title: "我的拍卖", url: "auction" }, */
          { title: "我的评价", url: "evaluation" },
          { title: "退款退货", url: "goodSrefund" },
          { title: "套餐退款退货", url: "packageSrefund" },
          { title: "我的投诉", url: "complaint" },
          { title: "我的收藏", url: "collect" },
          { title: "最近浏览", url: "ecentBrowse" }
        ],
        [
          { title: "我的账户", url: "myAccount" },
          { title: "我的积分", url: "myIntegral" },
          { title: "我的优惠券", url: "myCoupons" },
          { title: "我的充值", url: "myCharge" },
          { title: "我的提现账户", url: "withdraWalaccount" },
          { title: "我的提现", url: "myWithdrawal" }
        ],
        [
          { title: "发票信息", url: "invoiceInfo" },
          { title: "发票管理", url: "invoiceManage" }
        ],
        [
          { title: "我要开店", url: "agreement" },
          { title: "查看进度", url: "progressLook" }
        ]
      ],
      isactive: 0,
      titleArr: [
        { img: huiyuan, p: "会员中心" },
        { img: jiaoyi, p: "交易中心" },
        { img: zijin, p: "资金中心" },
        { img: fapiao, p: "我的发票" },
        { img: fuwu, p: "服务中心" },
      ],
      paractive: 0,
      num: 0
    }
  },
  watch: {
    $route(to, from) {
      this.watchRoute(to);
    }
  },
  created() {
    this.initializeStyle();
    // if(this.$route.query.id){
    this.watchRoute(this.$route);
    // }
    //Shop_Sn
  },
  methods: {
    reload() {
      this.isRouterAlive = false;
      this.$nextTick(function() {
        this.isRouterAlive = true;
      });
    },

    initializeStyle() {
      if (
        sessionStorage.getItem("router_index") &&
        sessionStorage.getItem("router_index1")
      ) {
        this.isactive = sessionStorage.getItem("router_index");
        this.paractive = sessionStorage.getItem("router_index1");
      } else {
        sessionStorage.setItem("router_index", 0);
        sessionStorage.setItem("router_index1", 0);
      }
    },
    change(item, index, k) {
      if (
        item.url == "collect" ||
        item.url == "ecentbrowse" ||
        item.url == "agreement"
      ) {
        this.$router.push(item.url);
      } else {
        this.$router.push({
          path: "/" + item.url,
          query: {
            x: this.num++
          }
        });
      }
    },
    watchRoute(to) {
      for (let j = 0; j < this.data.length; j++) {
        for (let k = 0; k < this.data[j].length; k++) {
          if (to.name == this.data[j][k].url) {
            sessionStorage.setItem("router_index", k);
            sessionStorage.setItem("router_index1", j);
            continue;
          }
        }
      }
      this.isactive = sessionStorage.getItem("router_index");
      this.paractive = sessionStorage.getItem("router_index1");
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
  width: 1190px;
  margin: 0 auto 50px;
  height: 100%;
}
.center:after {
  display: block;
  content: "";
  clear: both;
}
.bottom {
  background: #f6f6f6;
  overflow: hidden;
  .left {
    width: 190px;
    background: #fff;
    margin: 15px 10px 0 0;
    padding-top: 17px;
    overflow: hidden;
    padding-bottom: 17px;
    p {
      width: 160px;
      height: 43px;
      line-height: 43px;
      font-size: 14px;
      color: #484848;
      margin-left: 29px;
      img {
        margin-right: 12px;
      }
    }
    ul {
      margin-left: 29px;
      overflow: hidden;
      li {
        width: 160px;
        height: 30px;
        line-height: 30px;
        padding-left: 37px;
        color: #666;
        font-size: 11px;
        cursor: pointer;
        i {
          float: right;
          margin: 9px 10px 0 0;
        }
      }
      .active {
        color: red;
        background: #f6f6f6;
      }
    }
  }
  // .right-page-view {
  //   min-height: 1100px !important;
  //   height: auto !important;
  // }
}
</style>