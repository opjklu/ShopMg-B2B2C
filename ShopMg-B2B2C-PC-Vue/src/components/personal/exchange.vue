<template>
	<div class="exchange">
		<common-header></common-header>
		<my-header></my-header>
		<div class="center">
			<div class="top"><span>您的位置： </span> <span>交易中心</span> > <span>我的订单 </span> > <span>申请售后</span> > <span>仅换货</span></div>
			<img v-show="logo1" class="logo" src="../../assets/img/huanhuo.png"/><img v-show="logo2" class="logo" src="../../assets/img/huanhuo1.png"/><img v-show="logo3" class="logo" src="../../assets/img/huanhuo1.png"/>
			<div class="middle">
				<div class="left l" v-show="logo1">
					<div class="up"><span>换货</span></div>
					<div class="down">
						<div class="yuanyin">换货原因：<span>*</span><select name="">
							<option value="">大小尺寸与商品描述不相符</option><option value="">大小尺寸与商品描述不相符</option><option value="">大小尺寸与商品描述不相符</option>
						</select></div>
						<div class="shuoming"><p class="l">说明：</p><textarea class="l"></textarea><span>(2/200字)</span></div>
						<div class="pingzheng">上传凭证：<span>选择凭证图片</span></div>
						<div class="jiahao"><i class="el-icon-plus"></i></div>
						<div class="but"><button @click="open">提交申请</button><router-link to="apply">取消并返回</router-link></div>
					</div>
				</div>
				<div class="left l logo2" v-show="logo3">
					<div>
						<p class="chuli">请等待卖家处理</p>
						<p class="same">. 如果卖家同意，请按照已给出的换货地址退货给卖家，并请记录退货运单号。</p> 
						<p class="same"> . 如果卖家拒绝，或在 <span>04</span>天<span>23</span>时<span>58</span>分<span>05</span>秒内未处理，需要您更改换货申请。</p>
					</div>
					<p class="xiugai">您好可以：<a @click="xiugai">修改换货申请</a><router-link to="apply">取消换货申请</router-link></p>
					
				</div>
				<div class="left l logo3" v-show="logo2">
					<div class="Box">
						<div class="chuli"><p class="l">请确认完成换货申请</p>   倒计时： <span>04</span>天<span>23</span>时<span>59</span>分<span>48</span>秒</div>
						<p class="same">.  卖家已提供退货信息：闵行区江凯路199号蕾特商务中心311室（收件人：张三，18592654874）</p> 
						<p class="same">  .  请将商品退回,在收到卖家的换货商品后，请点击“完成换货申请”</p>
						<p class="same">  .  逾期您的换货申请将自动关闭，无法再次申请</p>
						<button>完成换货申请</button>
					</div>
					<p class="xiugai">您好可以：<router-link to="apply">取消换货申请</router-link></p>
				</div>
				<div class="right r">
					<div class="xiangqing" v-text="title"></div>
					<div class="shangpin"><img src="../../assets/img/apply.png"/><span>小熊电热饭盒保温可插电蒸煮器加热真空保鲜双层不锈钢内胆便当盒 </span></div>
					<ul class="ul">
						<li>卖    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 家：bojiechina</li><li>联系电话：0510-87486600</li><li>订单编号：<span class="lanse">3215375429258336</span></li><li>单   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 价：<span>688.00</span>元*1（数量）</li><li>邮   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 费：<span>0.00</span>元</li>
					</ul>
					<ul class="ul uL" v-show="ul">
						<li>退款编号：827790197963683</li><li>退款金额：<span>668.68</span>元</li><li>原   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 因：大小尺寸与商品描述不相符</li><li>要   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 求：仅退款</li><li>货物状态：已收到货</li>
					</ul>
				</div>
			</div> 
			<div class="bottom">
				<div class="jieshao"><span >服务介绍</span></div>
				<p>1.仅退款</p><span class="spa">申请条件：若您未收到货，或已收到货且与卖家达成一致不退货仅退款时，请选择“仅退款”选项。</span><span class="spa">退款流程：1.申请退款>2.卖家同意退款申请>3.退款成功</span>
				<p>2.退货退款</p><span class="spa">申请条件：若您未收到货，或已收到货且与卖家达成一致不退货仅退款时，请选择“仅退款”选项。</span><span class="spa">退款流程：1.申请退款>2.卖家同意退款申请>3.退款成功</span>
				<p>3.换货</p><span class="spa">申请条件：若您未收到货，或已收到货且与卖家达成一致不退货仅退款时，请选择“仅退款”选项。</span><span class="spa">退款流程：1.申请退款>2.卖家同意退款申请>3.退款成功</span>
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
				logo1:true,
				logo2:false,
				logo3:false,
				title:'订单详情',
				ul:false,
				
			}
		},
		components: {
      myHeader
    },
		methods:{
			open(){
				this.logo1=false
				this.logo2=true
				this.title='仅换货'
				this.ul=true
			},
			xiugai(){
				this.logo1=true
				this.logo2=false
			}
		}
		
	}
