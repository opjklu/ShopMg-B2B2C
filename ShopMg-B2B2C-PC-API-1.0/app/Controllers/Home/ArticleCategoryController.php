<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\ArticleCategoryLogic;
use App\Models\Logic\Specific\ArticleLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/articleCategory")
 * 文章分类
 *
 * @author Administrator
 */
class ArticleCategoryController
{

    /**
     * @Inject()
     *
     * @var ArticleCategoryLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var ArticleLogic
     */
    private $articeLogic;

    /**
     * 首页底部文章
     * @RequestMapping(route="categoryLists")
     */
    public function categoryListsByShopMGRw(): array
    {
        $ret = $this->logic->getCategoryListsCache(); // 逻辑处理

        if (count($ret) === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $article = $this->articeLogic->getArticleListCache($ret, $this->logic->getPrimaryKey());

        return AjaxReturn::sendData([
            'atricle_category' => $ret,
            'article' => $article
        ]); // 返回数据
    }

    /**
     * 文章分类
     * @RequestMapping(route="getArticleType")
     */
    public function getArticleTypeByShopMGEa(): array
    {
        $ret = $this->logic->getCategoryListsCache(); // 逻辑处理

        return AjaxReturn::sendData($ret);
    }
}