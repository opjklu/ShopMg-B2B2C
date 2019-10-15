import httpConfig from '../httpConfig.js'

export default {
  refreshVerificationCode () {
    var random = httpConfig.accountSecurityVerify + '?a=' + Math.random()
    return random
  }
}
