<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsClass;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\Tree;

/**
 * 商品分类模型
 * @Bean()
 */
class GoodsClassLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    public function __construct()
    {
        $this->tableName = 'mg_goods_class';
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin(): array
    {
        $message = [
            'fid' => [
                'required' => '上级Id必传'
            ]
        ];
        return $message;
    }

    public function getValidateByShop(): array
    {
        $message = [
            'store_id' => [
                'required' => '必须传入店铺ID'
            ]
        ];
        return $message;
    }

    /**
     * 获取所有的商品分类 获取所有的商品分类
     */
    public function getAllClassees()
    {
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
        return GoodsClass::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [
        ];
    }

    /**
     * 验证page
     */
    public function getValidateByClassPage(): array
    {
        return [
            'page' => [
                'number' => '分页必须是数字'
            ]
        ];
    }

    /**
     * 分类必须是一推荐的
     */
    public function getTopClass()
    {
        $cache = &$this->cache;

        $key = 'goods_top_class';

        $data = $cache->get($key);

        if (!empty($data)) {
            return array(
                'status' => 1,
                'message' => '获取成功',
                'data' => $data
            );
        }

        $field = 'id,class_name';
        $where['fid'] = 0;
        $where['hide_status'] = 1;
        $ret = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition($where)
            ->order('sort_num DESC')
            ->select();
        $cache->set($key, $ret);

        return array(
            'status' => 1,
            'message' => '获取成功',
            'data' => $ret
        );
    }

    /**
     * 获取所有分类数据
     *
     * @return
     *
     */
    public function getCacheByClassByPid(array $post): array
    {
        $cache = &$this->cache;

        $key = 'cache_class_' . $post['id'] . '_sdf';

        $data = $cache->get($key);

        if (!empty($data)) {
            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field([
                'id',
                'class_name',
                'fid'
            ])
            ->where('fid', $post['id'])
            ->where('hide_status', 1)
            ->select();
        if (empty($data)) {
            $this->errorMessage = '商品分类错误';
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 160);

        return $data;
    }

    /**
     * 分类必须是一推荐的
     * 楼层数据
     *
     * @return array
     */
    public function getClassByPage(array $post)
    {
        $cache = $this->cache;

        $page = $post['page'] - 1;

        $key = 'goods_class_page' . '_' . $page;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $field = GoodsClass::$id . ',' . GoodsClass::$className . ',' . GoodsClass::$picUrl;

        $data = $this->getQueryBuilderProxy()
            ->field([
                'id',
                'class_name',
                'pic_url',
                'pc_url'
            ])
            ->where('fid', 0)
            ->where(GoodsClass::$hideStatus, 1)
            ->where(GoodsClass::$shoutui, 1)
            ->order(GoodsClass::$sortNum, 'DESC')
            ->limit(1, $page)
            ->select();
        if (empty($data[0])) {
            return [];
        }

        $cache->set($key, json_encode($data[0], JSON_UNESCAPED_UNICODE), 60);

        return $data[0];
    }

    /**
     * 根据一级分类获取二级分类
     */
    public function getClassTwoByOne(array $oneClass): array
    {
        $id = $oneClass[GoodsClass::$id];

        $field = $this->getTableColum();

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where(GoodsClass::$fid, $id)
            ->where('hide_status', 1)
            ->order('sort_num', 'DESC')
            ->select();
    }

    /**
     * 获取三级分类
     *
     * @return array
     */
    public function getClassThreeByTwo(array $data): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn('fid', $data)
            ->where('hide_status', 1)
            ->order('sort_num', 'DESC')
            ->select();
    }

    /**
     *
     * @param array $oneClass
     * @return array
     */
    public function getClassThreeByTwoCache(array $twoClass): array
    {
        $column = array_column($twoClass, 'id');

        $key = implode('', $column) . '_three_class';

        $cache = $this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getClassThreeByTwo($column);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 105);

        return $data;
    }

    /**
     * 组装二三级分类
     *
     * @param array $data
     * @return array
     */
    public function classTwoThreeBuild(array $data): array
    {
        $twoCLass = $this->getClassTwoByOneCache($data);

        if (0 === count($twoCLass)) {
            return [];
        }

        $threeClass = $this->getClassThreeByTwoCache($twoCLass);

        $tree = new Tree(array_merge($threeClass, $twoCLass));

        return $tree->makeTree([
            'parent_key' => 'fid'
        ], $data['id']);
    }

    /**
     *
     * @param array $oneClass
     * @return array
     */
    public function getClassTwoByOneCache(array $oneClass): array
    {
        $key = $oneClass[GoodsClass::$id] . '_two_class';

        $cache = $this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getClassTwoByOne($oneClass);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 100);

        return $data;
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
            GoodsClass::$id,
            GoodsClass::$className,
            GoodsClass::$picUrl,
            GoodsClass::$fid
        ];
    }

    /**
     * 根据绑定的分类获取分类数据
     */
    public function getGoodsClassByBindClass(array $classKey, array $bindClassData): array
    {
        $data = $this->getGoodsClass($classKey);

        foreach ($bindClassData as $key => & $value) {

            if (isset($data[$value['class_id']])) {
                $value['one_name'] = $data[$value['class_id']];
            }

            if (isset($data[$value['class_two']])) {
                $value['two_name'] = $data[$value['class_two']];
            }

            if (isset($data[$value['class_three']])) {
                $value['three_name'] = $data[$value['class_three']];
            }
        }

        return $bindClassData;
    }

    /**
     * 根据绑定的分类获取分类数据（未审核）
     */
    public function getGoodsClassByBindClassByApproval(array $data): array
    {
        $one = array_column($data, 'one_class');

        $two = array_column($data, 'two_class');

        $three = array_column($data, 'three_class');

        $id = array_merge($one, $two, $three);

        $receive = $this->getQueryBuilderProxy()
            ->field([
                GoodsClass::$id,
                GoodsClass::$className
            ])
            ->whereIn(GoodsClass::$id, $id)
            ->getField();

        if (0 === count($receive)) {
            return [];
        }

        foreach ($data as $key => & $value) {

            if (isset($receive[$value['one_class']])) {
                $value['one_name'] = $receive[$value['one_class']];
            }

            if (isset($receive[$value['two_class']])) {
                $value['two_name'] = $receive[$value['two_class']];
            }

            if (isset($receive[$value['three_class']])) {
                $value['three_name'] = $receive[$value['three_class']];
            }
        }

        return $data;
    }

    /**
     * 获取分类
     *
     * @param array $classKey
     * @return array
     */
    protected function getGoodsClass(array $classKey): array
    {
        $id = implode(',', $classKey);

        $data = $this->getQueryBuilderProxy()
            ->where(GoodsClass::$id . ' in (%s)', $id)
            ->getField(GoodsClass::$id . ',' . GoodsClass::$className);

        if (empty($data)) {
            return [];
        }

        return $data;
    }

    /**
     * 获取分类信息
     *
     * @param array $data
     * @return array
     */
    public function getGoodsClassByBindClassCache(array $data, array $cacheKey): array
    {
        $key = 'store_bind_ddd' . $cacheKey['id'];

        $classData = $this->cache->get($key);

        if ($classData) {
            return json_decode($classData, true);
        }

        $classData = $this->getGoodsClassByBindClassByIds($data);

        if (count($classData) === 0) {
            $this->errorMessage = '分类绑定错误';
            return [];
        }
        $classData = (new Tree($classData))->makeTreeForHtml(array(
            'parent_key' => 'fid'
        ));

        $this->cache->set($key, json_encode($classData, JSON_UNESCAPED_UNICODE), 80);

        return $classData;
    }

    /**
     * 根据绑定的分类获取分类数据
     */
    public function getGoodsClassByBindClassByIds(array $data): array
    {
        $one = array_column($data, 'class_one');

        $two = array_column($data, 'class_two');

        $three = array_column($data, 'class_three');

        $id = array_merge($one, $two, $three);

        $classData = $this->getQueryBuilderProxy()
            ->field([
                GoodsClass::$id,
                GoodsClass::$className,
                GoodsClass::$fid
            ])
            ->whereIn(GoodsClass::$id, $id)
            ->select();

        return $classData;
    }
}