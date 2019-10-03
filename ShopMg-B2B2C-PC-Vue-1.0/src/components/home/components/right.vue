<template>
  <div class="denglu r">
    <img
      class="touxiang"
      @click="HeadPortrait"
      v-if="userInfo.userHeaderImg"
      :src="URL+userInfo.userHeaderImg"
    />
    <img class="touxiang" @click="HeadPortrait" v-else src="../../../assets/img/default-head.png" />
    <h3 class="l" v-if="userInfo.userName!=null">
      <span class="user-name text1-hidden">Hi, {{userInfo.userName}}</span>
    </h3>
    <h3 class="l" v-else>Hi,欢迎来到{{$constant.mainTitle}}</h3>
    <div class="qdl l" v-if="userInfo.userName==null">
      <span class="qingdenglu both" @click="logIn">请登录</span>
      <router-link to="agreement" class="kaidian both">我要开店</router-link>
    </div>
    <div class="qdl l" v-else>
      <router-link class="qingdenglu both" to="myOrder?id=1">查看订单</router-link>
      <router-link to="personalData" class="kaidian both">查看资料</router-link>
    </div>
    <p class="l notice">
      热门公告
      <span class="r" @click="toAnnouncement">更多</span>
    </p>
    <div class="seamless-warp wufeng l">
      <ul class="item">
        <li
          @click="Announcement(item.id)"
          v-for="(item,index) in announcementList"
          :key="index"
        >{{item.title}}</li>
      </ul>
    </div>
    <h4 class="l rukou">快捷入口</h4>
    <ul class="ul l">
      <li>
        <a href="javascript:;" @click="toLink('ecentBrowse')">
          <i class="el-icon-view"></i>
          <br />浏览
        </a>
      </li>
      <li>
        <a href="javascript:;" @click="toLink('collect')">
          <img src="../../../assets/img/heart.jpg" /> 收藏
        </a>
      </li>
      <li>
        <a href="javascript:;" @click="toLink('myOrder',0)">
          <i class="el-icon-date"></i>
          <br />订单
        </a>
        <router-link to="myOrder?id=1"></router-link>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  data() {
    return {
      userInfo: {},
      announcementList: []
    };
  },

  mounted() {
    if (
      sessionStorage.getItem("userHeaderImg") ||
      sessionStorage.getItem("userName")
    ) {
      this.userInfo = {
        userName: sessionStorage.getItem("userName"),
        userHeaderImg: sessionStorage.getItem("userHeaderImg")
      };
    }

    this.getAnnouncementList();
  },

  methods: {
    //头像判断登录跳转
    HeadPortrait() {
      if (this.userInfo.userName != null) {
        this.$router.push({
          name: "greet"
        });
      } else {
        this.$router.push({
          name: "passwordLogin"
        });
      }
    },
    logIn() {
      this.$router.push({
        name: "passwordLogin"
      });
    },
    toAnnouncement() {
      this.$router.push({
        name: "notice"
      });
    },

    toLink(l, n) {
      if (n == 0) {
        window.open(window.location.origin + "/" + l + "?id=1");
      } else {
        console.log("=====" + l);
        window.open(window.location.origin + "/" + l);
      }
    },
    getAnnouncementList() {
      this.HTTP(this.$httpConfig.announcementLIst, {}, "post").then(res => {
        this.announcementList = res.data.data;
      });
    }
  }
};
</script>


<style lang="less" scoped>
.denglu {
  position: absolute;
  top: 0;
  right: 0;
  width: 190px;
  height: 410px;
  background: #fff;
  // margin-top: 11px;
  z-index: 10;
  .touxiang {
    margin: 10px auto;
    width: 82px;
    height: 82px;
    border-radius: 50%;
    display: block;
    cursor: pointer;
  }
  h3 {
    text-align: center;
    color: #767676;
    font-size: 12px;
    width: 100%;
    .user-name {
      display: inline-block;
      max-width: 100px;
    }
  }
  .qdl {
    margin: 10px 0 0 22px;
    .both {
      float: left;
      width: 68px;
      text-align: center;
      line-height: 22px;
      height: 22px;
      border: 1px solid red;
      font-size: 12px;
      background: #fff;
      &:hover {
        background: red;
      }
    }
    .qingdenglu {
      cursor: pointer;
      color: red;
      &:hover {
        color: #fff;
      }
    }
    .kaidian {
      color: #333;
      border-color: #333;
      margin-left: 10px;
      cursor: pointer;
      &:hover {
        color: #fff;
        border-color: red;
      }
    }
  }
  .wufeng {
    height: 100px;
    margin: 10px 0 0;
    overflow: hidden;
    .item {
      overflow: hidden;
    }
    li {
      cursor: pointer;
      width: 165px;
      float: left;
      line-height: 25px;
      font-size: 12px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      padding-left: 22px;
    }
  }
  .notice {
    width: 100%;
    height: 24px;
    line-height: 24px;
    margin-top: 16px;
    background: #fff;
    font-size: 14px;
    font-weight: 600;
    color: black;
    padding-left: 22px;
    padding-right: 22px;
    span {
      font-weight: 200;
      font-size: 12px;
      cursor: pointer;
    }
  }
  h4 {
    width: 100%;
    height: 24px;
    line-height: 24px;
    margin-top: 16px;
    background: #fff;
    font-size: 14px;
    font-weight: 600;
    color: black;
    padding-left: 22px;
  }
  .rukou {
    color: #434343;
    margin-top: 9px;
  }
  .ul {
    li {
      float: left;
      width: 63px;
      border-right: 1px solid #eee;
      height: 59px;
      text-align: center;
      img {
        display: block;
        margin: 16px auto 6px;
      }
      i {
        margin-top: 14px;
        margin-bottom: 5px;
        color: #000;
        font-size: 18px;
      }
      a {
        color: #8f8f8f;
        font-size: 12px;
      }
      &:hover a {
        color: red;
      }
    }
    li:last-child {
      border: 0;
    }
  }
}
.r {
  float: right;
}
</style>

