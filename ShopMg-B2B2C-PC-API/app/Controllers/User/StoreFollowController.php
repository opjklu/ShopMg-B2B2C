<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\StoreFollowLogic;
use App\Models\Logic\Specific\StoreLogic;
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
 * 店铺收藏控制器
 * @Controller(prefix="/storeFollow")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author Administrator
 */
class StoreFollowController
{

    /**
     * @Inject()
     *
     * @var StoreFollowLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storelogic;

    /**
     * 关注店铺
     * @RequestMapping(route="attenStore", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function attenStoreByShopMGKi(Request $request): array
    {
        $post = $request->post();

        $ret = $this->logic->attenStore($post);

        if (!$ret) {
            return AjaxReturn::error('关注失败或已关注');
        }

        $status = $this->storelogic->storesIncreaseTheNumberOfFansByTrancestation($post);

        if (!$status) {
            return AjaxReturn::error('关注失败,店铺增加粉丝数失败');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 取消关注店铺
     * @RequestMapping(route="cancelAttenStore", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function cancelAttenStoreByShopMGCx(Request $request): array
    {
        $post = $request->post();

        $ret = $this->logic->cancelAttenStore($post);

        if (!$ret) {
            return AjaxReturn::error('取消关注失败');
        }

        $status = $this->storelogic->storesReduceTheNumberOfFansByTrancestation($post);

        if (!$status) {
            return AjaxReturn::error('取消失败,店铺减少粉丝数失败');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 我的收藏--店铺收藏
     * @RequestMapping(route="myCollectionStore", method=RequestMethod::POST)
     */
    public function myCollectionStoreByShopMGJj(): array
    {
        $result = $this->logic->getMyCollectionStore();

        if (0 === count($result)) {
            return AjaxReturn::error('暂无店铺收藏');
        }

        $result = $this->storelogic->getStoreByContrast($result, $this->logic->getSplitKeyByStore());

        return AjaxReturn::sendData($result);
    }

    /**
     * 我的收藏--店铺收藏搜索
     * @RequestMapping(route="myStoreFollowSearch", method=RequestMethod::POST)
     * @Number(name="page", min=1, default=1)
     */
    public function myStoreFollowSearchByShopMGNd(Request $req): array
    {
        $post = $req->post();

        // 验证数据
        $checkObj = new CheckParam($this->logic->getValidateBySearch(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $storeWhere = $this->storelogic->getAssociationCondition($post);

        if ($this->storelogic->getWhereExits()) {
            return AjaxReturn::error('暂无数据');
        }

        $result = $this->logic->getStoreFollowSearch($post, $storeWhere);


        if (0 === count($result['data'])) {
            return AjaxReturn::error('暂无店铺收藏');
        }

        $result['data'] = $this->storelogic->getStoreByContrast($result['data'], $this->logic->getSplitKeyByStore());

        return AjaxReturn::sendData($result['data']);
    }
}