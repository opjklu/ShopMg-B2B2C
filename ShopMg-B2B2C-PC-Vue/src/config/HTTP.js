import {APIRequest} from "./apiRequest";

/**
 * @param {string} API_URL 
 * @param {JSON} params 
 * @param {string} requestType 
 * @param {boolean} checkLogin 
 */
function HTTP(API_URL, params = {}, requestType = 'post', checkLogin = true) {
  return new Promise(async (resolve, reject) => {

    let apiRequest = new APIRequest(API_URL, resolve, reject, checkLogin);

    return await APIRequest.prototype[requestType].call(apiRequest, params);
  })
}

export default HTTP 
