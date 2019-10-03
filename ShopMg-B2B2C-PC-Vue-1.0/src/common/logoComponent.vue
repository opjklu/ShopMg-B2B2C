<template>
  <div>
    <common-header></common-header>
    <div class="logo">
      <router-link to="/home">
        <img :src="logo_path" />
      </router-link>
      <p>{{title}}</p>
    </div>
  </div>
</template>

<script>
import { TimeInterval } from "../../es6/time.js";

export default {
  data() {
    return {
      title: "",
      logo_path: ""
    };
  },

  mounted() {
    this.$nextTick(() => {
      this.title = this.$parent.getTitle();
      this.getFootData();
    });
  },

  methods: {
    getFootData() {
      let data = TimeInterval.getItem("web_info");
      console.log(data);
      if (data) {
        this.logo_path = this.URL + data.logo_name;
      }
    }
  }
};
</script>

<style lang="less" scoped>
.logo {
  height: 124px;
  width: 1200px;
  margin: 0 auto;
  background: url(../assets/img/headbg.jpg) repeat-x 0 100%;
  background-color: white;

  img {
    float: left;
  }
  p {
    font-size: 24px;
    float: left;
    margin: 40px 0 0 29px;
  }
}
</style>
