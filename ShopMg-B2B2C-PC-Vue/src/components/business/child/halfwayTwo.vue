<template>
  <div id="interview">
    <logo-component></logo-component>
    <openStoreLogo></openStoreLogo>

    <div class="middle">
      <div class="center">
        <div class="Box">
          <img src="../../../assets/img/deng.png" />

          <div>
            <span class="spa">注意事项</span>

            <span>开店成功后，可在店铺基本设置处修改店铺名称</span>

            <!-- <span>待支付费用：<b style="color:red;">{{money}}</b>元</span> -->

            <span>请先提交至网站管理人员进行人工审核，审核通过后，缴纳“待支付费用”，支付成功后即可成功开店。</span>
          </div>
        </div>

        <div class="show">
          <div class="up">
            <h1>店铺经营信息</h1>

            <p class="four">
              <span class="span">*</span>
              商家账号 :
              <el-input
                size="small"
                @change="changeWarning(1)"
                v-model="params.shop_account"
                type="text"
              ></el-input>

              <span class="huise">此账号为日后登录并管理商家中心时使用，注册后不可修改，请牢记</span>
            </p>

            <div class="item-tip">
              <el-alert title="请输入商家账号" v-show="tip.tip1" type="error" show-icon :closable="false"></el-alert>
            </div>

            <p class="four">
              <span class="span">*</span>
              店铺等级 :
              <el-select size="small" v-model="params.level_id" placeholder="请选择">
                <el-option
                  v-for="item in levelArr"
                  :key="item.id"
                  :label="item.level_name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </p>

            <div class="item-tip">
              <el-alert title="请选择店铺等级" v-show="tip.tip2" type="error" show-icon :closable="false"></el-alert>
            </div>

            <p class="four">
              <span class="span">*</span>
              开店时长 :
              <el-input
                size="small"
                @change="changeWarning(2)"
                maxlength="2"
                v-model="params.shop_long"
                type="text"
              ></el-input>年
            </p>

            <div class="item-tip">
              <el-alert title="请输入开店时长" v-show="tip.tip3" type="error" show-icon :closable="false"></el-alert>
            </div>

            <p class="four">
              <span class="span">*</span>
              店铺分类 :
              <el-select size="small" v-model="params.shop_class" placeholder="请选择">
                <el-option
                  v-for="item in classArr"
                  :key="item.id"
                  :label="item.sc_name"
                  :value="item.id"
                ></el-option>
              </el-select>

              <span class="huise">请根据您所经营的内容认真选择店铺分类，注册后商家不可自行修改</span>
            </p>

            <div class="item-tip">
              <el-alert title="请选择店铺分类" v-show="tip.tip4" type="error" show-icon :closable="false"></el-alert>
            </div>

            <p class="four leimu">
              <span class="span">*</span>
              经营类目 :
              <el-select
                size="small"
                @change="getNextClass(2,classItem.one_class.id)"
                class="class"
                v-model="classItem.one_class"
                value-key="id"
                placeholder="请选择"
              >
                <el-option
                  v-for="(item,index) in thereClassArr"
                  :key="index"
                  :label="item.class_name"
                  :value="item"
                ></el-option>
              </el-select>

              <el-select
                size="small"
                @change="getNextClass(3,classItem.two_class.id)"
                class="class"
                v-model="classItem.two_class"
                value-key="id"
                placeholder="请选择"
              >
                <el-option
                  v-for="(item,index) in thereClassArr2"
                  :key="index"
                  :label="item.class_name"
                  :value="item"
                ></el-option>
              </el-select>

              <el-select
                size="small"
                class="class"
                v-model="classItem.three_class"
                value-key="id"
                placeholder="请选择"
              >
                <el-option
                  v-for="(item,index) in thereClassArr3"
                  :key="index"
                  :label="item.class_name"
                  :value="item"
                ></el-option>
              </el-select>

              <span @click="addClass" class="spn">+选择添加类目</span>
            </p>

            <div class="item-tip">
              <el-alert title="请添加经营分类" v-show="tip.tip5" type="error" show-icon :closable="false"></el-alert>
            </div>

            <div class="jyClass">
              <div class="under">
                <span>一级类目</span>

                <span>二级类目</span>

                <span>三级类目</span>

                <span>操作</span>
              </div>

              <div class="under down" v-for="(item,index) in management" :key="index">
                <span>{{item.one_class.class_name}}</span>

                <span>{{item.two_class.class_name}}</span>

                <span>{{item.three_class.class_name}}</span>

                <span @click="delClass(index)">删除</span>
              </div>
            </div>

            <button @click="submit">提交申请</button>
          </div>
        </div>
      </div>
    </div>

    <sign></sign>
  </div>
</template>

