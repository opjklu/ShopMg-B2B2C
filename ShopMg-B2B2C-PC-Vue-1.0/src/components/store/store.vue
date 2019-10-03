<template>
	<div class="store">
		<head-com></head-com>
		<div class="center">
			<div class="top">
				<img src="../../assets/img/fangzi.jpg" />
				<span><router-link class="to-link" to="home">首页</router-link></span>
				<span>></span>
				<span class="pingpai"><router-link :to="{path:'/store',query:{currentId:3}}">店铺</router-link></span>
			</div>
			<div class="middle">
				<p>分类</p>
				<div class="place-list">
					<span class="t l">区域地点：</span>
					<div class="region l" :class="{active:onoff}">
						<ul class="l" ref="regionHeight">
							<li @click="regionalSelection(index, item)" class="text1-hidden" :class="{selected:selectArr[index]}" v-for="(item,index) in  areaList" :key="item.id">{{item.name}}</li>
						</ul>
						<i @click="open(1)" v-if="show" :class="{'el-icon-arrow-up':onoff}" class="el-icon-arrow-down cut_z"></i>
					</div>
				</div>
				<div class="place-list">
					<span class="t l">店铺分类：</span>
					<div class="region l" :class="{active:onoff1}">
						<ul class="l" ref="classHeight">
							<li @click="shopsSelection(index, item)" class="text1-hidden" :class="{selected:selectArrTwo[index]}" v-for="(item,index) in goodsClass" :key="item.id">{{item.sc_name}}</li>
						</ul>
						<i @click="open(2)" v-if="show1" :class="{'el-icon-arrow-up':onoff1}" class="el-icon-arrow-down cut_z"></i>
					</div>
				</div>
			</div>
			<ul class="tab">
				<li class="l li" v-for="(order, index) in orderBy" :key="index" @click="tab(index, order)" :class="{actives:isactive == index}">{{order.name}}
					<span class="icon" v-if="order.key">
							<em class="top" :class="{active: searchParam[order.key] === 1}"></em><br>
							<em class="bottom" :class="{active: searchParam[order.key] === 0}"></em>
						</span>
				</li>

			</ul>
			<div class="bottom">
				<div class="unit" v-for="(store,index) in shopList" :key="index">
					<div class="left l">
						<img @click="toStore(store.id)" class="l logo" :src="URL + store.store_logo" />
						<div class="name l">
							<p @click="toStore(store.id)">{{store.shop_name}}</p>
							<p class="l">
								<span class="huise l">区域：{{store.prov_name}} - {{store.city_name}} - {{store.dist_name}}  </span>
							</p><br />
							<p class="l">
								<span class="huise l">主营：</span>
								<ul class="l">
									<li class="lanse" >{{store.sc_name}}</li>
								</ul>
							</p><br />
							<div class="btn l"><span class="button" @click="toStore(store.id)">进入店铺</span><span class="button">联系我们</span></div>
						</div>
						<div class="l shuliang">
							<p class="l">商品数量<span class="huangse">{{store.good_number}}</span>件</p>
							<p class="l">最近成交<span class="huangse">{{store.store_sales}}</span>笔</p>
						</div>
						<img @mouseover="getStar(store.id,index)" @mouseout="Hit" class="l store" src="../../assets/img/store.jpg" />
					</div>
					<div class="right l">
						<ul>
							<li class="l" v-if="goods.store_id === store.id "  v-for="(goods, index) in 	goodsList " :key="index" @click="toDetail(goods.id)" >
								<img class="l goods-img" :src="URL + goods.pic_url" />
								<p class="l">{{goods.title}}</p>
								<span class="l">￥{{goods.goods_price}}</span>
							</li>
						</ul>
					</div>
					<div class="pingjia" v-show="over==index">
						<p>店铺动态评分</p>
						<p>描述相符：<span>{{starInfo.deliverycredit || '0.0'}}</span></p>
						<p>服务态度：<span>{{starInfo.desccredit || '0.0'}}</span></p>
						<p>物流速度：<span>{{starInfo.servicecredit || '0.0'}}</span></p>
						<img src="../../assets/img/jaintou.jpg" />
					</div>
				</div>
			</div>
			<div class="paging">
				<div class="paging_r">
					<el-pagination background layout="total,prev, pager, next,jumper" @current-change="handleCurrentChange" :page-size="page_size" :total="page">
					</el-pagination>
				</div>
			</div>
		</div>
		<foot-com></foot-com>
	</div>
</template>

