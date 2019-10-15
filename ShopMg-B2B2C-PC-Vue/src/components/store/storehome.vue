<template>
	<div class="home">
		<common-header></common-header>
		<store-header></store-header>
		<img src="../../assets/img/banner1.jpg" />  
		<div class="center">
			<img class="zhuanqu" src="../../assets/img/zhuanqu.jpg" />
			<div class="detonating-area">
				<div class="new-product inline-block">
					<div class="goods-l" v-if="storeDetonatingList.left!=null" @click="detail(storeDetonatingList.left.id)">
						<span class="g-title">{{storeDetonatingList.left.description}}</span>
						<p class="g-name">{{storeDetonatingList.left.title}}</p>
						<p class="g-price">
							<i>￥</i>{{storeDetonatingList.left.goods_price}}</p>
						<img :src="URL+storeDetonatingList.left.pic_url" alt="">
					</div>
					<div class="goods-r">
						<div class="banner g-swipe">
							<el-carousel height="200px" arrow="never">
								<el-carousel-item v-if="item != null" v-for="(item,index) in storeDetonatingList.center_top" :key="index" >
									<div class="goods_b" @click="detail(item.id)">
										<p class="r-title">{{item.title}}</p>
										<p class="r-new">{{item.description}}</p>
										<p class="r-price">
											<i>￥</i>{{item.goods_price}}</p>
									</div>
									<img :src="URL+item.pic_url" alt="" @click="detail(item.id)">
								</el-carousel-item>
							</el-carousel>
						</div>
						<div class="banner g-t" v-if="storeDetonatingList.center_lower ">
							<div class="goods_b" @click="detail(storeDetonatingList.center_lower.id)">
								<p class="r-title">{{storeDetonatingList.center_lower.title}}</p>
								<p class="r-new">{{storeDetonatingList.center_lower.description}}</p>
								<p class="r-price">
									<i>￥</i>{{storeDetonatingList.center_lower.goods_price}}</p>
							</div>
							<img :src="URL+storeDetonatingList.center_lower.pic_url" alt="">
						</div>
					</div>
					<ul class="cheap inline-block" v-if="storeDetonatingList.right">
						<li :key="j" v-for="(i,j) in storeDetonatingList.right">
							<span class="cheap-title">剁手价</span>
							<p>{{i.title}}</p>
							<p class="c-price">￥{{i.price_member}}</p>
							<img :src="URL+i.pic_url" alt="">
						</li>
					</ul>
				</div>
			</div>
			<div class="tuijian">
				<span class="l">推荐商品</span>
				<span @click="toAll" class="r">更多>></span>
			</div>
			<ul class="bottomul" v-if="storeRecommendGoods">
				<li  v-for="(li,index) in storeRecommendGoods" :key="index" class="l">
					<img class="storefuzhu" :src="URL+li.pic_url" @click="detail(li.id)"/>
					<p @click="detail(li.id)">{{li.title}}</p>
					<p>
						<span class="pic1">{{li.price_member}}</span>
						<span class="pic2">{{li.price_member}}</span>
					</p>
					<div class="collection" @click="collection(1, li.id, index)">
						<i :class="['l like', recommendCollection[index] === 1 ? 'cancel' : '']"></i>
						<span>{{recommendCollection[index] === 1 ? '已收藏' : '收藏'}}</span>
					</div>
					<img class="r bycar" src="../../assets/img/bycar.jpg" @click="addCar(li.store_id, li.price_member, li.id)"/>
				</li>
			</ul>
			<div class="tuijian">
				<span class="l">新品上架</span>
				<span @click="toAll" class="r">更多>></span>
			</div>
			<ul class="bottomul">
				<li  v-for="(li,index) in newArrivalsGoodsByStoreList" :key="index" class="l" >
					<img class="storefuzhu" :src="URL+li.pic_url" @click="detail(li.id)"/>
					<p @click="detail(li.id)">{{li.title}}</p>
					<p>
						<span class="pic1">{{li.price_member}}</span>
						<span class="pic2">{{li.price_member}}</span>
					</p>
					<div class="collection" @click="collection(2, li.id, index)">
            <i :class="['l like', detonatingListCollection[index] === 1 ? 'cancel' : '']"></i>
						<span>{{detonatingListCollection[index] === 1 ? '已收藏' : '收藏'}}</span>
					</div>
					<img class="r bycar" src="../../assets/img/bycar.jpg" @click="addCar(li.store_id, li.price_member, li.id)"/>
				</li>
			</ul>
		</div>
		<foot-com></foot-com>
	</div>
