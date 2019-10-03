<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\CommentControTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\OrderCommentImgLogic;
use App\Models\Logic\Specific\OrderCommentLogic;
use App\Models\Logic\Specific\OrderLogic;
use Swoft\App;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 订单评价
 * @Controller(perfix="/orderCommentMake")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author Administrator
 */
class OrderCommentMakeController
{
    use CommentControTrait;

    /**
     * @Inject()
     *
     * @var OrderCommentLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var OrderCommentImgLogic
     */
    private $orderCommentImgLogic;

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
     * 发布评论
     * @RequestMapping(route="publishConmment", method=RequestMethod::POST)
     *
     * @param Request $req
     * @return array
     */
    public function publishConmmentByShopMGAd(Request $req): array
    {
        $post = $req->post();

        $receive = $this->commonByComment($post);

        if (!isset($receive['insert_id'])) {
            return $receive;
        }

        if ($post['have_pic'] === '1' && !empty($post['path'])) {

            $post['comment_id'] = $receive['insert_id'];

            $status = $this->orderCommentImgLogic->addCommentPic($post);

            if (!$status) {
                return AjaxReturn::error($this->logic->getErrorMessage());
            }
        }

        $orderLogic = App::getBean(OrderLogic::class);

        $status = $orderLogic->commentStatus($post);

        if (!$status) {
            return AjaxReturn::error($orderLogic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 评论详情
     * @RequestMapping(route="evaluateDetails", method=RequestMethod::POST)
     * @Number(name="goods_id", min=1)
     * @Number(name="order_id", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function evaluateDetailsByShopMGVp(Request $req): array
    {
        // 评价详情
        $evaluateDetails = $this->logic->getEvaluateDetails($req->post());

        if (0 === count($evaluateDetails)) {
            return AjaxReturn::error('评价详情错误');
        }

        $orderCommentImages = $this->orderCommentImgLogic->getOrderCommentImage($evaluateDetails, $this->logic->getPrimaryKey());

        $goods = $this->goodsLogic->getGoodInfoByOneOfTheTotalCommoditiesCache($evaluateDetails, $this->logic->getSplitKeyByGoods());

        $goodsImage = $this->goodsImagesLogic->getThumbImagesByGoodsId($goods, $this->goodsLogic->getSplitKeyByPid());

        return AjaxReturn::sendData([
            'comment' => $evaluateDetails,
            'comment_image' => $orderCommentImages,
            'goods' => array_merge($goodsImage, $goods)
        ]);
    }
}
