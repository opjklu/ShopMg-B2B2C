<template>
	<div class="only">
		<ul class="ul">
			<li>修改手机验证</li>
		</ul>
		<img v-show="img" class="logo" src="../../../../assets/img/buzhou1.png" />
		<img v-show="imgs" class="logo" src="../../../../assets/img/buzhou2.png" />
		<img v-show="imgss" class="logo" src="../../../../assets/img/buzhou3.png" />
		<ul>
			<li class="l" :class="{colour:isok}">验证身份</li>
			<li :class="{colour:isoks}" class="l">修改已验证手机</li>
			<li :class="{colour:isokss}" class="l">完成</li>
		</ul>
		<div v-show="first">
			<p class="shouji">已绑定的手机：<span v-if="userInfo.mobile">{{userInfo.mobile | phoneEncryption}}</span></p>
			<p class="yanzhengma"><span>*</span>验证码：<input type="text" v-model="phoneverify"/><span></span><img :src="refresh" @click="getrefresh" /></p>
			<p class="dongtai"><span>*</span><span>手机动态验证码：</span><input class="l" type="text" v-model="phoneverify1" /><span class="l" :class="{active:isActive}" @click="abtain">{{btnText}}</span></p>
			<button @click="next">下一步</button>
		</div>
		<div v-show="second">
			<p class="new"><span>*</span>新手机号码：<input type="text" v-model="newphone"/></p>
			<p class="yanzhengma"><span>*</span>验证码：<input type="text" v-model="newphone1"/><span></span><img :src="refresh" @click="getrefresh" /></p>
			<p class="dongtai"><span>*</span><span>手机动态验证码：</span><input class="l" type="text" v-model="newphone2"/><span class="l" :class="{active:isActive}" @click="abtains">{{btnTexts}}</span></p>
			<button @click="last">下一步</button>
		</div>
		<div v-show="third" class="samll">
			<img class="duihao" src="../../../../assets/img/bigduihao.png" />
			<p class=" success">恭喜您！修改手机成功！</p>
			<p class=" bangding">您绑定的手机号码：<span>18570623665</span></p>
			<p class="goback" @click="goback">返回账户安全中心>></p>
		</div>
	</div>
</template>

