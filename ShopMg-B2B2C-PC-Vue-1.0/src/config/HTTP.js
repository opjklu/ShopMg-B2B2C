import qs from 'qs'

import {Message, axios} from './axios.js';

import router from '../router/index'

function HTTP(API_URL, params, requestType, checkLogin = true) {
  return new Promise(async (resolve, reject) => {
    if (requestType === 'post') {
      let res = await axios.post(API_URL, qs.stringify(params))

      if (res.data.status === 10001) {
        console.log(res.data, checkLogin)
        sessionStorage.clear()
        if (checkLogin) {
          router.push('/passwordLogin')
        } else {
          resolve(res)
        }
      } else if (res.data.status === 20010) {
        Message({
          message: `${res.data.message}`,
          type: 'error',
          duration: 2000
        })
        resolve(res)
      } else if (res.data.status === 1) {
        resolve(res)
      } else {
        Message.info(res.data.message)

        reject(res)
      }
    } else {
      axios({
        method: 'get',
        url: API_URL,
        params: params
      }).then((res) => {
        if (res.data.status === 10001) {
          if (!checkLogin) {
            router.push('/passwordLogin')
            window.location.reload()
          } else {
            resolve(res)
          }
        } else if (res.data.status === 1) {
          resolve(res)
        } else {
          Message.info(res.data.message)
          reject(res)
        }
      })
    }
  })
}

export default HTTP
