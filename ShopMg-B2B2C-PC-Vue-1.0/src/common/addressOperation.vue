<template>
	<div>
		<div class="dizhi">
			<p class="biaoti">选择收货地址</p>
			<ul class="dizhiul">
				<li class="l" @click="hit(index)" v-for="(sites,index) in addressList" :key="index" :class="{hover:sites.status == 1}">
					<p>{{sites.prov_name}}{{sites.city_name}} ({{sites.realname}}收)</p>
					<p>{{sites.prov_name}}{{sites.city_name}}{{sites.dist_name}}{{sites.address}} {{sites.mobile}}</p>
					<p><span @click.stop="modify(sites.id)">修改</span></p>
				</li>
			</ul>
			
			<p class="guanli"><button @click.stop="newly">使用新地址</button><button @click="managementAddress">管理收货地址</button></p>
		</div>
		<modal :backdrop-closable="false" title="新增收货地址" :width="625" :is-show="isopen" transition="fadeDown" @close="isopen=false" :show-footer="false">
			<div class="contents">
				<div>
					<p class="l"><span class="l">*</span>所在地址：</p>
					<p class="l">
						<selection-area v-if="isShow" :operateStyle="operateStyle" @subgradeTransmit="subgradeTransmit" :selectProvId="selectProvId" :selectCityId="selectCityId" :selectAreaId="selectAreaId"></selection-area>
					</p>
				</div>
				<div>
					<p class="l"><span class="l">*</span>详细地址：</p>
					<textarea v-model="addressInfo.address" class="l" placeholder="建议您如实填写详细收货地址，例如街道名称，门牌号码，楼层和房间号码等信息"></textarea>
				</div>
	
				<!-- <div>邮政编码：<input type="text" v-model="bank"/></div> -->
				<div><span>*</span>收货人姓名：<input type="text" v-model="addressInfo.realname" /></div>
				<div><span>*</span>手机号码：<input type="text" v-model="addressInfo.mobile" /></div>
				<!-- <div>电话号码：<input type="text" v-model="mobile"/></div> -->
				<p class="moren"><input type="checkbox" v-model="addressInfo.status" />设为默认收货地址</p>
				<p class="baocun" @click="protect">保存</p>
			</div>
		</modal>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				selectProvId: '请选择',
				selectCityId: '请选择',
				selectAreaId: '请选择',
				operateStyle: 1,
				isShow: false,
				operation: false,
				isopen: false,
				// bank:"",
				hello: "默认地址",
				iphone: "",
				addressList: [],
				//单条地址
				addressInfo: {
					address: '',
					realname: '',
					mobile: '',
					status: false
				},
			}
		},
		mounted() {
			this.getAddressList();
		},
		methods: {
			managementAddress() {
				window.open(window.location.origin + '/receive');
			},
			//修改获取单条地址数据
			modify(id) {
				this.isShow = true;
				this.addressInfo = {};
				this.isopen = true;
				this.operateStyle++;
				this.operation = true;
				this.HTTP(this.$httpConfig.addressInfo, {
						id: id
					}, 'post', false)
					.then((res) => {
						this.addressInfo = res.data.data;
						this.addressInfo.status = parseInt(this.addressInfo.status); //是否默认
						this.selectProvId = this.addressInfo.prov;
						this.selectCityId = this.addressInfo.city;
						this.selectAreaId = this.addressInfo.dist;
	
					})
			},
			subgradeTransmit(val) {
				if (val.sign == 'city') {
					this.selectProvId = val.addressId;
				} else if (val.sign == 'area') {
					this.selectCityId = val.addressId;
				} else {
					this.selectAreaId = val.addressId;
				}
			},
			getAddressList() {
				this.HTTP(this.$httpConfig.addressLists, {}, 'post', false)
					.then((res) => {
						this.addressList = res.data.data;
						if (this.addressList.length === 0) {
							this.isShow = true;
							this.isopen = true;
						}
						for (let index = 0; index < this.addressList.length; index++) {
							if (this.addressList[index].status === '1') {
								this.$emit('transferAddress', this.addressList[index]);
							}
						}
					})
			},
			hit(index) {
				for (let i = 0; i < this.addressList.length; i++) {
					this.addressList[i].status = 0;
				}
				this.addressList[index].status = 1;
				this.$emit('transferAddress', this.addressList[index]);
			},
			//初始化数据
			initData() {
				this.addressInfo = {
					address: '',
					realname: '',
					mobile: '',
					status: false
				}
				this.operateStyle = 1;
				this.selectProvId = '请选择';
				this.selectCityId = '请选择';
				this.selectAreaId = '请选择';
			},
			protect() {
				let defaultAddress = '';
				if (this.selectCityId == '请选择' || this.selectAreaId == '请选择') {
					this.$message({
						message: "请选择地区",
						duration: 1500
					})
					return false;
				}
				if (this.addressInfo.address == "") {
					this.$message({
						message: "请填写地址",
						duration: 1500
					})
					return false;
				}
				// if(this.bank.length !== 6) {
				// 	this.$message({
				// 		message: "请填写正确的编码"
				// 	})
				// }
				if (this.addressInfo.realname.length < 2) {
					this.$message({
						message: "请填写正确的收货人姓名",
						duration: 1500
					})
					return false;
				}
				if (!(/^1[345789]\d{9}$/.test(this.addressInfo.mobile))) {
					this.$message({
						message: "请填写正确的手机号",
						duration: 1500
					})
					return false;
				}
				if (this.addressInfo.status == false) {
					defaultAddress = 0;
				} else {
					defaultAddress = 1;
				}
				if (this.operation == false) {
					this.HTTP(this.$httpConfig.addAddress, {
							realname: this.addressInfo.realname,
							mobile: this.addressInfo.mobile,
							prov: this.selectProvId,
							city: this.selectCityId,
							dist: this.selectAreaId,
							address: this.addressInfo.address,
							status: defaultAddress
						}, 'post')
						.then((res) => {
							this.isopen = false;
							this.initData();
							this.getAddressList();
						})
				} else {
					this.HTTP(this.$httpConfig.editAddress, {
							id: this.addressInfo.id,
							realname: this.addressInfo.realname,
							mobile: this.addressInfo.mobile,
							prov: this.selectProvId,
							city: this.selectCityId,
							dist: this.selectAreaId,
							address: this.addressInfo.address,
							status: defaultAddress
						}, 'post')
						.then((res) => {
							this.isopen = false;
							this.operation = false;
							this.initData();
							this.getAddressList();
						})
				}
			},
			newly() {
				this.isShow = true;
				this.isopen = !this.isopen;
				this.initData();
			},
		},
	}