<script>
	import refresh from '../../../../common/refreshVerificationCode.js';
	export default {
		data() {
			return {
				//手机验证
				phoneverify:null,
				phoneverify1:null,
				newphone:null,
				newphone1:null,
				newphone2:null,
				//账户安全
				img: true,
				imgs: false,
				imgss: false,
				first: true,
				second: false,
				third: false,
				isok: true,
				isoks: false,
				isokss: false,
				btnText: "获取验证码",
				btnTexts:"获取验证码",
				isActive: "",
				//mobile: '',
				userInfo:{},
				refresh:null,
			}
		},
		created(){
			this.userInfo=JSON.parse(sessionStorage.getItem('userInfo'));
			console.log(this.userInfo,'手机');
			this.refresh =refresh.refreshVerificationCode();
		},
		mounted() {
			// this.HTTP(this.$httpConfig.userinfo,{
			// 	id: this.class_id
			// },'get')
			// .then((res) =>{
			// 	this.mobile=res.data.mobile
			// })
		},
		methods: {
			//切换图形验证码
			getrefresh(){
				this.refresh =refresh.refreshVerificationCode();
			},
			abtain() {
				if (this.isActive == true) return;


				var N = 60,
					_this = this,
					clear = null;
				_this.isActive = true;
				_this.btnText = '请' + N + '秒后重试';
				_this.isActive = true;
				clear = setInterval(function() {
					_this.btnText = '请' + N-- + '秒后重试';
					if (N < 0) {
						clearInterval(clear);
						_this.btnText = '获取验证码';
						_this.isActive = false;
					}
				}, 1000);
				this.HTTP(this.$httpConfig.sendPhoneNumberByEditPhone, {
						mobile: this.userInfo.mobile
					}, 'post')
					.then((res) => {
						// this.$message({
						// 	message: res.data.test_code,
						// 	type: 'success',
						// });
						if (res.status == 1) {
							this.token = res.data.token
						} else {
							clearInterval(clear);
							_this.btnText = '再次获取验证码';
							_this.isActive = false;
						}
					}).catch((e)=>{
						console.log(e)
					})
			},
			abtains() {
				if (this.isActive == true) return;
				var N = 60,
					_this = this,
					clear = null;
				_this.isActive = true;
				_this.btnTexts = '请' + N + '秒后重试';
				_this.isActive = true;
				clear = setInterval(function() {
					_this.btnTexts = '请' + N-- + '秒后重试';
					if (N < 0) {
						clearInterval(clear);
						_this.btnTexts = '获取验证码';
						_this.isActive = false;
					}
				}, 1000);
				if(this.newphone!=null){
					this.HTTP(this.$httpConfig.sendPhoneNumberByEditPhone, {
						mobile: this.newphone
					}, 'post')
					.then((res) => {
						if (res.status == 1) {
							this.token = res.data.token
						} else {
							clearInterval(clear);
							_this.btnText = '再次获取验证码';
							_this.isActive = false;
						}
					}).catch((e)=>{
						console.log(e)
					})
				}
				
			},
			next() {
				if (this.phoneverify!=null&&this.phoneverify1!=null) {
					//验证身份
					this.HTTP(this.$httpConfig.shortMessageVerification,
					{
						phone_code:this.phoneverify1,
						mobile:this.userInfo.mobile,
						vertify:this.phoneverify
					},'post').then((res)=>{
						if (res.message=='成功') {
							this.first = false,
							this.second = true
							this.img = false,
							this.imgs = true,
							this.isoks = true,
							//恢复'获取验证码',刷新
							this.btnText='获取验证码',
							this.isActive=true,
							this.getrefresh();
						} else {
								this.$confirm('验证码错误或过期', '提示', {
									confirmButtonText: '确定',
									cancelButtonText: '取消',
									type: 'warning',
									closeOnClickModal: false,
									lockScroll: false,
									center: true
								}).then(() => {
								}).catch(() => {
								});
						}
						console.log(res,'手机短信')
					}).catch((e)=>{
						console.log(e)
						this.$confirm('验证码错误或过期', '提示', {
							confirmButtonText: '确定',
							cancelButtonText: '取消',
							type: 'warning',
							closeOnClickModal: false,
							lockScroll: false,
							center: true
						}).then(() => {
						}).catch(() => {
						});
					})
				} else {
					this.$confirm('验证码不能为空', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning',
            closeOnClickModal: false,
            lockScroll: false,
            center: true
          }).then(() => {
          }).catch(() => {
          });
				}
				
			},
			last() {
				//修改手机号
				if (this.newphone!=null&&this.newphone1!=null&&this.newphone2) {
					this.HTTP(this.$httpConfig.modifyIphone,{
						mobile:this.newphone,//手机号
						vertify:this.newphone1,//图形验证码
						phone_code:this.newphone2//短信验证码
					}).then((res)=>{
						console.log(res)
						if (res.message=='成功') {
							this.third = true
							this.second = false
							this.imgs = false,
							this.imgss = true,
							this.isokss = true
						}
					}).catch((e)=>{
						console.log(e)
						this.$confirm(`${e.data.message}`, '提示', {
							confirmButtonText: '确定',
							cancelButtonText: '取消',
							type: 'warning',
							closeOnClickModal: false,
							lockScroll: false,
							center: true
						}).then(() => {
						}).catch(() => {
						});
					})
				} else {
					this.$confirm('新手机号或验证码不能为空', '提示', {
						confirmButtonText: '确定',
						cancelButtonText: '取消',
						type: 'warning',
						closeOnClickModal: false,
						lockScroll: false,
						center: true
					}).then(() => {
					}).catch(() => {
					});
				}
					
			},
	
			goback() {
				this.third = false
				this.first = true,
					this.second = false
				this.img = true,
					this.imgs = false,
					this.imgss = false,
					this.isok = true,
					this.isoks = false,
					this.isokss = false,
					this.$emit('Goback')
			}
	
		}
	}
</script>

