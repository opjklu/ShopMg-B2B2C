<template>
	<div class="team l">
		<ul class="top"><li @click="team(0)" :class="{active:Actives==0}"><p>一级分销</p></li><li @click="team(1)" :class="{active:Actives==1}"><p>二级分销</p></li><li @click="team(2)" :class="{active:Actives==2}"><p>三级分销</p></li></ul>	
					<div class="under">
						<div class="thead"><p>会员ID</p><p>会员名</p></div>
						<div class="same"><p>1</p><p>小小的太阳</p></div>
					</div>
	</div>
</template>

<script>
export default {
  data () {
    return {
      Actives:'',
    }
  },
  created () {
  },
  methods: {
   team(index){this.Actives=index},
  }
}
</script>


<style lang="less" scoped>
	.l{float: left;}
	.r{float: right;}
	.center {width: 1200px;margin: 0 auto;height: 100%;}
	.team{
			width:980px;background: #fff;margin:16px 0;padding-bottom:40px;height:357px;
			.top{height:37px;border-bottom:1px solid #e7e7e7;margin:14px 17px 23px;; li{cursor:pointer; float:left; width:104px;text-align:center;height:37px;font-size:14px;color:#666; p{line-height:16px;border-right:1px solid #eee;margin-top:10px;}}li:last-child{p{border-right:0;}}}
			.active{border-bottom:2px solid red;color:red !important;}
			.under{
				margin:23px 17px 0;border: 1px solid #e7e6e6;overflow:hidden;
				.thead{overflow: hidden;height:38px;background:#f5f5f5;line-height:38px;}.same{line-height:38px;border-top:1px solid #e7e6e6;p:nth-of-type(1){margin:0 225px 0 32px;}}
				p{font-size:12px;color:#333;float:left;}p:nth-of-type(1){margin:0 199px 0 32px;}
			}
		}
</style>