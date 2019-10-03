
/**
 * 获取地区
 */
function getArea(object, pId) {

    object.HTTP(object.$httpConfig.regionLists, { parent_id: pId }, 'post')
        .then((res) => {
            object.areaList = res.data.data;
        }).catch((e) => {
            object.areaList = [];
        })
}

export {
    getArea
}