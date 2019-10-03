<template>
    <div class="newProduct">
        <div class="left l">
            <div class="l up">
                <div class="headline">新品推荐</div>
                <span class="nullData">{{newProduct.length === 0 ? '暂无数据' : ''}}</span>
                <ul>
                    <li v-for="(item, index) in newProduct" :key="index" >
                        <img :src="URL + item.pic_url" @click="toRouter(item.id)">
                        <p>{{item.title}}</p>
                        <p>￥{{item.goods_price}}</p>
                    </li>
                </ul>
            </div>
            <div class="l down">
                <div class="headline">热销排行</div>
                <span class="nullData">{{topSelling.length === 0 ? '暂无数据' : ''}}</span>
                <ul>
                    <li v-for="(item,index) in topSelling" :key="index">
                        <img :src="URL+item.pic_url" @click="toRouter(item.id)">
                        <p class="l">{{item.title}}</p>
                        <p class="l">￥{{item.goods_price}}</p>
                        <p class="r">
                            销量：
                            <span class="xiaoliang">{{item.sales_sum}}</span>
                        </p>
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
            newProduct: [],
            topSelling: []
        };
    },
    created() {
   
        let classId =  this.$parent.getClassId();
        this.HTTP(
            this.$httpConfig.newRecommend,
            {
                id: classId
            },
            "post"
        )
            .then(res => {
                if (res.data.status) this.newProduct = res.data.data;
            })
            .catch(e => {
                console.log(e);
            });
        this.HTTP(
            this.$httpConfig.hotSale,
            {
                id: classId
            },
            "post"
        )
            .then(res => {
                if (res.data.status) this.topSelling = res.data.data;
            })
            .catch(e => {
                console.log(e);
            });
    },

    methods : {
        
        toRouter(id) {
            location.href = '/inroyaldrink?id='+id;
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
.left {
    width: 190px;
    background: #fff;
    border: 1px solid #e5e5e5;
    box-sizing: border-box;
    overflow: hidden;
    .up {
        // margin-bottom: 20px;
    }
    .up,
    .down {
        width: 190px;
        overflow: hidden;
        // border: 1px solid #e5e5e5;
        .nullData {
            display: flex;
            height: 50px;
            justify-content: center;
            align-items: center;
        }
    }
    .headline {
        height: 34px;
        background: #f9f9f9;
        width: 100%;
        line-height: 34px;
        color: #383838;
        padding-left: 12px;
        font-size: 16px;
    }
    li {
        width: 100%;
        cursor: pointer;
        img {
            width: 160px;
            margin: 10px 19px 0;
        }
        p {
            font-size: 12px;
            color: #333;
            margin: 0 14px 9px 20px;
        }
        p:nth-of-type(1) {
            &:hover {
                color: red;
            }
        }
        p:nth-of-type(2) {
            color: #e25b55;
        }
        p:last-child {
            margin-bottom: 0;
        }
        .xiaoliang {
            color: #e25b55;
        }
    }
    p:nth-of-type(2) {
        margin-bottom: 0;
    }
    li:last-child {
        margin-bottom: 15px;
    }
}
</style>
