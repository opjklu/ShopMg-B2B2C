<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\StoreLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Swoft\Bean\Annotation\Number;
use Swoft\App;

/**
 * @Controller(prefix="/selfMadeGoods")
 *
 * @author wq
 *
 */
class SelfMadeGoodsController
{

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $logic;
    
    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;
    
    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;
    
    /**
     * 获取自营商品
     * @RequestMapping(route="getGoodsSelfMadeGoods", method=RequestMethod::POST)
     * @Number(name="p", min=1)
     */
    public function getGoodsSelfMadeGoodsByShopMGXl(Request $req): array
    {
        $post = $req->post();
        
        $idArray = $this->logic->getSelfStoreList($post);

        if (0 === count($idArray)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $goodsData = $this->goodsLogic->getSelfStoreGoodsCache($post, $idArray['data']);

        if (0 === count($goodsData)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $image = $this->goodsImagesLogic->getSelfStoreGoodsImageCache($post, $goodsData);

        $idArray['data'] = $goodsData;

        $idArray['image'] = $image;

        return AjaxReturn::sendData($idArray);
    }
}
