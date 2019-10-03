import Vue from 'vue'
import Router from 'vue-router'

//  首页
const home = () => import('../components/home/home.vue')
// 品牌
const brand = () => import('../components/brand/brand.vue')
// 品牌内页
const innerbrand = () => import('../components/brand/innerbrand.vue')
// 品牌内页
const compared = () => import('../components/brand/compared.vue')
// 所有商品页
const allGoods = () => import('../components/add/allGoods.vue')

// 店铺
const store = () => import('../components/store/store.vue')

// 店铺搜索
const storeSearch = () => import('../components/store/storeSearch.vue')

// 店铺内商品搜索
const TheStoreSearch = () => import('../components/storeSearch/storeSearch.vue')

// 店铺首页
const storehome = () => import('../components/store/storehome.vue')
// 店铺产品列表
const storelist = () => import('../components/store/storelist.vue')
// 皇家御饮
const royaldrink = () => import('../components/goods/royaldrink.vue')
// 商品分类
const goodsClass = () => import('../components/goods/goodsClass.vue')
// 商品搜索
const goodsSearch = () => import('../components/goods/goodsSearch.vue')
// 皇家御饮内页
const inroyaldrink = () => import('../components/goods/inroyaldrink.vue')
// 套餐购物车
const setMealCar = () => import('../components/goods/setMealCar.vue')
// 购物车
const buyCar = () => import('../components/buyCar/buyCar.vue')
// 购物车
const buyCarPackage = () => import('../components/buyCar/buyCarPackage.vue')
// 普通商品结算页
const account = () => import('../components/buyCar/account.vue')
// 套餐订单结算页
const orderInfo = () => import('../components/buyCar/orderInfo.vue')
// 商品订单结算

const confirmOrder = () => import('../components/confirmOrder/confirmOrder.vue')
// 支付
const pay = () => import('../components/pay/pay.vue')
// 普通商品支付宝成功页
const successCommonAlipay = () => import('../components/pay/successAlipay.vue')
// 余额充值支付宝成功页
const rechargeSuccess = () => import('../components/pay/rechargeSuccess.vue')
// 开店支付 支付宝成功页
const lookProgress = () => import('../components/pay/progressSuccess.vue')
// 积分商品支付宝成功页
const successAlipay = () => import('../components/pay/integralSuccess.vue')
// 套餐商品支付宝成功页
const successPackageAlipay = () => import('../components/pay/packageSuccess.vue')
// 套餐订单售后
const packageReturn = () => import('../components/personal/child/packageOrderDetail/packageReturn.vue')
// 套餐订单售后申请
const packageReturnApplication = () => import('../components/personal/child/packageOrderDetail/packageReturnApplication.vue')
// 套餐订单卖家处理退货申请
const handlingPackageReturns = () => import('../components/personal/child/packageOrderDetail/handlingPackageReturns.vue')
// 套餐订单买家退货给卖家
const theBuyerReturns = () => import('../components/personal/child/packageOrderDetail/theBuyerReturns.vue')
// 套餐订单卖家退款
const setARefund = () => import('../components/personal/child/packageOrderDetail/setARefund.vue')
// 微信支付成功页
const wxSuccess = () => import('../components/pay/successWeixin.vue')
// 微信支付
const wxpay = () => import('../components/pay/wxpay.vue')
// 积分商城
const integral = () => import('../components/integral/integral.vue')
// 积分商品详情页
const IntegralInside = () => import('../components/integral/IntegralInside.vue')
// 积分商城列表
const integrallist = () => import('../components/integral/integrallist.vue')
// 积分商城结算页
const Settlement = () => import('../components/integral/Settlement.vue')
// 个人中心首页
const homepage = () => import('../components/personal/homepage.vue')
// 个人中心欢迎页
const greet = () => import('../components/personal/child/greet.vue')
// 个人资料
const personalData = () => import('../components/personal/child/personal.vue')
// 账户安全
const security = () => import('../components/personal/child/accountSecurity.vue')
// 账户绑定
const bound = () => import('../components/personal/child/bound.vue')
// 收货地址
const receive = () => import('../components/personal/child/receive.vue')
// 我的消息
const myNews = () => import('../components/personal/child/myNews.vue')
// 我的订单
const myOrder = () => import('../components/personal/child/myOrder.vue')
// 积分订单
const integralOrder = () => import('../components/personal/child/integralOrder.vue')
// 我的评价
const evaluation = () => import('../components/personal/child/evaluation.vue')
// 退款退货
const goodSrefund = () => import('../components/personal/child/goodsRefund.vue')
// 套餐商品退款退货
const packageSrefund = () => import('../components/personal/child/packageSrefund.vue')
// 我的投诉
const complaint = () => import('../components/personal/child/complaint.vue')
// 我的账户
const myAccount = () => import('../components/personal/child/myAccount.vue')
// 我的积分
const myIntegral = () => import('../components/personal/child/myIntegral.vue')