</script>


<style lang="less" scoped>
	.l{float: left;}
	.r{float: right;}
	.center {width: 1200px;margin: 0 auto;height: 100%;}
	.exchange{background:#f6f6f6;}
	.top{
		line-height:42px;font-size:12px;span{color:#474747;}span:last-child{color:red;}
	}
	.logo{margin-bottom:11px;}
	.middle{
		overflow: hidden;
		.left{
			width:902px;height:437px;background:#fff;
			.up{line-height:35px;margin:10px;border-bottom:1px solid #e7e7e7;span{text-align: center; display:inline-block; width:104px;font-size:12px;color:red;border-bottom:2px solid red;}}
			.down{
				.yuanyin{margin:25px 0 0 55px; font-size:12px;color:#484848;span{color:#f14343;margin-right:13px;}select{width:250px;height:30px;outline:none;color:#484848;}}
				.shuoming{overflow: hidden; font-size:12px;color:#484848;margin:10px 0 0 79px;textarea{width:468px;height:60px;margin-left:11px;}span{margin-left:5px;}}
				.pingzheng{margin:19px 0 0 55px;font-size:12px;color:#484848;span{cursor:pointer; display: inline-block;width:121px;height:28px;text-align: center;line-height:28px;background: #f9f9f9;border:1px solid #ccc;margin-left:17px;}}
				.jiahao{width:98px;height:98px;border:1px dashed #ccc;margin:21px 0 23px 133px;line-height:116px;text-align: center;i{font-size:45px;color:#e4e4e4;}}
				.but{margin-left:133px;button{cursor:pointer; width:94px;height:32px;border-radius:3px;text-align: center;line-height:32px;color:#fff;background: red;margin-right:18px; a{font-size:13px;}}}
			}
		}
		.logo2{
			div{margin:0 15px;height:203px;border-bottom:1px solid #e7e7e7;.chuli{font-size:18px;margin:46px  0 22px 43px;}}.same{font-size:14px;margin-left:44px;line-height:26px;span{color:red;}}
			p.xiugai{margin:42px 0 0 63px;font-size: 14px;a{padding-right: 29px;font-size:14px;}}
		}
		.logo3{
			.Box{margin:0 15px;height:263px;border-bottom:1px solid #e7e7e7;.chuli{margin:46px 0 22px 43px;line-height:18px;font-size:14px; p{font-size: 18px;margin-right:42px;}span{color:red;}}}
			.same{font-size:14px;margin-left:44px;line-height:26px;}button{cursor:pointer; width:94px;height:32px;border-radius:3px;text-align: center;line-height:32px;color:#fff;background: red;margin:22px 0 0 56px;}
			p.xiugai{margin:42px 0 0 63px;font-size: 14px;a{padding-right: 29px;font-size:14px;}}
		}
		.right{
			width:289px;height:437px;background:#fff;
			.xiangqing{line-height:34px;margin: 10px 12px 14px;border-bottom:1px solid #e7e7e7;}
			.shangpin{overflow: hidden; margin:0 12px;border-bottom:1px solid #e7e7e7;img{margin:0 11px 15px 0;float:left;}span{font-size:12px;color:#333;}}
			.ul{
				margin:9px 12px 0;
				li{line-height:34px;font-size:12px;color:#333;span{color:#ff6000;}.lanse{color:#59c4eb;}}
			}
			.uL{margin-top:0;}
		}
	}
	.bottom{
		height:489px;background:#fff;margin-bottom:30px;
		.jieshao{line-height:35px;margin:10px;border-bottom:1px solid #e7e7e7;span{text-align: center; display:inline-block; width:104px;font-size:12px;color:red;border-bottom:2px solid red;}}
		p{font-size:14px;color:#333;line-height: 73px;margin-left:44px;}.spa{display: block;font-size:14px;color:#5a5a5a;line-height:25px;margin-left:44px;}

	}
</style>