<style lang="less" scoped>
	.l {
		float: left;
	}
	
	.r {
		float: right;
	}
	
	.only {
		.ul {
			overflow: hidden;
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
		img.logo {
			margin: 59px 79px 0;
		}
		ul {
			overflow: hidden;
			margin: 13px 0 64px 79px;
			li {
				width: 241px;
				text-align: center;
				color: #ccc;
				font-size: 14px;
			}
		}
		.colour {
			color: #afd129;
		}
		p {
			font-size: 12px;
			color: #333;
		}
		p.shouji {
			margin: 25px 0 0 212px;
			span {
				color: #999;
			}
		}
		p.yanzhengma {
			margin: 25px 0 0 230px;
			span:nth-of-type(1) {
				color: #ff3f3f;
				margin-right: 13px;
			}
			input {
				width: 180px;
				height: 38px;
				border: 1px solid #ccc;
				border-radius: 3px;
				margin-right: 15px;
			}
		}
		p.new {
			margin: 53px 0 0 205px;
			span {
				color: #ff3f3f;
				margin-right: 13px;
			}
			input {
				width: 280px;
				height: 38px;
				border: 1px solid #ccc;
				border-radius: 3px;
			}
		}
		p.dongtai {
			margin: 21px 0 0 182px;
			overflow: hidden;
			line-height: 38px;
			span {
				float: left;
			}
			span:nth-of-type(1) {
				color: #ff3f3f;
				margin-right: 13px;
			}
			input {
				width: 110px;
				height: 38px;
				border: 1px solid #ccc;
				border-radius: 3px;
			}
			span:nth-of-type(3) {
				cursor: pointer;
				width: 136px;
				height: 38px;
				border: 1px solid #d9d9d9;
				background: #f6f6f6;
				display: inline-block;
				text-align: center;
				line-height: 38px;
				margin: 0 0 0 12px;
			}
			.active {
				cursor: pointer;
				width: 136px;
				height: 38px;
				border: 1px solid #d9d9d9;
				background: #f6f6f6;
				display: inline-block;
				text-align: center;
				line-height: 38px;
				margin: 0 0 0 12px;
			}
		}
		button {
			cursor: pointer;
			border-radius: 3px;
			width: 110px;
			height: 38px;
			background: #afd129;
			text-align: center;
			line-height: 38px;
			color: #fff;
			font-size: 12px;
			margin: 30px 0 0 296px;
		}
		.samll {
			position: relative;
		}
		.duihao {
			position: absolute;
			top: -13px;
			left: 292px;
		}
		.success {
			font-size: 18px;
			color: #afd129;
			margin: 85px 0 0 375px;
		}
		.bangding {
			font-size: 12px;
			color: #666;
			margin: 19px 0 0 375px;
			span {
				color: #ff0000;
			}
		}
		.goback {
			font-size: 12px;
			color: #ff0000;
			margin: 39px 0 0 375px;
			cursor: pointer;
		}
		.numbers {
			margin: 51px 0 0 194px;
			display: block;
			span {
				color: #ff3f3f;
				margin-right: 13px;
			}
			input {
				width: 280px;
				height: 38px;
				border: 1px solid #ccc;
				border-radius: 3px;
			}
		}
		.dangqian {
			margin: 70px 0 0 152px;
			span {
				color: #438ed1;
			}
		}
		.slet {
			margin: 0 0 26px 148px;
			span {
				color: #ff3f3f;
				margin-right: 13px;
			}
			select {
				padding: 10px;
				width: 120px;
				height: 38px;
				border: 1px solid #ccc;
				font-size: 12px;
				color: #ccc;
				border-radius: 3px;
				outline: none;
			}
		}
		.name {
			margin: 0 0 0 240px;
			span {
				color: #ccc;
			}
		}
		.denglu {
			margin: 24px 0 0 215px;
			span {
				color: #ff3f3f;
				margin-right: 13px;
			}
			input {
				width: 280px;
				height: 38px;
				border: 1px solid #ccc;
				border-radius: 3px;
			}
		}
		.pass {
			margin: 0 0 0 230px;
			span {
				color: #ff3f3f;
				margin-right: 13px;
			}
			input {
				width: 260px;
				height: 38px;
				border: 1px solid #ccc;
				border-radius: 3px;
			}
			span:nth-of-type(2) {
				color: #fa4862;
				margin-left: 13px;
				img {
					margin-right: 11px;
				}
			}
		}
		.newAddress {
			margin-left: 194px !important;
		}
	}
</style>