<template>
	<div class="account">
		<div v-show="j">
			<ul class="top">
				<li>账户安全</li>
			</ul>
			<div class="head">
				<img :src="URL+userInfo.user_header" v-if="userInfo.user_header" alt="" /><img v-else src="../../../assets/img/xinxitouxiang.png" />
				<p>登录账号：<span>{{userInfo.user_name}}</span></p>
				<p>绑定邮箱：<span>{{userInfo.email||'未绑定'}}</span></p>
				<p>绑定手机：<span v-if="userInfo.mobile">{{userInfo.mobile|phoneEncryption}}</span></p>
				<p>上次登录：<span>{{userInfo.last_logon_time|formatDate}} | IP地址：100.109.222.33</span>（不是您登录？请立即<a  @click="code">更改密码</a>）</p>
			</div>
			<div class="dengji">
				<span>安全等级</span><img src="../../../assets/img/dengji.jpg" /><span>中</span><span>您的帐号目前还存在一定的安全隐患</span>
			</div>
			<ul class="Ul">
				<li>
					<div class="l zuo common" >登录密码</div>
					<p class="l">已设置登录密码</p><span class="r lv" >修改密码</span></li>
				<li>
					<div class="l zuos common" :class="{zuo:emailzuo}">邮箱验证</div>
					<p class="l">绑定后，可用于账号登录，快速找回登录密码、支付密码，接收账户余额变动提醒等。</p><span :class="{greet:emailsucceed}" class="r red" @click="email" v-text="concent"></span></li>
				<li>
					<div class="l zuos common" :class="{zuo:phonezuo}">手机验证</div>
					<p class="l">您绑定的手机： <span>{{userInfo.mobile}}</span>，该手机可用于账号登录，快速找回登录密码、支付密码，接收账户余 额变动提醒等。</p><span :class="{greet:phonesucceed}" class="r lv" @click="hit" v-text="html"></span></li>
				<li>
					<div class="l zuos common" :class="{zuo:keyszuo}">支付验证</div>
					<p class="l">启用支付密码后，可保障您账户余额的支付安全,在使用账户资产时，需通过支付密码进行支付认证。</p><span class="r red" @click="pay" v-text="keys"></span></li>
			</ul>
		</div>
	
		<div v-show="Password">
			<Password v-on:Goback="GoBack"></Password>
		</div>
		<div v-show="bdemail">
			<bdemail v-on:Goback="Go_back" :userInfo="userInfo"></bdemail>
		</div>
		<div v-show="xgemail">
			<xgemail v-on:Goback="Go_Back"></xgemail>
		</div>
		<div v-show="xgphone">
			<xgphone v-on:Goback="go_Back"></xgphone>
		</div>
		<div v-show="bdphone">
			<bdphone v-on:Goback="go_back"></bdphone>
		</div>
		<div v-show='oppay'>
			<oppay v-on:Goback="back"></oppay>
		</div>
		<div v-show="xgpay">
			<xgpay v-on:Goback="Back"></xgpay>
		</div>
	</div>
</template>