<script>
export default {
  data() {
    return {
      storeID: "",

      params: {
        shop_account: "", //商家账号

        level_id: "", //店铺等级

        shop_long: "", //开店时长

        shop_class: "", //店铺分类

        store_id: "", //店铺申请id

        class: [] //经营类目
      },

      management: [], //经营类目

      levelArr: [],

      classArr: [],

      thereClassArr: [],

      thereClassArr2: [],

      thereClassArr3: [],

      classItem: {
        one_class: "",

        two_class: "",

        three_class: ""
      },

      tip: {
        tip1: false,

        tip2: false,

        tip3: false,

        tip4: false,

        tip5: false
      }
    };
  },

  watch: {
    "params.level_id": {
      deep: true,

      handler: function(newVal, oldVal) {
        this.$set(this.tip, "tip2", false);
      }
    },

    "params.shop_class": {
      deep: true,

      handler: function(newVal, oldVal) {
        this.$set(this.tip, "tip4", false);
      }
    },

    "classItem.one_class": {
      deep: true,

      handler: function(newVal, oldVal) {
        this.$set(this.tip, "tip5", false);
      }
    }
  },
  components: {
    sign: () => import("../../../common/sign"),
    openStoreLogo: () => import("../../../common/opStoreLogo")
  },
  mounted() {
    this.storeID = this.$route.params.id;

    this.params.store_id = this.storeID;

    // 获取店铺等级

    this.getShopLevel();

    // 获取店铺分类

    this.getStoreClasses();

    // 获取经营类目

    this.getTopClass();
  },

  created() {
    this.storeInformationQuery();
  },

  methods: {
    getStoreType() {
      return "开店申请";
    },
    //店铺信息查询
    getTitle() {
      return "招商入住";
    },
    storeInformationQuery() {
      this.HTTP(this.$httpConfig.getInformationAndBindClass, {}, "post")
        .then(res => {
          let shop = res.data.information;

          let kind = res.data.class_data;

          //暂无返回值，若有请修复

          if (res.data != null) {
            this.params.shop_account = shop.shop_account; //商家账号

            this.params.level_id = shop.level_id; //店铺等级

            this.params.shop_long = shop.shop_long; //开店时长

            this.params.shop_class = shop.shop_class; //店铺分类

            this.params.store_id = shop.store_id; //店铺申请id

            for (let index = 0; index < kind.length; index++) {
              let classItem = {
                one_class: "",

                two_class: "",

                three_class: ""
              };

              classItem.one_class = {
                id: kind[index].one_class,

                class_name: kind[index].one_name
              };

              classItem.two_class = {
                id: kind[index].two_class,

                class_name: kind[index].two_name
              };

              classItem.three_class = {
                id: kind[index].three_class,

                class_name: kind[index].three_name
              };

              console.log(classItem);

              this.management.push(classItem);
            }

            console.log(this.management);
          }
        })
        .catch(e => {});
    },

    changeWarning(sign) {
      let reg = /^[1-9]\d*$/;

      if (sign === 1) {
        if (this.params.shop_account) {
          this.$set(this.tip, "tip1", false);
        } else {
          this.$set(this.tip, "tip1", true);
        }
      } else {
        if (reg.test(this.params.shop_long)) {
          this.$set(this.tip, "tip3", false);
        }
      }
    },

    // 获取店铺等级

    getShopLevel() {
      this.HTTP(this.$httpConfig.getShopLevel, {}, "post")
        .then(res => {
          this.levelArr = res.data;
        })
        .catch(() => {});
    },

    // 获取店铺分类

    getStoreClasses() {
      this.HTTP(this.$httpConfig.getStoreClasses, {}, "post")
        .then(res => {
          this.classArr = res.data.class;
        })
        .catch(() => {});
    },

    // 获取一级菜单

    getTopClass() {
      this.HTTP(
        this.$httpConfig.getClass,
        {
          id: 0
        },
        "post"
      )
        .then(res => {
          var list = res.data;

          for (var i in list) {
            this.thereClassArr.push(list[i]);
          }
        })
        .catch(() => {});
    },

    // 获取二级、三级菜单

    getNextClass(type, id) {
      console.log(id);

      this.HTTP(
        this.$httpConfig.getClass,
        {
          id: id
        },
        "post"
      )
        .then(res => {
          var list = res.data;

          if (type == 2) {
            this.thereClassArr2 = list;
          } else {
            this.thereClassArr3 = list;
          }
        })
        .catch(() => {});
    },

    // 添加经营类目

    addClass() {
      console.log(3);
      if (
        this.classItem.three_class == "" ||
        this.classItem.three_class == undefined
      ) {
        this.$message.error("请先选择再添加！");

        return;
      } else {
        if (this.management.length === 0) {
          this.management.push(this.classItem);
        } else {
          let add = false;
          for (let index = 0; index < this.management.length; index++) {
            if (
              this.management[index].three_class.id ==
              this.classItem.three_class.id
            ) {
              add = false;
              this.$message.warning("不可重复添加!");
              break;
            } else {
              add = true;
            }
            //添加之后,清空类目选项
            if (add == true) {
              this.management.push(this.classItem);
            } else {
              this.classItem = {};
              this.thereClassArr2 = [];
              this.thereClassArr3 = [];
              return;
            }
          }
        }

        this.classItem = {};

        this.thereClassArr2 = [];

        this.thereClassArr3 = [];
      }
    },

    // 删除经营类目

    delClass(index) {
      console.log(this.management);

      return;

      this.management.splice(index, 1);
    },

    // 提交

    submit() {
      let reg = /^[1-9]\d*$/;

      if (!this.params.shop_account) {
        this.$set(this.tip, "tip1", true);
      }

      if (!this.params.level_id) {
        this.$set(this.tip, "tip2", true);
      }

      if (!reg.test(this.params.shop_long)) {
        this.$set(this.tip, "tip3", true);
      }

      if (!this.params.shop_class) {
        this.$set(this.tip, "tip4", true);
      }

      if (this.management.length === 0) {
        this.$set(this.tip, "tip5", true);
      }

      for (const key in this.tip) {
        if (this.tip[key] == true) {
          return;
        }
      }

      console.log(this.management);

      var list = this.management;

      var item = [];

      for (var i in this.management) {
        item[i] = {
          one_class: "",

          two_class: "",

          three_class: ""
        };

        item[i].one_class = list[i].one_class.id;

        item[i].three_class = list[i].three_class.id;

        item[i].two_class = list[i].two_class.id;
      }

      console.log(item);

      this.params.class = item;

      this.HTTP(this.$httpConfig.dispatchOption, this.params, "post")
        .then(res => {
          this.$router.push("./submit");
        })
        .catch(res => {
          alert(res.message);
        });
    }
  }
};
</script>

