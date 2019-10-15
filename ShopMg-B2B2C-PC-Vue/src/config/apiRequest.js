import qs from 'qs'
import router from '../router/index'
import axios from "./axios";
/**
 * API 请求
 */
class APIRequest {
    /**
     * @param {string} API_URL 
     * @param {boolean} checkLogin 
     */
    constructor(API_URL, resolve, reject, checkLogin) {
        this.API_URL = API_URL;

        this.checkLogin = checkLogin;

        this.resolve = resolve;

        this.reject = reject;
    }
    /**
     * @param {{}} params 
     */
    async post(params) {
        let res = await axios.post(this.API_URL, qs.stringify(params));
        if (res.status === 10001) {
            sessionStorage.clear()
            if (this.checkLogin) {
                router.push('/passwordLogin');
                return;
            }
            return this.resolve(res);
        }

        if (res.status === 1) {
            return this.resolve(res);
        }
        return this.reject(res);
    }

    /**
    * @param {{}} params 
    */
    get(params) {
        return axios({
            method: 'get',
            url: this.API_URL,
            params: params
        }).then((res) => {
            if (res.status === 10001) {
                if (this.checkLogin) {
                    router.push('/passwordLogin')
                    return;
                }
                return this.resolve(res);
            }
            if (res.status === 1) {
                return this.resolve(res)
            }
            return this.reject(res)
        });
    }
}
export { APIRequest }