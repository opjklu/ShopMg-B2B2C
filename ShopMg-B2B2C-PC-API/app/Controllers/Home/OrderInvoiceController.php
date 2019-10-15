<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\OrderInvoiceLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Bean\Annotation\Number;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/orderInvoice")
 *
 * @author wq
 *
 */
class OrderInvoiceController
{

    /**
     * @Inject()
     *
     * @var OrderInvoiceLogic
     */
    private $logic;

    /**
     * 添加订单发票数据
     * @RequestMapping(route="addOrderInvoice", method=RequestMethod::POST)
     * @Number(name="raised_id", min=1)
     * @Number(name="content_id", min=1)
     * @Number(name="type_id", min=1)
     */
    public function addOrderInvoiceByShopMGRm(Request $req): array
    {

        $ret = $this->logic->addData($req->post());

        if (0 === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }
}
