<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsAdvisoryReplyLogic;
use App\Models\Logic\Specific\GoodsConsultationLogic;
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
 * @Controller(perfix="goodsConsultation")
 *
 * @author wq
 *
 */
class GoodsConsultationController
{

    /**
     * @Inject()
     *
     * @var GoodsConsultationLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsAdvisoryReplyLogic
     */
    private $goodsAdvisoryReplyLogic;

    /**
     * 商品咨询数据
     * @RequestMapping(route="consultationData", method=RequestMethod::POST)
     * @Number(name="goods_id", min=1)
     * @Number(name="page", min=1)
     */
    public function consultationDataByShopMGNp(Request $req): array
    {
        $param = $req->post();

        $ret = $this->logic->getGoodsConsultationByGoods($param);

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }

        $advisoryData = $this->goodsAdvisoryReplyLogic->getParseGoodsAdvisoryReply($ret['data'], $this->logic->getPrimaryKey());

        $ret['data'] = $advisoryData;

        return AjaxReturn::sendData($ret);
    }

    /**
     * 用户提交问题
     * @Middleware(ValidateLoginMiddleware::class)
     * @RequestMapping(route="userCommitProblem", method=RequestMethod::POST)
     */
    public function userCommitProblemByShopMGDg(Request $req): array
    {
        $param = $req->post();

        $param['ip'] = $req->getServerParams()['remote_ip'];

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getMessageValidate(), $param);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->addData($param);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}
