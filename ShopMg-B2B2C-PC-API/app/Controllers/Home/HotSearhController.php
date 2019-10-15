<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsItemLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller(prefix="/hotSearh")
 *
 * @author wq
 *
 */
class HotSearhController
{

    /**
     * @Inject()
     *
     * @var GoodsItemLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;

    /**
     * 商品热词搜索列表
     * @RequestMapping(route="getHotSearchList",method=RequestMethod::POST)
     */
    public function getHotSearchListByShopMGOo(Request $req): array
    {
        $post = $req->post();
        
        $checkParam = new CheckParam($this->logic->getvalidateByHotSearch(), $post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }

        $data = $this->logic->getHotSearchList($post);
        
        if (0 === count($data['data'])) {
            return AjaxReturn::error('暂无数据');
        }

        $data['data'] = $this->goodsImagesLogic->getImageByArrayGoods($data['data']);

        return AjaxReturn::sendData($data);
    }
}