</template>

<script>
export default {
	data() {
		return {
      storeID: 0,
      stord_id:null,
      coll: [],
      storeDetonatingList: {},	//店铺爆品专区
      storeRecommendGoods: {},	//店铺推荐商品
      recommendCollection: [],
      detonatingListCollection: [],
      newArrivalsGoodsByStoreList: [],
		}
  },
  created(){
    this.stord_id=sessionStorage.getItem('store_id');
  },
	mounted() {
    this.storeID = this.$route.query.id;
    console.log(this.storeID)
		//店铺爆品专区
		this.getStoreDetonatingFun();
		//店铺推荐商品
    this.getStoreRecommendGoodsFun();
    
    this.newArrivalsGoodsByStore();
	},
	methods: {
    /*
      type 类型 推荐为1 爆品为2
      id  商品id
      index 下标
      collectionArr 需要改变的数组
    */
    collection (type, id, index) {
      type === 1 ? this.collectionType(this.recommendCollection, id, index) : this.collectionType(this.detonatingListCollection, id, index)
    },
    collectionType (collectionArr, id, index) {
      this.HTTP(this.$httpConfig.setCollectionGoods, {
        goods_id: id
      }, 'post', false).then(res => {
        this.$set(collectionArr, index, res.status)
      }).catch(()=>{})
    },
    addCar (storeId, price, goodsId) {
      var params = {
        goods_id: goodsId,
        goods_num: 1,
        price_new: price,
        store_id: storeId
      }
      this.HTTP(this.$httpConfig.addGoodToCart, params, 'post', false).then((res) => {
        this.$confirm('', '已成功加入购物车', {
          confirmButtonText: '查看购物车',
          cancelButtonText: '继续购物',
          type: 'success',
          center: true,
          lockScroll: false,
          closeOnClickModal: false,
          confirmButtonClass: 'to-shopping-cart',
          cancelButtonClass: 'continue-shopping'
        }).then(() => {
          window.open(window.location.origin + '/buyCar');
        }).catch(() => {

        });
      })
    },
		toAll() {
			this.$router.push({
				path: '/storelist',
				query: {
					id: this.storeID
				}
			});
    },
    detail (id) {
      window.open(window.location.origin + '/inroyaldrink?id=' + id);
    },
		//店铺爆品专区接口
		getStoreDetonatingFun() {
			this.HTTP(this.$httpConfig.getStoreDetonating, { id: this.storeID }, 'post').then((res) => {
        this.storeDetonatingList = res.data;
        console.log(this.storeDetonatingList);
			}).catch(()=>{})
		},
		//店铺推荐商品接口
		getStoreRecommendGoodsFun() {
			this.HTTP(this.$httpConfig.getStoreRecommendGoods, { id: this.storeID }, 'post').then((res) => {
				this.storeRecommendGoods = res.data;
			}).catch(()=>{})
    },
    // 新品推荐
    newArrivalsGoodsByStore()
    {
      	this.HTTP(this.$httpConfig.getStoreNewArrivalsGoodsByStore, { id: this.storeID }, 'post').then((res) => {
        this.newArrivalsGoodsByStoreList = res.data;
			}).catch(()=>{})
    }
	}
}
</script>
<style>
.el-carousel__button {
  width: 22px;
  height: 5px;
  background-color: #8c958f;
}
</style>

<style lang="less" scoped>
.collection {
		display: inline-block;
    margin:  10px 10px 0;
    i {
      margin-right: 5px;
    }
		.like {
			width: 25px;
			height: 25px;
			background: url(../../assets/img/collect_gooods.png) no-repeat;
			background-size: 100% 100%;
		}
		.cancel {
			background: url(../../assets/img/collected_goods.png) no-repeat;
			background-size: 100% 100%;
		}
	}
