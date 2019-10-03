<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\ArticleLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 文章控制器
 * @Controller()
 */
class ArticleController
{

    /**
     * @Inject()
     *
     * @var ArticleLogic
     */
    private $logic;

    /**
     * 文章分类列表
     * @RequestMapping(route="categoryLists", method=RequestMethod::POST)
     */
    public function categoryListsByShopMGCk(Request $req): array
    {
        $ret = $this->logic->categoryLists(); // 逻辑处理

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        } // 获取失败提示并返回

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * 文章列表
     * @RequestMapping(route="lists", method=RequestMethod::POST)
     */
    public function listsByShopMGEf(Request $req): array
    {
        $ret = $this->logic->lists(); // 逻辑处理

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        } // 获取失败提示并返回

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * 文章详情
     * @RequestMapping(route="info", method=RequestMethod::POST)
     */
    public function infoByShopMGMc(Request $req): array
    {
        $ret = $this->logic->info(); // 逻辑处理

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        } // 获取失败提示并返回

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * 获取分类下的文章
     * @RequestMapping(route="getArticleByCategoryId", method=RequestMethod::POST)
     * @Number(name="category_id", min=1)
     */
    public function getArticleByCategoryIdByShopMGOc(Request $req): array
    {
        $data = $this->logic->getArticleListByCategoryIdCache($req->post());

        return AjaxReturn::sendData($data);
    }

    /**
     * 最新文章
     * @RequestMapping(route="getArticleLatest", method=RequestMethod::POST)
     */
    public function getArticleLatestByShopMGXw(): array
    {
        $data = $this->logic->lastestArticleCache();

        if (0 === count($data)) {
            return AjaxReturn::error('暂无文章');
        }

        return AjaxReturn::sendData($data);
    }

    /**
     * 文章详情
     * @RequestMapping(route="getArticleDetails", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function getArticleDetailsByShopMGDv(Request $req): array
    {
        $result = $this->logic->info($req->post());

        return AjaxReturn::sendData($result);
    }
}