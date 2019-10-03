<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\HotWords;
use App\Models\Entity\DbHotWords;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 关键词逻辑处理层
 * @Bean()
 */
class HotWordsLogic extends AbstractLogic
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

        // $this->getQueryBuilderProxy() = Base::getInstance('HotWords');
        $this->tableName = DbHotWords::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'page' => [
                'required' => '必须输入分页信息'
            ]
        ];
        return $message;
    }

    /**
     * 获取结果
     */
    public function getResult()
    {
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return HotWords::class;
    }

    /**
     * 热门搜索
     */
    public function hotWordSearch(): array
    {

        $field = [
            'id',
            'hot_words',
            'goods_class_id'
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where('is_hide', 1)
            ->order('update_time', 'desc')
            ->limit(10)
            ->select();
    }

    /**
     * 热门搜索关键词带缓存
     */
    public function hotWordSearchCache(): array
    {
        $key = 'hot_search_key111';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data != null) {
            return json_decode($data, true);
        }

        $data = $this->hotWordSearch();

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 200);

        return $data;
    }
}
