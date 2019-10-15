<template>
  <div class="personal">
    <ul class="topul">
      <li class="l" @click="fun(0)" :class="{bg:isbg==0}">
        <span>基本信息</span>
      </li>
      <li class="l" @click="fun(1)" :class="{bg:isbg==1}">
        <span>实名认证</span>
      </li>
      <li class="l" @click="fun(2)" :class="{bg:isbg==2}">
        <span>头像信息</span>
      </li>
    </ul>
    <!--基本信息-->
    <div class="xinxi" v-show="hidden==0">
      <el-alert v-if="successShow" title="修改资料成功" type="success" :closable="false" center show-icon></el-alert>
      <p class="touxiang redact">
        当前头像：
        <img :src="URL+userInfo.user_header" v-if="userInfo.user_header">
        <img v-else src="../../../assets/img/default-head.png">
        <span class="hidecom" @click="blockCom">编辑头像</span>
      </p>
      <p class="name">
        会员名称：
        <span class="member_name">{{userInfo.user_name}}</span>
      </p>
      <p class="nicheng">
        <span>*</span>昵称：
        <input type="text" v-model="userInfo.nick_name">
        <el-alert title="昵称不能为空" type="error" v-show="nameShow" show-icon :closable="false"></el-alert>
        <br>
        <span>与平台业务或者店铺名称冲突的昵称，平台将有可能收回</span>
      </p>
      <p class="huiyuan">
        会员等级：
        <span>{{userInfo.level_name}}</span>我的成长值：
        <span>0</span>再积累
        <span>{{userInfo.next_level_integral}}</span>
        成长值即可升级为{{userInfo.next_level_name}}
      </p>
      <p class="xingbie">
        性别：
        <label>
          <input type="radio" name="sex" value="3" v-model="userInfo.sex">保密
        </label>
        <label>
          <input type="radio" name="sex" value="1" v-model="userInfo.sex">男
        </label>
        <label>
          <input type="radio" name="sex" value="0" v-model="userInfo.sex">女
        </label>
      </p>
      <p class="shengri">
        生日：
        <select name="form-control" v-model="year" @change="selectYear">
          <option>年</option>
          <option v-for="i in currentTime" :key="i" v-if="i>=1970">{{i}}</option>
        </select>
        <select name="form-control" v-model="month" @change="selectMonth">
          <option>月</option>
          <option v-for="i in 12" :key="i" v-if="i>0">{{i}}</option>
        </select>
        <select name="form-control" v-model="day">
          <option>日</option>
          <option v-for="i in days" :key="i" v-if="i>0">{{i}}</option>
        </select>
      </p>
      <!-- <p class="zhudi">
							现居住地：
							<select name="">
								<option value="">上海市</option>
							</select>
							<select name="">
								<option value="">上海市</option>
							</select>
							<select name="">
								<option value="">徐家汇</option>
							</select>
						</p>
						<p class="xiangxi">
							<span class="l">详细地址：</span>
							<textarea placeholder="建议您如实填写详细收货地址，例如街道名称，门牌号码，楼层和房间号等信息"></textarea>
      </p>-->
      <button @click="infoSave">保存</button>
      <div class="zhuyi">
        <p>注意事项</p>
        <p>成长值：是会员通过购物所获得的经验值，由累计购物金额计算获得，成长值获得根据确认收货时间计算，成长值按照交易金额的个位数取整计算</p>
        <p>例如：会员的订单是88.2元，则确认收货后可以得到88点成长值</p>
        <img src="../../../assets/img/deng.png">
      </div>
    </div>
    <!--实名认证-->
    <div class="renzheng" v-show="hidden==1">
      <div class="top">
        <p>为什么要进行实名认证?</p>
        <p>实名认证需要网站方管理员人工审核，审核通过后即认证成功。</p>
        <p>实名认证成功后，不可重复认证。</p>
        <img src="../../../assets/img/deng.png">
      </div>
      <p class="name">
        <span class="span">*</span>真实姓名：
        <input type="text" v-model="name">
        <br>
        <span class="l">身份证号码位数为15位或18位</span>
      </p>
      <p class="haoma">
        <span class="span">*</span>身份证号码：
        <input type="text" v-model="idNumber">
      </p>
      <div class="zhengmian both">
        <p class="l">
          <span class="span">*</span>身份证正面照:
        </p>
        <p class="l photo same">
          <el-upload
            class="upload-demo"
            drag
            :with-credentials="true"
            :on-success="frontSucceed"
            accept=".jpg, .png, .gif, .JPG, .GIF, .PNG"
            :action="front()"
            name="idcard_positive"
            multiple
          >
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">点击上传</div>
          </el-upload>
        </p>
        <p class="l">实例：</p>
        <p class="l photos same">
          <img v-if="imGfrontSucceed==''" src="../../../assets/img/photo.png">
          <img v-else :src="URL + imGfrontSucceed" alt>
        </p>
      </div>
      <div class="jianyi">图片建议使用4：3比例，尺寸建议为1200*900像素jpg、gif、png格式的图片，并且图片大小不可超过2M。</div>
      <div class="beimian both">
        <p class="l">
          <span class="span">*</span>身份证背面照:
        </p>
        <p class="l photo same">
          <el-upload
            class="upload-demo"
            drag
            :on-success="contrarySucceed"
            accept=".jpg, .png, .gif, .JPG, .GIF, .PNG"
            :with-credentials="true"
            :action="contrary()"
            name="idcard_side"
            multiple
          >
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">点击上传</div>
            <!-- <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div> -->
          </el-upload>
        </p>
        <p class="l">实例：</p>
        <p class="l photos same">
          <img v-if="imGcontrarySucceed==''" src="../../../assets/img/photo.png">
          <img v-else :src="URL + imGcontrarySucceed" alt>
        </p>
      </div>
      <div class="jianyi">图片建议使用4：3比例，尺寸建议为1200*900像素jpg、gif、png格式的图片，并且图片大小不可超过2M。</div>
      <button @click="identityInformation">保存</button>
    </div>
    <!--头像信息-->
    <div class="touxiang" v-show="hidden==2">
      <div class="top">
        <span class="l">
          <input @change="imgChange($event)" type="file">
          <img src="../../../assets/img/wenjian.png">本地上传
        </span>
        <span class="l">
          <img src="../../../assets/img/paozhao.png">拍照上传
        </span>
      </div>
      <div class="jianyi">仅支持JPG、JPEG、PNG图片文件，且文件小于5M，建议使用正方形图片</div>
      <div class="git">
        <div class="lefts l">
          <div class="img-cont">
            <img
              width="150px"
              height="150px"
              :src="URL+userInfo.user_header"
              v-if="userInfo.user_header"
            >
            <img v-else width="150px" height="150px" src="../../../assets/img/default-head.png" alt>
          </div>
        </div>
        <div class="right l">
          <p>您上传的头像会自动生成4种尺寸，请注意中小尺寸 的头像是否清晰：</p>
          <ul class="rightul">
            <li class="l">
              <span>
                <img :src="URL+userInfo.user_header" v-if="userInfo.user_header">
                <img v-else src="../../../assets/img/default-head.png">
              </span>
              <br>100*100像素
            </li>
            <li class="l">
              <span>
                <img :src="URL+userInfo.user_header" v-if="userInfo.user_header">
                <img v-else src="../../../assets/img/default-head.png">
              </span>
              <br>80*80像素
            </li>
            <li class="l">
              <span>
                <img :src="URL+userInfo.user_header" v-if="userInfo.user_header">
                <img v-else src="../../../assets/img/default-head.png">
              </span>
              <br>50*50像素
            </li>
            <li class="l">
              <span>
                <img :src="URL+userInfo.user_header" v-if="userInfo.user_header">
                <img v-else src="../../../assets/img/default-head.png">
              </span>
              <br>30*30像素
            </li>
          </ul>
        </div>
      </div>
      <button @click="head" :class="{active:prohibit}">保存</button>
    </div>
  </div>
