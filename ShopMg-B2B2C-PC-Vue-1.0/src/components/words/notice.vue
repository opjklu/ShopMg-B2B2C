<template>
	<div class="guide">
		<head-com></head-com>
		<div class="center">
			<div class="top">
				<img class="l" src="../../assets/img/fangzi.jpg" alt="" />
				<ul class="l topul">
					<li class="l li">
						<router-link to="home">首页</router-link>
					</li>
					<li class="l li">></li>
					<li class="l li">
						<router-link to="">公告</router-link>
					</li>
				</ul>
			</div>
			<div class="bottom">
				<div class="l left">
					<div class="up">
						<p>公告列表</p>
						<ul>
							<li v-for="(item,index) in articleList" :key="index" @click="fun(item.id)">· {{item.title}} </li>
						</ul>
					</div>
				</div>
				<div class="r dexter">
					<div class="shop">
						<p>{{articleDetail.name}}</p>
						<p>{{articleDetail.create_time | formatDate}}</p>
					</div>
					<div class="zhinan">{{articleDetail.intro}}</div>
					
				</div>
			</div>
		</div>
		<foot-com></foot-com>
	</div>
</template>

<script>

export default {
	data() {
		return {
      articleList:[],
      articleDetail:{}

		}
  },
	mounted() {
    this.geAarticleList();
    setTimeout(() => {
      if(this.$route.params.id!=undefined){
          this.getAnnouncementDetail(this.$route.params.id);
      }
    }, 500);
	},
	methods: {
    getAnnouncementDetail(id){
			this.HTTP(this.$httpConfig.getArticleDetails, {id:id}, 'post').then((res) => {
				this.articleDetail = res.data.data;
			})
    },
		geAarticleList(id) {
      this.HTTP(this.$httpConfig.home, {}, 'post')
        .then((res) => {
          this.articleList = res.data.data.announcement
        })
     
		}

	}

}
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
.top {
  height: 35px;
  line-height: 35px;
  margin-bottom: 5px;
  img {
    margin: 13px 8px 0 0;
  }
  .topul {
    .li {
      font-size: 12px;
      a {
        color: #919191;
      }
      &:hover {
        color: red;
      }
    }
    li:last-child {
      a {
        color: #545454;
      }
    }
  }
}
.bottom {
  overflow: hidden;
  .left {
    width: 208px;
    margin-bottom: 30px;
    .up {
      width: 206px;
      border: 1px solid #ddd;
      height: auto;
      border-top: 2px solid #b9a157;
      p {
        height: 32px;
        font-size: 15px;
        color: #454545;
        line-height: 32px;
        padding-left: 10px;
        background: #fbfbfb;
      }
      ul {
        margin-top: 17px;
        li {
          width: 200px;
          color: #515151;
          height: 20px;
          margin-bottom: 10px;
          line-height: 15px;
          cursor: pointer;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          &:hover {
            color: red;
          }
        }
        li:nth-child(2n) {
          border-left: 1px dashed #d5d5d5;
        }
        .active {
          color: #ceb35a;
        }
      }
    }
    .down {
      width: 206px;
      border: 1px solid #ddd;
      overflow: hidden;
      margin-top: 12px;
      p {
        height: 32px;
        font-size: 15px;
        color: #454545;
        line-height: 32px;
        padding-left: 10px;
        background: #fbfbfb;
      }
      ul {
        margin-top: 9px;
        margin-bottom: 9px;
        li {
          line-height: 31px;
          margin-left: 12px;
          color: #515151;
          cursor: pointer;
          &:hover {
            color: red;
          }
        }
      }
    }
  }
  .right {
    width: 978px;
    border: 1px solid #ddd;
    .shop {
      height: 57px;
      border-bottom: 1px dashed #e6e6e6;
      margin: 0 19px;
      line-height: 60px;
      font-size: 17px;
      color: #333;
    }
    ul {
      margin: 10px 19px 58px;
      li {
        line-height: 32px;
        font-size: 12px;
        color: #666;
        cursor: pointer;
        &:hover {
          color: red;
        }
      }
    }
  }
  .dexter {
    width: 978px;
    border: 1px solid #ddd;
    .shop {
      height: 96px;
      border-bottom: 1px solid #e6e6e6;
      margin: 0 19px;
      p {
        text-align: center;
      }
      p:nth-of-type(1) {
        margin: 28px 0 18px;
        font-size: 16px;
      }
      p:nth-of-type(2) {
        font-size: 10px;
        color: #929292;
      }
    }
    .zhinan {
      height: 60px;
      border-bottom: 1px solid #e6e6e6;
      margin: 0 19px;
      line-height: 64px;
      font-size: 12px;
      color: #333;
    }
    .bottom {
      margin: 15px 30px 97px;
      p {
        font-size: 12px;
        color: #343434;
        span {
          color: #959595;
        }
      }
    }
  }
}
</style>