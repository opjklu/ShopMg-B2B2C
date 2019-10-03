<template>
	<div class="paiHang">
		<ul class="top"><li @click="paiHang(0)" :class="{active:isActive==0}"><p>佣金排行</p></li><li @click="paiHang(1)" :class="{active:isActive==1}"><p>线下排行</p></li></ul>	
		<div class="under" v-show="isActive==0"> 
			<div class="thead"><p>排名</p><p>会员名</p><p>获得佣金</p></div>
			<div class="same sames"><p>1</p><p>小小的太阳</p><p>9000</p></div><div class="same"><p>1</p><p>小小的太阳</p><p>6000</p></div>
		</div>
		<div class="under" v-show="isActive==1"> 
			<div class="thead"><p>排名</p><p>会员名</p><p>下线人数</p></div>
			<div class="same sames"><p>1</p><p>小小的太阳</p><p>9000</p></div><div class="same"><p>1</p><p>小小的太阳</p><p>6000</p></div>
		</div>
	</div>
</template>

<script>
export default {
  data () {
    return {
      isActive:'',
    }
  },
  created () {
  },
  methods: {
   paiHang(index){this.isActive=index},
  }
}
</script>

<style lang="less" scoped>
	.l{float: left;}
	.r{float: right;}
	.center {width: 1200px;margin: 0 auto;height: 100%;}
	.paiHang{
			width:980px;background: #fff;margin:16px 0;padding-bottom:40px;height:357px;
			.top{height:37px;border-bottom:1px solid #e7e7e7;margin:14px 17px 23px;; li{cursor:pointer; float:left; width:104px;text-align:center;height:37px;font-size:14px;color:#666; p{line-height:16px;border-right:1px solid #eee;margin-top:10px;}}li:last-child{p{border-right:0;}}}
			.active{border-bottom:2px solid red;color:red !important;}
			.under{
				margin:23px 17px 0;border: 1px solid #e7e6e6;overflow:hidden;
				.thead{overflow: hidden;height:38px;background:#f5f5f5;line-height:38px;}.same{overflow:hidden; line-height:38px;border-top:1px solid #e7e6e6;}
				p{font-size:12px;color:#333;float:left;text-align: center;}p:nth-of-type(1){width:87px;margin-right:147px;}p:nth-of-type(2){margin-left:128px;width:104px;}p:nth-of-type(3){margin-left:47px;width:105px;}
				p:nth-of-type(4){margin-left:61px;width:127px;}p:nth-of-type(5){width:106px;}
				.sames{p{color:red !important;}}
			}
		}
</style>