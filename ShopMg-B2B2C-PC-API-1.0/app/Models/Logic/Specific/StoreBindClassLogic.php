<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreBindClass;
use App\Models\Entity\DbStoreBindClass;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 逻辑处理层
 * @Bean()
 */
class StoreBindClassLogic extends AbstractLogic
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

        // $this->getQueryBuilderProxy() = Base::getInstance('StoreBindClass');
        $this->tableName = DbStoreBindClass::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'id' => [
                'required' => '必须输入店铺id'
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
        return StoreBindClass::class;
    }

    /**
     * 获取店铺分类
     */
    public function getStoreClass(array $post): array
    {
        $cache = &$this->cache;

        $store_id = $post['id'];

        $key = 'store_bind_class' . $store_id;

        $store_class = $cache->get($key);
        if ($store_class) {
            return json_decode($store_class, true);
        }

        $where['store_id'] = $post['id'];
        $where['status'] = 1;
        $field = "class_one,class_two,class_three";
        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition($where)
            ->select();
        if (empty($data)) {
            $this->errorMessage = '暂无绑定分类';

            return [];
        }
        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 75);

        return $data;
    }
}