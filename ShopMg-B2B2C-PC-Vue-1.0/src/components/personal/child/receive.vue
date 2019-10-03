<template>
  <div class="receive l">
    <div class="top">
      <span>收货地址</span>
    </div>
    <p class="piecemeal">
      <span>注意：</span>如果您的购物订单已提交，请不要改动提交购物订单时的收货地址，以免造成不必要的错误。如果需要，请另行添加！
    </p>
    <p class="first">
      <span>新增收货地址</span>电话号码、手机号选填一项,其余均为必填项
    </p>
    <p class="diqu">
      <span class="spa">
        所在地区
        <i>*</i>
      </span>
      <select class="front" name v-model="id">
        <option :value="1">中国大陆</option>
      </select>
      <selection-area
        :operateStyle="operateStyle"
        @subgradeTransmit="subgradeTransmit"
        :selectProvId="selectProvId"
        :selectCityId="selectCityId"
        :selectAreaId="selectAreaId"
      ></selection-area>
      <el-alert v-show="tip.tip1" title="请完善地址" type="error" show-icon :closable="false"></el-alert>
    </p>
    <p class="diqu">
      <span class="spa">
        详细地址
        <i>*</i>
      </span>
      <textarea
        @change="changeWarning(2)"
        v-model="addressInfo.address"
        placeholder="建议您如实填写详细收货地址，例如街道名称，门牌号码，楼层和房间号 等信息"
      ></textarea>
      <el-alert v-show="tip.tip2" title="请完善详细地址" type="error" show-icon :closable="false"></el-alert>
    </p>
    <!-- <p class="diqu"><span class="spa">邮政编码 </span><input @change="changeWarning(3)" type="text" v-model="bank" /><el-alert v-show="tip.tip3" title="请完善邮政编码" type="error" show-icon :closable="false"></el-alert></p> -->
    <p class="name clearfix">
      <span class="spa">
        收货人姓名
        <i>*</i>
      </span>
      <input @change="changeWarning(4)" type="text" v-model="addressInfo.realname">
      <el-alert v-show="tip.tip4" title="收货人姓名不能为空" type="error" show-icon :closable="false"></el-alert>
    </p>
    <p class="haoma clearfix">
      <span class="spa">
        手机号码
        <i>*</i>
      </span>
      <input @change="changeWarning(5)" type="text" v-model="addressInfo.mobile">
      <el-alert v-show="tip.tip5" title="请输入正确的手机号" type="error" show-icon :closable="false"></el-alert>
    </p>
    <div class="moren">
      <span @click="setDefault">
        <input type="checkbox" :checked="addressInfo.status" v-model="addressInfo.status">设置为默认收货地址
      </span>
    </div>
    <button @click="protect">保存</button>
    <ul>
      <li class="thead">
        <p class="l">收货人</p>
        <p class="l">所在地区</p>
        <p class="l">详细地址</p>
        <!-- <p class="l">邮编</p> -->
        <p class="l">手机</p>
        <p class="l">操作</p>
      </li>
      <li class="list" v-for="(item,index) in addressList" :key="index">
        <p class="l">{{item.realname}}</p>
        <p class="l">{{item.prov_name}} {{item.city_name}} {{item.dist_name}} {{item.address_name}}</p>
        <p class="l">{{item.address}}</p>
        <!-- <p class="l">{{item.youbian}}</p> -->
        <p class="l">{{item.mobile|phoneEncryption}}</p>
        <p class="l">
          <span @click="modify(item.id)" class="huangse">修改</span> |
          <span @click="del(item.id)">删除</span>
        </p>
        <div class="r" v-if="item.status == 1">默认地址</div>
        <div class="r note" v-else @click="font(item.id)">设为默认</div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: 1,
      selectProvId: "请选择",
      selectCityId: "请选择",
      selectAreaId: "请选择",
      operateStyle: 1,
      operation: false, //是添加或者是修改
      tip: {
        tip1: false,
        tip2: false,
        // tip3:false,
        tip4: false,
        tip5: false
      },
      //单条地址
      addressInfo: {
        address: "",
        realname: "",
        mobile: "",
        status: false
      },
      //收货地址
      addressList: [],
      bank: ""
    };
  },
  created() {
    this.getAddressList();
  },

  methods: {
    subgradeTransmit(val) {
      if (val.sign == "city") {
        this.selectProvId = val.addressId;
      } else if (val.sign == "area") {
        this.selectCityId = val.addressId;
      } else {
        this.selectAreaId = val.addressId;
      }
    },

    //设为默认
    setDefault() {
      this.addressInfo.status = !this.addressInfo.status;
    },
    //地址列表
    getAddressList() {
      this.HTTP(this.$httpConfig.addressLists, {}, "post").then(res => {
        this.addressList = res.data.data;
      });
    },
    //删除
    del(id) {
      this.$confirm("确认删除该条地址么?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning",
        lockScroll: false,
        center: true,
        closeOnClickModal: false
      })
        .then(() => {
          this.HTTP(
            this.$httpConfig.addressDelete,
            {
              id: id
            },
            "post"
          ).then(res => {
            this.initData();
          });
        })
        .catch(() => {});
    },
    //修改获取单条地址数据
    modify(id) {
      this.operateStyle++;
      window.scrollTo(0, 0);
      this.initTip();
      this.operation = true;
      this.HTTP(
        this.$httpConfig.addressInfo,
        {
          id: id
        },
        "post"
      ).then(res => {
        this.addressInfo = res.data.data;
        this.addressInfo.status = parseInt(this.addressInfo.status); //是否默认
        this.selectProvId = this.addressInfo.prov;
        this.selectCityId = this.addressInfo.city;
        this.selectAreaId = this.addressInfo.dist;
      });
    },
    //设为默认地址
    font(id) {
      this.HTTP(
        this.$httpConfig.setDefault,
        {
          id: id
        },
        "post"
      ).then(res => {
        this.getAddressList();
      });
    },
    //初始化提示信息
    initTip() {
      for (const key in this.tip) {
        this.tip[key] = false;
      }
    },
    //初始化数据
    initData() {
      this.addressInfo = {
        address: "",
        realname: "",
        mobile: "",
        status: false
      };
      this.operateStyle = 1;
      this.selectProvId = "请选择";
      this.selectCityId = "请选择";
      this.selectAreaId = "请选择";
      this.getAddressList();
    },
    changeWarning(sign) {
      switch (sign) {
        case 1:
          if (this.selectCityId != "请选择" && this.selectAreaId != "请选择") {
            this.$set(this.tip, "tip1", false);
          }
          break;
        case 2:
          if (this.addressInfo.address != "") {
            this.$set(this.tip, "tip2", false);
          }
          break;
        // case 3:
        // 	if((/\d/g).test(this.bank)){
        // 		this.$set(this.tip,'tip3',false);
        // 	}
        // 	break;
        case 4:
          if (this.addressInfo.realname != "") {
            this.$set(this.tip, "tip4", false);
          }
          break;
        case 5:
          if (/^1[345789]\d{9}$/.test(this.addressInfo.mobile)) {
            this.$set(this.tip, "tip5", false);
          }
          break;
      }
    },
    protect() {
      let defaultAddress = "";
      if (this.selectCityId == "请选择" || this.selectAreaId == "请选择") {
        this.$set(this.tip, "tip1", true);
      }
      if (this.addressInfo.address == "") {
        this.$set(this.tip, "tip2", true);
      }
      // if(!(/\d/g).test(this.bank)) {
      // 	this.$set(this.tip,'tip3',true);
      // }
      if (this.addressInfo.realname == "") {
        this.$set(this.tip, "tip4", true);
      }
      if (!/^1[345789]\d{9}$/.test(this.addressInfo.mobile)) {
        this.$set(this.tip, "tip5", true);
      }
      if (this.addressInfo.status == false) {
        defaultAddress = 0;
      } else {
        defaultAddress = 1;
      }
      for (const key in this.tip) {
        if (this.tip[key] == true) {
          return;
        }
      }
      if (this.operation == false) {
        this.HTTP(
          this.$httpConfig.addAddress,
          {
            realname: this.addressInfo.realname,
            mobile: this.addressInfo.mobile,
            prov: this.selectProvId,
            city: this.selectCityId,
            dist: this.selectAreaId,
            address: this.addressInfo.address,
            status: defaultAddress
          },
          "post"
        ).then(res => {
          this.initData();
        });
      } else {
        this.HTTP(
          this.$httpConfig.editAddress,
          {
            id: this.addressInfo.id,
            realname: this.addressInfo.realname,
            mobile: this.addressInfo.mobile,
            prov: this.selectProvId,
            city: this.selectCityId,
            dist: this.selectAreaId,
            address: this.addressInfo.address,
            status: defaultAddress
          },
          "post"
        ).then(res => {
          this.operation = false;
          this.initData();
        });
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
  width: 1190px;
  margin: 0 auto;
  height: 100%;
}
.receive {
  width: 990px;
  background: #fff;
  margin-top: 16px;
  overflow: hidden;
  .piecemeal {
    margin-left: 17px;
    margin-top: 23px;
    span:nth-child(1) {
      color: red;
      font-size: 110%;
    }
  }
  .top {
    height: 37px;
    border-bottom: 1px solid #e7e7e7;
    margin: 14px 17px 0;
    span {
      display: inline-block;
      width: 104px;
      text-align: center;
      line-height: 35px;
      border-bottom: 2px solid red;
      color: red;
      font-size: 14px;
    }
  }
  p {
    .el-alert {
      float: left;
      margin-left: 15px;
      width: 150px;
      padding: 0;
    }
    .el-alert--error {
      background-color: transparent;
    }
    input {
      float: left;
      width: 205px;
      height: 27px;
      border: 1px solid #ccc;
      padding-left: 10px;
    }
  }
  p {
    .spa {
      float: left;
      i {
        font-style: normal;
        color: #ff0000;
      }
    }
  }
  p.first {
    margin: 23px 17px 19px;
    font-size: 12px;
    color: #333;
    span {
      color: red;
    }
  }
  p.diqu {
    margin-left: 32px;
    font-size: 12px;
    color: #333;
    margin-bottom: 10px;
    overflow: hidden;
    .front {
      float: left;
      min-width: 100px;
      outline: none;
      margin-left: 19px;
      border-color: #ccc;
    }
    .behind {
      float: left;
      min-width: 100px;
      outline: none;
      margin-left: 10px;
      border-color: #ccc;
    }
    textarea {
      margin-left: 19px;
      width: 419px;
      height: 76px;
      float: left;
      padding: 8px;
      border-color: #ccc;
    }
    input {
      margin-left: 29px;
    }
  }
  p.name {
    margin-left: 24px;
    margin-bottom: 10px;
    font-size: 12px;
    color: #333;
    input {
      margin-left: 15px;
    }
  }
  p.haoma {
    margin-left: 37px;
    font-size: 12px;
    color: #333;
    margin-bottom: 10px;
    input {
      margin-left: 15px;
    }
  }
  .moren {
    margin: 18px 0 20px 111px;
    font-size: 12px;
    color: #333;
    display: block;
    span {
      cursor: default;
    }
    input {
      margin-right: 7px;
    }
  }
  button {
    width: 73px;
    height: 30px;
    background: red;
    text-align: center;
    line-height: 30px;
    color: #fff;
    border-radius: 3px;
    margin-left: 111px;
    cursor: pointer;
  }
  ul {
    margin: 60px 17px 100px;
    border: 1px solid #e7e6e6;
    overflow: hidden;
    .thead {
      height: 45px;
      background: #f5f5f5;
      line-height: 45px;
      p {
        font-size: 14px;
        color: #333;
      }
    }
    .list {
      min-height: 70px;
      border-bottom: 1px solid #f5f5f5;
      overflow: hidden;
      p {
        font-size: 12px;
        color: #666;
        margin-top: 22px !important;
        margin-bottom: 12px;
      }
    }
    .list:last-child {
      border-bottom: 0;
    }
    .bg {
      background: #f5f5f5;
    }
    .list:hover {
      background: #eee;
    }
    .list:hover .note {
      display: block;
    }
    p:nth-child(1) {
      width: 124px;
      text-align: center;
    }
    p:nth-child(2) {
      width: 150px;
      margin: 0 46px;
    }
    p:nth-child(3) {
      width: 165px;
      margin: 0 46px;
    }
    p:nth-child(4) {
      width: 122px;
    }
    p:nth-child(5) {
      .huangse {
        color: black;
        text-decoration: underline;
      }
      span {
        cursor: pointer;
      }
    }
    div.r {
      width: 58px;
      height: 22px;
      border: 1px solid #ff3800;
      text-align: center;
      line-height: 22px;
      background: #ffd6cc;
      color: #ff5633;
      font-size: 12px;
      border-radius: 3px;
      margin: 18px 18px 0 0;
      cursor: default;
    }
    .note {
      cursor: pointer !important;
      background: #ff6600 !important ;
      color: #fff !important;
      display: none;
    }
  }
}
</style>