// 我的优惠券
const myCoupons = () => import('../components/personal/child/myCoupons.vue')
// 我的充值
const myCharge = () => import('../components/personal/child/myCharge.vue')
// 我的提现账户
const withdraWalaccount = () => import('../components/personal/child/withdrawalAccount.vue')
// 我的提现
const myWithdrawal = () => import('../components/personal/child/myWithdrawal.vue')
// 发票信息
const invoiceInfo = () => import('../components/personal/child/invoiceInfo.vue')
// 发票管理
const invoiceManage = () => import('../components/personal/child/invoiceManage.vue')

// 底部购物指南-列表页
const guide = () => import('../components/words/article.vue')
// 公告--列表--详情
const notice = () => import('../components/words/notice.vue')
// 申请售后
const apply = () => import('../components/personal/apply.vue')
// 余额充值
const recharge = () => import('../components/personal/recharge.vue')
// 换货处理---仅换货
const exchange = () => import('../components/personal/exchange.vue')
// 退款申请
// 提现申请
const drawMoney = () => import('../components/drawMoney/drawMoney.vue')
// 换货申请
const applyChange = () => import('../components/personal/applyChange.vue')
// 换货处理
const disposeChange = () => import('../components/personal/disposeChange.vue')
// 退款退货
const withdraw = () => import('../components/personal/withdraw.vue')
// 退款退货申请
const returnGoods = () => import('../components/personal/returnGoods.vue')
// 退款退货处理
const returnHandle = () => import('../components/personal/returnHandle.vue')
// 买家退货给卖家
const sellerReceives = () => import('../components/personal/sellerReceives.vue')
// 卖家退款
const sellerRefund = () => import('../components/personal/sellerRefund.vue')
// 退款退货详情
const xiangQing = () => import('../components/personal/xiangQing.vue')
// 我的收藏
const collect = () => import('../components/personal/collect.vue')
// 最近浏览
const ecentBrowse = () => import('../components/personal/ecentbrowse.vue')
// 我的订单-----买家投诉
const complain = () => import('../components/personal/complain.vue')
// 招商入驻  -------查看进度
const progressLook = () => import('../components/personal/child/lookProgress.vue')
// 招商入驻  -------入驻协议
const agreement = () => import('../components/business/agreement.vue')
// 招商入驻  -------个人入驻
const personAdmission = () => import('../components/business/child/personAdmission.vue')
// 招商入驻  -------个人入驻银行卡信息
const personBankInfo = () => import('../components/business/child/personBankInfo.vue')
// 招商入驻  -------个人入驻店铺信息
const personShopInfo = () => import('../components/business/child/personShopInfo.vue')
// 招商入驻  -------企业入驻
const companyAdmission = () => import('../components/business/child/companyAdmission.vue')
// 招商入驻  -------企业入驻银行卡信息
const companyBankInfo = () => import('../components/business/child/companyBankInfo.vue')
// 招商入驻  -------企业入驻店铺信息
const companyShopInfo = () => import('../components/business/child/companyShopInfo.vue')
// 招商入驻  -------提示页
const Submit = () => import('../components/business/submit.vue')
// 招商入驻  -------编辑个人开店信息第一页
const halfwayOne = () => import('../components/business/child/halfwayOne.vue')
// 招商入驻  -------编辑个人开店信息第二页
const halfwayTwo = () => import('../components/business/child/halfwayTwo.vue')
// 招商入驻  -------编辑企业开店信息第一页
const companyOne = () => import('../components/business/child/companyOne.vue')
// 招商入驻  -------编辑企业开店信息第二页
const companyTwo = () => import('../components/business/child/companyTwo.vue')
// 招商入驻  -------编辑企业开店信息第三页
const companyTherr = () => import('../components/business/child/companyTherr.vue')

