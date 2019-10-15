<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 wq.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://wq.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsClassLogic;
use App\Models\Logic\Specific\StoreGradeLogic;
use App\Models\Logic\Specific\StoreInformationLogic;
use App\Models\Logic\Specific\StoreManagementCategoryLogic;
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
 *
 * @author wq
 * @Controller(prefix="/storeInformation")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class StoreInformationController
{

    /**
     * @Inject()
     *
     * @var StoreInformationLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var StoreManagementCategoryLogic
     */
    private $storeManagementCategoryLogic;

    /**
     * @Inject()
     *
     * @var StoreGradeLogic
     */
    private $storeGradleLogic;

    /**
     * @Inject()
     *
     * @var GoodsClassLogic
     */
    private $goodsClassLogic;

    private $optionType = [
        'perfectInfo',
        'saveInformationAndBindClass'
    ];

    /**
     * 数据
     * @RequestMapping(route="perfectInfo", method=RequestMethod::POST)
     */
    public function perfectInfoByShopMGMc(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByLogin(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->perfectCompanyInfo($post);

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $status = $this->storeManagementCategoryLogic->addStoreManagerment($post['class']);

        if (!$status) {
            return AjaxReturn::error($this->storeManagementCategoryLogic->getErrorMessage());
        }

        return AjaxReturn::sendData($status);
    }

    /**
     * 保存店铺信息
     */
    private function saveInformationAndBindClass(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByLogin(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $status = $this->logic->saveInformation($post);

        if (!$status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        $status = $this->storeManagementCategoryLogic->saveBindClass($post['class']);

        if (!$status) {
            return AjaxReturn::error('店铺分类错误');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 获取店铺信息
     * @RequestMapping(route="getInformationAndBindClass", method=RequestMethod::POST)
     */
    public function getInformationAndBindClassByShopMGKj(): array
    {
        // 是 添加还是保存
        session()->put('option_type', 0);

        $data = $this->logic->getStoreInfoByStoreByApproval();

        if (0 === count($data)) {
            return AjaxReturn::error('暂无数据');
        }
        $classData = $this->storeManagementCategoryLogic->getBindClassByStore();

        $classData = $this->goodsClassLogic->getGoodsClassByBindClassByApproval($classData);

        session()->put('option_type', 1);

        return AjaxReturn::sendData([
            'information' => $data,
            'class_data' => $classData
        ]);
    }

    /**
     * 分发操作
     * @RequestMapping(route="dispatchOption", method=RequestMethod::POST)
     */
    public function dispatchOptionByShopMGHh(Request $req): array
    {
        $option = $this->optionType[session()->get('option_type')];

        return $this->$option($req);
    }

    /**
     * 获取支付信息
     * @RequestMapping(route="getPayInfo", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function getPayInfoByShopMGEh(Request $req): array
    {
        $storeInfo = $this->logic->getStoreInfoByStore($req->post());

        if (0 === count($storeInfo)) {
            return AjaxReturn::error('店铺信息异常');
        }

        $data = $this->storeGradleLogic->getStoreGrade($storeInfo);

        return AjaxReturn::sendData($data['price']);
    }
}
