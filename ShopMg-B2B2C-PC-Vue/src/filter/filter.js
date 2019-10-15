export function keep2Num(value) {
    value = Number(value)
    var b = value.toFixed(3)
    return b.substring(0, b.toString().length - 1)
};

export function formatDate(value) { //  时间戳转换
    var time = new Date(Number(value) * 1000)
    var Y = time.getFullYear()
    var m = time.getMonth() + 1
    var d = time.getDate()
    var H = time.getHours()
    var mi = time.getMinutes()
    var s = time.getSeconds()
    if (m < 10) {
        m = '0' + m
    }
    if (d < 10) {
        d = '0' + d
    }
    if (H < 10) {
        H = '0' + H
    }
    if (mi < 10) {
        mi = '0' + mi
    }
    if (s < 10) {
        s = '0' + s
    }
    return Y + '-' + m + '-' + d + ' ' + H + ':' + mi + ':' + s
}

export function formatDate2(value) { // 时间戳转换
    var time = new Date(Number(value) * 1000)
    var Y = time.getFullYear()
    var m = time.getMonth() + 1
    var d = time.getDate()
    var H = time.getHours()
    var mi = time.getMinutes()
    var s = time.getSeconds()
    if (m < 10) {
        m = '0' + m
    }
    if (d < 10) {
        d = '0' + d
    }
    if (H < 10) {
        H = '0' + H
    }
    if (mi < 10) {
        mi = '0' + mi
    }
    if (s < 10) {
        s = '0' + s
    }
    return (Y + '-' + m + '-' + d)
};

export function phoneEncryption(phone) { //  手机号加星号
    return (phone.substr(0, 3) + '****' + phone.substr(7))
}
