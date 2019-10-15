<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\RegionLogic;
use App\Models\Logic\Specific\StoreAddressLogic;
use App\Models\Logic\Specific\StoreClassLogic;
use App\Models\Logic\Specific\StoreLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Tool\Tool;

/**
 * 店铺控制器
 * @Controller(prefix="/store")
 *
 * @author Administrator
 */
class StoreController
{

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImageLogic;

    /**
     * @Inject()
     *
     * @var StoreAddressLogic
     */
    private $storeAddressLogic;

    /**
     * @Inject()
     *
     * @var StoreClassLogic
     */
    private $storeClassLogic;

    /**
     * @Inject()
     *
     * @var RegionLogic
     */
    private $regionLogic;

    /**
     * 得到店铺列表
     * @RequestMapping(route="storeList", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function storeListByShopMGIf(Request $req): array
    {
        $ret = $this->logic->getParseDataByListNoSearch($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $ret = $this->getGoodsByStore($ret['data']);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 得到店铺列表（通过搜索）
     * @RequestMapping(route="storeListBySearch", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     * @Number(name="class_id", min=1, default=1)
     * @Number(name="page", min=1, default=1)
     * @Number(name="store_sales", min=0, max=1, default=1)
     * @Number(name="credibility", min=0, max=1, default=1)
     */
    public function storeListBySearchByShopMGSh(Request $req): array
    {
        $param = $req->post();

        $addressWhere = $this->storeAddressLogic->getAssocConditionByStore($param);

        if ($this->storeAddressLogic->getWhereExits()) {
            return AjaxReturn::error('暂无商品');
        }

        $ret = $this->logic->getStoreList($param, $addressWhere);

        if (0 === count($ret['data'])) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $ret['data'] = $this->getGoodsByStore($ret['data']);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 获取商品
     *
     * @return array
     */
    private function getGoodsByStore(array $store): array
    {
        $store = $this->storeClassLogic->getStoreClassByStore($store, $this->logic->getSplitKeyByStoreClassId());

        $goodsList = $this->goodsLogic->getGoodsListByStoreInfo($store);

        if (0 === count($goodsList)) {
            return [
                'data' => $store
            ];
        }

        $primaryKey = $this->logic->getPrimaryKey();

        $storeAddress = $this->storeAddressLogic->getAddressListCache($store, $primaryKey);

        $storeAddress = $this->regionLogic->getRegionByManyArea($storeAddress, $this->storeAddressLogic->getAreaIds($storeAddress));

        $store = Tool::oneReflectManyArray($storeAddress, $store, 'store_id', $primaryKey);

        return [
            'goods' => $this->goodsImageLogic->getImageByArrayGoods($goodsList),
            'data' => $store
        ];
    }

    /**
     * 店铺详情
     * @RequestMapping(route="shopDetails", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function shopDetailsByShopMGBl(Request $req): array
    {
        $ret = $this->logic->getShopDetails($req->post());

        if (count($ret) === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $ret['store_id'] = $ret['id'];

        $addressData = $this->storeAddressLogic->getStoreAddressId($ret);

        $addressData = $this->regionLogic->getAddressDataByCSpecial($addressData);

        return AjaxReturn::sendData([
            'store' => $ret,
            'address' => $addressData
        ]);
    }

    /**
     * 店铺街换一换
     * @RequestMapping(route="storeShoppingList", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function storeShoppingListByShopMGDm(Request $req): array
    {
        return AjaxReturn::sendData($this->logic->getShopStreetForAChange($req->post()));
    }
}