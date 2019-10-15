<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\BrandLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller(prefix="/brand")
 *
 * @author wq
 *
 */
class BrandController
{

    /**
     * @Inject()
     *
     * @var BrandLogic
     */
    private $logic;

    /**
     * 品牌列表
     * @RequestMapping(route="brandList", method=RequestMethod::POST)
     */
    public function brandListByShopMGEo(Request $req): array
    {
        // 检测传值
        $ret = $this->logic->getBrandLists($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 品牌推荐
     * @RequestMapping(route="recommendBrand", method=RequestMethod::POST)
     */
    public function recommendBrandByShopMGDr(Request $req): array
    {
        $brand = $this->logic->getRecommendBrandListCache();

        if (0 === count($brand)) {
            return AjaxReturn::error('暂无推荐的品牌');
        }

        return AjaxReturn::sendData($brand);
    }
}