<template>

    <div class="base" >
        <div class="top">
            <span class="l border" @click="cut(0)">猜您喜欢</span>
            <span class="r" @click="getNew">
                <img class="r" src="../assets/img/huanyipi.jpg" />换一批
            </span>
        </div>
        <div>
            <div class="bottom" v-show="isborder === 0">
                <ul>
                    <li v-for="(bases, index) in myLikeList" @click="toDetail(bases.id)" :key="index" v-if="bases !== null">
                        <img :src="bases.pic_url === null ? 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1542620438617&di=934a6c42aa8fc70f89d333365c9bf7e8&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimgad%2Fpic%2Fitem%2Fb21c8701a18b87d69f0ccc220c0828381f30fd45.jpg' : URL + bases.pic_url" />
                        <p>{{bases.title === null ? '暂无数据' : bases.title}}</p>
                        <p>{{bases.price_market === null ? '暂无数据' : '￥' + bases.price_market}}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            myLikeList: '',
            myRecordsList: '',
            isborder: 0,
            page:1
        }
    },
    mounted() {
        this.getMyCollectionLike();
    },
    methods: {
        // 去详情页
		toDetail(id) {
            window.open(window.location.origin+'/inroyaldrink?id=' + id);
		},
        // 获取猜你喜欢列表
        getMyCollectionLike() {
            this.HTTP(this.$httpConfig.guessLove, {page: this.page}, 'post', true).then((res) => {

              if(res.data.status !==  1 || res.data.data.length === 0 ) {
                this.page = 0;
                return;
              }
                this.myLikeList = res.data.data;
            })
        },
   
        // 换一批
        getNew() {

          this.page ++;
                this.getMyCollectionLike();
        },
        cut(index) {
            this.isborder = index;
        },  
    }
}   
</script>
<style lang="less">
.base {
  overflow: hidden;
  margin: 40px 0;
  background: #f9f9f9;
  border:1px solid #e3d3d3;
  box-sizing: border-box;
  .top {
     height: 37px;
    width: 100%;
    line-height: 37px;
    padding-right: 20px;
    span.l {
      height: 37px;
      width: 105px;
      line-height: 37px;
      color: #454545;
      text-align: center;
      cursor: pointer;
      display: inline-block;
    }
    img {
      width: 20px;
      height: 20px;
      margin: 0 6px 0 0;
      cursor: pointer;
    }
    span.r {
      float: right;
      color: #93919e;
      font-size: 12px;
      cursor: pointer;
    }
    .border {
      border-bottom: 2px solid red;
      color: red !important;
    }
  }
  .bottom {
    height: 270px;
    width: 100%;
    background: #fff;
    // border: 1px solid #e5e5e5;
    ul {
      li {
        width: 168px;
        margin: 17px 15px 0;
        float: left;
        cursor: pointer;
        img {
          width: 168px;
          height: 178px;
        }
        p {
          font-size: 12px;
          margin-top: 10px;
          display: -webkit-box;
          overflow: hidden;
          white-space: normal !important;
          text-overflow: ellipsis;
          word-wrap: break-word;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
        }
        p:nth-of-type(1) {
          &:hover {
            color: red;
          }
        }
        p:nth-of-type(2) {
          color: #b22e2c;
          margin-top: 5px;
        }
      }
    }
  }
}
</style>