// 引入抢购页面
const chase = () => import('../components/panic/chase.vue')
const introduce = () => import('../components/panic/introduce.vue')
const settleAccounts = () => import('../components/panic/settleAccounts.vue')
const payment = () => import('../components/panic/payment.vue')
const progress = () => import('../components/business/progress.vue')
const passwordLogin = () => import('../components/login/passwordLogin.vue')
const find = () => import('../components/login/find.vue')
const findTwo = () => import('../components/login/findTwo.vue')
const findThree = () => import('../components/login/findThree.vue')
const findFour = () => import('../components/login/findFour.vue')
const register = () => import('../components/login/register.vue')
const packagePay = () => import('../components/packagePay/packagePay.vue')

//  引入公共组件
const headCom = () => import('../common/headCom.vue')
const homeHeadCom = () => import('../common/homeHeadCom.vue')
const storeheader = () => import('../common/storeHeader.vue')
const footCom = () => import('../common/footCom.vue')
const buyHeader = () => import('../common/buyHeader.vue')
const Header = () => import('../common/Header.vue')
const backTop = () => import('../common/backTop.vue')
const receivingAddress = () => import('../common/receivingAddress.vue')
const myShoppingCart = () => import('../common/myShoppingCart.vue')
const addressOperation = () => import('../common/addressOperation.vue')
const selectionArea = () => import('../common/selectionArea.vue')
const likeAndHistory = () => import('../common/likeAndHistory.vue')

Vue.component('head-com', headCom)
Vue.component('home-head-com', homeHeadCom)
Vue.component('store-header', storeheader) //  店铺头部
Vue.component('foot-com', footCom)
Vue.component('buy-header', buyHeader)
Vue.component('common-header', Header)
Vue.component('back-top', backTop)
Vue.component('receiving-address', receivingAddress)
Vue.component('my-shopping-cart', myShoppingCart)
Vue.component('address-operation', addressOperation)
Vue.component('selection-area', selectionArea)
Vue.component('like-and-history', likeAndHistory)
Vue.component('logo-component', () => import('../common/logoComponent.vue'))
Vue.use(Router)

