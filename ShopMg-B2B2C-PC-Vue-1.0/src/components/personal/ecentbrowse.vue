<template>
  <div class="collect">
    <logo-component></logo-component>
    <div class="center">
      <div class="top">
        <div class="l">
          <span>最近浏览 ({{page.count || 0}})</span>
        </div>
        <div class="r" v-if="dataList.length != 0">
          <p class="l all" v-show="isShow" @click="choose">
            全选
            <input class="l" :checked="checked" id="allchange" type="checkbox" />
          </p>
          <p class="l del" @click="batchDelet" v-show="isShow">
            <img src="../../assets/img/delete_z1.png" />删除
          </p>
          <p class="l quxiao" @click="manage">{{operation}}</p>
          <!-- <p class="l inp"><input type="text" v-model="searchValue" /><span @click="searchFun"><i class="el-icon-search"></i></span></p> -->
        </div>
      </div>
      <div class="bottom">
        <ul>
          <li
            :class="{active:item.isSelected}"
            class="l"
            v-for="(item,index) in dataList"
            :key="index"
          >
            <div @click="choice(item,index)" v-show="mask_show" class="item-mask"></div>
            <i v-show="mask_show" class="check"></i>
            <img @click="detail(item.gid)" class="goods-img" v-lazy="URL + item.pic_url" />
            <p @click="detail(item.gid)">{{item.title}}</p>
            <p>￥{{item.price_member}}</p>
            <p>
              <span class="l shop-name">{{item.shop_name}}</span>
              <span class="r">{{item.prov_name}}</span>
            </p>
            <p class="del" @click="del(item.id)">删除</p>
          </li>
        </ul>
        <div v-if="dataList.length === 0" class="no-data">暂无浏览记录</div>
      </div>
      <div class="fenye" v-if="dataList.length != 0">
        <div class="box2">
          <el-pagination
            :current-page.sync="currentPage"
            @current-change="handleCurrentChange"
            background
            layout="total,prev, pager, next,jumper"
            :page-size="page_size"
            :total="parseInt(page.count)"
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
      dataList: [],
      mask_show: false,
      isShow: false,
      checked: false,
      operation: "批量操作",
      searchValue: "",
      page: 0, //共多少条
      currentPage: 1, //当前页
      page_size: 20, //每页显示多少条数据
      del_id: ""
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    detail(id) {
      window.open(window.location.origin + "/inroyaldrink?id=" + id);
    },
    getTitle() {
      return "最近浏览";
    },
    //批量操作按钮
    manage() {
      if (this.operation === "批量操作") {
        this.operation = "完成";
        this.isShow = true;
        this.mask_show = true;
      } else {
        this.operation = "批量操作";
        this.isShow = false;
        this.mask_show = false;
      }
    },
    del(id) {
      if (id) {
        this.del_id = id;
      }
      this.HTTP(
        this.$httpConfig.myFootFrintDel,
        {
          id: this.del_id
        },
        "post"
      ).then(res => {
        this.checked = false;
        this.page = 0;
        this.currentPage = 1;
        this.getData();
      });
    },
    //批量删除
    batchDelet() {
      let goodsId = [];
      for (let index = 0; index < this.dataList.length; index++) {
        if (this.dataList[index].isSelected == true) {
          goodsId.push(this.dataList[index].id);
        }
      }
      this.del_id = goodsId.join();
      if (goodsId.length == 0) {
        return;
      } else {
        this.$confirm("是否删除选中的商品?", "提示", {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
          lockScroll: false,
          center: true,
          closeOnClickModal: false
        })
          .then(() => {
            this.del();
          })
          .catch(() => {});
      }
    },
    //选中多个
    choice(items, index) {
      if (this.mask_show == false) {
        return;
      }
      //手动更新视图
      this.$forceUpdate();
      if (items.isSelected === false) {
        this.$set(this.dataList[index], "isSelected", true);
      } else {
        this.$set(this.dataList[index], "isSelected", false);
      }
    },
    getData() {
      this.HTTP(
        this.$httpConfig.getMyFootFrint,
        {
          page: this.currentPage
        },
        "post"
      )
        .then(res => {
          this.dataList = res.data.data.data;
          for (var i in this.dataList) {
            this.dataList[i].isSelected = false;
          }
          this.page = res.data.data;
        })
        .catch(() => {
          console.log(11111);
          this.dataList = [];
        });
    },
    // searchFun() {
    // 	this.HTTP(this.$httpConfig.myFootFrintSearch, {
    // 		keyWords: this.searchValue
    // 	}, 'post').then((res) => {

    // 	}).catch((res)=>{

    // 	})
    // },
    /*页面跳转*/
    handleCurrentChange(currentPage) {
      this.currentPage = currentPage;
      this.getData();
    },
    //全选
    choose() {
      if (this.checked == false) {
        for (let index = 0; index < this.dataList.length; index++) {
          this.dataList[index].isSelected = true;
        }
        this.checked = true;
      } else {
        for (let index = 0; index < this.dataList.length; index++) {
          this.dataList[index].isSelected = false;
        }
        this.checked = false;
      }
    }
  }
};
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

