import $ from 'jquery'
// $(document).ready(function() {
var test = function () {
  // 图片上下滚动
  var count = 0
  // 因为请求的原因 延迟1秒获取
  count = $('#imageMenu ul li').length - 5
  var interval = 75

  var curIndex = 0

  var flag = false // 防止点击过快

  $('.scrollbutton').click(function () {
    if (!flag) {
      flag = true
      if ($(this).hasClass('disabled')) {
        flag = false
        return false
      }
      if ($(this).hasClass('smallImgUp')) --curIndex

      else ++curIndex

      $('.scrollbutton').removeClass('disabled')
      console.log(curIndex)
      if (curIndex == 0) $('.smallImgUp').addClass('disabled')

      if (curIndex == count) $('.smallImgDown').addClass('disabled')

      $('#imageMenu ul').stop(false, true).animate({
        'marginLeft': -curIndex * interval + 'px'
      }, 500, function () {
        flag = false
      })
    }
  })
  var shadeWidth = $('#winSelector').width()
  // 阴影的宽度

  var shadeHeight = $('#winSelector').height()
  // 阴影的高度

  var middleWidth = $('.bigImg').width()
  // 容器的宽度

  var middleHeight = $('.bigImg').height()
  // 容器的高度

  var bigWidth = $('#bigView').width()
  // 放大图片盒子的宽度

  var bigHeight = $('#bigView').height()
  // 放大图片盒子的高度

  var rateX = bigWidth / shadeWidth
  // 放大区和遮罩层的宽度比例

  var rateY = bigHeight / shadeHeight // 放大区和遮罩层的高度比例

  $('.bigImg').mouseover(function () {
    $('#winSelector').show()
    $('#bigView').show()
  }).mouseout(function () {
    $('#winSelector').hide()
    $('#bigView').hide()
  }).mousemove(function (e) {
    // 记录下光标距离页面的距离
    var Event = e || window.event
    var x = Event.pageX

    var y = Event.pageY

    // 设置遮罩层的位置
    $('#winSelector').offset({
      top: y - shadeHeight / 2,
      left: x - shadeWidth / 2
    })

    // 获取遮罩层相对父元素的位置
    var cur = $('#winSelector').position()

    var _top = cur.top

    var _left = cur.left

    var hdiffer = middleHeight - shadeHeight

    var wdiffer = middleWidth - shadeWidth

    if (_top < 0) _top = 0
    else if (_top > hdiffer) _top = hdiffer
    if (_left < 0) _left = 0
    else if (_left > wdiffer) _left = wdiffer

    // 判断完成后设置遮罩层的范围
    $('#winSelector').css({
      top: _top,
      left: _left
    })

    // 设置放大区图片移动
    $('#bigView .big-img').css({
      top: -rateY * _top,
      left: -rateX * _left
    })
  })
}
// });
export default test
