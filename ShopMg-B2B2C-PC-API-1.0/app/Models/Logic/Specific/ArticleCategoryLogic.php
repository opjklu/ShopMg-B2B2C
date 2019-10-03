<?php
declare(strict_types = 1);
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\ArticleCategory;
use App\Models\Entity\DbArticleCategory;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 文章逻辑处理层
 * @Bean()
 */
class ArticleCategoryLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    public function __construct()
    {
        $this->tableName = DbArticleCategory::class;
    }

    public function getResult()
    {}

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return ArticleCategory::class;
    }

    /**
     * 查看文章分类列表
     */
    public function categoryLists(): array
    {
        // 首页底部文章
        return $this->getQueryBuilderProxy()
            ->field([
            'id',
            'name'
        ])
            ->condition([
            "status" => 1,
            'is_help' => 1
        ])
            ->order('sort', 'DESC')
            ->limit(8)
            ->select();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            ArticleCategory::$id,
            ArticleCategory::$name,
            ArticleCategory::$createTime
        ];
    }

    /**
     * 获取底部文章并缓存
     */
    public function getCategoryListsCache(): array
    {
        $key = 'article_55_cache';
        
        $cache = &$this->cache;
        
        $data = $cache->get($key);
        
        if (! empty($data)) {
            return json_decode($data, true);
        }
        
        $data = $this->categoryLists();
        
        if (count($data) === 0) {
            $this->errorMessage = '文章分类为空';
            return [];
        }
        
        $cache->set($key, json_encode($data), 120);
        
        return $data;
    }
}
