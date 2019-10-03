<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\FreightAreaLogic;
use App\Models\Logic\Specific\FreightConditionLogic;
use App\Models\Logic\Specific\FreightModeLogic;
use App\Models\Logic\Specific\FreightSendLogic;
use App\Models\Logic\Specific\FreightsLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Tool\SessionManager;
use Tool\Strategy\Context;

/**
 * @Controller(prefix="/freightMonery")
 * @Middleware(ValidateLoginMiddleware::class)
 * 运费计算
 */
class FreightMoneryController
{

    /**
     * @Inject()
     *
     * @var FreightsLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var FreightModeLogic
     */
    private $freightModeLogic;

    /**
     * @Inject()
     *
     * @var FreightSendLogic
     */
    private $freightSendLogic;

    /**
     * @Inject()
     *
     * @var FreightConditionLogic
     */
    private $freightConditionLogic;

    /**
     * @Inject()
     *
     * @var FreightAreaLogic
     */
    private $freightAreaLogic;

    /**
     * 计算运费
     * @RequestMapping(route="getFreightMoneyByEnoughToBuyImmediately", method=RequestMethod::POST)
     */
    public function getFreightMoneyByEnoughToBuyImmediatelyByShopMGPw(Request $req): array
    {
        $post = $req->post();

        if (false === $this->logic->getValidateSource($post)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        // 模板设置
        $templateConf = $this->logic->getFreightTemplate();

        if (0 === count($templateConf)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        // 运费模板有没有运送到该地区的
        $fModeConf = $this->freightModeLogic->getFreightMoney($templateConf);

        if (0 === count($fModeConf)) {
            return AjaxReturn::error($this->freightModeLogic->getErrorMessage());
        }
        // 查看 该模板包不包含该配送地区
        if (false === $this->freightSendLogic->userAddressIndexOfSendArea([
                'f_mode' => $fModeConf,
                'area_conf' => $post
            ])) {
            return AjaxReturn::error($this->freightSendLogic->getErrorMessage());
        }

        // 具体的计算方式
        $modeDetail = $this->freightSendLogic->getModeDetail();

        if (0 === count($modeDetail)) {
            return AjaxReturn::error($this->freightSendLogic->getErrorMessage());
        }

        if ($this->logic->getIsAllPost()) { // 包邮
            return AjaxReturn::sendData(0);
        }

        $condition = $this->freightConditionLogic->getFreightOneData($templateConf, $this->logic->getPrimaryKey());

        // 筛选指定条件包邮商家
        $freightMode = $this->freightAreaLogic->sendAddressIsInFreeShipping([
            'con' => $condition,
            'param' => $post,
            'freight_mode' => $modeDetail
        ]);

        $context = Context::getInstance($freightMode, SessionManager::GETFREIGHT_MODE_DATA());

        $monery = $context->getPriceByFreight();

        SessionManager::SET_FREIGHT_MONRY($monery);

        return AjaxReturn::sendData($context->getTotalMoney());
    }
}