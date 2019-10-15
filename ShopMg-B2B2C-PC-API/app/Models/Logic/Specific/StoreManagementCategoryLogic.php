<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreManagementCategory;
use App\Models\Entity\DbStoreManagementCategory;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 绑定分类
 *
 * @author Administrator
 *
 * @Bean()
 */
class StoreManagementCategoryLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbStoreManagementCategory::class;
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
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return StoreManagementCategory::class;
    }

    /**
     *
     * @return bool
     */
    public function addStoreManagerment(array $data): bool
    {
        $status = $this->addAll($data);

        if (!$this->traceStation($status)) {
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAddAll()
     */
    protected function getParseResultByAddAll(array $post): array
    {
        $addData = [];

        $i = 0;

        $companyId = session()->get('add_join_company_id');

        $storeType = session()->get('store_type');

        $time = time();

        foreach ($post as $key => $value) {
            $addData[$i] = [];
            $addData[$i][StoreManagementCategory::$oneClass] = $value['one_class'];
            $addData[$i][StoreManagementCategory::$twoClass] = $value['two_class'];
            $addData[$i][StoreManagementCategory::$threeClass] = $value['three_class'];
            $addData[$i][StoreManagementCategory::$storeId] = $companyId;
            $addData[$i][StoreManagementCategory::$status] = $storeType;
            $addData[$i][StoreManagementCategory::$createTime] = $time;
            $addData[$i][StoreManagementCategory::$updateTime] = $time;
            $i++;
        }

        session()->remove('add_join_company_id');

        session()->remove('store_type');

        return $addData;
    }

    /**
     * 获取 绑定分类
     *
     * @return array
     */
    public function getBindClassByStore(): array
    {
        $field = [
            StoreManagementCategory::$id,
            StoreManagementCategory::$oneClass,
            StoreManagementCategory::$twoClass,
            StoreManagementCategory::$threeClass
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(StoreManagementCategory::$storeId, session()->get('add_join_company_id'))
            ->select();
        return $data;
    }

    /**
     * 保存绑定信息
     *
     * @return bool
     */
    public function saveBindClass(array $class): bool
    {
        $status = $this->getQueryBuilderProxy()
            ->where(StoreManagementCategory::$storeId, session()->get('add_join_company_id'))
            ->delete();

        if (!$this->traceStation($this->addAll($class))) {
            return false;
        }

        Db::commit();

        return true;
    }
}