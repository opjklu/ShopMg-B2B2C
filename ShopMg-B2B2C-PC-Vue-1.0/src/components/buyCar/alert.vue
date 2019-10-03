<template>
  <div class="alertBox" v-show="alertShow">
    <i class="el-icon-loading loading" v-show="loading"></i>
    <div class="voucherBox" v-show="!loading">
      <div class="close" @click="close">x</div>
      <ul>
        <li v-for="(voucher, index) in vouchers.data" :key="index">
          <div class="MoneyBox">
            <span class="money">{{'￥' + voucher.money}}</span>
          </div>
          <div class="col">
            <div class="row">
              <span>{{voucher.name}}</span>
              <span>{{'满' + voucher.condition + '元使用'}}</span>
            </div>
            <div class="row">
              <span>{{voucher.use_start_time | formatDate}}</span>
              <span>至</span>
              <span>{{voucher.use_end_time | formatDate}}</span>
            </div>
          </div>
          <div>
            <el-button type="mini" @click="CheckIsUseCoupon(voucher.id)">领取</el-button>
          </div>
        </li>
      </ul>
      <el-pagination
        background
        layout="prev, pager, next"
        :total="~~vouchers.page"
        :page-size="vouchers.page_size"
        @current-change="handleCurrentChange">
      </el-pagination>
    </div>
  </div>
</template>

<script>
import {Message} from 'element-ui'
  export default {
    props: {
      alertShow: Boolean,
      storeId: Number
      // vouchers: Object
    },
    data () {
      return {
        vouchers: [],
        loading: true,
      }
    },
    
    watch: {
      storeId () {
        (() => {
        for (let i = 1; i <= 5; i++) {
          setTimeout(() => {
            if (i === 5 && this.loading) {
              this.loading = false
              Message.info('请求超时')
              this.$emit('update:alertShow', false)
            }
          }, i * 1000)
        }
      })()
        this.getCouponList(1)
      }
    },
    methods: {
      close () {
        this.$emit('update:alertShow', false)
      },
      CheckIsUseCoupon (id) {
				this.HTTP(this.$httpConfig.coupon.couponReceiveBehavior, {
					c_id: id
				}, 'post').then(res => {
					console.log(res.data)
					if (res.data.status) Message.info('领取成功')
				})
			},
      getCouponList (page) {
        this.loading = true
        this.HTTP(this.$httpConfig.coupon.couponSendList, {
          store_id: this.storeId,
          page: page
        }, 'post').then(res => {
          this.loading = false
          Message.info(res.data.message);
          if (res.data.status) this.vouchers = res.data.data
        })
      },
      handleCurrentChange (page) {
        this.getCouponList(page)
      }
    }
  }
</script>
<style lang="less" scoped>
  .el-pagination {
    text-align: center;
  }
  .loading {
    color: white;
    font-size: 70px;
    animation: rotating 1.5s linear infinite;
  }
  .alertBox {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    position: absolute;
    top: -30%;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: center;
   
    .voucherBox {
      border: 2px solid #d09d27;
      border-radius: 8px;
      overflow: hidden;
      background: white;
      display: flex;
      flex-direction: column;
      z-index: 1;
      padding: 10px 20px 20px;
      position: relative;
      .close {
        display: flex;
        justify-content: flex-end;
        font-size: 30px;
        margin-right: 0px;
        margin-top: -10px;
      }
      li {
        display: flex;
        flex-direction: row;
        margin: 5px 0;
        .MoneyBox {
          display: flex;
          align-items: center;
        }
        .money {
          width: 70px;
          height: 50px;
          display: flex;
          justify-content: center;
          align-items: center;
          border: 2px solid #ccc;
          border-radius: 5px;
        }
        .col {
          flex: 1;
          flex-direction: column;
        }
        .row {
          display: flex;
          flex-direction: row;
          height: 30px;
          margin-left: 30px;
        }
        div:last-child {
          color: red;
          display: flex;
          align-items: center;
          margin-right: 30px;
        }
      }
    }
    .voucher {
      width: 110px;
      border: 2px dotted #d09d27;
      height: 35px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-left: 25px;
    }
  }
</style>
