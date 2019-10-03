<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Models\Logic\Specific\StoreCompanyBankInformationLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller(perfix="storeCompanyBankInformation")
 *
 * @author wq
 *
 */
class StoreCompanyBankInformationController
{

    private $optionType = [
        'storeBank',
        'saveEditBank'
    ];

    /**
     * @Inject()
     *
     * @var StoreCompanyBankInformationLogic
     */
    private $logic;

    /**
     * *
     * 填写银行卡信息
     */
    public function storeBankByShopMGKe(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getMessageValidateBankInfo(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->addBankInfo($post);

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 获取银行卡信息
     * @RequestMapping(route="getBankInfo")
     */
    public function getBankInfoByShopMGAd(Request $req): array
    {
        // 是 添加还是保存
        session()->put('option_type', 0);

        $data = $this->logic->getBankInformation();

        if (0 === count($data)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        session()->put('option_type', 1);

        return AjaxReturn::sendData($data);
    }

    /**
     * 保存
     */
    private function saveEditBank(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getMessageValidateBankInfo(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $status = $this->logic->saveData($post);
        if (!$status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * @RequestMapping(route="dispatchOptionType")
     */
    public function dispatchOptionTypeByShopMGCi(Request $req): array
    {
        $option = $this->optionType[session()->get('option_type')];

        return $this->$option($req);
    }
}