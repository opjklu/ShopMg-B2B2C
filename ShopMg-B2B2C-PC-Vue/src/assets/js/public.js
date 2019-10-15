const publicObj = {
  // 设置cookie
  setCookie: function (name, value, days) {
    var d = new Date()
    d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days)
    window.document.cookie = name + '=' + value + ';path=/;expires=' + d.toGMTString()
  },
  // 获取cookie
  getCookie: function (name) {
    var v = window.document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)')
    return v ? v[2] : null
  },
  // 删除cookie
  delCoolkie: function (name) {
    this.setCookie(name, '', -1)
  },

  // 文档高度
  getDocumentTop: function () {
    var scrollTop = 0
    var bodyScrollTop = 0
    var documentScrollTop = 0
    if (document.body) {
      bodyScrollTop = document.body.scrollTop
    }
    if (document.documentElement) {
      documentScrollTop = document.documentElement.scrollTop
    }
    scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop; return scrollTop
  },
  // 可视窗口高度
  getWindowHeight: function () {
    var windowHeight = 0
    if (document.compatMode === 'CSS1Compat') {
      windowHeight = document.documentElement.clientHeight
    } else {
      windowHeight = document.body.clientHeight
    }
    return windowHeight
  },

  // 滚动条滚动高度
  getScrollHeight: function () {
    var scrollHeight = 0
    var bodyScrollHeight = 0
    var documentScrollHeight = 0
    if (document.body) {
      bodyScrollHeight = document.body.scrollHeight
    }
    if (document.documentElement) {
      documentScrollHeight = document.documentElement.scrollHeight
    }
    scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight; return scrollHeight
  }
}
export default publicObj