</script>

<style lang="less" scoped>
	.l {
		float: left;
	}
	
	.r {
		float: right;
	}
	
	.dizhi {
		overflow: hidden;
		.biaoti {
			font-size: 14px;
			margin: 18px 0 20px;
			width: 100%;
		}
		.dizhiul {
			overflow: hidden;
			li {
				width: 279px;
				height: 123px;
				border: 1px solid #dedede;
				margin-right: 25px;
				cursor: pointer;
				margin-bottom: 10px;
				p {
					font-size: 12px;
					color: #333;
					padding-left: 13px;
					padding-right: 13px;
				}
				p:nth-of-type(1) {
					line-height: 38px;
					border-bottom: 1px solid #dedede;
				}
				p:nth-of-type(2) {
					margin: 16px 0 10px;
					height: 34px;
				}
				p:nth-of-type(3) {
					color: gray;
				}
			}
			.hover {
				border-color: red !important;
				background: url(../assets/img/bg.jpg) no-repeat right 0 bottom 0;
			}
			li:nth-child(4n) {
				margin-right: 0;
			}
		}
		.guanli {
			overflow: hidden;
			margin: 15px 0 12px 0;
			button {
				width: 84px;
				height: 25px;
				text-align: center;
				line-height: 25px;
				float: left;
				font-size: 12px;
				cursor: pointer;
			}
			button:nth-of-type(1) {
				background: red;
				color: #fff;
				margin-right: 18px;
			}
			button:nth-of-type(2) {
				width: 84px;
				height: 25px;
				border: 1px solid #dedede;
				color: #333;
			}
		}
	}
	
	.contents {
		margin: 20px 0 143px 0;
		div {
			text-align: left;
			font-size: 12px;
			overflow: hidden;
			span {
				color: #ff2626;
			}
		}
		div:nth-of-type(1) {
			p {
				font-size: 12px;
			}
			select {
				width: 90px;
				height: 24px !important;
				outline: none;
				float: left;
			}
			p:nth-of-type(2) {
				height: 24px;
				.behind {
					width: 364px;
					height: 24px;
					padding-left: 13px;
					height: 22px;
				}
				i {
					float: right;
					margin: 4px 10px 0 0;
				}
			}
		}
		div:nth-of-type(2) {
			margin-top: 15px;
			p {
				font-size: 12px;
			}
			textarea {
				width: 463px;
				height: 85px;
				padding: 10px 0 0 10px;
				border: 1px solid #ccc;
			}
		}
		// div:nth-of-type(3){padding-left:5px;
		// 	margin-top: 15px;input{width:281px;height:24px;border:1px solid #ccc;}
		// }
		div:nth-of-type(3) {
			margin-left: -11px;
			margin-top: 15px;
			input {
				width: 281px;
				height: 24px;
				border: 1px solid #ccc;
				padding-left: 5px;
			}
		}
		div:nth-of-type(4) {
			margin-top: 15px;
			input {
				width: 281px;
				height: 24px;
				border: 1px solid #ccc;
				padding-left: 5px;
			}
		}
		// div:nth-of-type(6){padding-left:5px;
		// 	margin-top: 15px;input{width:281px;height:24px;border:1px solid #ccc;}
		// }
		.moren {
			margin-top: 21px;
			font-size: 12px;
			margin-left: 64px;
			input {
				margin: 2px 8px 0 0;
				float: left;
			}
		}
		.baocun {
			cursor: pointer;
			font-size: 12px;
			margin-left: 64px;
			height: 32px;
			width: 72px;
			border-radius: 3px;
			background: #ff6000;
			text-align: center;
			line-height: 32px;
			color: #fff;
			margin-top: 15px;
		}
	}
</style>