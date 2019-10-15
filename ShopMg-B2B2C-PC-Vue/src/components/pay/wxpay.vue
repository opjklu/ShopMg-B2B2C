<template>
	<div class="pay">
		<div class="center">
			<div class="header">
				<img class="l" src="../../assets/img/weixinzhifu.jpg" />
				<p class="l">我的收银台</p>
			</div>
			<div class="middle">
				<p><span class="dindan">订单号：{{order_sn}}</span><span class="r">应付金额<span class="hong">{{$route.params.total_price|keep2Num}}</span>元</span>
				</p>
				<p>请您在提交订单后{{minutes}}分{{seconds}}秒内完成支付。否则将自动回到相应操作页</p>
			</div>
			<div class="bottom">
				<p class="money">扫一扫付款（元）<br /> <span>{{$route.params.total_price|keep2Num}}</span></p>
				<div class="saoma l">
					<div class="qrcode" id="qrcode"></div>
					<img class="sao" src="../../assets/img/saoyisao.jpg" alt="" />
					<p class="phone">打开手机微信<br />扫一扫继续付款</p>
				</div>
				<img class="r" src="../../assets/img/iphone.jpg" />
			</div>
		</div>
		<foot-com></foot-com>
	</div>
</template>

<script>
	import QRCode from 'qrcodejs2';
	export default {
		data() {
			return {
				order_sn: '',
				clear_time: null,
				clear_time1: null,
				minutes: 0,
				seconds: 0,
				paySuccess:{
					'z':'/myOrder', //普通商品支付成功
					'c':'/myAccount', //余额充值成功
					'r':'/progressLook', //开店支付成功
					't':'/packageOrder' //套餐商品支付成功
				}
			}
		},
		beforeRouteLeave(to, from, next) {
			clearInterval(this.clear_time);
			clearInterval(this.clear_time1);
			next();
		},
		created() {
			this.countDown();
		},
		mounted() {
			if (this.$route.params.state === 'z') {
				this.getPaymentCode(this.$httpConfig.initiatePayment); //普通商品支付
			} else if (this.$route.params.state === 'c') {
				if (sessionStorage.getItem('payData')) { //余额充值
					let payData = JSON.parse(sessionStorage.getItem('payData'));
					this.order_sn = payData.order_sn;
					this.qrcode(payData.code_url);
					this.pollingQuery(payData);
				} else {
					alert('支付信息出错,请重新充值');
				}
			} else if(this.$route.params.state === 'r') {
				this.getPaymentCode(this.$httpConfig.openShopPay); //开店支付
			} else if(this.$route.params.state === 'q'){
				this.getPaymentCode(this.$httpConfig.getinitiatePayment);// 抢购支付
			} else{
				this.getPaymentCode(this.$httpConfig.packagePay); //套餐支付
			}
		},
		methods: {
			countDown() {
				let maxTime = 2 * 60;
				this.clear_time1 = setInterval(() => {
					if (maxTime >= 0) {
						this.minutes = Math.floor(maxTime / 60);
						this.seconds = Math.floor(maxTime % 60);
						--maxTime;
					} else {
						clearInterval(this.clear_time1);
						if (this.$route.params.state === 'z') {
							this.$router.push('/myOrder');
						} else if (this.$route.params.state === 'c') {
							this.$router.push('/recharge');
						} else if (this.$route.params.state === 'r'){
							this.$router.push('/progressLook');
						}else{
							this.$router.push('/packageOrder');
						}
					}
				}, 1000)
			},
			getPaymentCode(url) {
				this.HTTP(url, {
					pay_type_id: this.$route.params.id
				}, 'post').then((res) => {
					this.order_sn = res.data.order_sn;
					this.qrcode(res.data.code_url);
					this.pollingQuery(res.data);
				}).catch(() => {
	
				})
			},
			//查询是否支付完成
			pollingQuery(res) {
				this.clear_time = setInterval(() => {
					this.isCheckPay(res);
				}, 1500)
			},
			isCheckPay(res) {
				this.HTTP(res.callback_url, {
					order_id: res.order_id
				}, 'post').then((res) => {
					clearInterval(this.clear_time);
					let routerName = this.paySuccess[this.$route.params.state];
					this.$router.push({
						path:'/wxSuccess',
						query:{
							link:routerName
						}
					})
				}).catch(() => {

				})
			},
			qrcode(url) {
				let qrcode = new QRCode('qrcode', {
					width: 165,
					height: 165, // 高度
					text: url // 二维码内容
					// render: 'canvas' // 设置渲染方式（有两种方式 table和canvas，默认是canvas）
					// background: '#f0f'
					// foreground: '#ff0'
				})
			},
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
	
	.center {
		width: 1200px;
		margin: 0 auto;
		height: 100%;
		background: #fff;
	}
	
	.pay {
		background: #f6f5f5;
		.header {
			height: 109px;
			border-bottom: 1px solid #f6f5f5;
			img {
				margin: 37px 0 0 20px;
			}
			p {
				line-height: 30px;
				border-left: 1px solid #cdcfd0;
				font-size: 18px;
				color: #555;
				margin: 45px 0 0 20px;
				padding-left: 17px;
			}
		}
		.middle {
			height: 115px;
			border-bottom: 1px solid #f6f5f5;
			p {
				float: left;
				font-size: 12px;
				margin-left: 35px;
				width: 100%;
			}
			p:nth-of-type(1) {
				color: #333;
				margin-top: 41px;
				font-weight: 600;
				.dindan {
					font-weight: 500;
				}
				span.r {
					font-weight: 500;
					margin-right: 42px;
					.hong {
						color: #d32026;
						font-size: 17px;
						margin: 0 11px;
					}
				}
			}
		}
		.bottom {
			overflow: hidden;
			height: 484px;
			.money {
				line-height: 30px;
				font-size: 12px;
				color: #333;
				margin: 52px 0 0 418px;
				span {
					font-size: 24px;
					color: #d32026;
					font-weight: 700;
				}
			}
			.saoma {
				height: 232px;
				width: 180px;
				border: 1px solid #d3d3d3;
				margin: 11px 0 0 372px;
				.sao {
					margin: 10px 10px 0 26px;
					float: left;
				}
				.phone {
					float: left;
					font-size: 12px;
					margin-top: 6px;
				}
				.qrcode {
					width: 165px;
					margin: 6px;
					min-height: 165px;
				}
			}
			img.r {
				margin-right: 360px;
				margin-top: -36px;
			}
		}
	}
</style>