.l {
  float: left;
}
.r {
  float: right;
}
.inline-block {
  display: inline-block;
}
.center {
  width: 1200px;
  margin: 0 auto;
  height: 100%;
}
.zhuanqu {
  margin-bottom: 28px;
  margin-top: 47px;
}
.detonating-area {
  padding: 0 25px;
  .new-product {
    border: 1px solid #f5f5f5;
    border-left: none;
    .goods-l {
      float: left;
      height: 400px;
      width: 300px;
      border-left: 1px solid #f5f5f5;
      cursor:pointer;
      .g-title {
        box-sizing: content-box;
        color: #434343;
        font-size: 16px;
        font-weight: 800;
        border-bottom: 1px dashed #848484;
        display: block;
        height: 30px;
        line-height: 30px;
        margin: 0 25px;
        margin-top: 10px;
        text-align: center;
      }
      .g-name {
        padding: 0 30px;
        margin-top: 19px;
        display: -webkit-box;
        overflow: hidden;
        white-space: normal !important;
        text-overflow: ellipsis;
        word-wrap: break-word;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
      }
      .g-issue {
        font-weight: 800;
        margin-left: 30px;
        text-indent: 5px;
        color: #fff;
        background-color: #ff3334;
        width: 150px;
        height: 20px;
      }
      .g-price {
        padding: 0 30px;
        color: #ff3334;
        font-weight: 800;
        font-size: 17px;
        i {
          font-style: normal;
          color: #ff3334;
          font-size: 12px;
          font-weight: 600;
        }
      }
      img {
        margin: 0 30px;
        width: 240px;
        height: 230px;
      }
    }
    .goods-r {
      float: left;
      width: 420px;
      border-left: 1px solid #f5f5f5;
      .banner {
        background: #fdf8f2;
        height: 200px;
        cursor:pointer;
        .goods_b {
          width: 198px;
          float: left;
          padding-left: 30px;
          .r-title {
            font-size: 16px;
            padding-top: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
          }
          .r-new {
            color: #ff3334;
          }
          .r-price {
            padding-top: 15px;
            color: #ff3334;
            font-size: 17px;
            i {
              font-style: normal;
              color: #ff3334;
              font-size: 12px;
            }
          }
        }
        img {
          float: left;
          width: 170px;
          height: 120px;
          margin-left: 10px;
          margin-top: 38px;
        }
        .g-t-image {
          width: 200px;
          height: 60px;
          margin-top: 73px;
        }
      }
      .g-t {
        background-color: #fff;
      }
      .g-swipe {
        border-bottom: 1px solid #f5f5f5;
      }
    }
    .cheap {
      width: 420px;
      li {
        border-left: 1px solid #f5f5f5;
        float: left;
        width: 50%;
        height: 200px;
        text-align: center;
        .cheap-title {
          color: #434343;
          font-size: 16px;
          font-weight: 800;
          margin-top: 10px;
          display: block;
        }
        p {
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }
        .c-price {
          border-radius: 10px;
          font-weight: 800;
          font-size: 13px;
          width: 67px;
          color: #fff;
          margin: 0 auto;
          margin-top: 5px;
          background-color: #ff3334;
        }
        img {
          width: 170px;
          height: 85px;
          margin-top: 18px;
        }
      }
      li:nth-child(1) {
        border-bottom: 1px solid #f5f5f5;
      }
      li:nth-child(2) {
        border-bottom: 1px solid #f5f5f5;
      }
    }
  }
}
.tuijian {
  width: 100%;
  height: 40px;
  background: #f9f9f9;
  border: 1px solid #e5e5e5;
  margin: 12px 0;
  line-height: 40px;
  span:nth-of-type(1) {
    font-size: 14px;
    color: #333;
    margin-left: 13px;
  }
  span {
    font-size: 12px;
    color: #adadad;
    margin-right: 15px;
    cursor: pointer;
  }
  span:nth-of-type(2):hover {
    color: red;
  }
}
.bottomul {
  height: auto;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  width: 100%;
  cursor:pointer;
  li {
    width: 218px;
    height: 332px;
    border: 1px solid #f5f5f5;
    margin-right: 27px;
    margin-top: 12px;
    .storefuzhu {
	  margin: 5px;
	  width: 205px;
	  height: 205px;
    }
    p:nth-of-type(1) {
      font-size: 12px;
      color: #06060e;
    margin: 5px;
    height: 34px;
	  display: -webkit-box;
		overflow: hidden;
		white-space: normal!important;
		text-overflow: ellipsis;
		word-wrap: break-word;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
    }
    p:nth-of-type(2) {
      margin: 5px;
    }
    .pic1 {
      font-size: 14px;
      color: #c0354c;
    }
    .pic2 {
      font-size: 12px;
      color: #bbb;
      text-decoration: line-through;
      margin-left: 5px;
    }
    .storeheart {
      margin: 16px 5px 0 8px;
    }
    .shoucang {
      font-size: 12px;
      color: #949494;
      margin-top: 13px;
    }
    .bycar {
      margin: 5px 12px 0 0;
    }
    &:hover {
      border-color: #5a564a !important;
    }
  }
  li:nth-of-type(10) {
    margin-right: 0;
  }
  li:nth-of-type(5) {
    margin-right: 0;
  }
}
.bottomul:last-child {
  margin-bottom: 40px;
}
</style>