<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\RegionLogic;
use App\Models\Logic\Specific\UserAddressLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 收货地址
 * @Controller(perfix="/userAddress")
 *
 * @Middleware(ValidateLoginMiddleware::class)
 */
class UserAddressController
{

    /**
     * @Inject()
     *
     * @var UserAddressLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var RegionLogic
     */
    private $region;

    /**
     * 添加收货地址
     * @RequestMapping(route="addAddress", method=RequestMethod::POST)
     */
    public function addAddressByShopMGMb(Request $req): array
    {
        $param = $req->post();

        $checkObj = new CheckParam($this->logic->getRuleByAddEditAddress(), $param); 

        $status = $checkObj->detectionParameters(); 

        if ($status === false) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->addAddress($param); // 逻辑处理

        if ($ret === false) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * @RequestMapping(route="editAddress", method=RequestMethod::POST)
     *
     * @name 修改收货地址
     */
    public function editAddressByShopMGMf(Request $req): array
    {
        $param = $req->post();

        $checkObj = new CheckParam($this->logic->getRuleByAddEditAddress(), $param);

        $status = $checkObj->detectionParameters();

        if ($status === false) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->editAddress($param); // 逻辑处理

        if ($ret === false) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * @RequestMapping(route="addressInfo", method=RequestMethod::POST)
     *
     * @name 查看收货地址
     * @Number(name="id", min=1)
     */
    public function addressInfoByShopMGHc(Request $req): array
    {
        $ret = $this->logic->getFindOne($req->post()); // 逻辑处理

        if (count($ret) === 0) {
            return AjaxReturn::error('没有收获地址详情');
        }
        return AjaxReturn::sendData($ret);
    }

    /**
     * 用户收货地址列表
     *
     * @RequestMapping(route="addressLists", method=RequestMethod::POST)
     */
    public function addressListsByShopMGDv(): array
    {
        $ret = $this->logic->getAddressLists(); // 逻辑处理

        if (count($ret) === 0) {
            return AjaxReturn::error('没有收获地址');
        }

        $data = $this->region->getRegionByManyArea($ret, $this->logic->getAreaIds($ret));

        return AjaxReturn::sendData($data);
    }

    /**
     *
     * @name 用户收货地址删除
     * @RequestMapping(route="addressDelete", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function addressDeleteByShopMGOx(Request $req): array
    {
        $ret = $this->logic->delete($req->post()); // 逻辑处理

        if ($ret === false) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 设置默认收货地址
     * @RequestMapping(route="setDefault", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function setDefaultByShopMGNo(Request $req): array
    {
        $ret = $this->logic->setAddressDefault($req->post()); // 逻辑处理

        if ($ret === false) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        return AjaxReturn::sendData('');
    }

    /**
     * 获取默认收货地址
     * @RequestMapping(route="getAddressLists", method=RequestMethod::POST)
     *
     * @return array
     */
    public function getAddressListsByShopMGFj(): array
    {
        $ret = $this->logic->getDefaultAddress(); // 逻辑处理

        if (count($ret) === 0) {
            return AjaxReturn::error('暂无收获地址');
        }

        $region = $this->region->getAddressDataByCSpecial($ret);

        return AjaxReturn::sendData($region);
    }
}