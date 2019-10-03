<template>
  <div class="publishComment">
    <div class="dianping r">
      <div class="top">
        <p class="l">评价商品</p>
        <p class="r">
          <span>卖家：{{shop_name}}</span>
          <span>订单号：{{order_sn}}</span>
        </p>
      </div>
      <div class="under">
        <div class="zuo">
          <img :src="URL + pic_url" />
          <p>{{title}}</p>
        </div>
        <div class="right">
          <div class="clearfix">
            <p class="l">商品满意度</p>
            <div class="block">
              <el-rate v-model="star" :show-text="true" :texts="['极差', '失望', '一般', '满意', '惊喜']"></el-rate>
            </div>
          </div>
          <div class="yinxiang">
            <span class="l">卖家印象</span>
            <ul class="l">
              <li
                :class="['l', tagIndex === index ? 'bor' : '']"
                v-for="(tag, index) in tag"
                :key="index"
                @click="tagChange(index)"
              >{{tag}}</li>
            </ul>
          </div>
          <div class="pingjia">
            <span class="l">评价</span>
            <el-input type="textarea" v-model="content" class="l"></el-input>
          </div>
          <div class="niming">
            <span>是否匿名</span>
            <el-switch v-model="delivery"></el-switch>
          </div>
          <!-- <img class="imgs" src="../../../assets/img/pingjia.png"> -->
          <div class="shaitu">
            <span title="最多五张">晒 &nbsp;&nbsp;&nbsp;&nbsp;图:</span>
            <el-upload
              :action="difficulty()"
              list-type="picture-card"
              :with-credentials="true"
              :data="uploadData"
              :on-success="succeed"
              :on-preview="handlePictureCardPreview"
              :on-remove="handleRemove"
              :before-upload="beforeUploade"
              :on-exceed="beyond"
              :file-list="fileList"
              :limit="5"
              name="fileData"
              accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .GIF, .PNG"
            >
              <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog :visible.sync="dialogVisible">
              <img width="100%" :src="dialogImageUrl" alt />
            </el-dialog>
            <span class="last">
              <span>最多上传：{{figureCollection.length}}/5</span>
              <span>宽度介于: {{imageConf.min_width}}～{{imageConf.max_width}}，高度介于: {{imageConf.min_height}}～{{imageConf.max_height}}</span>
            </span>
          </div>
        </div>
      </div>
      <div class="base">
        <div class="dongtai">店铺动态评分</div>
        <p>
          宝贝与描述相符
          <img src="../../../assets/img/xingxing1.png" />
          <span>3.0 分</span> - 质量一般，没有卖家描述的那样好
        </p>
        <p>
          卖家的服务态度
          <img src="../../../assets/img/xingxing2.png" />
          <span>4.0 分</span> - 卖家服务挺好的，沟通挺顺畅的，总体满意
        </p>
        <p>
          物流服务的质量
          <img src="../../../assets/img/xingxing2.png" />
          <span>4.0 分</span> - 到货速度及时，派件员态度较好
        </p>
        <button @click="appraise">发表评论</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dialogImageUrl: "",
      dialogVisible: false,
      tag: ["手感好", "发货快", "物美价廉", "性价比高"],
      tagIndex: 0,
      filePath: [],
      fd: undefined,
      order_sn_id: null,
      pic_url: null,
      title: null,
      // 评价所需
      goods_id: this.$route.query.goods_id, //商品编号
      order_id: this.$route.query.id, //订单编号
      store_id: this.$route.query.store_id, //店铺编号
      //status:1,//是否可见
      delivery: true, //是否匿名
      content: "请输入评论", //评论
      star: 0, //评分
      level: 2, //评级
      have_pic: 0, //是否有图
      figureCollection: [], //图片路径
      type: Number(this.$route.query.type), //判断是我的还是套餐订单
      shop_name: "",
      order_sn: "",
      imageConf: {},
      uploadData: {
        sessionToken: "",
        imageToken: ""
      },
      fileList: []
    };
  },
  mounted() {
    this.Blurb();

    this.$nextTick(() => {
      this.HTTP(this.$httpConfig.getCommentImageConf, {})
        .then(res => {
          this.imageConf = res.data.data.config;
          console.log(this.imageConf);
          this.uploadData.imageToken = res.data.data.token;
          this.uploadData.sessionToken = res.data.data.s_token;
        })
        .catch(e => {});
    });
  },
  created() {
    console.log(this.$route.query);
    this.shop_name = decodeURIComponent(this.$route.query.shop_name);

    this.order_sn = this.$route.query.order_sn;
  },
  methods: {
    // 提交评论
    appraise() {
      //评级
      if (this.star <= 2) {
        this.level = 0;
      } else if (this.star == 5) {
        this.level = 2;
      } else {
        this.level = 1;
      }
      //是否匿名
      let anonymous = 0;
      if (this.delivery == true) {
        anonymous = 0;
      } else {
        anonymous = 1;
      }
      if (this.type === 0) {
        //我的订单提交
        this.HTTP(
          this.$httpConfig.PublishComment,
          {
            goods_id: this.goods_id,
            order_id: this.order_id,
            status: 1,
            content: this.content,
            anonymous: anonymous,
            score: this.star,
            level: this.level,
            labels: this.tagIndex.toString(),
            have_pic: this.have_pic,
            store_id: this.store_id,
            path: this.figureCollection
          },
          "post"
        )
          .then(res => {
            console.log(res);
            this.$message(`${res.data.message}`);
            if (res.data.message == "成功") {
              setTimeout(() => {
                this.$router.push("/evaluation");
              }, 1500);
            }
          })
          .catch(e => {
            console.log(e);
          });
      } else {
        this.HTTP(
          this.$httpConfig.PublishConmment,
          {
            goods_id: this.goods_id,
            order_id: this.order_id,
            status: 1,
            content: this.content,
            anonymous: anonymous,
            score: this.star,
            level: this.level,
            labels: this.tagIndex.toString(),
            have_pic: this.have_pic,
            store_id: this.store_id,
            path: this.figureCollection
          },
          "post"
        )
          .then(res => {
            console.log(res);
            this.$message(`${res.data.message}`);
            if (res.data.message == "成功") {
              setTimeout(() => {
                this.$router.push("/evaluation");
              }, 1500);
            }
          })
          .catch(e => {
            console.log(e);
          });
      }
    },

    // 上传之前
    beforeUploade(file) {
      const isLt2M = file.size / 1024 / 1024 < 3;
      if (!isLt2M) {
        this.$message.error("上传头像图片大小不能超过 2MB!");
        return false;
      }
      return true;
    },
    Blurb() {
      //商品
      this.HTTP(
        this.$httpConfig.getGoodsDetailsByUserCenter,
        { id: this.goods_id },
        "post",
        false
      )
        .then(res => {
          if (res.data.status) {
            this.pic_url = res.data.data.images[0].pic_url;
            this.title = res.data.data.title;
          }
          console.log(res.data.data);
        })
        .catch(e => {
          console.log(e);
        });
    },
    // 图片最大数之后
    beyond() {
      this.$message.warning("做多五张图片");
    },
    //上传成功，在数组中添加获取后的路径
    succeed(response, file, fileList) {
      console.log(response);
      if (response.status === 0) {
        this.$message.error(response.message);
        let length = fileList.length;
        let i = 0;
        for (i; i < length; i++) {
          if (fileList[i].name === file.name) {
            fileList.splice(i, 1);
          }
        }

        return false;
      }
      console.log(file);
      this.figureCollection.push(file.response.data);
      if (this.figureCollection.length > 0) {
        this.have_pic = 1;
      } else {
        this.have_pic = 0;
      }

      return true;
    },
    //上传路径
    difficulty() {
      return this.$httpConfig.uploadCommentImg;
    },

    //删除图片
    handleRemove(file, fileList) {
      // 删除数组中的元素
      let index = this.figureCollection.indexOf(file.response.data);
      if (index > -1) {
        this.figureCollection.splice(index, 1);
      }
      //后台删除当前图片
      this.HTTP(
        this.$httpConfig.delPic,
        {
          fileName: file.response.data
        },
        "post"
      )
        .then(e => {
          console.log(res);
        })
        .catch(e => {
          console.log(e);
        });
    },
    // 成功后显示的图片
    handlePictureCardPreview(file) {
      console.log(file);
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    // 标签
    tagChange(index) {
      this.tagIndex = index;
    }
  }
};
</script>
<style>
textarea {
  resize: none;
}
/* 添加方块 */
.el-upload--picture-card {
  width: 60px !important;
  height: 60px !important;
  line-height: 60px !important;
}
/* 加号 */
.el-upload--picture-card i {
  font-size: 18px;
}
/* 图片 */
.el-upload-list__item-thumbnail {
  width: 60px !important;
  height: 60px !important;
  line-height: 60px !important;
}
/* 外框 */
.el-upload-list--picture-card .el-upload-list__item {
  width: 60px !important;
  height: 60px !important;
  line-height: 60px !important;
  position: relative;
}
/* 对号 */
.el-upload-list--picture-card .el-upload-list__item-status-label i {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 16px;
  margin: 0;
}
</style>

