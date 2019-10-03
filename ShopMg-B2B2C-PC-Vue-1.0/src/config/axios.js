import axios from 'axios'
import {
  Message
} from 'element-ui';

axios.defaults.withCredentials = true // 让ajax携带cookie

axios.interceptors.request.use(
  config => {
    return config
  },
  err => {
    return Promise.reject(err)
  })

// 添加响应拦截器
axios.interceptors.response.use(response => {
  return response
}, error => {
  Message({
    message: '网络请求失败，请重试~',
    type: 'error',
    duration: 2000
  })
  console.log(error)
})

export {Message, axios};