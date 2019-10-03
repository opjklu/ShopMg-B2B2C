<template>
  <div id="interview">
    <logo-component></logo-component>
    <openStoreLogo></openStoreLogo>

    <div class="middle">
      <div class="center">
        <div class="Box">
          <img src="../../../assets/img/deng.png" />
          <span class="spa">注意事项</span>
          <span>以下所需要上传的电子版资质文件仅支持JPG\GIF\PNG格式图片，大小请控制在1M之内。</span>
        </div>
        <div class="show">
          <div class="top">
            <h1>店铺及联系人信息</h1>
            <p class="four">
              <span class="span">*</span>店铺名称 :
              <el-input size="small" @change="changeWarning(1)" v-model="store_name"></el-input>
              <el-alert v-if="tip.tip1" title="请填写店铺名称" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="three">
              <span class="span">*</span>所在地 :
              <select
                class="behind address"
                v-model="selectProvId"
                @change="getCityArea(selectProvId,'city','c')"
              >
                <option v-if="selectProvId == '请选择'" value="请选择">请选择</option>
                <option
                  :value="item.id"
                  v-for="(item,index) in provList"
                  :key="index"
                >{{ item.name }}</option>
              </select>
              <select
                class="behind"
                v-model="selectCityId"
                @change="getCityArea(selectCityId,'area','t')"
              >
                <option v-if="selectCityId == '请选择'" value="请选择">请选择</option>
                <option :value="item.id" v-for="(item,index) in cityList" :key="index">{{item.name}}</option>
              </select>
              <select class="behind" v-model="selectAreaId" @change="changeWarning(2)">
                <option v-if="selectAreaId=='请选择'" value="请选择">请选择</option>
                <option :value="item.id" v-for="(item,index) in areaList" :key="index">{{item.name}}</option>
              </select>
              <el-alert v-if="tip.tip2" title="请完善地址" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="four">
              <span class="span">*</span>详细地址 :
              <el-input size="small" @change="changeWarning(3)" v-model="store_address"></el-input>
              <el-alert v-if="tip.tip3" title="请完善详细地址" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="five">
              <span class="span">*</span>联系人手机 :
              <el-input size="small" @change="changeWarning(4)" v-model="mobile"></el-input>
              <el-alert v-if="tip.tip4" title="请输入正确的手机号" type="error" show-icon :closable="false"></el-alert>
            </p>
          </div>
          <div class="bottom">
            <h1>身份证信息</h1>
            <p class="two">
              <span class="span">*</span>姓名 :
              <el-input size="small" @change="changeWarning(5)" v-model="person_name"></el-input>
              <el-alert v-if="tip.tip5" title="请输入姓名" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="four">
              <span class="span">*</span>身份证号 :
              <el-input size="small" @change="changeWarning(6)" v-model="id_card"></el-input>
              <el-alert
                v-if="tip.tip6"
                title="请输入正确的身份证号码"
                type="error"
                show-icon
                :closable="false"
              ></el-alert>
            </p>
            <p class="five">
              <span class="span">*</span>身份证类型 :
              <select name>
                <option value>二代身份证</option>
              </select>
            </p>
            <div class="both">
              <p class="l">
                <span class="span">*</span>身份证正面照 :
              </p>
              <span class="l photo same">
                <input v-if="uploadShow" @change="addIdImg($event,1)" class="upload" type="file" />
                <img @click="del(0)" v-else :src="URL + positive" />
                <div class="load-animation" v-show="load1">
                  上传中
                  <i class="el-icon-loading"></i>
                </div>
              </span>
              <p class="l">实例：</p>
              <p class="l photos same">
                <img src="../../../assets/img/photo.png" />
              </p>
              <el-alert
                v-if="tip.tip7"
                title="请上传正确的身份证正面照"
                type="error"
                show-icon
                :closable="false"
              ></el-alert>
            </div>
            <div class="jianyi">图片建议使用4：3比例，尺寸建议为1200*900像素jpg、gif、png格式的图片，并且图片大小不可超过2M。</div>
            <div class="both">
              <p class="l">
                <span class="span">*</span>身份证背面照 :
              </p>
              <span class="l photo same">
                <input v-if="uploadShow1" @change="addIdImg($event,2)" class="upload" type="file" />
                <img @click="del(1)" v-else :src="URL + back" />
                <div class="load-animation" v-show="load2">
                  上传中
                  <i class="el-icon-loading"></i>
                </div>
              </span>
              <p class="l">实例：</p>
              <p class="l photos same">
                <img src="../../../assets/img/photo.png" />
              </p>
              <el-alert
                v-if="tip.tip8"
                title="请上传正确的身份证背面照"
                type="error"
                show-icon
                :closable="false"
              ></el-alert>
            </div>
            <div class="jianyi">图片建议使用4：3比例，尺寸建议为1200*900像素jpg、gif、png格式的图片，并且图片大小不可超过2M。</div>
          </div>
          <div class="top clear-boot">
            <h1>打款信息</h1>
            <p class="two">
              <span class="span">*</span>微信 :
              <el-input size="small" @change="changeWarning(7)" v-model="wx_account"></el-input>
              <el-alert v-if="tip.tip9" title="请填写微信账号" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="three">
              <span class="span">*</span>支付宝 :
              <el-input size="small" @change="changeWarning(8)" v-model="alipay_account"></el-input>
              <el-alert v-if="tip.tip10" title="请填写支付宝账号" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="three">
              <span class="span">*</span>开户行 :
              <el-input size="small" @change="changeWarning(9)" v-model="bank_name"></el-input>
              <el-alert v-if="tip.tip11" title="请输入开户行" type="error" show-icon :closable="false"></el-alert>
            </p>
            <p class="four">
              <span class="span">*</span>银行卡号 :
              <el-input size="small" @change="changeWarning(10)" v-model="bank_account"></el-input>
              <el-alert
                v-if="tip.tip12"
                title="请输入正确的银行卡号"
                type="error"
                show-icon
                :closable="false"
              ></el-alert>
            </p>
          </div>
          <div class="base">
            <p>您提供的身份信息，网站将予以保护，不会挪作他用</p>
            <!-- <button>上一步</button> -->
            <button @click="next">下一步</button>
          </div>
        </div>
      </div>
    </div>
    <sign></sign>
  </div>
