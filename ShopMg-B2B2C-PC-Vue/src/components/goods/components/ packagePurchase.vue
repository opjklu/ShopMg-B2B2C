<template>
    <div class="middle">
        <div class="l tab">
            <ul class="l">
                <li
                    @click="change(index)"
                    :class="{bor: item.selected === true}"
                    class="l"
                    v-for="(item, index) in tabList"
                    :key="index"
                >{{item.name}}</li>
            </ul>
            <div class="l"></div>
        </div>
        <keep-alive>
            <component :is="components[tabIndex].component"></component>
        </keep-alive>
    </div>
</template>
<script>
import { Discount } from "../../../../es6/discount";

export default {
    data() {
        return {
            components: Discount.getComponents(),

            tabIndex: 0,

            tabList: Discount.getTabList()
        };
    },

    methods: {
        change(index) {
            this.tabIndex = index;

            this.tabList.forEach(element => {
                element.selected = false;
            });

            this.tabList[index].selected = true;
        },

         //计算需要加入购物车的id
        addCarToString(data) {
            let totalArr = [];
            data.map((item, index) => {
                totalArr.push(item.goods_id || ~~item.id);
            });
            return totalArr + "";
        },
    }
};
</script>


<style lang="less">
.class_one,
.class_three {
    .all {
        p:nth-of-type(2) {
            text-decoration: none !important;
            color: white !important;
        }
    }
}
.nullData {
    font-size: 35px;
    color: #999999;
    font-weight: 400;
    display: flex;
    flex: 1;
    justify-content: center;
    text-shadow: 0 1px 0 #ccc, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9,
        0 5px 0 #aaa, 0 6px 1px rgba(0, 0, 0, 0.1), 0 0 5px rgba(0, 0, 0, 0.1),
        0 1px 3px rgba(0, 0, 0, 0.3), 0 3px 5px rgba(0, 0, 0, 0.2),
        0 5px 10px rgba(0, 0, 0, 0.25);
}
.GoodsAccessories {
    overflow-x: auto;
    // width: 1020px;
    height: 200px;
}
.l {
    float: left;
}
.middle {
    height: 283px;
    margin-top: 20px;
    .tab {
        width: 100%;
        display: flex;
        ul:first-child {
            display: flex;
        }
        ul {
            border-left: 1px solid #e8e8e8;
            li {
                height: 40px;
                width: 94px;
                text-align: center;
                line-height: 40px;
                border: 1px solid #e8e8e8;
                border-left: 0;
                cursor: pointer;
            }
            .bor {
                border-bottom: 0;
                border-top-color: red;
                color: red;
            }
        }
        div {
            height: 40px;
            border: 1px solid #e8e8e8;
            border-left: 0;
            width: 917px;
        }
    }
    .taocan {
        width: 100%;
        height: 242px;
        border: 1px solid #e8e8e8;
        border-top: 0;
        text-align: center;
        display: flex;
        align-items: center;
        .shangpin {
            width: 155px;
            text-align: center;
            margin-right: 15px;
            img {
                margin: 14px auto;
                display: block;
                width: 142px;
                height: 124px;
            }
            p {
                font-size: 12px;
                color: #646464;
                cursor: pointer;
                text-align: left;
                white-space: nowrap;
                word-break: keep-all;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            p:nth-of-type(1) {
                &:hover {
                    color: red;
                }
            }
            p:nth-of-type(2) {
                color: #cc3441;
                margin-top: 12px;
            }
        }
        .add {
            margin: 84px 12px 0;
        }
        .all {
            p {
                cursor: pointer;
            }
            p:nth-of-type(1) {
                color: #bf1e2d;
                font-size: 12px;
                span:nth-of-type(1) {
                    font-size: 14px;
                }
                span:nth-of-type(2) {
                    width: 72px;
                    height: 20px;
                    display: inline-block;
                    background: #343434;
                    color: #fff;
                    text-align: center;
                    line-height: 20px;
                    margin-left: 20px;
                }
            }
            p:nth-of-type(2) {
                font-size: 12px;
                color: #323232;
                text-decoration: line-through;
            }
            .same {
                width: 112px;
                height: 24px;
                border: 1px solid #757575;
                text-align: center;
                line-height: 24px;
                border-radius: 3px;
                margin-top: 18px;
                font-size: 12px;
            }
            .buy {
                background: #f5e9cf;
                color: red;
            }
            .car {
                background: red;
                color: #fff;
                margin-top: 10px;
            }
        }
    }
}
</style>