<style lang="less" scoped>
.l {
  float: left;
}
.r {
  float: right;
}
input[type="file"] {
  display: none;
}
.dianping {
  width: 980px;
  background: #fff;
  margin: 16px 0;
  height: 1200px;
  .top {
    overflow: hidden;
    margin: 14px 17px 20px;
    border-bottom: 1px solid #e7e7e7;
    line-height: 37px;
    p.l {
      width: 104px;
      text-align: center;
      border-bottom: 2px solid red;
      color: red;
    }
    span {
      margin-left: 89px;
    }
  }
  .under {
    margin: 0 17px;
    border: 1px solid #e7e7e7;
    padding: 20px 0;
    height: 40%;
    div {
      margin: 10px 0;
    }
    .zuo {
      width: 132px;
      border-right: 1px solid #e7e7e7;
      height: 100%;
      float: left;
      text-align: center;
      img {
        display: block;
        margin: 13px auto 7px;
        width: 100px;
        height: 100px;
      }
      p {
        width: 105px;
        font-size: 12px;
        color: #666;
        margin: 0 auto;
      }
    }
    .right {
      float: left;
      margin-left: 24px;
      .pingjia {
        display: flex;
        span {
          width: 100px;
        }
      }
      .clearfix {
        margin: 27px 0 24px;
        font-size: 12px;
        color: #484848;
        line-height: 14px;
        p {
          width: 85px;
          vertical-align: middle;
        }
        span {
          color: red;
        }
      }
      .yinxiang {
        overflow: hidden;
        line-height: 22px;
        font-size: 12px;
        color: #484848;
        ul {
          margin-left: 37px;
          overflow: hidden;
        }
        li {
          font-size: 12px;
          color: #484848;
          width: 90px;
          height: 22px;
          text-align: center;
          line-height: 22px;
          border: 1px solid #e0e0e0;
          margin-right: 10px;
        }
        .bor {
          background: #eef1ff;
          border: 0;
        }
      }
      .evaluation {
        overflow: hidden;
        margin-top: 17px;
        font-size: 12px;
        color: #484848;
        textarea {
          width: 559px;
          height: 75px;
          margin-left: 61px;
        }
      }
      .niming {
        overflow: hidden;
        font-size: 12px;
        color: #484848;
        span {
          width: 80px;
          display: inline-block;
        }
        input {
          margin: 1px 9px 0 0;
        }
      }
      .imgs {
        margin: 13px 0 0 78px;
        display: block;
      }
      .shaitu {
        margin-top: 10px;
        font-size: 12px;
        display: flex;
        flex-wrap: nowrap;
        width: 550px;
        height: 72px;
        line-height: 72px;
        color: #484848;
        span {
          float: left;
          margin-right: 35px;
          text-align: center;
        }
        .first {
          margin-top: 20px;
        }
        .spa {
          margin-left: 61px;
          width: 58px;
          height: 58px;
          border: 1px solid #ccc;
          display: inline-block;
          text-align: center;
          line-height: 58px;
          i {
            font-size: 20px;
            color: #e6e6e6;
          }
        }
        .last {
          margin: 0 0 0 15px;
        }
      }
    }
  }
  .base {
    height: 262px;
    .dongtai {
      width: 124px;
      height: 47px;
      text-align: center;
      line-height: 47px;
      color: #fff;
      background: red;
      margin: 68px 53px 0 62px;
      float: left;
    }
    p {
      font-size: 13px;
      color: #484848;
      line-height: 30px;
      float: left;
      width: 74%;
      img {
        display: inline-block;
        margin: 0 12px;
      }
      span {
        color: red;
      }
    }
    p:nth-of-type(1) {
      margin-top: 46px;
    }
    button {
      width: 120px;
      height: 35px;
      background: #ff6000;
      text-align: center;
      line-height: 35px;
      color: #fff;
      border-radius: 3px;
      cursor: pointer;
      margin: 43px 0 0 240px;
    }
  }
}
</style>