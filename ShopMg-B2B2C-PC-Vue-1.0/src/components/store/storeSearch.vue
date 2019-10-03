<template>
	<div class="store">
		<head-com></head-com>
		<div class="center">
			<div class="top">
				<img src="../../assets/img/fangzi.jpg" />
				<span><router-link class="to-link" to="storehome">首页</router-link></span>
				<span>></span>
				<span class="pingpai">店铺</span>
			</div>
			<ul class="tab">
				<li class="l actives">默认</li>
			</ul>
			<div class="bottom"  v-if="shopList.length != 0">
				<div class="unit" v-for="(store,index) in shopList" :key="index">
					<div class="left l">
						<img @click="toStore(store.id)" class="l logo" :src="URL + store.store_logo" />
						<div class="name l">
							<p @click="toStore(store.id)">{{store.shop_name}}</p>
							<p class="l">
								<span class="huise l">区域：{{store.prov_name}} {{store.city_name}}</span>
							</p><br />
							<p class="l">
								<span class="huise l">主营：</span>
								<ul class="l">
									<li class="lanse" v-for="(zhuying,i) in store.class_name" :key="i">{{zhuying.class_name}}</li>
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
							<li class="l" v-for="(goods,index) in store.store_goods" :key="index" @click="toDetail(goods.id)">
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
        <div v-if="shopList.length === 0" class="no-data">暂无更多</div>
			</div>
			<div class="paging" v-if="shopList.length != 0">
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
	export default {
		data() {
			return {
				over: -1,
				page: 1, //共多少条
				currentPage: 1, //当前页
				page_size: 10, //每页显示多少条数据
				shopList: [],
				// 评分信息
				starInfo: {
	
				}
	
			}
    },
    watch: {
      '$route' (to, from) { //监听路由是否变化
        if(this.$route.query.t){
          this.getSearchList(); //重新请求
        }
      } 
    },
		created() {
				this.getSearchList();
		},
		methods: {
			toDetail (id) {
				window.open(window.location.origin + '/inroyaldrink?id=' + id)
			},
			toStore(id) {
				window.open(window.location.origin + '/storehome?id=' + id)
			},
			/*页面跳转*/
			handleCurrentChange(currentPage) {
				console.log(currentPage);
				this.currentPage = currentPage;
				this.getSearchList();
			},
			//搜索列表
			getSearchList(){
				this.HTTP(this.$httpConfig.SearchIndex, {
						type:this.$route.query.type,
						title: this.$route.query.title,
						page: this.currentPage
					}, 'post')
					.then((res) => {
						this.shopList = res.data.data.data;
						this.page = res.data.data.count;
						this.page_size = res.data.data.page_size;
					}).catch((e)=>{
						console.log(e)
						this.shopList = [];
						this.page = 0;
						this.page_size = 10; 
					})
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
		.tab {
			margin-top: 18px;
			width: 100%;
			height: 40px;
			background: #fafafa;
			border: 1px solid #e4e4e4;
			// .active{background: #fff url(../../assets/img/Xiajiantou1.png) no-repeat top 17px right 12px !important;-webkit-transform: translateY(1px);color: #ddbf69;height: 38px;}
			.actives {
				background: #fff;
				// transform: translateY(1px);
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
			}
		}
		.bottom {
			margin-top: 6px;
			min-height: 230px;
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
      .no-data{
        text-align: center;
        line-height: 230px;
      }
		}
		.paging {
			text-align: right;
			padding: 20px 0;
		}
	}
</style>