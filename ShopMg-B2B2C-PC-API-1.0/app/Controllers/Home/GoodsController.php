<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\FootPrintLogic;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use Swoft\App;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Cookie\Cookie;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Http\Server\Command\ServerCommand;
use Swoft\Process\ProcessBuilder;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/goods")
 * 商品控制器
 */
class GoodsController
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
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;

    /**
     * @Inject()
     *
     * @var FootPrintLogic
     */
    private $footPrintLogic;

    /**
     * 获取商品详情
     * @RequestMapping(route="goodsDetails", method=RequestMethod::POST)
     * @Number(name="id", min=0)
     */
    public function goodsDetailsByShopMGRh(Request $req, Response $response): Response
    {
        $param = $req->post();

        $ret = $this->logic->getGoodInfoCache($param);

        if (count($ret) === 0) {
            return $response->json(AjaxReturn::error($this->logic->getErrorMessage()));
        }

        // 是否登录
        $userId = App::getBean('sessionManager')->getSession()->get('user_id');
        if ($userId) {

            $this->footPrintLogic->addData($ret);
        } else {
            // 未登录时猜你喜欢

            $classId = $ret['class_two'];

            $brandId = $ret['brand_id'];

            $time = time() + 600;

            $cookieDomin = config('cookie_domain');

            $cookie = $req->getCookieParams();

            if (isset($cookie['class_id']) && false === strpos($cookie['class_id'], $classId . ',')) {

                $classId .= ',' . $cookie['class_id'];
            }

            if (isset($cookie['brand_id']) && false === strpos($cookie['brand_id'], $brandId . ',')) {

                $brandId .= ',' . $cookie['brand_id'];
            }

            $response = $response->withCookie(new Cookie('brand_id', $brandId, $time, '/', $cookieDomin))->withCookie(new Cookie('class_id', $classId, $time, '/', $cookieDomin));
        }

        $images = $this->goodsImagesLogic->getGoodsImagesByPidCache($ret, $this->logic->getSplitKeyByPid());

        $ret['images'] = $images;

        // try {
        // ProcessBuilder::get('php-swoft what');
        // } catch (\Exception $e) {
        // var_dump($e->getMessage());
        // // App::getBean(ServerCommand::class)->stop();
        // }

        return $response->json(AjaxReturn::sendData($ret));
    }

    /**
     * 用于个人中心查询商品数据
     * @RequestMapping(route="getGoodsDetailByUserCenter", method=RequestMethod::POST)
     * @Number(name="id", min=0)
     */
    public function getGoodsDetailByUserCenterByShopMGNc(Request $req): array
    {
        $ret = $this->logic->getGoodInfoByOneOfTheTotalCommoditiesCache($req->post());

        if (count($ret) === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        $images = $this->goodsImagesLogic->getGoodsImagesByPidCache($ret, $this->logic->getSplitKeyByPid());

        $ret['images'] = $images;

        return AjaxReturn::sendData($ret);
    }

    /**
     * 获取店铺热门商品排行
     * @RequestMapping(route="hotCommodities", method=RequestMethod::POST)
     */
    public function hotCommoditiesByShopMGBx(Request $req): array
    {
        $result = $this->logic->hotSellingGoodsAll($req->post());
        return AjaxReturn::sendData($result);
    }

    /**
     * 店铺--爆品专区
     * @RequestMapping(route="detonating", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function detonatingByShopMGBc(Request $req): array
    {
        $ret = $this->logic->getDetonating($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无数据');
        }

        $ret = $this->goodsImagesLogic->getImageByArrayGoods($ret);

        $left = array_shift($ret);

        $length = count($ret);

        $ct = [];

        for ($i = 0; $i < 3 && $i < $length - 1; $i++) {
            $ct[] = $ret[$i];
        }

        $right = [];

        for ($i; $i < $length - 1; $i++) {
            $right[] = $ret[$i];
        }

        $cl = array_pop($ret);

        return AjaxReturn::sendData([
            'center_top' => $ct,
            'left' => $left,
            'center_lower' => $cl,
            'right' => $right
        ]);
    }

    /**
     * 店铺--推荐商品
     * @RequestMapping(route="recommendGoods", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function recommendGoodsByShopMGDb(Request $req): array
    {
        $ret = $this->logic->recommendByStore($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无数据');
        }

        $ret = $this->goodsImagesLogic->getImageByArrayGoods($ret);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 店铺--新品推荐
     * @RequestMapping(route="newArrivalsGoodsByStore", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function newArrivalsGoodsByStoreByShopMGBm(Request $req): array
    {
        $ret = $this->logic->newArrivalsAllByStore($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无数据');
        }

        $ret = $this->goodsImagesLogic->getImageByArrayGoods($ret);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 获取店铺全部宝贝
     * @RequestMapping(route="storeGoodsAll", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     * @Number(name="page", min=1)
     */
    public function storeGoodsAllByShopMGPx(Request $req): array
    {
        $ret = $this->logic->getGoodsListByStore($req->post());

        if (0 === count($ret['list'])) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $ret['list'] = $this->goodsImagesLogic->getImageByArrayGoods($ret['list']);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 积分热兑商品列表
     * @RequestMapping(route="getGoodsListByIntegral", method=RequestMethod::POST)
     */
    public function getGoodsListByIntegralByShopMGBd(): array
    {
        $data = $this->logic->getGoodsByIntegralHotCache();

        if (0 === count($data)) {
            return AjaxReturn::error('暂无数据');
        }

        $data = $this->goodsImagesLogic->getImageByArrayGoods($data);

        return AjaxReturn::sendData($data);
    }
}
