<template>
  <div id="gouwu">
    <head-com></head-com>
    <div id="top">
      <img src="../../assets/img/qianggou/top-bg.png" />
    </div>
    <div id="chase">
      <div class="center">
        <div class="boxxing">
          <img class="l" src="../../assets/img/qianggou/house.png" />
          <p class="l">
            <router-link to="home" class="l spot">首页</router-link>
            <span class="l spot">></span>
            <span class="l spot">抢购</span>
          </p>
        </div>
        <div class="box1">
          <dl class="l" v-for="(arrs,index) in list" :key="index" @click="detail(arrs.id)">
            <dt>
              <img :src="URL+arrs.pic_url" />
            </dt>
            <dd>
              <p class="one">
                <span class="one_first">{{arrs.title}}</span>
                <span class="one_second">[{{arrs.start_time | formatDate}}开抢]</span>
                <span class="one_three">{{arrs.already_num}}人已购买</span>
              </p>

              <p class="two l">
                <span class="two_first l">￥{{arrs.panic_price}}</span>
                <span class="two_second l">￥{{arrs.price_market}}</span>
              </p>
              <p v-if="arrs.start_time>now" class="three l">
                <span>即将开始</span>
              </p>
              <p v-else class="three l">
                <span>马上抢购</span>
              </p>
            </dd>
          </dl>
        </div>
        <div class="box2">
          <el-pagination
            @current-change="handleCurrentChange"
            background
            layout="total,prev, pager, next,jumper"
            :page-size="page_size"
            :total="page"
          ></el-pagination>
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
      list: [],
      issty: "",
      isShow: true,
      now: "",
      page: 0, //共多少条
      currentPage: 1, //当前页
      page_size: 12 //每页显示多少条数据
    };
  },
  mounted() {
    this.now = new Date().getTime() / 1000;
    this.getList();
  },
  methods: {
    /*页面跳转*/
    handleCurrentChange(currentPage) {
      console.log(currentPage);
      this.currentPage = currentPage;
      this.getList();
    },
    getList() {
      this.HTTP(
        this.$httpConfig.getPanicGoods,
        {
          page: this.currentPage
        },
        "post"
      ).then(res => {
        this.list = res.data.data;
        this.page = Number(res.data.count);
        console.log(this.page);
      });
    },
    detail(id) {
      this.$router.push({
        name: "introduce",
        params: {
          id: id
        }
      });
    }
  }
};
</script>

<style>
.el-pagination.is-background .el-pager li:not(.disabled):hover {
  color: #e2c670;
}

.el-pagination.is-background .el-pager li:not(.disabled).active {
  background-color: #c79a01;
  color: #fff;
}

.el-input.is-active .el-input__inner,
.el-input__inner:focus {
  border-color: #ae984d;
}
</style>

<style scoped lang='less'>
#gouwu {
  width: 100%;
  background: #fff;
}
.center {
  width: 1190px;
  height: 100%;
  margin: 0 auto;
}

.l {
  float: left;
}

.r {
  float: right;
}

#top {
  width: 1190px;
  height: 343px;
  margin: 0 auto;
  img {
    width: 100%;
    height: 100%;
  }
}

#chase {
  width: 1190px;
  margin: 0 auto;
  .center {
    .boxxing {
      width: 100%;
      height: 32px;
      img {
        margin-left: 10px;
        margin-right: 5px;
        margin-top: 11px;
      }
      p {
        height: 32px;
        line-height: 32px;
        .spot {
          margin-left: 5px;
          font-size: 14px;
          color: #666666;
        }
      }
    }
    .box1 {
      width: 100%;
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      flex-wrap: wrap;
      dl {
        width: 390px;
        height: 466px;
        border: 1px solid #dddddd;
        box-sizing: border-box;
        margin-right: 10px;
        margin-bottom: 20px;
        &:nth-child(3) {
          margin-right: 0;
        }
        &:nth-child(6) {
          margin-right: 0;
        }
        &:nth-child(9) {
          margin-right: 0;
        }
        &:nth-child(12) {
          margin-right: 0;
        }
        &:hover {
          border: 1px solid red;
        }
        dt {
          width: 100%;
          height: 344px;
          line-height: 344px;
          vertical-align: middle;
          text-align: center;
          img {
            width: 297px;
            height: 305px;
          }
        }
        dd {
          width: 100%;
          height: 122px;
          .one {
            width: 100%;
            height: 70px;
            margin-left: 28px;
            .one_first {
              height: 20px;
              line-height: 20px;
              overflow: hidden;
              text-overflow: ellipsis;
              white-space: nowrap;
              display: block;
              color: #000000;
              font-size: 13px;
              width: 350px;
            }
            .one_second {
              height: 18px;
              line-height: 18px;
              color: red;
              font-size: 13px;
              margin-right: 8px;
            }
            .one_three {
              color: #757575;
              font-size: 13px;
            }
          }
          .two {
            width: 288px;
            height: 50px;
            line-height: 50px;
            background: red;
            .two_first {
              font-size: 22px;
              color: #ffffff;
              margin-right: 10px;
              margin-left: 10px;
            }
            .two_second {
              font-size: 12px;
              color: #ffffff;
              text-decoration: line-through;
            }
          }
          .three {
            width: 100px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            background: red url(../../assets/img/qianggou/pic-small.png)
              no-repeat;
            span {
              color: #f06807;
              font-weight: 600;
              font-size: 18px;
              cursor: pointer;
            }
          }
        }
      }
    }
    .box2 {
      width: 1200px;
      height: 80px;
      text-align: center;
      .prev {
        width: 70px;
        height: 28px;
        line-height: 28px;
        border: 1px solid #e6e6e6;
        font-size: 13px;
        color: #868686;
        margin: 0 auto;
        text-align: center;
      }
      ul {
        width: 155px;
        height: 28px;
        li {
          width: 28px;
          height: 28px;
          line-height: 28px;
          border: 1px solid #e6e6e6;
          text-align: center;
        }
      }
      .next {
        width: 70px;
        height: 28px;
        line-height: 28px;
        border: 1px solid #e6e6e6;
        font-size: 13px;
        color: #868686;
        margin-right: 10px;
        text-align: center;
        margin-right: 17px;
      }
      .go {
        height: 28px;
        line-height: 28px;
      }
    }
  }
}
</style>