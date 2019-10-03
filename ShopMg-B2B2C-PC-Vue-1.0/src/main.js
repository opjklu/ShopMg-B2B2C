import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
// 引入配置对象
import HttpConfig from './httpConfig.js'
import publicObj from './assets/js/public'
import HTTP from './config/HTTP'
import magnify from './assets/js/magnify.js'
import { constant, Status } from './config/constant' //  常用的常量
import { axios } from './config/axios'


import 'vue-blu/dist/css/vue-blu.min.css';

// Element
import ElementUI from 'element-ui'

import 'element-ui/lib/theme-chalk/index.css'
// 懒加载调用

import VueLazyload from 'vue-lazyload'
// 引入自己的css
import './assets/css/base.css'
Vue.use(VueLazyload, {
  error: require('./assets/img/404.jpeg'),
  loading: require('./assets/img/404.jpeg'),
  attempt: 1
});

// 图片地址
const URl = 'http://image.shopqorg.com'
Vue.prototype.$constant = constant
Vue.prototype.$Status = Status
Vue.prototype.URL = URl
Vue.prototype.HTTP = HTTP
Vue.prototype.magnify = magnify

import * as filters from './filter/filter' // global filters

// register global utility filters
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key])
})

//  ajax请求
Vue.prototype.$ajax = axios //  可以使用this.$ajax了
//  请求路径
//  路径
Vue.prototype.$httpConfig = HttpConfig
//  引入公共的js
Vue.prototype.publicObj = publicObj
//  title修改
//  在组件中使用 1 <div v-title>标题内容</div>
Vue.directive('title', {
  inserted: function (el, binding) {
    document.title = binding.value
  }
})
//  路由切换时 滚动条位置为顶部
router.afterEach((to, from, next) => {
  window.scrollTo(0, 0)
})


Vue.prototype.crumbs = '全部商品'
// 清空保存的分类
/* var intervalId = */ setInterval(function () {
  localStorage.removeItem('class')
}, 1000 * 60 * 10)
//  关闭生产模式下给出的提示
Vue.config.productionTip = false

Vue.use(ElementUI)

new Vue({
  el: '#app',
  router, //  router
  store, //  注入store
  render: (c) => c(App)
})
