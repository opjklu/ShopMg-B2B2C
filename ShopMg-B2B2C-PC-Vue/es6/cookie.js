class Cookie {
    constructor(name) {
        this.name = name;
    }

    setCookie(value, expiredays) {
        let cookieValue;
        if (typeof (value) === 'object') {
            cookieValue = JSON.stringify(value);
        } else {
            cookieValue = value;
        }
        const data = new Date();
        data.setDate(data.getDate() + expiredays);
        document.cookie = `${this.name}=${escape(cookieValue)
            }${(expiredays == null) ? '' : `;expires=${data.toGMTString()}`};path=/`;
    }

    getCookie() {
        if (document.cookie.length > 0) {
            let startIndex = document.cookie.indexOf(`${this.name}=`);
            if (startIndex !== -1) {
                startIndex = startIndex + this.name.length + 1;
                let endIndex = document.cookie.indexOf(';', startIndex);
                if (endIndex === -1) {
                    endIndex = document.cookie.length;
                }
                return unescape(document.cookie.substring(startIndex, endIndex));
            }
        }
        return null;
    }

    delCookie() {

        this.setCookie(0, -10)
    }
}
export {Cookie};