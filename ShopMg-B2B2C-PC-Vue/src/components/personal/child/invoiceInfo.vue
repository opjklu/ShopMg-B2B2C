<template>
	<div>
		<div class="invoice_info l">
			<ul class="top"><li @click="Hit(0)" :class="{line:isLine==0}"><p>普通发票抬头</p></li><li @click="Hit(1)" :class="{line:isLine==1}"><p> 增值税专用发票资质</p></li></ul>
			<div v-show="isLine==0">
				<button class="xinzeng" @click="New">新增发票抬头</button>
				<div class="under">
					<div class="fapiao" v-for="(items,index) in invoiceInfo" :key="items.id">
						<input type="text" v-model="items.name">
						<!-- <p>{{items.name}}</p> -->
						<span @click="del(index)">删除</span>
						<span @click="modify(index)">保存</span>
					</div>
				</div>						
			</div>
			<div v-show="isLine==1">
				<div class="xinzeng" @click="News">新增专票资质</div>
				<div class="unders">
					<div class="fapiao" v-for="(item,index) in capitaList" :key="item.id">
						<p>公司名称：<span>{{item.company_name}}</span></p>
						<p>开户银行：<span>{{item.opening_bank}}</span></p>
						<p>注册地址：<span>{{item.prov_name}}-{{item.city_name}}-{{item.dist_name}}</span></p>
						<div class="xbox"><span class="span" @click="Delete(index)">删除</span><span @click="edit(item.id)" class="span">修改</span></div>
					</div>
				</div>	
			</div>
		</div>
		<el-dialog
			title="新增发票抬头"
			:visible.sync="addInvoice"
			width="30%"
			>
			<div id="Concent">
				<p class="top">新增发票抬头：<input type="text" @keyup.enter="submit" v-model="Data"/></p>
				<button @click="submit">保存</button>
				<button @click="cancel">取消</button>
			</div>
		</el-dialog>
		<el-dialog
			:title="title+'增值税专用发票资质'"
			:visible.sync="addInvoice2"
			width="40%"
			>
			<div id="Concents">
				<p class="same"><span class="spa"><i>* </i>公司名称：</span><input  @change="changeWarning(1)" type="text" v-model="addValueInfo.company_name"/><el-alert v-show="tip.tip1" title="请完善公司名称" type="error" show-icon :closable="false"></el-alert></p>
				<p class="onther"><span class="spa"><i>* </i>税号：</span><input @change="changeWarning(2)" type="text" v-model="addValueInfo.ein"/><el-alert v-show="tip.tip2" title="请完善税号" type="error" show-icon :closable="false"></el-alert></p>
				<p><span class="spa"><i>* </i>开户银行名称：</span><input @change="changeWarning(3)" type="text" v-model="addValueInfo.opening_bank"/><el-alert v-show="tip.tip3" title="请完善开户银行名称" type="error" show-icon :closable="false"></el-alert></p>
				<p><span class="spa"><i>* </i>开户银行账户：</span><input @change="changeWarning(4)" type="text" v-model="addValueInfo.bank_account"/><el-alert v-show="tip.tip4" title="银行账号格式错误" type="error" show-icon :closable="false"></el-alert></p>
				<p class="same">
					<span class="spa"><i>* </i>注册地址：</span><select v-model="selectProvId" @change="getCityArea(selectProvId,'city','c')">
						<option v-if="selectProvId == '请选择'" value="请选择">请选择</option>
						<option :value="item.id" v-for="(item,index) in provList" :key="index">{{item.name}}</option>
					</select>
					<select v-model="selectCityId" @change="getCityArea(selectCityId,'area','t')">
						<option v-if="selectCityId == '请选择'" value="请选择">请选择</option>
						<option :value="item.id" v-for="(item,index) in cityList" :key="index">{{item.name}}</option>
					</select>
					<select v-model="selectAreaId" @change="changeWarning(5)">
						<option v-if="selectAreaId=='请选择'" value="请选择">请选择</option>
						<option :value="item.id" v-for="(item,index) in areaList" :key="index">{{item.name}}</option>
					</select>
					<el-alert v-show="tip.tip5" class="address-tip" title="请完善地址" type="error" show-icon :closable="false"></el-alert>
				</p>
				<p class="same"><span class="spa"><i>* </i>详细地址：</span><input @change="changeWarning(6)" type="text" v-model="addValueInfo.register_address"/><el-alert v-show="tip.tip6" title="请输入详细地址" type="error" show-icon :closable="false"></el-alert></p>
				<p class="same"><span class="spa"><i>* </i>注册电话：</span><input @change="changeWarning(7)" maxlength="11" type="text" v-model="addValueInfo.register_tel"/><el-alert v-show="tip.tip7" title="请输入正确的号码" type="error" show-icon :closable="false"></el-alert></p>
				<button class="span" @click="preserve">保存</button>
				<button class="span" @click="off">取消</button>
			</div>
		</el-dialog>
	</div>