.header {
  height: 108px;
  img {
    margin: 28px 20px 0 0;
    float: left;
  }
  span {
    font-size: 23px;
    font-weight: 600;
    float: left;
    margin-top: 39px;
  }
}

.top {
  height: 43px;
  line-height: 41px;
  border-bottom: 2px solid #e6e6e6;
  div.l {
    span {
      display: inline-block;
      width: 132px;
      text-align: center;
      margin-right: 8px;
      cursor: pointer;
      border-bottom: 2px solid red;
      color: red;
    }
  }
  div.r {
    overflow: hidden;
    .all {
      font-size: 12px;
      color: #666;
      margin-right: 24px;
      cursor: pointer;
      input {
        margin: 14px 6px 0 0;
      }
    }
    .del {
      font-size: 12px;
      color: #666;
      margin-right: 19px;
      cursor: pointer;
      img {
        float: left;
        margin: 13px 6px 0 0;
      }
    }
    .quxiao {
      width: 68px;
      height: 27px;
      text-align: center;
      border: 1px solid #dcdcdc;
      font-size: 12px;
      color: #666;
      line-height: 27px;
      margin-top: 7px;
      cursor: pointer;
    }
    .inp {
      width: 157px;
      height: 27px;
      border: 1px solid #dcdcdc;
      line-height: 27px;
      margin: 7px 0 0 11px;
      input {
        width: 128px;
        height: 25px;
        padding-left: 5px;
        float: left;
        border-right: 1px solid #dcdcdc;
      }
      span {
        float: left;
        width: 27px;
        height: 25px;
        background: #f5f5f5;
        text-align: center;
        line-height: 25px;
      }
    }
  }
}

.bottom {
  height: auto;
  padding: 0 0 20px 0;
  .no-data {
    line-height: 370px;
    text-align: center;
  }
  ul {
    margin-top: 11px;
    overflow: hidden;
    li {
      width: 204px;
      height: 321px;
      margin-top: 10px;
      border: 1px solid #e7e6e6;
      margin-right: 45px;
      position: relative;
      .item-mask {
        position: absolute;
        top: 0px;
        right: 0px;
        left: 0;
        bottom: 0;
        z-index: 99;
      }
      .check {
        position: absolute;
        top: 0px;
        right: 0px;
        width: 40px;
        height: 40px;
        background: url("../../assets/img/css_sprites.png") no-repeat -55px -5px;
      }
      p {
        font-size: 12px;
      }
      img.goods-img {
        width: 202px;
        height: 202px;
        cursor: pointer;
      }
      p:nth-of-type(1) {
        margin: 7px 9px 6px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        &:hover {
          color: red;
        }
      }
      p:nth-of-type(2) {
        margin: 0px 9px 4px;
        color: #e30707;
      }
      p:nth-of-type(3) {
        margin: 0px 9px 13px;
        overflow: hidden;
        span {
          color: #999;
        }
        .shop-name {
          cursor: pointer;
        }
        .shop-name:hover {
          color: red;
        }
      }
      p:nth-of-type(4) {
        cursor: pointer;
        width: 40px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        color: #888;
        border: 1px solid #e7e6e6;
        margin-left: 9px;
        background: #f4f4f4;
        &:hover {
          color: red;
        }
      }
      .img {
        position: absolute;
        top: 0;
        right: 0;
      }
    }
    li:nth-child(5n) {
      margin-right: 0;
    }
    li.active {
      .check {
        background-position: -5px -5px;
      }
    }
  }
}

.fenye {
  margin: 20px 0;
  width: 100%;
  overflow: hidden;
  text-align: right;
}
</style>