//  路由配置
export default new Router({
  mode: 'history',
  routes: [
    // //  重定向
    {
      path: '/',
      name: 'default',
      redirect: {
        name: 'home',
        component: home
      }
    },
    // 首页
    {
      path: '/home',
      name: 'home',
      component: home
    },
    // 所有商品页
    {
      path: '/allGoods',
      name: 'allGoods',
      component: allGoods
    },
    // 品牌
    {
      path: '/brand',
      name: 'brand',
      component: brand
    },
    // 品牌内页
    {
      path: '/innerbrand/:id',
      name: 'innerbrand',
      component: innerbrand
    },
    // 品牌内页
    {
      path: '/compared/:id',
      name: 'compared',
      component: compared
    },
    // 店铺
    {
      path: '/store',
      name: 'store',
      component: store
    },
    // 店铺搜索
    {
      path: '/storeSearch',
      name: 'storeSearch',
      component: storeSearch
    },
    // 店内商品搜索
    {
      path: '/TheStoreSearch',
      name: 'TheStoreSearch',
      component: TheStoreSearch
    },
    // 套餐购物车
    {
      path: '/setMealCar',
      name: 'setMealCar',
      component: setMealCar
    },
    // 套餐支付
    {
      path: '/packagePay',
      name: 'packagePay',
      component: packagePay
    },
    // 店铺首页
    {
      path: '/storehome',
      name: 'storehome',
      component: storehome
    },
    // 店铺产品列表
    {
      path: '/storelist',
      name: 'storelist',
      component: storelist
    },
    // 皇家御饮
    {
      path: '/royaldrink',
      name: 'royaldrink',
      component: royaldrink
    },
    // 商品分类
    {
      path: '/goodsClass',
      name: 'goodsClass',
      component: goodsClass
    },

    // 商品搜索
    {
      path: '/goodsSearch',
      name: 'goodsSearch',
      component: goodsSearch
    },
    // 皇家御饮内页
    {
      path: '/inroyaldrink',
      name: 'inroyaldrink',
      component: inroyaldrink
    },
    // 最佳组合 结算页
    {
      path: '/recommendAndGroupAccout',
      name: 'recommendAndGroupAccout',
      component: () =>
        import('../components/goods/recommendAndGroupAccout')
    },

    // 购物车
    {
      path: '/buyCar',
      name: 'buyCar',
      component: buyCar
    },
    // 购物车
    {
      path: '/buyCarPackage',
      name: 'buyCarPackage',
      component: buyCarPackage
    },
    // 普通商品结算页
    {
      path: '/account',
      name: 'account',
      component: account
    },
    // 套餐商品结算页
    {
      path: '/orderInfo',
      name: 'orderInfo',
      component: orderInfo
    },
    // 商品订单结算
    {
      path: '/confirmOrder/:goods_id/:num',
      name: 'confirmOrder',
      component: confirmOrder
    },
    // 支付
    {
      path: '/pay',
      name: 'pay',
      component: pay
    },
    // 积分支付
    {
      path: '/integralPay',
      name: 'integralPay',
      component: () =>
        import('../components/integral/integralPay.vue')
    },
    // 微信积分支付
    {
      path: '/integralwxPay',
      name: 'integralwxPay',
      component: () =>
        import('../components/integral/integralwxPay.vue')
    },
    // 微信支付
    {
      path: '/wxpay/:total_price/:id/:state',
      name: 'wxpay',
      component: wxpay
    },
    // 普通商品支付宝支付成功页
    {
      path: '/successCommonAlipay',
      name: 'successCommonAlipay',
      component: successCommonAlipay
    },
    // 余额充值支付宝成功页
    {
      path: '/rechargeSuccess',
      name: 'rechargeSuccess',
      component: rechargeSuccess
    },
    // 开店支付 支付宝成功页
    {
      path: '/lookProgress',
      name: 'lookProgress',
      component: lookProgress
    },
    // 积分商品支付支付宝成功页
    {
      path: '/successAlipay',
      name: 'successAlipay',
      component: successAlipay
    },
    // 套餐商品支付支付宝成功页
    {
      path: '/successPackageAlipay',
      name: 'successPackageAlipay',
      component: successPackageAlipay
    },
    // 微信支付成功页
    {
      path: '/wxSuccess',
      name: 'wxSuccess',
      component: wxSuccess
    },

    // 积分商城
    {
      path: '/integral',
      name: 'integral',
      component: integral
    },
    // 积分详情页
    {
      path: '/IntegralInside',
      name: 'IntegralInside',
      component: IntegralInside
    },
    // 积分商城列表
    {
      path: '/integrallist',
      name: 'integrallist',
      component: integrallist
    },
    // 积分商城结算页
    {
      path: '/Settlement/:id',
      name: 'Settlement',
      component: Settlement
    },
    {
      // 提现申请
      path: '/drawMoney',
      name: 'drawMoney',
      component: drawMoney
    },
    // 套餐订单售后
    {
      path: '/packageReturn',
      name: 'packageReturn',
      component: packageReturn
    },
    // 套餐订单售后申请
    {
      path: '/packageReturnApplication',
      name: 'packageReturnApplication',
      component: packageReturnApplication
    },
    // 套餐订单卖家处理退货申请
    {
      path: '/handlingPackageReturns',
      name: 'handlingPackageReturns',
      component: handlingPackageReturns
    },
    // 套餐订单买家退货给卖家
    {
      path: '/theBuyerReturns',
      name: 'theBuyerReturns',
      component: theBuyerReturns
    },
    // 套餐订单卖家退款
    {
      path: '/setARefund',
      name: 'setARefund',
      component: setARefund
    },
    // 个人中心首页
    {
      path: '/homepage',
      name: 'homepage',
      component: homepage,
      children: [
        // 重定向
        {
          path: '/homepage',
          redirect: '/greet'
        },
        {
          // 个人中心欢迎页
          path: '/greet',
          name: 'greet',
          component: greet
        },
        {
          // 个人资料
          path: '/personalData',
          name: 'personalData',
          component: personalData
        },
        {
          // 账户安全
          path: '/security',
          name: 'security',
          component: security
        },
        {
          // 账户绑定
          path: '/bound',
          name: 'bound',
          component: bound
        },
        {
          // 收货地址
          path: '/receive',
          name: 'receive',
          component: receive
        },
        {
          // 我的消息
          path: '/myNews',
          name: 'myNews',
          component: myNews
        },
        {
          // 我的订单
          path: '/myOrder',
          name: 'myOrder',
          component: myOrder
        },
        {
          // 积分订单
          path: '/integralOrder',
          name: 'integralOrder',
          component: integralOrder
        },
        { // 套餐订单
          path: '/packageOrder',
          name: 'packageOrder',
          component: () =>
            import('../components/personal/child/packageOrder')
        },
        { // 套餐订单详情
          path: '/packageOrderDetail',
          name: 'packageOrderDetail',
          component: () => import('../components/personal/child/packageOrderDetail/orderDetail')
        },

        // 订单详情
        {
          path: '/orderDetail',
          name: 'orderDetail',
          component: () => import('../components/personal/child/order/orderDetail')
        },
        // 积分订单详情
        {
          path: '/integralDetail',
          name: 'integralDetail',
          component: () => import('../components/personal/child/integralOrder/orderDetail')
        },
        // 评论详情
        {
          path: '/commentDetail',
          name: 'commentDetail',
          component: () => import('../components/personal/child/commentDetail')
        },
        // 物流详情
        {
          path: '/logistics/',
          name: 'logistics',
          component: () => import('../components/personal/child/order/logistics')
        },

        {
          // 我的评价
          path: '/evaluation',
          name: 'evaluation',
          component: evaluation
        },
        {
          // 我的评价详情
          path: '/commentDetail',
          name: 'commentDetail',
          component: () => import('../components/personal/child/commentDetail')
        },
        {
          // 发布评价
          path: '/publishComment',
          name: 'publishComment',
          component: () => import('../components/personal/child/publishComment')
        },
        {
          // 退款退货
          path: '/goodSrefund',
          name: 'goodSrefund',
          component: goodSrefund
        },
        {
          // 套餐商品退款退货
          path: '/packageSrefund',
          name: 'packageSrefund',
          component: packageSrefund
        },
        {
          // 我的投诉
          path: '/complaint',
          name: 'complaint',
          component: complaint
        },
        {
          // 我的账户
          path: '/myAccount',
          name: 'myAccount',
          component: myAccount
        },
        {
          // 我的积分
          path: '/myIntegral',
          name: 'myIntegral',
          component: myIntegral
        },
        {
          // 我的优惠券
          path: '/myCoupons',
          name: 'myCoupons',
          component: myCoupons
        },
        {
          // 我的充值
          path: '/myCharge',
          name: 'myCharge',
          component: myCharge
        },
        {
          // 我的提现账户
          path: '/withdraWalaccount',
          name: 'withdraWalaccount',
          component: withdraWalaccount
        },
        {
          // 我的提现
          path: '/myWithdrawal',
          name: 'myWithdrawal',
          component: myWithdrawal
        },

        {
          // 发票信息
          path: '/invoiceInfo',
          name: 'invoiceInfo',
          component: invoiceInfo
        },
        {
          // 发票管理
          path: '/invoiceManage',
          name: 'invoiceManage',
          component: invoiceManage
        },
        // 招商入驻  -------查看进度
        {
          path: '/progressLook',
          name: 'progressLook',
          component: progressLook
        }
      ]
    },
    // 底部购物指南-列表页
    {
      path: '/guide',
      name: 'guide',
      component: guide
    },
    // 公告列表详情
    {
      path: '/notice',
      name: 'notice',
      component: notice
    },
    // 申请售后
    {
      path: '/apply',
      name: 'apply',
      component: apply
    },
    // 余额充值
    {
      path: '/recharge',
      name: 'recharge',
      component: recharge
    },
    // 仅换货
    {
      path: '/exchange',
      name: 'exchange',
      component: exchange
    },

    // 换货申请
    {
      path: '/applyChange',
      name: 'applyChange',
      component: applyChange
    },
    // 换货申请
    {
      path: '/disposeChange',
      name: 'disposeChange',
      component: disposeChange
    },
    // 退款退货
    {
      path: '/withdraw',
      name: 'withdraw',
      component: withdraw
    },
    // 退款退货申请
    {
      path: '/returnGoods',
      name: 'returnGoods',
      component: returnGoods
    },
    // 退款退货处理
    {
      path: '/returnHandle',
      name: 'returnHandle',
      component: returnHandle
    },
    // 买家退货给卖家
    {
      path: '/sellerReceives',
      name: 'sellerReceives',
      component: sellerReceives
    },
    // 卖家退款
    {
      path: '/sellerRefund',
      name: 'sellerRefund',
      component: sellerRefund
    },
    // 退款退货详情
    {
      path: '/xiangQing',
      name: 'xiangQing',
      component: xiangQing
    },
    // 我的收藏
    {
      path: '/collect',
      name: 'collect',
      component: collect
    },
    // 最近浏览
    {
      path: '/ecentBrowse',
      name: 'ecentBrowse',
      component: ecentBrowse
    },
    // 我的订单-----买家投诉
    {
      path: '/complain',
      name: 'complain',
      component: complain
    },
    // 招商入驻  -------入驻协议
    {
      path: '/agreement',
      name: 'agreement',
      component: agreement
    },
    // 招商入驻  -------个人入驻个人信息
    {
      path: '/personAdmission',
      name: 'personAdmission',
      component: personAdmission
    },
    // 招商入驻  -------个人入驻个人银行信息
    {
      path: '/personBankInfo',
      name: 'personBankInfo',
      component: personBankInfo
    },
    // 招商入驻  -------个人入驻店铺信息
    {
      path: '/personShopInfo',
      name: 'personShopInfo',
      component: personShopInfo
    },
    // 招商入驻  -------企业入驻
    {
      path: '/companyAdmission',
      name: 'companyAdmission',
      component: companyAdmission
    },
    // 招商入驻  -------企业入驻银行卡信息
    {
      path: '/companyBankInfo',
      name: 'companyBankInfo',
      component: companyBankInfo
    },
    // 招商入驻  -------企业入驻店铺信息
    {
      path: '/companyShopInfo',
      name: 'companyShopInfo',
      component: companyShopInfo
    },
    // 招商入驻  -------提示页
    {
      path: '/Submit',
      name: 'Submit',
      component: Submit
    },
    {
      path: '/chase',
      name: 'chase',
      component: chase
    },
    {
      path: '/introduce/:id',
      name: 'introduce',
      component: introduce
    },
    { // 抢购内页
      path: '/settleAccounts',
      name: 'settleAccounts',
      component: settleAccounts
    },
    { // 抢购支付页
      path: '/payment',
      name: 'payment',
      component: payment
    },
    // 招商入驻12-0
    {
      path: '/progress',
      name: 'progress',
      component: progress
    },

    // 招商入住 编辑个人开店信息第一页
    {
      path: '/halfwayOne',
      name: 'halfwayOne',
      component: halfwayOne
    },
    // 招商入住 编辑个人开店信息第二页
    {
      path: '/halfwayTwo',
      name: 'halfwayTwo',
      component: halfwayTwo
    },
    // 招商入住 编辑企业开店信息第一页
    {
      path: '/companyOne',
      name: 'companyOne',
      component: companyOne
    },
    // 招商入住 编辑企业开店信息第二页
    {
      path: '/companyTwo',
      name: 'companyTwo',
      component: companyTwo
    },
    // 招商入住 编辑企业开店信息第三页
    {
      path: '/companyTherr',
      name: 'companyTherr',
      component: companyTherr
    },
    // 密码登录
    {
      path: '/passwordLogin',
      name: 'passwordLogin',
      component: passwordLogin
    },
    // 找回密码1
    {
      path: '/find',
      name: 'find',
      component: find
    },
    // 找回密码2
    {
      path: '/findTwo',
      name: 'findTwo',
      component: findTwo
    },
    // 找回密码3
    {
      path: '/findThree',
      name: 'findThree',
      component: findThree
    },
    // 找回密码4
    {
      path: '/findFour',
      name: 'findFour',
      component: findFour
    },
    // 注册
    {
      path: '/register',
      name: 'register',
      component: register
    }
  ]
})