<style>
.el-input__inner:focus {
  border-color: #ae984d !important;
}

.el-input__inner:focus {
  border-color: #ae984d !important;
}

.el-select-dropdown__item.selected {
  color: #ae984d;
}
</style>

<style lang='less' scoped>
.el-alert {
  display: inline;

  // margin-left: 15px;

  padding: 0;
}

.el-alert--error {
  background-color: transparent;
}

.center {
  width: 1200px;

  height: 100%;

  margin: 0 auto;
}

.l {
  float: left;
}

.r {
  float: right;
}
.middle {
  background: #fafafa;

  padding: 20px 0;

  #btn_file {
    border: 0;

    margin-left: 25px;

    width: 160px;
    halfwaytwomargin-top: 4px;
  }

  .center {
    background: #fff;

    overflow: hidden;

    .Box {
      height: 120px;

      border: 1px solid #bce8f1;

      background: #eff8ff;

      margin: 51px 110px 33px;

      display: flex;

      flex-direction: row;

      img {
        margin: 27px 16px 0 40px;

        width: 30px;

        height: 30px;
      }

      > div {
        span {
          font-size: 12px;

          color: #b1b4b6;

          float: left;

          width: 70%;

          display: block;
        }

        .spa {
          color: #333;

          font-size: 14px;

          margin: 25px 0 3px;
        }
      }
    }

    input {
      width: 286px;

      height: 30px;

      border: 1px solid #ccc;

      margin-left: 31px;
    }

    select,
    .el-date-editor.el-input,
    .el-select,
    .el-input {
      margin-left: 30px;

      width: 286px;

      outline: none;

      color: #888;
    }

    .el-select.class {
      margin-left: 30px;

      width: 150px;

      height: 30px;

      outline: none;

      color: #888;
    }

    .span {
      color: #ff3f3f;

      margin-right: 5px;
    }

    .show {
      margin: 0 110px;

      h1 {
        font-size: 14px;

        color: #333;

        margin-bottom: 22px;
      }

      p {
        font-size: 12px;

        color: #555;

        // margin-bottom: 20px;

        line-height: 32px;
      }

      p.four {
        margin-left: 118px;
      }

      .item-tip {
        min-height: 24px;

        line-height: 24px;

        margin: 3px 0 3px 220px;
      }

      .up {
        height: auto;

        margin: 0 0 50px 0;

        .huise {
          color: #999;

          margin-left: 20px;
        }

        button {
          cursor: pointer;

          width: 94px;

          height: 32px;

          border-radius: 4px;

          text-align: center;

          line-height: 32px;

          background: red;

          margin-left: 213px;

          margin-top: 20px;

          color: #fff;

          a {
            color: #fff;

            font-size: 12px;
          }
        }

        .leimu {
          select {
            width: 199px;

            margin-left: 19px;
          }

          select:nth-of-type(1) {
            margin-left: 31px;
          }

          .spn {
            display: inline-block;

            width: 105px;

            height: 28px;

            text-align: center;

            line-height: 28px;

            font-size: 12px;

            background: #f5f5f5;

            border: 1px solid #ddd;

            margin-left: 13px;

            margin-top: 5px;

            cursor: pointer;
          }
        }
      }

      .jyClass {
        margin: 0 0 30px 213px;

        .under {
          line-height: 38px;

          background: #f7f7f7;

          border: 1px solid #ddd;

          width: 598px;

          font-size: 12px;

          color: #767676;

          font-weight: 600;

          span {
            width: 24%;

            display: inline-block;

            text-align: center;
          }
        }

        .down {
          border-top: none;

          background-color: #fff;

          span {
            color: #999;
          }

          span::nth-of-type(4) {
            cursor: pointer;
          }

          span:nth-of-type(4):hover {
            color: #f00;

            cursor: pointer;
          }
        }
      }
    }
  }
}
</style>