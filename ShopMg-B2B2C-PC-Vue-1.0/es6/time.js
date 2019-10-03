class TimeInterval
{
    static setTask(key, param)
    {   
        localStorage.setItem(key, JSON.stringify(param));

        setInterval(function() {

            localStorage.removeItem(key)

        }, 1200*1000);
    }

    static getItem(key) {
        let data = localStorage.getItem(key);
        if (!data || data === '"{}"') {
            return null;
        }

        data = JSON.parse(data);

        data  = eval( '('+ data+ ')');
        
        return data;
      
    }
}

export {TimeInterval};