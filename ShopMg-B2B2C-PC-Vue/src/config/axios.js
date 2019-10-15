
import axios from 'axios'
import {
  Message
} from 'element-ui'
axios.defaults.withCredentials = true // 让ajax携带cookie
// 添加响应拦截器
axios.interceptors.response.use(response => {

  const res = response.data
  // if the custom code is not 20000, it is judged as an error.
  if (res.status === 0 ) {
    Message({
      message: res.message || 'Error',
      type: 'error',
      duration: 5 * 1000
    });
    return Promise.reject(new Error(res.message || '发生了错误'));
  }
  return res;
}, error => {
  Message({
    message: '网络请求失败，请重试~',
    type: 'error',
    duration: 2000
  })
  return Promise.reject(error);
})

export default axios;