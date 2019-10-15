<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\BrandLogic;
use App\Models\Logic\Specific\GoodsClassLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\StoreLogic;
use Common\Tool\Extend\ClassificationTreatment;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller(prefix="/contrast")
 *
 * @author wq
 *
 */
class ContrastController
{

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var BrandLogic
     */
    private $brandLogic;

    /**
     * @Inject()
     *
     * @var GoodsClassLogic
     */
    private $goodsClassLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * 对比结果
     * @RequestMapping(route="contrastResult", method=RequestMethod::POST)
     */
    public function contrastResultByShopMGUd(Request $req): array
    {
        $post = $req->post();

        $checkParam = new CheckParam($this->logic->getValidateByContrast(), $post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }

        $goods = $this->logic->getContrastGoodsById($post);

        if (0 === count($goods)) {
            return AjaxReturn::error('商品错误');
        }

        $brandData = $this->brandLogic->getBrandForGoods($goods, $this->logic->getSplitKeyByBrand());

        $classIdArray = (new ClassificationTreatment($brandData, $this->logic->getClassIdKey()))->getClassIdArray();

        $goods = $this->goodsClassLogic->getGoodsClassByBindClass($classIdArray, $brandData);

        $goods = $this->storeLogic->getStoreByContrast($goods, $this->logic->getSplitKeyByStore());

        return AjaxReturn::sendData($goods);
    }
}
