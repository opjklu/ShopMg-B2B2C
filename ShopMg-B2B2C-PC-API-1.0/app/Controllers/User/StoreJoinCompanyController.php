<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\StoreAddressLogic;
use App\Models\Logic\Specific\StoreJoinCompanyLogic;
use App\Models\Logic\Specific\StorePersonLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller(prefix="/storeJoinCompany")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class StoreJoinCompanyController
{

    /**
     * @Inject()
     *
     * @var StoreJoinCompanyLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var StorePersonLogic
     */
    private $storePersonLogic;

    /**
     * @Inject()
     *
     * @var StoreAddressLogic
     */
    private $storeAddressLogic;

    /**
     * 企业入驻
     * @RequestMapping(route="storeJoinCompany", method=RequestMethod::POST)
     */
    public function storeJoinCompanyByShopMGXm(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByLogin(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        // 检测个人是否开店

        $status = $this->storePersonLogic->isCheckIn();

        if (!$status) {
            return AjaxReturn::error($this->storePersonLogic->getErrorMessage());
        }

        $ret = $this->logic->addCompanyInfo($post);

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $post['insert_id'] = $ret;

        $resultAddress = $this->storeAddressLogic->addAddressStore($post);

        if (!$resultAddress) {
            return AjaxReturn::error($this->storeAddressLogic->getErrorMessage());
        }

        session()->put('add_join_company_id', $ret);

        session()->put('store_name', $post['store_name']);

        session()->put('store_type', 1); // 企业入住

        return AjaxReturn::sendData('');
    }

    /**
     * 保存企业信息
     * @RequestMapping(route="saveCompanyInfo", method=RequestMethod::POST)
     */
    public function saveCompanyInfoByShopMGPo(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByApproval(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $status = $this->logic->saveEdit($post);

        if (!$status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $status = $this->storeAddressLogic->saveAddress($post);

        if (!$status) {
            return AjaxReturn::error($this->storeAddressLogic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}