</template>

<script>
export default {
  inject: ["reload"], // 引入方法
  data() {
    return {
      name: "",
      idNumber: "",
      imGfrontSucceed: "", //正面图
      imGcontrarySucceed: "", //反面图
      // 身份证↑
      userInfo: {},
      hidden: "",
      isbg: "",
      token: "",
      currentTime: new Date().getFullYear(),
      year: "年",
      month: "月",
      day: "日",
      days: 31,
      nameShow: false,
      successShow: false,
      pjtid: "",
      accept: "image/gif, image/jpeg, image/png, image/jpg",
      prohibit: true
    };
  },
  created() {
    this.pjtid = this.$route.query.t;
    window.onbeforeunload = () => {
      sessionStorage.removeItem("successShow");
    };
    this.getInfo();
    if (sessionStorage.getItem("successShow")) {
      this.successShow = sessionStorage.getItem("successShow");
    }
  },
  watch: {
    pjtid() {
      sessionStorage.removeItem("successShow");
    }
  },
  methods: {
    // 保存身份信息
    identityInformation() {
      var reg = /^[1-9]\d{5}(18|19|20)\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/; //身份证号正则
      if (
        this.name != "" &&
        reg.test(this.idNumber) &&
        this.imGfrontSucceed != "" &&
        this.imGcontrarySucceed != ""
      ) {
        this.HTTP(
          this.$httpConfig.getidentityAuthentication,
          {
            card_positive: this.imGfrontSucceed,
            card_side: this.imGcontrarySucceed,
            person_name: this.name,
            id_card: this.idNumber
          },
          "post"
        )
          .then(res => {
            this.$message.success(res.message);
            this.hidden = 0;
          })
          .catch(err => {
            this.$message.error(err.data.message);
          });
      } else {
        this.$message.error("您的信息不完整或不正确，请重新认证");
      }
    },
    // 反面上传成功
    contrarySucceed(response, file, fileList) {
      this.imGcontrarySucceed = response.data;
    },
    // 正面上传成功
    frontSucceed(response, file, fileList) {
      this.imGfrontSucceed = response.data;
    },
    //正面路径
    front() {
      return this.$httpConfig.getuploadIdCard;
    },
    // 反面路径
    contrary() {
      return this.$httpConfig.getuploadIdCardSide;
    },
    // 上传图片
    status(e) {},
    //编辑头像
    blockCom() {
      this.hidden = 2;
      this.isbg = 2;
    },
    //保存头像
    head() {
      if (this.prohibit === false) {
        this.HTTP(
          this.$httpConfig.parseuserHeader,
          {
            user_header: this.userInfo.user_header
          },
          "post"
        )
          .then(res => {
            if (res.message == "成功") {
              this.$message(res.message);
              this.hidden = 0;
              this.isbg = 0;
            } else {
              this.$message("上传失败");
            }
          })
          .catch(() => {});
      }
    },
    imgChange(e) {
      let reader = new FileReader();
      let img1 = event.target.files[0];
      let type = img1.type; //文件的类型，判断是否是图片
      let size = img1.size; //文件的大小，判断图片的大小
      if (this.accept.indexOf(type) == -1) {
        alert("请选择我们支持的图片格式！");
        return false;
      }
      if (size > 5241880) {
        alert("请选择5M以内的图片！");
        return false;
      }
      var uri = "";
      let form = new FormData();
      form.append("header_content", img1, img1.name);
      let config = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };
      //上传头像
      this.$ajax
        .post(this.$httpConfig.uploadPicture, form, config)
        .then(res => {
          if (res.status == 10001) {
            this.$router.push("/passwordLogin");
          } else {
            if (res.status === 1) {
              this.$message.info(res.message);
              this.prohibit = false;
              this.userInfo.user_header = res.data;
            } else {
              this.$message.info(res.message);
            }
          }
        });
    },
    infoSave() {
      if (!this.userInfo.nick_name) {
        this.nameShow = true;
        return;
      } else {
        this.nameShow = false;
      }
      let date = `${this.year}-${this.month}-${this.day}`;
      let time = new Date(date).getTime() / 1000;
      if (date == "1970-1-1") {
        time = 0;
      }
      if (isNaN(time)) {
        time = "";
      }
      this.HTTP(
        this.$httpConfig.userInfoEdit,
        {
          nick_name: this.userInfo.nick_name,
          sex: this.userInfo.sex,
          birthday: time
        },
        "post"
      ).then(res => {
        this.reload(); //刷新
        sessionStorage.setItem("successShow", true);
      });
    },
    selectYear() {
      this.month = "月";
      this.day = "日";
      if (this.year == "年") return;
    },
    selectMonth() {
      this.day = "日";
      if (this.month == "月") return;
      if (this.month == 2) {
        //如果是闰年
        if (
          (this.year % 4 === 0 && this.year % 100 !== 0) ||
          this.year % 400 === 0
        ) {
          this.days = 29;
          //如果是平年
        } else {
          this.days = 28;
        }
        //如果是第4、6、9、11月
      } else if (
        this.month == 4 ||
        this.month == 6 ||
        this.month == 9 ||
        this.month == 11
      ) {
        this.days = 30;
      } else {
        this.days = 31;
      }
    },
    getInfo() {
      this.HTTP(this.$httpConfig.userInfo, {}, "post").then(res => {
        this.userInfo = res.data;
        this.year = res.data.year;
        this.month = this.handleDate(res.data.month);
        this.day = this.handleDate(res.data.day);
      });
    },
    handleDate(date) {
      return (date = date[0] == "0" ? date.slice(1) : date);
    },
    fun(index) {
      this.isbg = index;
      this.hidden = index;
      //		  		this.$ajax({
      //		  			method:"get",
      //		  			url:this.$httpConfig.userinfo,
      //
      //		  		})
      //		  		.then((res) => {
      //					console.log(res.data);
      //
      //				}).catch((err) => {
      //					console.log(err)
      //				});
    }
  }
};
</script>
<style>
.el-upload--picture-card {
  width: 160px;
  height: 120px;
}
.el-upload-dragger {
  width: 162px !important;
  height: 120px !important;
  border-radius: 0px !important;
}
.el-upload-dragger .el-icon-upload {
  margin-top: 20px !important;
}
</style>

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
.personal {
	height: 954px;
	width: 990px;
  float: left;
  background: #fff;
  margin-top: 16px;
  .topul {
    height: 40px;
    border-bottom: 1px solid #e7e7e7;
    margin: 12px 17px 0;
    li {
      height: 28px;
      font-size: 14px;
      color: 666;
      width: 104px;
      text-align: center;
      margin-top: 12px;
      cursor: pointer;
    }
    span {
      width: 104px;
      height: 16px;
      border-right: 1px solid #e8e8e8;
      float: left;
    }
    li:last-child {
      span {
        border-right: 0;
      }
    }
    .bg {
      color: red;
      border-bottom: 2px solid red;
    }
  }
  .xinxi {
    .el-alert {
      width: 400px;
      margin: 20px 10px;
    }
    p {
      font-size: 12px;
      color: #666;
    }
    .touxiang {
      margin: 20px 0 22px 45px;
      position: relative;
      img {
        margin-left: 18px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
      }
    }
    .hidecom {
      display: none;
    }
    .redact:hover .hidecom {
      display: block;
      background: #ccc;
      color: #333;
      width: 100px;
      height: 20px;
      text-align: center;
      position: absolute;
      top: 83px;
      left: 78px;
      cursor: pointer;
    }
    .name {
      margin-left: 45px;
      .member_name {
        margin-left: 26px;
      }
    }
    .nicheng {
      margin: 15px 0 0 50px;
      position: relative;
      .el-alert {
        position: absolute;
        left: 380px;
        top: 0;
        width: 200px;
        padding: 6px 16px;
      }
      span:nth-of-type(1) {
        color: #ff3f3f;
        margin-right: 12px;
      }
      input {
        width: 286px;
        height: 30px;
        border: 1px solid #ccc;
        margin-left: 26px;
        padding-left: 10px;
      }
      span:nth-of-type(2) {
        color: #a0a0a0;
        padding: 10px 0 0 79px;
        float: left;
      }
    }
    .huiyuan {
      margin: 49px 0 0 45px;
      span:nth-of-type(1) {
        margin: 0 38px 0 26px;
      }
      span:nth-of-type(2) {
        color: #ff2424;
        margin: 0 28px 0 9px;
      }
      span:nth-of-type(3) {
        color: #ff2424;
        margin: 0 5px;
      }
    }
    .xingbie {
      margin: 40px 0 0 70px;
      label {
        margin: 0 0 0 21px;
      }
      input {
        margin: 2px 8px 0 0;
      }
    }
    .shengri {
      margin: 27px 0 0 70px;
      line-height: 30px;
      select {
        outline: none;
      }
      span {
        margin: 0 12px;
      }
      select:nth-of-type(1) {
        margin-left: 25px;
      }
    }
    // .zhudi{margin:18px 0 0 45px;
    // 	select{outline:none; min-width:108px;height:30px;margin-right:13px;}select:nth-of-type(1){margin-left:27px;}
    // }
    // .xiangxi{margin:18px 0 0 45px;overflow: hidden;
    // 	textarea{width:514px;height:133px;padding:15px 13px 0;border-color:#ccc;margin-left:31px;float: left;}
    // }
    button {
      cursor: pointer;
      width: 94px;
      height: 32px;
      background: red;
      font-size: 12px;
      color: #fff;
      line-height: 32px;
      text-align: center;
      border-radius: 3px;
      margin: 30px 0 0 135px;
    }
    .zhuyi {
      border: 1px solid #bce8f1;
      margin: 34px 17px 0;
      height: 126px;
      background: #eff8ff;
      position: relative;
      p {
        font-size: 12px;
        color: #999;
        line-height: 24px;
        margin-left: 73px;
      }
      p:nth-of-type(1) {
        font-size: 14px;
        color: #333;
        margin-top: 25px;
      }
      img {
        position: absolute;
        top: 27px;
        left: 40px;
      }
    }
  }
  .renzheng {
    .top {
      border: 1px solid #bce8f1;
      margin: 34px 17px 0;
      height: 110px;
      background: #eff8ff;
      position: relative;
      p {
        font-size: 12px;
        color: #999;
        line-height: 24px;
        margin-left: 73px;
      }
      p:nth-of-type(1) {
        font-size: 14px;
        color: #333;
        margin-top: 25px;
      }
      img {
        position: absolute;
        top: 27px;
        left: 40px;
      }
    }
    p {
      font-size: 12px;
      color: #666;
    }
    input {
      width: 286px;
      height: 30px;
      border: 1px solid #ccc;
    }
    .span {
      color: #ff5454;
      margin-right: 11px;
    }
    .name {
      margin: 30px 0 0 65px;
      input {
        margin-left: 17px;
      }
      span:nth-of-type(2) {
        margin: 8px 0 0 92px;
        font-size: 12px;
        color: #999;
      }
    }
    .haoma {
      margin: 36px 0 0 55px;
      input {
        margin-left: 17px;
      }
    }
    .both {
      margin: 18px 0 0 44px;
      overflow: hidden;
      font-size: 12px;
      color: #666;
      .same {
        width: 163px;
        height: 122px;
      }
      .photo {
        margin: 0 42px 0 26px;
        img {
          display: block;
          margin: 10px auto 0;
        }
      }
      .photos {
        img {
          width: 100%;
          height: 100%;
        }
      }
    }
    .zhengmian {
      p:nth-of-type(1) {
        margin-top: 33px;
      }
      p:nth-of-type(3) {
        margin-top: 33px;
      }
    }
    .beimian {
      p:nth-of-type(1) {
        margin-top: 73px;
      }
      p:nth-of-type(3) {
        margin-top: 73px;
      }
    }
    .jianyi {
      font-size: 12px;
      color: #999;
      margin: 10px 0 26px 161px;
    }
    button {
      width: 94px;
      height: 32px;
      text-align: center;
      line-height: 32px;
      background: red;
      color: #fff;
      font-size: 12px;
      border-radius: 3px;
      margin: 17px 0 0 160px;
      cursor: pointer;
    }
  }
  .touxiang {
    .top {
      margin: 32px 0 0 48px;
      overflow: hidden;
      span {
        width: 114px;
        height: 31px;
        line-height: 31px;
        font-size: 12px;
        border-radius: 3px;
      }
      span:nth-of-type(1) {
        background: #1383d1;
        border: 1px solid #005b9b;
        color: #fff;
        margin-right: 18px;
        position: relative;
        input {
          opacity: 0;
          width: 100%;
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
        }
        img {
          float: left;
          margin: 7px 5px 0 14px;
        }
      }
      span:nth-of-type(2) {
        background: #f7f7f7;
        border: 1px solid #d3d3d3;
        color: #333;
        img {
          float: left;
          margin: 7px 9px 0 14px;
        }
      }
    }
    .jianyi {
      color: #a8a8a8;
      font-size: 12px;
      margin: 38px 0 23px 47px;
    }
    .git {
      overflow: hidden;
      .lefts {
        width: 518px;
        height: 366px;
        background: #f9f9f9;
        border: 1px solid #e9eaec;
        margin-left: 45px;
        text-align: center;
        display: table;
        .img-cont {
          display: table-cell;
          vertical-align: middle;
        }
      }
      .right {
        border-left: 1px solid #e6e6e6;
        margin-left: 38px;
        width: 376px;
        p {
          width: 270px;
          font-size: 12px;
          color: #5a5a5a;
          line-height: 24px;
          margin-left: 39px;
        }
        .rightul {
          margin: 24px 0 0 40px;
          li {
            width: 148px;
            height: 178px;
            text-align: center;
            color: #a8a8a8;
            font-size: 12px;
            margin-right: 10px;
            span {
              display: inline-block;
              border: 1px solid #e9eaec;
              background: #f9f9f9;
            }
            img {
              width: 100%;
              height: 100%;
            }
          }
          li:nth-of-type(1) {
            span {
              width: 100px;
              height: 100px;
              margin-bottom: 5px;
            }
          }
          li:nth-of-type(2) {
            span {
              width: 78px;
              height: 78px;
              margin: 70px auto 5px;
            }
          }
          li:nth-of-type(3) {
            height: 120px;
            span {
              width: 48px;
              height: 48px;
              margin: 43px auto 5px;
            }
          }
          li:nth-of-type(4) {
            height: 120px;
            span {
              width: 28px;
              height: 28px;
              margin: 65px auto 5px;
            }
          }
        }
      }
    }
    button {
      width: 94px;
      height: 32px;
      text-align: center;
      line-height: 32px;
      background: red;
      color: #fff;
      font-size: 12px;
      border-radius: 3px;
      margin: 30px 0 0 45px;
      cursor: pointer;
    }
    button.active {
      background-color: #ccc;
    }
  }
}
</style>