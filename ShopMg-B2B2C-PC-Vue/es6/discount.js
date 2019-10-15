/**
 *  优惠套餐相关
 */
class Discount {
    static getComponents() {

        return [
            {
                component: () => import("@/components/goods/components/discount/recommendedAccessories.vue"),
            },
            {
                component: () => import("@/components/goods/components/discount/discountPackage.vue"),
            },

            {
                component: () => import("@/components/goods/components/discount/bestCombination.vue"),
            }
        ];
    }

    static getTabList() {
        return [
            {
                selected: true,
                name: '推荐配件'
            },
            {
                selected: false,
                name: '优惠套餐'
            },

            {
                selected: false,
                name: '最佳组合'
            }
        ];
    }
}

export { Discount }