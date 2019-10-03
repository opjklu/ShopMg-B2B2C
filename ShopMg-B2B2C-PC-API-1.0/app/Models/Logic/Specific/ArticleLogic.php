<?php
declare(strict_types = 1);
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Article;
use App\Common\FieldMapping\ArticleCategory;
use App\Models\Entity\DbArticle;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 文章逻辑处理层
 *
 * @author 米糕网络团队
 *         @Bean()
 */
class ArticleLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    public function __construct()
    {
        //
        //
        $this->tableName = DbArticle::class;
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
        return Article::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
        return [
            Article::$name
        ];
    }

    /**
     * 获取底部文章并缓存
     */
    public function getCategoryListsCache(): array
    {
        $key = 'article_55_cache';
        
        $cache = Cache::getInstance('', [
            'expire' => 60
        ]);
        
        $data = $cache->get($key);
        
        if (! empty($data)) {
            return $data;
        }
        
        $data = $this->categoryLists();
        
        if (count($data) === 0) {
            $this->errorMessage = '文章分类为空';
            return [];
        }
        
        $cache->set($key, $data);
        
        return $data;
    }

    /**
     * 文章详情
     */
    public function info(array $post)
    {
        $retData = $this->getQueryBuilderProxy('a')
            ->field([
            'a.article_category_id',
            'a.id',
            'a.name',
            'a.intro',
            'a.create_time',
            'b.content'
        ])
            ->leftJoin('mg_article_content', 'b.article_id = a.id', 'b')
            ->where('a.id', $post['id'])
            ->where('a.status', 1)
            ->find();
        if (0 === count($retData)) {
            $this->errorMessage = '查询数据为空!';
            return [];
        }
        
        $retData['content'] = htmlspecialchars_decode($retData['content']);
        
        // 上一篇文章
        $retData['up_article'] = $this->getQueryBuilderProxy()
            ->condition([
            [
                'article_category_id',
                '=',
                $retData['article_category_id']
            ],
            [
                'id',
                '>',
                $retData['id']
            ]
        ])
            ->order('sort', 'DESC')
            ->field([
            'name',
            'id',
            'create_time'
        ])
            ->find();
        
        // 下一篇文章
        $retData['down_article'] = $this->getQueryBuilderProxy()
            ->condition([
            [
                'article_category_id',
                '=',
                $retData['article_category_id']
            ],
            [
                'id',
                '<',
                $retData['id']
            ]
        ])
            ->order('sort', 'DESC')
            ->field([
            'name',
            'id',
            'create_time'
        ])
            ->find();
        
        return $retData;
    }

    /**
     * 获取文章列表
     *
     * @return array
     */
    public function getArticleList(array $data, string $splitKey): array
    {
        $idString = array_column($data, $splitKey);
        
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn(Article::$articleCategory_id, $idString)
            ->order(Article::$sort, 'DESC')
            ->limit(4)
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
            Article::$id,
            Article::$name,
            Article::$createTime,
            Article::$articleCategory_id
        ];
    }

    /**
     * 获取文章列表
     *
     * @return array
     */
    public function getArticleListCache(array $data, string $splitKey): array
    {
        $key = 'article_detail_66';
        
        $cache = &$this->cache;
        
        $cacheData = $cache->get($key);
        
        if ($cacheData) {
            return json_decode($cacheData, true);
        }
        
        $data = $this->getArticleList($data, $splitKey);
        
        if (count($data) === 0) {
            $this->errorMessage = '文章列表为空';
            return [];
        }
        
        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 90);
        
        return $data;
    }

    /**
     * 获取分类下的文章
     *
     * @return array
     */
    public function getArticleListByCategoryId(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(Article::$articleCategory_id, $post['category_id'])
            ->where(ArticleCategory::$status, 1)
            ->select();
    }

    /**
     * 获取分类下的文章
     *
     * @return array
     */
    public function getArticleListByCategoryIdCache(array $post): array
    {
        $key = 'article_whate_categorey' . $post['category_id'];
        
        $cache = &$this->cache;
        
        $data = $cache->get($key);
        
        if ($data) {
            return json_decode($data, true);
        }
        
        $data = $this->getArticleListByCategoryId($post);
        
        if (count($data) === 0) {
            $this->errorMessage = '暂无文章';
            return [];
        }
        
        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 45);
        
        return $data;
    }

    /**
     * 获取 最新文章
     */
    public function lastestArticle(): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
            Article::$id,
            Article::$name
        ])
            ->where(Article::$status, 1)
            ->order(Article::$id, 'DESC')
            ->limit(6)
            ->select();
    }

    /**
     * 获取 最新文章并缓存
     *
     * @return array
     */
    public function lastestArticleCache(): array
    {
        $key = 'cache_lastest_117';
        
        $cache = &$this->cache;
        
        $data = $cache->get($key);
        
        if ($data) {
            return json_decode($data, true);
        }
        
        $data = $this->lastestArticle();
        
        if (count($data) === 0) {
            return [];
        }
        
        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 60);
        
        return $data;
    }
}
