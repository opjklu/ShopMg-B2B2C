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
 * @Controller(prefix="/storePerson")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class StorePersonController
{

    /**
     * @Inject()
     *
     * @var StorePersonLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var StoreJoinCompanyLogic
     */
    private $storeJoinCompanyLogic;

    /**
     * @Inject()
     *
     * @var StoreAddressLogic
     */
    private $storeAddressLogic;

    /**
     * 填写基本开店信息
     * @RequestMapping(route="personEnter", method=RequestMethod::POST)
     */
    public function personEnterByShopMGHn(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByLogin(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        // 检测企业是否开店
        $status = $this->storeJoinCompanyLogic->isCheckIn();

        if (!$status) {
            return AjaxReturn::error($this->storeJoinCompanyLogic->getErrorMessage());
        }

        $ret = $this->logic->personEnter($post);

        if ($ret === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $post['insert_id'] = $ret;

        $resultAddress = $this->storeAddressLogic->addAddressStore($post);

        if (!$resultAddress) {
            return AjaxReturn::error($this->storeAddressLogic->getErrorMessage());
        }

        session()->put('store_name', $post['store_name']);

        session()->put('add_join_company_id', $ret);

        session()->put('store_type', 0); // 个人入住

        return AjaxReturn::sendData('');
    }

    /**
     * 编辑基本开店信息
     * @RequestMapping(route="editPersonEnter", method=RequestMethod::POST)
     */
    public function editPersonEnterByShopMGUp(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByLoginMergeAddess(), $post);

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