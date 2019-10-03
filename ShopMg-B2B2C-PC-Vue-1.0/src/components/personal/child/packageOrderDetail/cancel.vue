<template>
  <div class="fullOrde">
    <div class="alike" v-for="(item, key) in order" :key="key">
      <div class="both">
          <!-- <input class="l" type="checkbox" /> -->
          <p class="l" style="margin-left: 10px;">{{item.create_time | formatDate}}</p>
          <p class="l">订单号： {{item.order_sn_id}}</p>
          <!-- <p class="l">店铺：
            <router-link target="_blank" :to="{path:'/storehome',query:{id:item.store_id}}">{{item.store.shop_name}}</router-link>
          </p> -->
          <img src="../../../../assets/img/qq.jpg" /><i @click="deleteOrder(item.id)" v-if="item.order_status == 4 || item.order_status == '-1'" class="el-icon-delete r"></i>
        </div>
      <div class="shopBox">
        <div class="right r">
          <p>
            <span>￥{{parseFloat(item.price_sum)}}</span>
            <span>（含运费：￥{{item.shipping_monery|keep2Num}}）</span>
          </p>
          <p>
            <span v-if="item.order_status == 0">等待买家付款</span>
            <span v-if="item.order_status == 1">等待卖家发货</span>
            <router-link target="_blank" class="a-block" :to="{path: '/packageOrderDetail', query: {id: item.id}}">订单详情</router-link>
            <a @click="lookLogistics(item)" class="a-block" v-if="~~item.order_status === 3">查看物流</a>
          </p>
          <p>
            <span ref="msg" :class="~~item.order_status === 1 ||item.order_status == '-1' ? 'quxiao' : ''">{{$Status[item.order_status]}}</span>
            <a v-if="item.order_status == 0" class="a-block" @click="cancelOrder(item.id)">取消订单</a>
          </p>
        </div>
        <div class="left">
          <div class="order-item clearfix" v-for="(goods, index) in goods" :key="index" v-show="item.id === goods.order_id">
            <div class="order-info l">
              <div class="zuo">
                <div class="huowu">
                  <router-link target="_blank" class="a-block" :to="{path:'/inroyaldrink',query:{id:goods.goods_id}}">
                    <img v-lazy="URL + goods.pic_url" />
                  </router-link>
                  <p>
                    <router-link target="_blank" class="a-block" :to="{path:'/inroyaldrink',query:{id:goods.goods_id}}">{{goods.title}}</router-link>
                  </p>
                  <p>￥{{goods.goods_discount}}</p>
                  <p>{{goods.package_num}}</p>
                  <router-link class="goods-operate" target="_blank" to="apply">售后处理</router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="pagation" v-if="data.length != 0">
      <el-pagination background layout="prev, pager, next" :total="~~data.count" :page-size="data.page_size" @current-change="handleCurrentChange">
      </el-pagination>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        data: [],
        currentPage:1,
        h: true,
        dingDan: false,
        message: '',
        order: [],
        goods:[],
      }
    },
    created() {
      this.Order()
    },
    methods: {
      deleteOrder(id){ // 删除订单
        this.$confirm('您确定要删除该订单吗?', '提示', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning',
					lockScroll: false,
					center: true,
					closeOnClickModal: false,
				}).then(() => {
					this.HTTP(this.$httpConfig.package.del, {
							id: id
						}, 'post')
						.then((res) => {
              if(res.data.status){
                this.Order();
              }else{
                this.search(1);
              }
						}).catch((e)=>{
              console.log(e);
              this.$message.error(e.data.message)
            })
				}).catch(() => {
					
				});
      },
      Order() {
        this.HTTP(this.$httpConfig.package.haveBeenCancelled, {
           page:this.currentPage
        }, 'post', false).then(res => {
          if (res.data.status) {
            this.data = res.data.data
            this.order = this.data.order
            this.goods = this.data.goods
            console.log('待收货' + res.data)
          }
          console.log('order是：' + '\n' + this.order)
          this.$emit('payMentCount', ~~this.data.count)
        }).catch(e=>{
          this.$message.error(e.data.message)
        })
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.Order();
      },
      xiangqing() {
        this.h = false;
        this.dingDan = true;
      },
    }
  }
</script>

<style lang="less" scoped>
.left {
  width: 600px;
  .order-item {
    display: flex;
  }
}
.shopBox {
  position: relative;
}

.alike .right {
    height: 100%;
    position: absolute;
    right: 0px;
    display: flex;
    align-items: center;
    box-sizing: border-box;
    p {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      span {
        display: flex;
        justify-content: center;
      }
    }
  }

  .pagation {
    display: flex;
    justify-content: center;
  }
  
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
  
  .alike {
    overflow: hidden;
    border: 1px solid #e7e6e6;
    margin: 0 17px 10px;
    .goods-operate {
      display: inline-block;
      margin-top: 20px;
    }
    .a-block {
      display: block;
    }
    a {
      font-size: 12px;
      color: #333;
    }
    a:hover {
      color: red;
    }
    .both {
      height: 42px;
      line-height: 42px;
      background: #f1f1f1;
      i {
        font-size: 16px;
        margin: 13px 16px 0 0;
        color: #999;
        font-weight: 900;
      }
      input {
        margin: 16px 14px 0 13px;
      }
      p {
        font-size: 12px;
        color: #333;
      }
      p:nth-of-type(2) {
        margin: 0 67px 0 25px;
      }
      img {
        float: left;
        margin: 9px 0 0 35px;
      }
    }
    .zuo {
      overflow: hidden;
      width: 613px;
      .huowu {
        height: 110px;
        img {
          width: 70px;
          height: 70px;
          float: left;
          margin: 15px 10px 0 13px;
        }
        p {
          float: left;
          font-size: 12px;
          color: #333;
          margin-top: 20px;
        }
        p:nth-of-type(1) {
          width: 147px;
          margin: 18px 117px 0 0;
        }
        p:nth-of-type(3) {
          margin: 20px 83px 0 44px;
        }
      }
    }
    .right {
      overflow: hidden;
      p {
        float: left;
        border-left: 1px solid #e7e6e6;
        height: 100%;
        text-align: center;
        span {
          display: block;
          font-size: 12px;
          color: #333;
        }
      }
      p:nth-of-type(1) {
        width: 120px;
        span:nth-of-type(1) {
          margin-top: 20px;
        }
      }
      p:nth-of-type(2) {
        width: 105px;
        span:nth-of-type(1) {
          margin-top: 20px;
        }
      }
      p:nth-of-type(2)> :first-child {
        margin-top: 20px;
      }
      p:nth-of-type(3) {
        width: 106px;
        span:nth-of-type(1) {
          cursor: pointer;
          margin: 17px auto 8px;
          width: 72px;
          height: 28px;
          line-height: 28px;
          color: #fff;
          background: #ff6000;
          border-radius: 3px;
        }
      }
      .quxiao {
        background: #cbcaca !important;
      }
      .queren {
        background: #66b6ff !important;
      }
    }
    .youhui {
      line-height: 35px;
      color: #333;
      font-size: 12px;
      margin-left: 13px;
      span {
        color: red;
      }
    }
  }
</style>


