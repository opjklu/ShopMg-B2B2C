
class MapTool
{
    static  deleteEmptyValue(params) {

        for (let i in params)
        {
            if (params[i] === '0' || params[i] === 0) {
                continue;
            }
            
            if(!params[i] ) {
                delete params[i];
            }
        }

    }

    /**
     * 根据id 把数组转换为map
     * @param {Array} params 待转换的list
     * @param {String} key  字符串 键
     */
    static covertDataByKey( params, key) {

        let map = {};
   
        for (let index = 0; index < params.length; index++) {
            
            map[params[index] [key]] = params[index];
            
        }
        console.log(params.valueOf());
        return map;
    }
}

export {MapTool};