<script>
	import {getArea} from "../../.././es6/area.js"
	import {MapTool} from "../../.././es6/tool.js"
	export default {
		data() {
			return {
				selectArr: [false],
				selectArrTwo: [false],
				over: -1,
				sales_status: '',
				credit_status: '',
				goodsClass: '',
				page: 0, //共多少条
				currentPage: 1, //当前页
				page_size: 10, //每页显示多少条数据
				shopList: '',
				isactive: 0,
				onoff: false,
				onoff1: false,
				goodsList: [],
				// 评分信息
				starInfo: {
	
				},
				show: false,
				show1: false,
				areaList: [],
				// 搜索参数
				searchParam: {
					prov_id: undefined, //选中区域的id
					class_id:  undefined, //选中店铺分类id
					store_sales: 0, // 销量
					credibility: 0,  // 信誉
					page: 1,  //分页
				},
				orderBy: [
					{name: '默认',  key: ''},
					{name: '销量',  key: 'store_sales'},
					{name: '信誉',  key: 'credibility'},
				]
			}
		},
		mounted() {
			this.show = this.$refs.regionHeight.clientHeight > 42 ? true : false;
			this.show1 = this.$refs.classHeight.clientHeight > 42 ? true : false;
			getArea(this, 0);
		},
		created() {
			this.getStoreListNoSuch();
			this.getStoreClass();
		},
		methods: {
			toDetail (id) {
				window.open(window.location.origin + '/inroyaldrink?id=' + id)
			},
			toStore(id) {
				sessionStorage.setItem('store_id',id);
				window.open(window.location.origin + '/storehome?id=' + id)
			},
			//地区选择
			regionalSelection(index, item) {
				this.regionalShopsId(index, this.selectArr );

				this.searchParam.prov_id = item.id;

				this.getStoreList();
			},
			//店铺分类选择
			shopsSelection(index, item) {
				this.regionalShopsId(index, this.selectArrTwo);

				this.searchParam.class_id = item.id;

				this.getStoreList();
			},
			regionalShopsId(index, status ) {
				for (let i in status) {
					if (status[index] == status[i]) {
						break;
					} else {
						status[i] = false;
						status.splice(i, 1);
					}
				}
				if (status[index] == true) {
					this.$set(status, index, false);
				} else {
					this.$set(status, index, true);
				}
			},
			/*页面跳转*/
			handleCurrentChange(currentPage) {
				console.log(currentPage);
				this.currentPage = currentPage;
				this.getStoreList();storeAreaList
			},
			//店铺分类
			getStoreClass() {
				this.HTTP(this.$httpConfig.ShopGoodClass, {}, 'post')
					.then((res) => {
						this.goodsClass = res.data.data;
					}).catch((e)=>{
						this.goodsClass = [];
					})
			},
			//店铺列表
			getStoreList () {

				MapTool.deleteEmptyValue(this.searchParam);

				this.HTTP(this.$httpConfig.getStoreListBySearch, this.searchParam, 'post')
					.then((res) => {
						this.shopList = res.data.data.data;
						this.goodsList = res.data.data.goods;
					
						this.page = Number(res.data.data.count);
						this.page_size = res.data.data.page_size;


					}) .catch((error) => {
						this.shopList = [];
						this.page = 1,
						this.page_size = 0;
						this.goodsList = [];
					});
			},

			/**
			 * 获取地区
			 */

			/**
			 * 店铺列表无搜索
			 */
			getStoreListNoSuch() {
				this.HTTP(this.$httpConfig.getStoreList, {
						page: this.currentPage
					}, 'post')
					.then((res) => {
						this.shopList = res.data.data.data;
						this.goodsList = res.data.data.goods;
						this.page = Number(res.data.data.count);
						this.page_size = res.data.data.page_size;
	

					}).catch((e)=>{
						this.shopList = [];
						this.page = 1,
						this.page_size = 0;
						this.goodsList = [];
					})
			},

			open(s) {
				if (s == 1) {
					this.onoff = !this.onoff;
				} else {
					this.onoff1 = !this.onoff1;
				}
	
			},
			tab(index, order) {


				this.isactive = index;

				if (order.key) {
					this.searchParam[order.key]  = Number(!this.searchParam[order.key]);
				} else {
					this.searchParam.store_sales = 0;
					this.searchParam.credibility = 0;
				}
				this.getStoreList();
			},

			Hit() {
				this.over = null
			},
			/**获取动态评分 */
			getStar(id, index) {
				this.over = index
				this.HTTP(this.$httpConfig.getStar, {
					store_id: id
				}, 'post').then((res) => {
					this.starInfo = res.data.data;
				})
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
	
	.center {
		width: 1200px;
		margin: 0 auto;
		height: 100%;
	}
	
	.store {
		.top {
			font-size: 12px;
			height: 35px;
			line-height: 35px;
			.to-link {
				transition: color .2s cubic-bezier(.645, .045, .355, 1);
			}
			.to-link:hover {
				color: #303133;
				transition: color .2s cubic-bezier(.645, .045, .355, 1);
			}
			img {
				margin: 12px 8px 0 0;
				float: left;
			}
			span:last-child {
				a {
					color: #616161 !important;
				}
			}
			span {
				color: #a7a7a7;
				a {
					color: #a7a7a7;
				}
			}
		}
		.middle {
			/*height:174px;*/
			overflow: hidden;
			border: 1px solid #e5e5e5;
			p {
				line-height: 36px;
				background: #f4f4f4;
				padding-left: 14px;
			}
			.place-list {
				overflow: hidden;
				position: relative;
				padding-bottom: 10px;
				border-bottom: 1px dashed #f5f5f5;
				.t {
					padding-left: 25px;
					color: #b5b5b5;
					width: 96px;
					font-size: 12px;
					line-height: 41px;
				}
				.region {
					width: 90%;
					height: 42px;
					overflow: hidden;
					position: relative;
					ul {
						li {
							width: 96px;
							line-height: 41px;
							float: left;
							font-size: 12px;
							cursor: pointer;
							&:hover {
								color: red;
							}
						}
						li.selected {
							color: #b39654;
						}
					}
					i {
						position: absolute;
						top: 14px;
						right: 6px;
						cursor: pointer;
					}
					i:hover {
						color: red;
					}
				}
				.region.active {
					height: auto;
				}
			}
			.place-list:last-child {
				border-bottom: 1px dashed none;
			}
		}
		.tab {
			margin-top: 18px;
			width: 100%;
			height: 40px;
			background: #fafafa;
			border: 1px solid #e4e4e4;
			// .active{background: #fff url(../../assets/img/Xiajiantou1.png) no-repeat top 17px right 12px !important;-webkit-transform: translateY(1px);color: #ddbf69;height: 38px;}
			.actives {
				background: #fff;
				transform: translateY(1px);
				color: #ddbf69;
				height: 38px;
			}
			li {
				width: 69px;
				height: 39px;
				line-height: 40px;
				text-align: center;
				position: relative;
				border-right: 1px solid #d8d8d8;
				font-size: 12px;
				cursor: pointer;
				.icon {
					position: absolute;
					left: 1.6rem;
					top: 0;
					height: 100%;
					.top {
						position: absolute;
						left: 25px;
						top: 11px;
						width: 10px;
						height: 10px;
						background: url(../../assets/img/sort-top.png);
						background-size: 100% 100%;
					}
					.top.active {
						background: url(../../assets/img/sort-top-active.png);
						background-size: 100% 100%;
					}
					.bottom {
						position: absolute;
						left: 25px;
						top: 12px;
						width: 10px;
						height: 10px;
						background: url(../../assets/img/sort-bottom.png);
						background-size: 100% 100%;
					}
					.bottom.active {
						background: url(../../assets/img/sort-bottom-active.png);
						background-size: 100% 100%;
					}
				}
			}
			// .li{background:url(../../assets/img/xiajiantou.png) no-repeat top 17px right 12px;}
		}
		.bottom {
			margin-top: 6px;
			/*height: 2700px;*/
			.unit {
				height: 230px;
				border-bottom: 1px solid #d8d8d8;
				position: relative;
				.left {
					width: 702px;
					float: left;
					margin-top: 14px;
					.logo {
						width: 120px;
						height: 120px;
						cursor: pointer;
					}
					.name {
						margin-left: 12px;
						p {
							font-size: 12px;
							margin-top: 5px;
							ul {
								width: 384px;
								white-space: nowrap;
								overflow: hidden;
								text-overflow: ellipsis;
								height: 17px;
								line-height: 17px;
							}
							li {
								font-size: 12px;
								margin-right: 8px;
							}
						}
						p:nth-of-type(1) {
							color: #2d5b96;
							font-size: 14px;
							cursor: pointer;
						}
						.huise {
							color: #939393;
						}
						.lanse {
							color: #2d5b96;
							cursor: pointer;
							display: inline;
						}
						.btn {
							margin-top: 23px;
							.button {
								width: 62px;
								height: 22px;
								font-size: 12px;
							}
							.button:nth-of-type(1) {
								background: #feeac5;
								color: #d99156;
								margin-right: 8px;
							}
						}
					}
					.shuliang {
						width: 100%;
						margin-top: 18px;
						p {
							color: #66646f;
							font-size: 12px;
							margin-right: 22px;
						}
						.huangse {
							color: #c69747;
						}
					}
					.store {
						margin-top: 27px;
						cursor: pointer;
					}
				}
				.right {
					margin-top: 21px;
					li {
						width: 136px;
						margin-left: 45px;
						cursor: pointer;
						.goods-img {
							width: 130px;
							height: 130px;
						}
						p {
							width: 100%;
							font-size: 12px;
							color: #676767;
							margin-top: 9px;
							height: 34px;
							display: -webkit-box;
							overflow: hidden;
							white-space: normal!important;
							text-overflow: ellipsis;
							word-wrap: break-word;
							-webkit-line-clamp: 2;
							-webkit-box-orient: vertical;
						}
						span {
							font-size: 11px;
							color: #e1a147;
							margin-top: 6px;
						}
					}
					li:first-child {
						margin-left: 0;
					}
				}
				.pingjia {
					position: absolute;
					bottom: -104px;
					left: -16px;
					background: rgba(255, 255, 255, 0.8);
					z-index: 99;
					width: 140px;
					height: 111px;
					border: 1px solid #d7d7d7;
					border-radius: 8px;
					/*display:none;*/
					img {
						position: absolute;
						left: 17px;
						top: -9px;
					}
					p {
						margin-top: 8px;
						margin-left: 14px;
						font-size: 12px;
						color: #888;
						span {
							color: #afa438;
						}
					}
				}
			}
		}
		.paging {
			height: 100px;
			.paging_r {
				float: right;
				padding: 32px 100px 32px 0;
			}
		}
	}
</style>