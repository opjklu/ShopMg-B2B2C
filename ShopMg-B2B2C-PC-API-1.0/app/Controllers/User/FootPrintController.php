<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\FootPrintLogic;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
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
 * 足迹
 * @Controller(perfix="/footPrint")
 *
 * @author Administrator
 * @Middleware(ValidateLoginMiddleware::class)
 */
class FootPrintController
{

    /**
     * @Inject()
     *
     * @var FootPrintLogic
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
     * 最近浏览
     * @RequestMapping(route="myFootFrint", method=RequestMethod::POST)
     * @Number(name="page", min=1, default=1)
     */
    public function myFootFrintByShopMGQe(Request $req): array
    {
        // 检测传值 //检测方法
        $result = $this->logic->getParseDataByListNoSearch($req->post());

        $data = $this->getGoodsInfoByFoot($result['data']);

        $tmp = $data['data'];

        unset($data['data']);

        $data['data']['data'] = $tmp;

        $data['data']['count'] = $result['count'];

        $data['data']['page_size'] = $result['page_size'];

        return $data;
    }

    /**
     * 我的收藏--猜你喜欢
     * @RequestMapping(route="myCollectionLike", method=RequestMethod::POST)
     */
    public function myCollectionLikeByShopMGBa(): array
    {
        $result = $this->logic->getMyLikeFootFrint();

        return $this->getGoodsInfoByFoot($result);
    }

    /**
     * 附属方法
     *
     * @param array $result
     * @return array
     */
    private function getGoodsInfoByFoot(array $result): array
    {
        if (0 === count($result)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $result = $this->goodsLogic->getGoodsByData($result, 'gid');

        $result = $this->goodsImagesLogic->getImageByArrayGoods($result);

        return AjaxReturn::sendData($result);
    }

    /**
     * 最近浏览--删除
     * @RequestMapping(route="myFootFrintDel", method=RequestMethod::POST)
     */
    public function myFootFrintDelByShopMGKq(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByDel(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $result = $this->logic->getMyFootFrintDel($post);

        if ($result === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($result);
    }

    /**
     * 最近浏览--宝贝搜索
     * @RequestMapping(route="myFootFrintSearch", method=RequestMethod::POST)
     */
    public function myFootFrintSearchByShopMGJg()
    {
        return AjaxReturn::sendData([]);
    }

    /**
     * 个人中心首页--猜你喜欢
     * @RequestMapping(route="myCollectionlikes", method=RequestMethod::POST)
     */
    public function myCollectionlikesByShopMGSo(): array
    {
        $result = $this->logic->guessYouLikeGoods();

        if (0 === count($result)) {
            return AjaxReturn::error('暂未找到');
        }

        $result = $this->goodsLogic->getGoodsByData($result, $this->logic->getSplitKeyByGoods());

        $result = $this->goodsImagesLogic->getImageByArrayGoods($result);

        return AjaxReturn::sendData($result);
    }

    /**
     * 个人中心首页--浏览记录
     * @RequestMapping(route="myCollectionRecords", method=RequestMethod::POST)
     */
    public function myCollectionRecordsByShopMGJs(): array
    {
        return $this->myCollectionlikes();
    }
}