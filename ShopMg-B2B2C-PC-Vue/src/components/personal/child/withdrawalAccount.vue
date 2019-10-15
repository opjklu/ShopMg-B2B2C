<template>
	<div class="withdraw-alaccount l">
		<div class="top"><span class="l">我的提现账户</span><span class="r d">绑定账户</span></div>
					<div class="shixiang"><p>我的提现账户注意事项 </p><span>. 您需要先绑定您的银行卡、支付宝等账户才能申请账户提现</span><span>.  申请提现时，网站方会将款项打入您选定的已绑定账户中</span><span>. 为确保您的账户信息安全，在绑定账户时需要进行身份验证，感谢您的理解和支持</span></div>
					<div class="under">
						<div class="thead"><p>账户类型</p><p>开户名/姓名</p><p>账号</p><p>开户行</p><p>操作</p></div>
						<div class="down"><p>中国建设银行</p><p>张三</p><p>621589445621354896</p><p>中国建设银行股份有限公司上海博山东路支行</p><p><input class="t" type="button" value="暂无操作"/></p></div>
						</div>
	</div>
</template>
<style lang="less" scoped>
.t{padding:5px;cursor:pointer}
.d{display: none}
.l{float: left;}
	.r{float: right;}
	.center {width: 1200px;margin: 0 auto;height: 100%;}
	
		.withdraw-alaccount{
			height:956px;width:980px;background: #fff;margin:16px 0;
			.top{overflow: hidden; margin:14px 17px 20px;border-bottom:1px solid #e7e7e7;line-height:37px;span.l{width:104px;text-align: center;border-bottom:2px solid red;font-size:14px;color:red;}span.r{width:80px;height:28px;text-align: center;line-height:28px;background:red;color:#fff;border-radius:4px;margin-top:4px;}}
			.shixiang{margin:0 17px 12px;border:1px solid #bce8f1;background:#eff8ff;height:141px;p{font-size:15px;color:#333;margin:15px 0 9px 23px;}span{font-size:12px;color:#a5a7a8;line-height:24px;display:block;margin-left: 23px;}}
			.under{overflow: hidden;border:1px solid #e7e6e6;margin:0 17px;
				.thead{line-height:42px;background:#f1f1f1;overflow: hidden;}
				p{height:100%; text-align: center; float:left;font-size:12px;color:#333;}p:nth-of-type(1){width:212px;}p:nth-of-type(2){width:118px;}p:nth-of-type(3){width:154px;margin:0 21px 0 28px;}p:nth-of-type(4){width:253px;}p:nth-of-type(5){width:81px;}
				.down{line-height:39px;height:39px;border-top:1px solid #e7e6e6;span{color:#e31939;}}
			}
		}
</style>