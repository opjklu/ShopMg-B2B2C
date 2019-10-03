
import {MapTool} from './tool'

/**
 * 订单相关
 */
class OrderRelevant
{
    /**
     * 构建请求参数
     * @param {Object} obj 
     */
    static buildOrderSearch(obj) {
        let param = {
            page: obj.currentPage,
            order_sn_id: obj.keyWords,
            order_status: obj.order_status,
            comment_status: obj.comment_status
        };

        if (obj.start_time) {
            param.start_time = obj.start_time / 1000;
        }

        if (obj.end_time) {
            param.end_time = obj.end_time / 1000;
        }

        MapTool.deleteEmptyValue(param);

        return param;
    }
}

export {OrderRelevant}