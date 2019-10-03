<template>
  <div class="back_top" v-show="showReturnToTop" @click="toTop">
      <i class="arrow"></i>
  </div>
</template>
<script>
import $ from 'jquery'
export default {
  name:'backTop',
  data(){
      return {
          showReturnToTop:false
      }
  },
  created () {
        window.addEventListener('scroll', this.currentPagePosition);
  },
  beforeDestroy () {
        window.removeEventListener('scroll', this.currentPagePosition)
  },
  methods:{
      currentPagePosition(){
          document.documentElement.scrollTop > 350 ? this.showReturnToTop = true : this.showReturnToTop = false;
      },
      toTop(){
          $('html,body').animate({scrollTop:'0px'},500);
      }
  },
  mounted(){
      //console.log(document.documentElement.scrollTop)
  }
}
</script>
<style lang="less" scoped>
    .back_top{
        position:fixed;
        right: 80px;
        bottom: 20px;
        width: 35px;
        height: 35px;
        border-radius: 5px; 
        z-index: 9999;
        cursor: pointer;
        .arrow {
            display: inline-block;
            position: relative;
            z-index: 99;
            width: 100%;
            height: 100%;
            border-radius: 5px;
            background: url(../assets/img/icon.png) no-repeat no-repeat -181px -209px #7a6e6e;
        }
    }
    
    @media screen and (min-width:1367px){
        .back_top{right:30px;}
    }
    @media screen and (min-width:1441px){
        .back_top{right:130px;}
    }
    @media screen and (min-width:1661px){
        .back_top{right:250px;}
    }
</style>
