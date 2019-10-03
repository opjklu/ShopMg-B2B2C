<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\InvoiceContentLogic;
use App\Models\Logic\Specific\InvoicesAreRaisedLogic;
use App\Models\Logic\Specific\InvoiceTypeLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Swoft\App;

/**
 * @Controller(perfix="invoiceType")
 *
 * @author wq
 *
 */
class InvoiceTypeController
{

    /**
     * @Inject()
     *
     * @var InvoiceTypeLogic
     */
    private $logic;
    


    /**
     * 数据
     * @RequestMapping(route="getAllInvoice", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function getAllInvoiceByShopMGHa(Request $req): array
    {
        $ret = $this->logic->getInvoiceAreRaisedList();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 获取发票类型
     * @RequestMapping(route="getInvoiceTypeData", method=RequestMethod::POST)
     */
    public function getInvoiceTypeDataByShopMGSd(Request $req): array
    {
        // 发票类型
        $invoiceList = $this->logic->invoiceListCache();

        if (0 === count($invoiceList)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }


        $invoiceContentLogic = App::getBean(InvoiceContentLogic::class);
        
        $invoiceContentData = $invoiceContentLogic->invoiceContentDataCache();

        if (0 === count($invoiceContentData)) {
            return AjaxReturn::error($invoiceContentLogic->getErrorMessage());
        }
        
        // 发票抬头
        $raisedData = App::getBean(InvoicesAreRaisedLogic::class)->invoiceAreRaiseDataCache();

        return AjaxReturn::sendData([
            'invoice_type' => $invoiceList,
            'invoice_content' => $invoiceContentData,
            'raised_data' => $raisedData
        ]);
    }
}
