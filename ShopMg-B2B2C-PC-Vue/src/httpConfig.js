const userModuleIndex = ''
 const request = 'http://api.shopqorg.com/'

// const request = 'http://pcapi.local.com/'

const uploadImage = ''
const imgRequest = 'http://image.shoporg.com/'
const config = {
  // 公共部分
  getCommonHeader: request + userModuleIndex + 'HomeIndex/commonHeader', // 首页头部
  getBalance: request + 'balance/getBalance', // 账号余额
  getCooprativeList: request + 'cooperativePartner/getCooprativeList', // 底部合作伙伴
  getKeyWordsList: request + 'hotWords/getKeyWordsList', // 商品关键词
  nav: request + 'nav/getNavList', // 导航
  announcementLIst: request + '/announcement/announcement',
  // 网站信息
  aboutEtcetera: request + 'intnetInfomartion/aboutEtcetera',
  // 公共底部
  commonFloor: request + 'articleCategory/categoryLists',
  // 登录注册
  register: request + 'register/accountRegister', //  用户注册
  login: request + 'register/loginAccount', //  账户登录
  sms: request + 'register/registerSendMsg', //  注册--发送短信
  smsLoginSend: request + 'register/smsLogin', // 手机登录
  smsLogin: request + 'register/loginSendMsg', //  短信登录发送短信
  QQThirdPartyLogin: request + 'qQThirdPartyLogin/qqLogin', //  第三方授权登录
  sendPhoneNumber: request + 'accountSecurity/sendPhoneNumber', // 账户安全-发送短信 :多用
  backPwdSendSms: request + 'register/backPwdSendSms', // 找回密码--短信发送
  backPwd: request + 'register/backPwd', // 找回密码
  outLogin: request + userModuleIndex + 'logOut/logOut', // 退出登录

  //  首页
  home: request + 'homeIndex/home', //  首页信息获取
  getClass: request + 'goodsClass/getClassByPid', // 首页商品分类
  getChildrenClass: request + 'goodsClass/getClassChildrenByParent', // 首页商品分类
  homefLoor: request + 'floor/homefLoor', // 首页楼层
  randStore: request + 'store/storeShoppingList', // 首页店铺街换一批
  SearchIndex: request + 'searchIndex/search', // 首页搜索
  getGoodsInStore: request + 'storeSearchGoods/getGoodsInStore', // 店铺首页搜索

  //  品牌
  recommendBrand: request + 'brand/recommendBrand', // 推荐品牌
  brandList: request + 'brand/brand_list', // 品牌店列表

  // 店铺
  ShopGoodClass: request + 'storeClass/storeClasses', // 店铺分类
  getStoreList: request + 'store/storeList', //  首页店铺列表
  getStoreListBySearch: request + 'store/storeListBySearch', //  首页店铺列表（用于搜索）
  getStar: request + 'storeEvaluate/getTheStoreDynamicRating', // 店铺动态评分
  getStoreNav: request + 'storeNav/storeNav', // 店铺导航
  getStoreClass: request + 'storeBindClass/storeClass', // 获取店铺导航商品分类
  getStoreBanner: request + 'storeAdv/getBanner', // 获取店铺轮播
  getStoreDetails: request + 'store/shopDetails', // 获取店铺详情
  setAttenStore: request + 'storeFollow/attenStore', // 关注店铺
  setCancelAttenStore: request + 'storeFollow/cancelAttenStore', // 取消关注店铺
  getStoreDetonating: request + 'goods/detonating', // 店铺爆品专区
  getStoreRecommendGoods: request + 'goods/recommendGoods', // 店铺推荐商品
  getStoreNewArrivalsGoodsByStore: request + 'goods/newArrivalsGoodsByStore', // 店铺新品推荐
  getStoreGoodsAll: request + 'goods/storeGoodsAll', // 店铺商品列表
  getStoreTopSelling: request + 'goods/hotSelling', // 店铺热销排行
  getTheStoreSearch: request + 'storeSearchGoods/searchGoodsList', // 店铺内搜索
  getGoodsStoreRankingsList: request + 'storeRankings/getGoodsStoreRankingsList', // 店内排行榜
  //  积分
  getAttenStore: request + 'goods/getGoodsListByIntegral', // 热兑商品
  getIntegralGoodsNewList: request + 'integralGoods/integralGoodsNewList', // 最新兑换商品
  getBrandList: request + 'brand/brandList', // 获取商品品牌
  getIntegralGoodsList: request + 'integralGoods/integralGoodsList', // 所有积分商品列表
  getIntegralGoodsDetail: request + 'integralGoods/integralGoodsList', // 积分商品详情
  IntegraltoSettleAccounts: request + 'integralGoods/toSettleAccounts', // 积分商品去结算(确认订单信息)
  IntegraltoAd: request + 'ad/getIntegralAd', // 积分商品去结算(确认订单信息)
  IntegralNumber: request + 'userData/getIntegralCache', // 积分商城获取积分信息

  // 我的收藏
  myCollectionGoods: request + userModuleIndex + 'collection/myCollectionGoods', // 获取商品收藏
  myCollectionLike: request + userModuleIndex + 'footPrint/myCollectionLike', // 猜你喜欢
  myCollectionStore: request + userModuleIndex + 'storeFollow/myCollectionStore', // 店铺收藏
  collectionDel: request + userModuleIndex + 'collection/myCollectionDel', // 商品收藏单个删除
  collectionDelAll: request + userModuleIndex + 'pcenter/myCollectionDelAll', // 商品收藏批量删除
  commoditySearch: request + userModuleIndex + 'collection/myCollectionBySearch', // 商品搜索
  myStoreFollowSearch: request + userModuleIndex + 'storeFollow/myStoreFollowSearch', // 店铺搜索
  myStoreFollowDel: request + 'storeFollow/cancelAttenStore', // 店铺收藏删除

  // 个人中心
  shopCollection: request + userModuleIndex + 'storeFollow/myCollectionStore', // 个人中心首页店铺收藏
  goodsCollection: request + userModuleIndex + 'collection/mycollectiondity', // 个人中心首页商品收藏
  myCollectionlikes: request + userModuleIndex + 'footPrint/myCollectionlikes', // 个人中心首页猜你喜欢
  myCollectionShopping: request + userModuleIndex + 'pcenter/myCollectionShopping', // 个人中心首页我的购物车
  myCollectionRecords: request + userModuleIndex + 'footPrint/myCollectionRecords', // 个人中心首页浏览记录
  orderStatusNum: request + userModuleIndex + 'orderMake/orderStatusNum', // 个人中心首页订单数
  userInfo: request + userModuleIndex + 'user/userInfo', // 个人资料基本资料
  userInfoEdit: request + userModuleIndex + 'user/userInfoEdit', // 个人资料基本资料修改
  getuploadIdCard: request + userModuleIndex + 'image/uploadIdCard', // 个人资料身份证正面
  getuploadIdCardSide: request + userModuleIndex + 'image/uploadIdCardSide', // 个人资料身份证反面
  getidentityAuthentication: request + userModuleIndex + 'user/identityAuthentication', // 个人资料身份保存
  uploadPicture: imgRequest + uploadImage + userModuleIndex + 'HeaderUpload/uploadImage', // 个人资料基本头像修改
  parseuserHeader: request + userModuleIndex + 'userHeader/parseuserHeader', // 保存个人资料头像
  userSecurityDetails: request + userModuleIndex + 'user/userSecurityDetails', // 账户安全用户资料
  accountSecurityVerify: request + userModuleIndex + 'accountSecurity/accountSecurityVerify', // 图形验证码
  accountSecurityCheckVerify: request + userModuleIndex + 'accountSecurity/accountSecurityCheckVerify', // 验证验证码
  shortMessageVerification: request + userModuleIndex + 'accountSecurity/shortMessageVerification', // 验证短信验证码
  emailsendMailbox: request + userModuleIndex + 'accountSecurity/sendMailbox', // 发送邮箱验证
  emailverifMailbox: request + userModuleIndex + 'accountSecurity/verifMailbox', // 验证邮箱
  sendPhoneNumberByEditPhone: request + userModuleIndex + 'accountSecurity/sendPhoneNumberByEditPhone', // 【修改手机号】发送验证码
  modifyIphone: request + userModuleIndex + 'accountSecurity/modifyIphone', // 账户安全-修改绑定手机:第二步
  verificationPassword: request + userModuleIndex + 'accountSecurity/verificationPassword', // 修改密码
  modifyPassword: request + userModuleIndex + 'accountSecurity/modifyPassword', // 新密码
  integralRule: request + userModuleIndex + 'userLevel/getList', // 资金中心我的积分规则
  myIntegral: request + userModuleIndex + 'userData/getLevel', // 资金中心我的积分
  myCouponLists: request + userModuleIndex + 'couponList/myCouponLists', // 资金中心我的优惠券
  rechargeList: request + userModuleIndex + 'balanceRecord/getBalanceList', // 资金中心我的充值记录
  rechargeType: request + userModuleIndex + 'recharge/rechargeType', // 资金中心我的充值类型
  getDetailsType: request + userModuleIndex + 'balance/getDetailsType', // 资金中心-我的账户-交易明细
  getDetailsIncome: request + userModuleIndex + 'balance/getDetailsIncome', // 资金中心-我的账户-收入
  getDetailsPay: request + userModuleIndex + 'balance/getDetailsPay', // 资金中心-我的账户-支出
  balanceRecharge: request + userModuleIndex + 'recharge/balanceRecharge', // 资金中心-我的账户-余额充值
  cashBehavior: request + userModuleIndex + 'cashWithdrawal/cashBehavior', // 提现
  loGcashBehavior: request + userModuleIndex + 'cashWithdrawalLog/cashBehavior', // 提现日志
  foRcashAppliation: request + userModuleIndex + 'cashWithdrawalApplication/cashAppliation', // 提现申请
  getPayRechargeResult: request + 'getPayType/getPayRechargeResult', // 资金中心-我的账户-余额充值 充值类型
  integralLog: request + userModuleIndex + 'integral/getOwnIntegralList',
  getInvoiceAreRaised: request + userModuleIndex + 'invoicesAreRaised/getInvoiceAreRaised', // 发票信息普通发票
  capitaList: request + userModuleIndex + 'invoice/capitaList', // 发票信息增值发票
  capitaAdd: request + userModuleIndex + 'invoice/capitaAdd', // 发票信息新增增值发票
  capitaDetails: request + userModuleIndex + 'invoice/capitaDetails', // 发票信息增值发票详情
  capitaDelete: request + userModuleIndex + 'invoice/capitaDelete', // 发票信息删除增值发票
  capitaSave: request + userModuleIndex + 'invoice/capitaSave', // 发票信息修改增值发票
  invoicesAreRaisedAdd: request + userModuleIndex + 'invoicesAreRaised/invoicesAreRaisedAdd', // 发票信息添加发票抬头
  invoicesAreRaisedDelete: request + userModuleIndex + 'invoicesAreRaised/delete', // 发票信息删除发票抬头
  invoicesAreRaisedSave: request + userModuleIndex + 'invoicesAreRaised/invoicesAreRaisedSave', // 发票信息修改发票抬头
  getMyFootFrint: request + userModuleIndex + 'footPrint/myFootFrint', // 个人中心-最近浏览
  myFootFrintSearch: request + userModuleIndex + 'footPrint/myFootFrintSearch', // 最近浏览--宝贝搜索
  myFootFrintDel: request + userModuleIndex + 'footPrint/myFootFrintDel', // 最近浏览--删除
  getOrderReturnList: request + userModuleIndex + 'orderReturnGoods/orderReturnList', // 退货-退货列表,搜索接口
  getOrderExchangeList: request + userModuleIndex + 'orderExchangeGoods/orderExchangeList', // 换货--换货列表
  orderReturnDetails: request + userModuleIndex + 'orderReturnGoods/orderReturnDetails', // 退货--退货详情
  myComplain: request + userModuleIndex + 'complain/myComplain', // 投诉申请
  complainList: request + userModuleIndex + 'complain/complainList', // 投诉申请列表
  ComplainDel: request + userModuleIndex + 'complain/ComplainDel', // 取消投诉

  //  文章--帮助中心
  getArticleType: request + 'articleCategory/getArticleType', // 文章分类
  getArticleDetails: request + 'article/getArticleDetails', // 文章详情
  getArticleLatest: request + 'article/getArticleLatest', // 最新文章
  geAarticleList: request + 'article/getArticleByCategoryId', // 获取文章列表

  // 收货地址
  addressLists: request + userModuleIndex + 'userAddress/addressLists', // 我的收获地址列表
  addAddress: request + userModuleIndex + 'userAddress/addAddress', // 添加收货地址
  editAddress: request + userModuleIndex + 'userAddress/editAddress', // 编辑收货地址
  addressInfo: request + userModuleIndex + 'userAddress/addressInfo', // 查看收货地址
  addressDelete: request + userModuleIndex + 'userAddress/addressDelete', // 删除收货地址
  setDefault: request + userModuleIndex + 'userAddress/setDefault', // 设置默认收货地址
  // 购物车数据
  cartGoodsList: request + 'goodsCart/cartGoodsList', // 购物车商品列表
  cartNumReduce: request + 'goodsCart/cartNumReduce', // 购物车商品数量减
  cartNumModify: request + 'goodsCart/cartNumModify', // 购物车商品数量修改
  delGoodsCart: request + 'goodsCart/delGoodsCart', // 购物车--删除(单个)
  deleteManyGoodsCart: request + 'goodsCart/deleteManyGoodsCart', // 购物车--删除(多个)
  cartGoodsCollection: request + 'collection/addCollection', // 购物车--移入收藏夹(单个)
  addBatchCollection: request + 'collection/addBatchCollection', // 购物车--移入收藏夹(多个)
  cartPackageList: request + 'goodsPackageCart/cartPackageList', // 购物车套餐列表
  packageNumModify: request + 'goodsPackageCart/cartNumModify', // 套餐购物车商品数量修改
  //  结算
  getAllInvoice: request + 'invoiceType/getAllInvoice', //  获取发票信息
  //  其他
  regionLists: request + 'region/regionLists', // 地区列表
  cityList: request + 'region/regionLists', //  城市四级联动
  //  招商入驻
  upLoadImage: imgRequest + uploadImage + 'EnterUpload/uploadImage', // 上传图片
  delPic: request + 'uploadImage/delPic', // 删除图片
  perfectInfo: request + 'storeInformation/perfectInfo', // 入驻提交
  companyProgress: request + userModuleIndex + 'companyStoreAduitProgress/getStoreByUser', // 企业入驻进度
  personProgress: request + userModuleIndex + 'personStoreAduitProgress/getStoreByUser', // 个人入驻进度
  editPersonEnter: request + 'storePerson/editPersonEnter', // 编辑基本开店信息
  getInformationAndBindClass: request + 'storeInformation/getInformationAndBindClass', // 获取提交后店铺信息
  dispatchOption: request + 'storeInformation/dispatchOption', // 编辑个人店铺信息（未审核或审核失败）
  saveCompanyInfo: request + 'storeJoinCompany/saveCompanyInfo', // 编辑基本企业信息（未审核或未通过）
  getBankInfo: request + 'storeCompanyBankInformation/getBankInfo', // 获取企业银行卡信息
  dispatchOptionType: request + 'storeCompanyBankInformation/dispatchOptionType', // 保存企业银行卡信息
  openShopPay: request + userModuleIndex + 'openShopPay/openShop', // 入驻支付
  getPayInfo: request + userModuleIndex + 'storeInformation/getPayInfo', // 入驻金额
  //  个人入驻
  setPersonEnter: request + 'storePerson/personEnter', // 基本开店信息
  enterCardInfo: request + userModuleIndex + 'storePerson/enterCardInfo', // 填写银行卡账户信息
  enterBankInfo: request + userModuleIndex + 'storePerson/enterBankInfo', // 店铺经营信息
  // 企业入驻
  StoreJoinCompany: request + 'storeJoinCompany/storeJoinCompany', // 基本信息提交
  storeBank: request + 'storeCompanyBankInformation/storeBank', // 填写银行卡结算
  // storeManagementInfo: request + userModuleIndex + 'storeJoinCompany/storeManagementInfo', // 店铺经营信息
  //  storeInformation: request + userModuleIndex + 'storeInformation/storeInformation', // 完善店铺信息
  // platformMargin: request + userModuleIndex + 'storeInformation/platformMargin', // 平台保证金
  getShopLevel: request + 'storeGrade/getShopLevel', // 获取店铺等级
  getStoreClasses: request + 'storeClass/storeClasses', // 获取店铺分类
  getTopClass: request + 'goodsClass/topClass', // 获取商品一级分类
  getNextClass: request + 'goodsClass/getClassByPid', // 获取下级分类
  //  抢购
  getPanicGoods: request + 'panic/getPanicGoods', // 抢购列表接口
  getInnerPanic: request + 'panic/getInnerPanic', // 抢购内页接口
  addProblem: request + 'panic/addProblem', // 商品咨询添加接口
  problemGoodsComment: request + 'panic/goodsComment', // 抢购商品评论接口
  getBuyImmediately: request + 'buyImmediately/buy', // 抢购结算页详情
  hotBuyThisWeek: request + 'panic/hotBuyThisWeek',
  getinitiatePayment: request + 'payPanic/initiatePayment', // 抢购发起支付

  //  商品相关
  getGoodsList: request + 'goodsSearhByList/goodsList', // 商品列表
  getHotCommodities: request + 'goods/hotCommodities', // 获取店铺商品排行榜
  getGoodsDetails: request + 'goods/goodsDetails', // 商品详情
  getGoodsDetailsByUserCenter: request + 'goods/getGoodsDetailByUserCenter', // 商品详情
  goodsSpecs: request + 'goodsSpec/goodSpecsByGoodsChildren', // 商品规格
  buyNow: request + 'goodsImmediatePurchase/buyNowByBuildSession', // 商品立即购买
  setCollectionGoods: request + 'collection/collectionGoods', // 商品收藏
  addGoodToCart: request + 'goodsCart/addGoodToCart', // 添加购物车
  getAllCommentContent: request + 'orderComment/getAllCommentContent', // 评价商品
  getGoodsStoreClass: request + 'storeBindClass/storeClass', // 获取店铺导航商品分类.
  GoodsPackage: request + 'goodsPackage/package', // 优惠套餐
  GoodsCombo: request + 'goodsCombo/matchGood', // 最佳组合
  GoodsAccessories: request + 'goodsAccessories/matchGood', // 推荐配件
  goodsStoreProprietary: request + 'selfMadeGoods/getGoodsSelfMadeGoods', // 商品自营平台搜索（品牌
  getInvoiceTypeData: request + 'invoiceType/getInvoiceTypeData', // 发票类型
  addOrderInvoice: request + 'orderInvoice/addOrderInvoice', // 发票id
  getFreight: request + 'freightMonery/getFreightMoneyByEnoughToBuyImmediately', // 获取运费
  orderBeginFromGood: request + 'generatingOrder/orderBeginFromGood', // 普通商品生成订单
  guessLove: request + 'guessYouLike/guessYouLike', // 猜你喜欢
  // 我的订单
  fullOrder: request + userModuleIndex + 'orderMake/fullOrder', // 所有订单
  pendingPayment: request + userModuleIndex + 'orderMake/pendingPayment', // 待付款
  pendingDelivery: request + userModuleIndex + 'orderMake/pendingDelivery', // 待发货
  goodsToBeReceived: request + userModuleIndex + 'orderMake/goodsToBeReceived', // 待收货
  toBeEvaluated: request + userModuleIndex + 'orderMake/toBeEvaluated', // 待评价
  orderRecoveryStation: request + userModuleIndex + 'orderMake/orderRecoveryStation', // 订单回收站,
  orderDetails: request + userModuleIndex + 'orderMake/getOrderDetail', // 订单详情
  OrdinaryGoods: request + userModuleIndex + 'orderMake/confirmGet', // 确认收货
  generalOrderReturnDetails: request + userModuleIndex + 'orderGoods/orderGoodsDetail', // 普通订单退货详情
  orderSearch: request + userModuleIndex + 'orderMake/orderSearch', // 搜索订单列表
  cancelOrder: request + userModuleIndex + 'orderMake/orderCancelByList', // 取消订单
  delOrder: request + userModuleIndex + 'orderMake/delOrder', // 删除订单
  lookGoodsExpress: request + userModuleIndex + 'logisticsQuery/lookGoodsExpress', // 查看物流-普通订单
  packageLogistics: request + userModuleIndex + 'logisticsQuery/lookOrderPackageExpress', // 查看物流-套餐订单
  integralLogistics: request + userModuleIndex + 'logisticsQuery/lookOrderIntegralExpress', // 查看物流-积分订单
  // 积分订单
  orderDetailByIntegral: request + userModuleIndex + 'integralOrders/getOrderDetail', // 积分订单详情
  integralList: request + userModuleIndex + 'integralOrders/integralList', // 积分订单列表
  integralSearch: request + userModuleIndex + 'integralOrders/orderSearch', // 积分订单列表

  // 支付相关
  getPayResult: request + 'getPayType/getPayResult', // 支付类型
  initiatePayment: request + 'payOrder/initiatePayment', // 普通商品支付接口

  // 立即付款
  regularOrders: request + userModuleIndex + 'orderMake/immediatePayment', // 普通订单
  setTheTrder: request + userModuleIndex + 'orderPackageMake/immediatePayment', // 套餐订单
  integralToPay: request + userModuleIndex + 'integralOrders/immediatePayment', // 积分订单

  // 购物车结算
  buildOrderByCart: request + 'generatingOrder/buildOrderByCart', // 购物车生成订单
  BuyCartGoods: request + 'goodsCart/userBuyCartGoods', // 购物车购买获取商品详情（结算页面
  addPackageCart: request + 'goodsPackage/addPackageCart', // 套餐的加入购物侧
  cartPackageBuyNow: request + 'goodsPackage/cartPackageBuyNow', // 套餐立即购买
  toSettleAccounts: request + 'goodsPackageCart/toSettleAccounts', // 套餐购物车去结算
  cartPackageDel: request + 'goodsPackageCart/cartPackageDel', // 套餐购物车删除
  ShopImageDetail: request + 'goodsDetail/getGoodsDetail', // 商品图文详情
  integralOrder: request + 'generatingOrderIntegral/confirmExchange', // 积分生成订单
  getIntegral: request + userModuleIndex + 'userData/getIntegral', // 获取当前积分(无缓存)
  integralPay: request + 'payOrderByIntegral/initiatePayment', // 积分支付

  contrastResult: request + 'contrast/contrastResult', // 对比

  orderBegin: request + 'orderPackage/orderBegin', // 套餐生成订单
  orderBeginByCart: request + 'orderPackage/orderBeginByCart', // 购物车套餐生成订单
  packagePay: request + 'payOrderByPackage/initiatePayment', // 套餐支付

  // 评价
  orderComment: request + userModuleIndex + 'orderMake/toBeEvaluated', // 普通订单待评价
  haveBeenEvaluated: request + userModuleIndex + 'orderMake/haveBeenEvaluated', // 普通订单已评价
  commentDetail: request + userModuleIndex + 'orderCommentMake/evaluateDetails', // 普通订单评价详情
  PublishComment: request + userModuleIndex + 'orderCommentMake/publishConmment', // 普通订单提交评论，
  uploadCommentImg: imgRequest + uploadImage + 'FileUpload/uploadImageByImageComment',
  getCommentImageConf: imgRequest + uploadImage + 'FileUpload/getCommentImageConfig',
  PublishConmment: request + userModuleIndex + 'orderPackageCommentMake/publishConmment', // 套餐订单提交评论
  // 退换货
  uploadImageByImageComment: imgRequest + uploadImage + 'fileUpload/uploadImageByImageComment', // 退换货上传图片
  getCommentImageConfig: imgRequest + uploadImage + 'fileUpload/getCommentImageConfig', // 图片配置
  customerService: request + userModuleIndex + 'orderExchangeGoods/customerService', // 普通订单换货申请
  packageOrderReturnDetails: request + userModuleIndex + 'orderPackageReturnGoods/progressQuery', // 套餐订单需退货详情
  packageOrderReturnRequest: request + userModuleIndex + 'orderPackageReturnGoods/customerService', // 套餐订单退货申请
  CommonOrderApplyForAfterSale: request + userModuleIndex + 'commonOrderApplyForAfterSale/customerService', // 普通订单退货退款申请
  CommonOrderApplyForList: request + userModuleIndex + 'orderPackageReturnGoods/progressQueryList', //  套餐订单退货列表
  packageOrderSearch: request + userModuleIndex + 'orderPackageReturnGoods/searchOrder', //  套餐订单退货列表

  getSAtoreAddress: request + userModuleIndex + 'storeAddress/getSAtoreAddress', // 获取店铺地址
  courierNumber: request + userModuleIndex + 'commonOrderApplyForAfterSale/courierNumber', // 普通订单退货退款填写快递号
  getExpressList: request + userModuleIndex + 'express/getExpressList', // 获取快递
  // 个人中心 套餐订单
  package: {
    fullOrder: request + userModuleIndex + 'orderPackageMake/fullOrder', // 全部订单
    orderSearch: request + userModuleIndex + 'orderPackageMake/orderSearch', // 搜索订单
    pendingPayment: request + userModuleIndex + 'orderPackageMake/pendingPayment', // 待付款
    pendingDelivery: request + userModuleIndex + 'orderPackageMake/pendingDelivery', // 待发货
    goodsToBeReceived: request + userModuleIndex + 'orderPackageMake/goodsToBeReceived', // 待收货
    confirmGet: request + userModuleIndex + 'orderPackageMake/confirmGet', // 确认收货
    packageToBeEvaluated: request + userModuleIndex + 'orderPackageMake/toBeEvaluated', // 待评价
    alreadyEvaluated: request + userModuleIndex + 'orderPackageMake/alreadyEvaluated', // 已评价
    haveBeenCancelled: request + userModuleIndex + 'orderPackageMake/haveBeenCancelled', // 已取消
    completed: request + userModuleIndex + 'orderPackageMake/completed', // 已完成
    orderDetail: request + userModuleIndex + 'orderPackageMake/getOrderDetail', // 套餐订单详情
    cancalPackageOrder: request + userModuleIndex + 'orderPackageMake/cancelOrder', // 取消订单
    del: request + userModuleIndex + 'orderPackageMake/orderDel', // 删除订单
    GoodscustomerService: request + userModuleIndex + 'orderPackageReturn/GoodscustomerService' // 退货
  },
  // 个人中心 积分订单
  intergral: {
    cancelOrder: request + userModuleIndex + 'integralOrders/cancelOrder', // 积分取消订单
    delOrder: request + userModuleIndex + 'integralOrders/delOrder' // 删除积分订单
  },
  newRecommend: request + 'recommendedSale/newRecommend', // 新品推
  hotSale: request + 'recommendedSale/hotSale', // 热卖推荐
  RecommendedSale: request + 'recommendedSale/getGoodsList', // 商品列表热卖推荐
  recommendAndGroup: request + 'addGoodsCart/addAll', // 最佳组合添加购物车
  goodsComboBuyNow: request + 'immediatePurchaseOfParts/goodsComboBuyNow', // 最佳组合立即购买
  partsBuyNow: request + 'generatingOrder/partsBuyNow', // 最佳组合生成订单
  getHotSearchList: request + 'hotSearh/getHotSearchList', // 热门搜索
  // 优惠券
  coupon: {
    couponSendList: request + 'couponSend/couponSendList', // 优惠券列表
    CheckIsUseCoupon: request + 'checkIsUseCoupon/check', // 检查优惠券是否可用
    couponList: request + 'orderCouponOptions/usersCanUseCoupons', // 优惠券列表
    couponReceiveBehavior: request + 'couponReceive/couponReceiveBehavior' // 领取优惠券
  },
  // 咨询
  consult: {
    goodsConsultation: request + 'goodsConsultation/consultationData', // 咨询列表
    userCommitProblem: request + 'goodsConsultation/userCommitProblem' // 添加咨询
  }
}

export default config