</template>

<script>
import uploadOneImage from "../../../common/uploadOneImage.vue";
export default {
  data() {
    return {
      uploadShow: true,
      uploadShow1: true,
      provList: [], //省级列表
      selectProvId: "请选择",
      cityList: [], //市列表
      selectCityId: "请选择",
      areaList: [], //区列表
      selectAreaId: "请选择",
      tip: {
        tip1: false,
        tip2: false,
        tip3: false,
        tip4: false,
        tip5: false,
        tip6: false,
        tip7: false,
        tip8: false,
        tip9: false,
        tip10: false,
        tip11: false,
        tip12: false
      },
      load1: false,
      load2: false,
      positive: "",
      back: "",
      store_name: "",
      store_address: "",
      mobile: "",
      person_name: "",
      id_card: "",
      wx_account: "",
      alipay_account: "",
      bank_account: "",
      bank_name: "",
      id: null,
      address_id: null,
      name: /^[\u4E00-\u9FA5\uf900-\ufa2d·s]{2,20}$/,
      imgData: {
        accept: "image/gif, image/jpeg, image/png, image/jpg"
      },
      editInfo: []
    };
  },
  watch: {
    positive() {
      if (this.positive != "") {
        this.$set(this.tip, "tip7", false);
      }
    },
    back() {
      if (this.back != "") {
        this.$set(this.tip, "tip8", false);
      }
    }
  },
  components: {
    uploadOneImage,
    sign: () => import("../../../common/sign"),
    openStoreLogo: () => import("../../../common/opStoreLogo")
  },
  created() {
    this.getProvince();

    this.editInfo = JSON.parse(sessionStorage.getItem("redact"));
    if (this.editInfo.length != 0) {
      this.store_name = this.editInfo.store_name; //店铺名
      this.person_name = this.editInfo.person_name; //姓
      this.id_card = this.editInfo.id_card; //身份证号
      this.mobile = this.editInfo.mobile; //联系方式
      this.wx_account = this.editInfo.wx_account; //微信
      this.alipay_account = this.editInfo.alipay_account; //支付宝
      this.bank_account = this.editInfo.bank_account; //开户行
      this.bank_name = this.editInfo.bank_name; //银行卡
      this.positive = this.editInfo.idcard_positive; //身份类正面
      this.uploadShow = false;
      this.back = this.editInfo.other_side; //反面
      this.uploadShow1 = false;
      this.id = this.editInfo.id;
    }
    this.queryStoreInformation();
    // this.getCityArea();
  },

  methods: {
    getStoreType() {
      return "个人开店申请";
    },
    //判断是否填写过信息
    queryStoreInformation() {
      this.HTTP(
        this.$httpConfig.getSAtoreAddress,
        { store_id: this.editInfo.id },
        "post"
      )
        .then(res => {
          if (res.data.message == "成功") {
            this.selectProvId = res.data.data.prov; //省
            this.selectCityId = parseInt(res.data.data.city); //市
            this.selectAreaId = parseInt(res.data.data.dist); //县/区
            this.store_address = res.data.data.address; //详细
            this.getCityArea(this.selectProvId, "city"); //调用市
            this.getCityArea(this.selectCityId, "area"); //调用区
            this.address_id = res.data.data.id;
          } else {
            return;
          }
        })
        .catch(e => {});
    },
    getTitle() {
      return "招商入住";
    },
    del(t) {
      let image = "";
      if (t === 0) {
        image = this.positive;
      } else {
        image = this.back;
      }
      this.HTTP(
        this.$httpConfig.delPic,
        {
          fileName: image
        },
        "post"
      )
        .then(res => {
          if (t == 0) {
            this.uploadShow = true;
            this.positive = "";
          } else {
            this.uploadShow1 = true;
            this.back = "";
          }
        })
        .catch(res => {
          alert(res.data.message);
        });
    },
    addIdImg(e, s) {
      let that = this;
      let file = e.target.files[0];
      let type = file.type;
      if (this.imgData.accept.indexOf(type) == -1) {
        if (s == 1) {
          this.$set(this.tip, "tip7", true);
        } else {
          this.$set(this.tip, "tip8", true);
        }
        return false;
      }
      if (s == 1) {
        this.load1 = true;
      } else {
        this.load2 = true;
      }
      let form = new FormData();
      form.append("adv_content", file, file.name);
      let config = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };
      this.$ajax.post(this.$httpConfig.upLoadImage, form, config).then(res => {
        if (res.data.status == 10001) {
          this.$router.push("/passwordLogin");
        } else {
          if (res.data.status === 1) {
            if (s == 1) {
              that.positive = res.data.data;
              that.uploadShow = false;
              that.load1 = false;
            } else {
              that.back = res.data.data;
              that.uploadShow1 = false;
              that.load2 = false;
            }
          } else {
            alert(res.data.message);
            if (s == 1) {
              that.load1 = false;
            } else if (s == 2) {
              that.load2 = false;
            }
          }
        }
      });
    },
    //获取省
    getProvince() {
      this.HTTP(
        this.$httpConfig.regionLists,
        {
          parent_id: 0
        },
        "post"
      ).then(res => {
        this.provList = res.data.data;
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
          this.cityList = res.data.data;
          console.log(this.cityList);
        } else if (name == "area") {
          this.areaList = res.data.data;
        }
      });
    },
    changeWarning(sign) {
      switch (sign) {
        case 1:
          if (this.store_name != "") {
            this.$set(this.tip, "tip1", false);
          }
          break;
        case 2:
          if (this.selectCityId != "请选择" && this.selectAreaId != "请选择") {
            this.$set(this.tip, "tip2", false);
          }
          break;
        case 3:
          if (this.store_address != "") {
            this.$set(this.tip, "tip3", false);
          }
          break;
        case 4:
          if (/^1[345789]\d{9}$/.test(this.mobile)) {
            this.$set(this.tip, "tip4", false);
          }
          break;
        case 5:
          if (this.name.test(this.person_name) == true) {
            this.$set(this.tip, "tip5", false);
          }
          break;
        case 6:
          if (/(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(this.id_card)) {
            this.$set(this.tip, "tip6", false);
          }
          break;
        case 7:
          if (this.wx_account) {
            this.$set(this.tip, "tip9", false);
          }
          break;
        case 8:
          if (this.alipay_account) {
            this.$set(this.tip, "tip10", false);
          }
          break;
        case 9:
          if (this.bank_name) {
            this.$set(this.tip, "tip11", false);
          }
          break;
        case 10:
          if (
            this.bank_account.length > 12 &&
            /^[1-9]\d*$/.test(this.bank_account)
          ) {
            this.$set(this.tip, "tip12", false);
          }
          break;
      }
    },
    next() {
      if (this.store_name == "") {
        this.$set(this.tip, "tip1", true);
      }
      if (this.selectCityId == "请选择" || this.selectAreaId == "请选择") {
        this.$set(this.tip, "tip2", true);
      }
      if (this.store_address == "") {
        this.$set(this.tip, "tip3", true);
      }
      if (!/^1[345789]\d{9}$/.test(this.mobile)) {
        this.$set(this.tip, "tip4", true);
      }
      if (this.name.test(this.person_name) == false) {
        this.$set(this.tip, "tip5", true);
      }
      if (!/(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(this.id_card)) {
        this.$set(this.tip, "tip6", true);
      }
      if (this.positive == "") {
        this.$set(this.tip, "tip7", true);
      }
      if (this.back == "") {
        this.$set(this.tip, "tip8", true);
      }
      if (this.wx_account == "") {
        this.$set(this.tip, "tip9", true);
      }
      if (this.alipay_account == "") {
        this.$set(this.tip, "tip10", true);
      }
      if (this.bank_name == "") {
        this.$set(this.tip, "tip11", true);
      }
      if (
        this.bank_account.length < 12 ||
        !/^[1-9]\d*$/.test(this.bank_account)
      ) {
        this.$set(this.tip, "tip12", true);
      }
      for (const key in this.tip) {
        if (this.tip[key] == true) {
          return;
        }
      }
      var params = {
        store_name: this.store_name, //店名
        person_name: this.person_name, //姓名
        id_card: this.id_card, //身份证号
        prov_id: this.selectProvId, //省
        city: this.selectCityId, //市
        dist: this.selectAreaId, //区
        address: this.store_address, //具体地址
        mobile: this.mobile, //联系方式
        wx_account: this.wx_account, //微信
        alipay_account: this.alipay_account, //支付宝
        bank_account: this.bank_account, //银行卡号
        bank_name: this.bank_name, //银行名
        idcard_positive: this.positive, //身份证正面
        other_side: this.back, //反面
        id: this.id, //主键
        address_id: this.address_id //地址id
      };
      console.log(params);
      this.HTTP(this.$httpConfig.editPersonEnter, params, "post")
        .then(res => {
          this.$router.push("halfwayTwo");
        })
        .catch(res => {
          this.$message.error(res.data.message);
        });
    }
  }
};
</script>