<script>
	import Password from './child/password'
	import bdemail from './child/bdemail'
	import xgemail from './child/xgemail'
	import xgphone from './child/xgphone'
	import bdphone from './child/bdphone'
	import oppay from './child/oppay'
	import xgpay from './child/xgpay';
	export default {
		data() {
			return {
				userInfo: {},
				//账户安全
				j: true,
				html: '绑定手机',
				phonesucceed:false,
				phonezuo:false,
				keys: '开启支付密码',
				keyssucceed:false,
				keyszuo:false,
				concent: '绑定邮箱',
				emailsucceed:false,
				emailzuo:false,
				Password: false,
				bdemail: false,
				xgemail: false,
				xgphone: false,
				bdphone: false,
				oppay: false,
				xgpay: false
			}
		},
		created() {
			this.getInfo();
		},
		methods: {
			getInfo() {
				this.HTTP(this.$httpConfig.userSecurityDetails, {}, 'post')
					.then((res) => {
						this.userInfo = res.data;
						sessionStorage.setItem('userInfo',JSON.stringify(this.userInfo));
						if(res.data){
							this.concent = '修改邮箱';
							this.emailsucceed = true;
							this.emailzuo =true;
							this.html = '修改手机';
							this.phonesucceed = true;
							this.phonezuo = true;
						}
					})
					.catch((e)=>{})
			},
			//账户安全
			hit() {
				this.j = false
				if (this.html == '绑定手机') {
					//this.html = '修改手机'
					this.xgphone = false,
						this.bdphone = true
				} else if (this.html == '修改手机') {
					//this.html = '绑定手机',
						this.xgphone = true,
						this.bdphone = false
				}
			},
			pay() {
				this.j = false
				if (this.keys == '开启支付密码') {
					this.keys = '修改支付密码'
					this.oppay = true
					this.xgpay = false
				} else if (this.keys == '修改支付密码') {
					this.keys = '开启支付密码',
						this.oppay = false
					this.xgpay = true
				}
			},
			GoBack() {
				this.j = true,
					this.Password = false
			},
			code() {
				this.j = false,
					this.Password = true
			},
			Go_back() {
				this.bdemail = false,
					this.j = true
			},
			Go_Back() {
				this.xgemail = false,
					this.j = true
			},
			go_Back() {
				this.xgphone = false,
					this.j = true
			},
			go_back() {
				this.bdphone = false,
					this.j = true
			},
			back() {
				this.oppay = false,
					this.j = true
			},
			Back() {
				this.xgpay = false,
					this.j = true
			}, 
			email() {
				this.j = false
				if (this.concent == '绑定邮箱') {
					this.bdemail = true,
						this.xgemail = false
					//this.concent = "修改邮箱"
				} else if (this.concent == '修改邮箱') {
					this.bdemail = false,
						this.xgemail = true
					//this.concent = "绑定邮箱"
				}
			},
		},
		components: {
			'Password': Password,
			'bdemail': bdemail,
			'xgemail': xgemail,
			'xgphone': xgphone,
			'bdphone': bdphone,
			'oppay': oppay,
			'xgpay': xgpay
		},
	}
</script>

<style lang="less" scoped>
	.greet{
		background: #7abd54!important;
	}
	.redness{
		background: #e31939!important;
	 }
	.l {
		float: left;
	}
	
	.r {
		float: right;
	}
	
	.center {
		width: 1190px;
		margin: 0 auto;
		height: 100%;
	}
	
	.account {
		float: left;
		height: 954px;
		width: 990px;
		background: #fff;
		margin-top: 16px;
		.top {
			height: 37px;
			border-bottom: 1px solid #e7e7e7;
			margin: 14px 17px 0;
			li {
				width: 104px;
				text-align: center;
				line-height: 35px;
				border-bottom: 2px solid red;
				color: red;
			}
		}
		.head {
			height: 171px;
			img {
				float: left;
				margin: 29px 21px 0 45px;
				width: 100px;
				height: 100px;
			}
			p {
				float: left;
				width: 700px;
				line-height: 24px;
				font-size: 12px;
				color: #999;
				span {
					color: #484848;
				}
			}
			p:nth-of-type(1) {
				margin-top: 31px;
			}
		}
		.dengji {
			height: 46px;
			background: #fff2e1;
			margin: 0 25px 40px;
			line-height: 46px;
			;
			span {
				font-size: 12px;
				color: #a8a6a3;
				float: left
			}
			img {
				float: left;
				margin-top: 16px;
			}
			span:nth-of-type(1) {
				color: #333;
				margin: 0 11px 0 20px;
			}
			span:nth-of-type(2) {
				color: #ff3b36;
				margin: 0 25px;
			}
		}
		.Ul {
			overflow: hidden;
			border: 1px solid #e7e7e7;
			border-bottom: 0;
			margin: 0 25px 0;
			li {
				height: 103px;
				border-bottom: 1px solid #e7e7e7;
				.common {
					height: 44px;
					width: 183px;
					text-align: center;
					border-right: 1px solid #e7e7e7;
					margin: 30px 26px 0 12px;
					font-size: 14px;
					color: #333;
					line-height: 30px;
				}
				.zuo {
					background: url(../../../assets/img/duihao.png) no-repeat top 2px left 13px!important;
				}
				.zuos {
					background: url(../../../assets/img/jinggao.png) no-repeat top 2px left 13px;
				}
				p {
					font-size: 12px;
					color: #999;
					margin-top: 34px;
					width: 535px;
					line-height: 22px;
					span {
						color: #e31939;
					}
				}
				span.r {
					cursor: pointer;
					width: 80px;
					height: 30px;
					line-height: 30px;
					font-size: 12px;
					color: #fff;
					text-align: center;
					margin: 30px 38px 0 0;
					border-radius: 3px;
				}
				.lv {
					background: #7abd54;
				}
				.red {
					background: #e31939;
				}
			}
		}
	}
</style>