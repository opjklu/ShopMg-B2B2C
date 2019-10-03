<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 wq.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://wq.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\CommentControTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OrderPackageCommentImgLogic;
use App\Models\Logic\Specific\OrderPackageCommentLogic;
use App\Models\Logic\Specific\OrderPackageLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Bean\Annotation\Number;
use Tool\AjaxReturn;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\GoodsImagesLogic;

/**
 * :array
 * 套餐订单评价
 *
 * @author Administrator
 *
 * @Controller(perfix="orderPackageCommentMake")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class OrderPackageCommentMakeController
{

    use CommentControTrait;
    /**
     * @Inject()
     *
     * @var OrderPackageCommentLogic
     */
    private $logic;
    
    /**
     * @Inject()
     * @var OrderPackageCommentImgLogic
     */
    private $orderPackageCommentImgLogic;

    /**
     * @Inject()
     * @var OrderPackageLogic
     */
    private $orderPackageLogic;
    
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
     * 发表评论
     * @RequestMapping(route="publishConmment")
     */
    public function publishConmmentByShopMGFe(Request $req): array
    {
        $post = $req->post();
        
        $receive = $this->commonByComment($post);
        
        if (!isset($receive['insert_id'])) {
            return $receive;
        }

        if ($post['have_pic'] === '1' && !empty($post['path'])) {

            $post['comment_id'] = $receive['insert_id'];

            $status = $this->orderPackageCommentImgLogic->addCommentPic($post);

            if (!$status) {
                return AjaxReturn::error($this->orderPackageCommentImgLogic->getErrorMessage());
            }
        }


        $status = $this->orderPackageLogic->commentStatus($post);

        if (!$status) {
            return AjaxReturn::error($this->orderPackageLogic->getErrorMessage());
        }
        
        return AjaxReturn::sendData('');
    }
    
    /**
     * @RequestMapping(route="evaluateDetails", method=RequestMethod::POST)
     * @Number(name="goods_id", min=1)
     * @Number(name="order_id", min=1)
     * @param Request $req
     * @return array
     */
    public function evaluateDetailsByShopMGFb(Request $req): array
    {
        $evaluateDetails = $this->logic->getEvaluateDetails($req->post());
        
        if (0 === count($evaluateDetails)) {
            return AjaxReturn::error('评价详情错误');
        }
        
        $orderCommentImages = $this->orderPackageCommentImgLogic->getOrderCommentImage($evaluateDetails, $this->logic->getPrimaryKey());
        
        $goods = $this->goodsLogic->getGoodInfoByOneOfTheTotalCommoditiesCache($evaluateDetails, $this->logic->getSplitKeyByGoods());
        
        $goodsImage = $this->goodsImagesLogic->getThumbImagesByGoodsId($goods, $this->goodsLogic->getSplitKeyByPid());
        
        return AjaxReturn::sendData([
            'comment' => $evaluateDetails,
            'comment_image' => $orderCommentImages,
            'goods' => array_merge($goodsImage, $goods)
        ]);
    }
}
