<template>
    <div class="commentDetail">
        <div class="xiangqing r">
            <div class="top">
                <p class="l">评价详情</p>
                <p class="r">
                    <span>卖家：{{i}}</span>
                    <span>订单号：{{l}}}</span>
                </p>
            </div>
            <div class="header">
                <span>宝贝信息</span>
                <span>评价状态</span>
                <span>评价内容</span>
            </div>
            <div class="both">
                <div class="zuo l" >
                    <img class="img" :src="URL + goods.pic_url">
                    <div>
                        <p>您的评价已生效</p>
                        <p>{{ ~~comment.status === 1 ? '您的评价已在宝贝页展示' : '将不会显示您的评价'}}</p>
                    </div>
                </div>
                <div class="you l">
                    <div class="Title">
                        <p>评论内容：</p>
                        <p style="color:#333">晒图：</p>
                        <p>评论时间：</p>
                        <p>评价：</p>
                        <p>标签：</p>
                    </div>
                    <p>{{comment.content}}</p>
                    <p>
                        <img
                            class="imgs"
                            v-show="commentImage.length"
                            v-for="(img, index) in  commentImage"
                            :key="index"
                            :src="URL + img.path"
                        >
                    </p>
                    <p>{{comment.create_time| formatDate}}</p>
                    <p class="grade">
                        <el-rate
                            v-model="star"
                            disabled
                            show-score
                            text-color="#ff9900"
                            score-template="{value}"
                        ></el-rate>
                    </p>
                    <p class="label">
                        <span v-if="data.labels!=null">{{tag[Number(data.labels)]}}</span>
                        <span v-else>暂无标签</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            star: 0,
            goods: [],
            tag: ["手感好", "发货快", "物美价廉", "性价比高"],
            comment: {},
            commentImage: []
        };
    },
    created() {
        this.HTTP(
            this.$httpConfig.commentDetail,
            {
                order_id: this.$route.query.id,
                goods_id: this.$route.query.goods_id
            },
            "post", false
        ).then(res => {
            this.data = res.data;
            this.goods = res.data.goods;
            this.commentImage = res.data.comment_image,
            this.comment = res.data.comment;
            this.star = Number(this.data.score);
        });
    },
    methods: {}
};
</script>
<style lang="less" scoped>
.img {
}
.l {
    float: left;
}
.r {
    float: right;
}
.xiangqing {
    height: 956px;
    width: 980px;
    background: #fff;
    margin: 16px 0;
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
    .header {
        height: 42px;
        line-height: 42px;
        background: #f1f1f1;
        margin: 0 17px 8px;
        span {
            font-size: 12px;
            color: #3b3b3b;
        }
        span:nth-of-type(1) {
            margin: 0 92px 0 40px;
        }
        span:nth-of-type(3) {
            margin-left: 174px;
        }
    }
    .both {
        height: 217px;
        border: 1px solid #e7e6e6;
        margin: 0 17px 9px;
        .zuo {
            width: 260px;
            border-right: 1px solid #e7e6e6;
            height: 100%;
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
            img {
                //margin: 13px 86px 0 13px;
                //float: left;
                width: 100px;
                height: 100px;
                //margin:20px 20px 0 13px!;
            }
            div {
                font-size: 12px;
                color: #333;
                line-height: 24px;
            }
        }
        .you {
            width: 534px;
            height: 100%;
            margin-left: 14px;
            float: left;
            .Title {
                width: 80px;
                float: left;
                p:nth-of-type(1) {
                    height: 20px;
                }
                p:nth-of-type(2) {
                    height: 80px;
                }
                p:nth-of-type(3) {
                    height: 15px;
                    margin-top: -3px;
                }
                p:nth-of-type(5) {
                    margin-top: 10px;
                }
            }
            .grade {
                margin-top: -3px;
            }
            .label {
                margin-top: 8px;
                font-weight: lighter;
            }
            p {
                font-size: 12px;
                color: #333;
            }
            p:nth-of-type(1) {
                margin-top: 22px;
                color: #333 !important;
            }
            .imgs {
                //margin-left: -8px;
                //margin-top: 10px;
                width: 80px;
            }
            p:nth-of-type(2) {
                color: #999;
                height: 80px;
                margin: 10px 0 11px 0;
            }
            p:nth-of-type(3) {
                overflow: hidden;
                margin-bottom: 15px;
                img {
                    padding-top: -3px;
                }
                span {
                    color: red;
                    margin-left: 9px;
                }
            }
            p:nth-of-type(4) {
                span {
                    display: inline-block;
                    width: 90px;
                    height: 22px;
                    text-align: center;
                    line-height: 22px;
                    color: #333;
                    margin-right: 10px;
                    background: #eef1ff;
                }
            }
        }
    }
}
</style>