</template>

<script>
export default {
  data() {
    return {
      title: "新增",
      invoiceInfo: [],
      capitaList: [],
      addInvoice: false,
      addInvoice2: false,
      isLine: 0,
      Data: "",
      provList: [], //省级列表
      selectProvId: "",
      cityList: [], //市列表
      selectCityId: "",
      areaList: [], //区列表
      selectAreaId: "",
      operation: false, //是添加或者是修改
      tip: {
        tip1: false,
        tip2: false,
        tip3: false,
        tip4: false,
        tip5: false,
        tip6: false,
        tip7: false
      },
      addValueInfo: {} //单条增值发票信息
    };
  },
  created() {
    this.getInvoiceInfo();
  },
  methods: {
    cancel() {
      this.addInvoice = false;
    },
    Hit(index) {
      if (index == 0) {
        this.getInvoiceInfo();
      } else {
        this.getCapitaList();
      }
      this.isLine = index;
    },
    //输入框改变时的验证
    changeWarning(sign) {
      switch (sign) {
        case 1:
          if (this.addValueInfo.company_name != "") {
            this.$set(this.tip, "tip1", false);
          }
          break;
        case 2:
          if (this.addValueInfo.ein != "") {
            this.$set(this.tip, "tip2", false);
          }
          break;
        case 3:
          if (this.addValueInfo.opening_bank != "") {
            this.$set(this.tip, "tip3", false);
          }
          break;
        case 4:
          if (/^[1-9](\d{15})|\d{18}$/.test(this.addValueInfo.bank_account)) {
            this.$set(this.tip, "tip4", false);
          }
          break;
        case 5:
          if (this.selectCityId != "请选择" && this.selectAreaId != "请选择") {
            this.$set(this.tip, "tip5", false);
          }
          break;
        case 6:
          if (this.addValueInfo.register_address != "") {
            this.$set(this.tip, "tip6", false);
          }
          break;
        case 7:
          if (/^1[345789]\d{9}$/.test(this.addValueInfo.register_tel)) {
            this.$set(this.tip, "tip7", false);
          }
          break;
      }
    },
    //获取省
    getProvince() {
      this.HTTP(this.$httpConfig.regionLists, {parent_id:0}, "post").then(res => {
        this.provList = res.data;
      });
    },
    //获取市区
    getCityArea(id, name, status) {
      this.HTTP(
        this.$httpConfig.regionLists,
        {
          parent_id: id
        },
        "post"
      ).then(res => {
        if (status == "c") {
          this.selectCityId = "请选择";
          this.selectAreaId = "请选择";
          this.areaList = [];
        } else if (status == "t") {
          this.selectAreaId = "请选择";
        }
        if (name == "city") {
          this.cityList = res.data;
        } else if (name == "area") {
          this.areaList = res.data;
        }
      }).catch((e)=>{
        console.log(e)
      });
    },
    //获取单条增值发票信息
    edit(id) {
      this.title = "修改";
      this.operation = false;
      this.initTip();
      this.selectCityId = "";
      this.selectAreaId = "";
      this.HTTP(
        this.$httpConfig.capitaDetails,
        {
          id: id
        },
        "post"
      ).then(res => {
        this.addValueInfo = res.data;
        this.getProvince();
        this.getCityArea(this.addValueInfo.prov_id, "city"); //根据省id去获取市列表
        this.getCityArea(this.addValueInfo.city_id, "area"); //根据市id去获取区列表
        this.selectProvId = this.addValueInfo.prov_id;
        this.selectCityId = this.addValueInfo.city_id;
        this.selectAreaId = this.addValueInfo.dist_id;
        this.addInvoice2 = true;
      }).catch((e)=>{
        console.log(e)
      });
    },
    getInvoiceInfo() {
      this.HTTP(this.$httpConfig.getInvoiceAreRaised, {}, "post").then(res => {
        this.invoiceInfo = res.data;
      }).catch((e)=>{
        console.log(e)
      });
    },
    getCapitaList() {
      this.HTTP(this.$httpConfig.capitaList, {}, "post").then(res => {
        this.capitaList = res.data;
      }).catch((e)=>{
        console.log(e)
      });
    },
    New() {
      this.addInvoice = true;
      this.Data = "";
    },
    News() {
      this.title = "新增";
      this.operation = true;
      this.addInvoice2 = true;
      this.getProvince(); //获取省
      this.selectProvId = "请选择";
      this.selectCityId = "请选择";
      this.selectAreaId = "请选择";
      this.cityList = [];
      this.areaList = [];
      this.initTip();
      this.addValueInfo = {
        register_address: "",
        company_name: "",
        ein: "",
        opening_bank: "",
        bank_account: "",
        register_tel: ""
      };
    },
    submit() {
      if (this.Data == "") {
        this.$message({
          message: "请填写发票抬头"
        });
      } else {
        this.HTTP(
          this.$httpConfig.invoicesAreRaisedAdd,
          {
            name: this.Data
          },
          "post"
        ).then(res => {
          this.getInvoiceInfo();
          this.addInvoice = false;
        }).catch((e)=>{
          console.log(e)
        });
      }
    },
    //初始化提示信息
    initTip() {
      for (const key in this.tip) {
        this.tip[key] = false;
      }
    },
    // 确定
    preserve() {
      if (this.addValueInfo.company_name == "") {
        this.$set(this.tip, "tip1", true);
      }
      if (this.addValueInfo.ein == "") {
        this.$set(this.tip, "tip2", true);
      }
      if (this.addValueInfo.opening_bank == "") {
        this.$set(this.tip, "tip3", true);
      }
      if (!/^[1-9](\d{15})|\d{18}$/.test(this.addValueInfo.bank_account)) {
        this.$set(this.tip, "tip4", true);
      }
      if (this.selectCityId == "请选择" || this.selectAreaId == "请选择") {
        this.$set(this.tip, "tip5", true);
      }
      if (this.addValueInfo.register_address == "") {
        this.$set(this.tip, "tip6", true);
      }
      if (!/(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}/.test(this.addValueInfo.register_tel)) {
        this.$set(this.tip, "tip7", true);
      }
      for (const key in this.tip) {
        if (this.tip[key] == true) {
          return;
        }
      }
      if (this.operation == true) {
        // 添加
        this.HTTP(
          this.$httpConfig.capitaAdd,
          {
            register_address: this.addValueInfo.register_address,
            company_name: this.addValueInfo.company_name,
            opening_bank: this.addValueInfo.opening_bank,
            ein: this.addValueInfo.ein,
            bank_account: this.addValueInfo.bank_account,
            register_tel: this.addValueInfo.register_tel,
            prov_id: this.selectProvId,
            city_id: this.selectCityId,
            dist_id: this.selectAreaId
          },
          "post"
        ).then(res => {
          this.addInvoice2 = false;
          this.getCapitaList();
        }).catch((e)=>{
          console.log(e)
        });
      } else {
        //修改
        this.HTTP(
          this.$httpConfig.capitaSave,
          {
            id: this.addValueInfo.id,
            register_address: this.addValueInfo.register_address,
            company_name: this.addValueInfo.company_name,
            opening_bank: this.addValueInfo.opening_bank,
            ein: this.addValueInfo.ein,
            bank_account: this.addValueInfo.bank_account,
            register_tel: this.addValueInfo.register_tel,
            prov_id: this.selectProvId,
            city_id: this.selectCityId,
            dist_id: this.selectAreaId
          },
          "post"
        ).then(res => {
          this.addInvoice2 = false;
          this.getCapitaList();
        }).catch((e)=>{
          console.log(e)
        });
      }
    },
    off() {
      this.addInvoice2 = false;
    },
    //删除发票抬头
    del(index) {
      this.HTTP(
        this.$httpConfig.invoicesAreRaisedDelete,
        {
          id: this.invoiceInfo[index].id
        },
        "post"
      ).then(res => {
        this.invoiceInfo.splice(index, 1);
      }).catch((e)=>{
        console.log(e)
      });
    },
    // 修改发票抬头
    modify(index) {
      this.HTTP(
        this.$httpConfig.invoicesAreRaisedSave,
        {
          id: this.invoiceInfo[index].id,
          name: this.invoiceInfo[index].name
        },
        "post"
      ).then(res => {

      }).catch((e)=>{
        console.log(e)
      });
    },
    //增值发票删除
    Delete(index) {
      this.HTTP(
        this.$httpConfig.capitaDelete,
        {
          id: this.capitaList[index].id
        },
        "post"
      ).then(res => {
        this.capitaList.splice(index, 1);
      }).catch((e)=>{
        console.log(e)
      });
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
.invoice_info {
  height: 956px;
  width: 980px;
  background: #fff;
  margin: 16px 0;
  .top {
    overflow: hidden;
    margin: 14px 17px 20px;
    border-bottom: 1px solid #e7e7e7;
    height: 37px;
    li {
      float: left;
      cursor: pointer;
      height: 36px;
      color: #666;
      width: 122px;
      p {
        height: 16px;
        border-right: 1px solid #e7e7e7;
        text-align: center;
        margin-top: 10px;
        font-size: 12px;
        span {
          color: red;
        }
      }
    }
    li:nth-of-type(2) {
      width: 168px;
      p {
        border-right: 0;
      }
    }
    .line {
      color: red;
      border-bottom: 1px solid red;
    }
  }
  .xinzeng {
    width: 100px;
    height: 32px;
    line-height: 32px;
    text-align: center;
    color: #fff;
    background: #ffaa45;
    border-radius: 4px;
    margin-left: 17px;
    font-size: 12px;
    cursor: pointer;
  }
  .under {
    margin: 19px 0 0 17px;
    overflow: hidden;
    .fapiao {
      width: 338px;
      height: 86px;
      border: 1px solid #cdcdcd;
      background: #f5f5f5;
      margin-right: 51px;
      float: left;
      margin-bottom: 10px;
      input {
        display: block;
        width: 276px;
        height: 32px;
        line-height: 32px;
        border: 1px solid #cdcdcd;
        background: #fff;
        margin: 13px 0 12px 9px;
        padding-left: 10px;
        font-size: 12px;
        color: #747474;
      }
      span {
        margin-left: 11px;
        font-size: 12px;
        cursor: pointer;
        color: #5fa0dc;
      }
      span:nth-of-type(2) {
        color: #d3a43f;
      }
    }
  }
  .unders {
    margin: 19px 0 17px;
    overflow: hidden;
    .fapiao {
      width: 338px;
      height: 147px;
      border: 1px solid #cdcdcd;
      background: #f5f5f5;
      float: left;
      margin: 0 51px 10px 20px;
      p {
        font-size: 12px;
        color: #555;
        margin-left: 20px;
        line-height: 26px;
        span {
          margin-left: 84px;
        }
      }
      p:nth-of-type(1) {
        margin-top: 18px;
      }
      .xbox {
        margin-left: 21px;
        margin-top: 20px;
      }
      .span {
        margin-right: 21px;
        font-size: 12px;
        cursor: pointer;
        color: #5fa0dc;
      }
      .span:nth-of-type(2) {
        color: #d3a43f;
      }
    }
  }
}
#Concent {
  margin-bottom: 20px;
  overflow: hidden;
  p.top {
    font-size: 12px;
    color: #666;
  }
  input {
    padding-left: 10px;
    width: 287px;
    height: 30px;
    border: 1px solid #ccc;
  }
  button {
    border: 1px solid #d0d0d0;
    background: #eaeaea;
    cursor: pointer;
    float: left;
    border-radius: 4px;
    font-size: 12px;
    width: 72px;
    height: 32px;
    text-align: center;
    line-height: 32px;
    margin-top: 19px;
  }
  button:nth-of-type(1) {
    background: red;
    border: 1px solid red;
    color: #fff;
    margin: 19px 8px 0px 85px;
  }
  span:nth-of-type(2) {
    background: #eaeaea;
    color: #666;
    border: 1px solid #cdcdcd;
  }
}
#Concents {
  margin-bottom: 20px;
  overflow: hidden;
  margin-top: 10px;
  p {
    min-width: 545px;
    .el-alert {
      float: left;
      margin-left: 15px;
      width: 150px;
      padding: 0;
    }
    .el-alert--error {
      background-color: transparent;
    }
    .address-tip {
      width: 100px;
    }
  }
  p:after {
    display: block;
    content: "";
    clear: both;
    *zoom: 1; /*IE/7/6*/
  }
  input {
    float: left;
    padding-left: 10px;
    width: 281px;
    height: 24px;
    border: 1px solid #ccc;
  }
  .spa {
    float: left;
    margin-right: 4px;
    i {
      font-style: normal;
      color: #ff0000;
    }
  }
  p {
    font-size: 12px;
    color: #666;
    margin-bottom: 15px;
  }
  .span {
    border: 1px solid #d0d0d0;
    background: #eaeaea;
    cursor: pointer;
    float: left;
    border-radius: 4px;
    font-size: 12px;
    width: 72px;
    height: 32px;
    text-align: center;
    line-height: 32px;
    margin-top: 19px;
  }
  .span:nth-of-type(1) {
    border: 1px solid red;
    background: red;
    color: #fff;
    margin: 19px 8px 0px 92px;
  }
  span:nth-of-type(2) {
    background: #eaeaea;
    color: #666;
    border: 1px solid #cdcdcd;
  }
  .same {
    margin-left: 24px;
  }
  .onther {
    margin-left: 48px;
  }
  select {
    float: left;
    outline: none;
    min-width: 108px;
    min-height: 30px;
    margin-left: 5px;
  }
  select:first-child {
    margin: 0;
  }
}
</style>