<style lang='less' scoped>
.el-input {
  width: 286px;
  margin-left: 31px;
}

.center {
  width: 1200px;
  height: 100%;
  margin: 0 auto;
}

.load-animation {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: #060606;
  text-align: center;
  padding: 45px 0;
  opacity: 0.4;
  font-size: 14px;
  color: #fff;
}

.l {
  float: left;
}

.r {
  float: right;
}

.middle {
  background: #fafafa;
  min-height: 973px;
  padding: 20px 0;
  .center {
    background: #fff;
    overflow: hidden;
    .el-alert {
      display: inline;
      margin-left: 15px;
      padding: 0;
    }
    .el-alert--error {
      background-color: transparent;
    }
    .Box {
      height: 97px;
      border: 1px solid #bce8f1;
      background: #eff8ff;
      margin: 51px 110px 33px;
      img {
        margin: 27px 16px 0 40px;
        float: left;
      }
      span {
        font-size: 12px;
        color: #b1b4b6;
        float: left;
        width: 70%;
      }
      .spa {
        color: #333;
        font-size: 14px;
        margin: 25px 0 3px;
      }
    }
    input {
      padding-left: 8px;
      width: 286px;
      height: 30px;
      border: 1px solid #ccc;
      margin-left: 31px;
    }
    select {
      margin-left: 31px;
      min-width: 286px;
      height: 30px;
      border: 1px solid #ccc;
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
        margin-bottom: 20px;
        line-height: 32px;
      }
      p.four {
        margin-left: 118px;
      }
      p.three {
        margin-left: 131px;
        .address {
          margin-left: 31px !important;
        }
        .behind {
          margin-left: 10px;
          min-width: 100px !important;
        }
      }
      p.five {
        margin-left: 107px;
      }
      p.two {
        margin-left: 142px;
      }
      .top {
        height: 274px;
        border-bottom: 1px dashed #d7d7d7;
        margin-bottom: 40px;
      }
      .clear-boot {
        margin-bottom: 0;
      }
      .Top {
        height: 272px;
        button {
          cursor: pointer;
          width: 94px;
          height: 32px;
          border-radius: 4px;
          text-align: center;
          line-height: 32px;
          color: #fff;
          font-size: 12px;
          background: red;
          margin-left: 225px;
        }
      }
      .bottom {
        height: 576px;
        border-bottom: 1px dashed #d7d7d7;
        margin-bottom: 40px;
        p.five {
          select {
            width: 183px;
          }
        }
        .both {
          margin-left: 96px;
          overflow: hidden;
          font-size: 12px;
          color: #666;
          .same {
            width: 163px;
            height: 122px;
            position: relative;
          }
          .photo {
            background: url(../../../assets/img/shangchuan.png) no-repeat 50%
              50%;
            border: 1px dashed #ccc;
            margin: 0 42px 0 31px;
            .upload {
              margin: 0;
              width: 100%;
              height: 100%;
              opacity: 0;
            }
            img {
              display: block;
              width: 100%;
              height: 100%;
              background-color: #fff;
            }
          }
          .photos {
            border: 1px solid #ccc;
            img {
              width: 100%;
              height: 100%;
            }
          }
        }
        .jianyi {
          margin-left: 215px;
          color: #999;
          font-size: 12px;
          margin-bottom: 28px;
        }
      }
      .base {
        height: 206px;
        p {
          margin: 20px 0 20px 216px;
          font-size: 12px;
          color: #666;
        }
        button {
          cursor: pointer;
          width: 94px;
          height: 32px;
          border-radius: 4px;
          text-align: center;
          line-height: 32px;
          color: #fff;
          font-size: 12px;
          margin-left: 215px;
          background: red;
        }
      }
      .under {
        line-height: 38px;
        background: #f7f7f7;
        border: 1px solid #ddd;
        width: 598px;
        margin: 16px 0 0 213px;
        font-size: 12px;
        color: #767676;
        font-weight: 600;
      }
    }
  }
}

</style>