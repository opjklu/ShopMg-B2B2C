<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreInformation;
use App\Models\Entity\DbStoreInformation;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 逻辑处理层
 * @Bean()
 */
class StoreInformationLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbStoreInformation::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [

            'level_id' => [
                'number' => '商家等级必填'
            ],
            'shop_long' => [
                'number' => '开店时长必填'
            ],
            'class' => [
                'required' => '绑定分类必传'
            ]

        ];
        return $message;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByBail()
    {
        $message = [
            'store_id' => [
                'required' => '开店ID必传'
            ],
            'status' => [
                'required' => '入驻方式必传'
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
        return StoreInformation::class;
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
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
    }

    /**
     * 公司信息
     *
     * @return bool
     */
    public function perfectCompanyInfo(array $post): bool
    {
        Db::beginTransaction();

        $resultData = $this->addData($post);

        return $this->traceStation($resultData);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $companyId = session()->get('add_join_company_id');

        // 用户只能完善自己的店铺信息
        $data[StoreInformation::$storeId] = session()->get('add_join_company_id');

        $data[StoreInformation::$shopClass] = $insert[StoreInformation::$shopClass];

        // 获取店铺名称
        $data[StoreInformation::$shopName] = session()->get('store_name');
        $data[StoreInformation::$shopAccount] = $insert[StoreInformation::$shopAccount];
        $data[StoreInformation::$levelId] = $insert[StoreInformation::$levelId];
        $data[StoreInformation::$shopLong] = $insert[StoreInformation::$shopLong];
        $data[StoreInformation::$status] = session()->get('store_type');

        $time = time();

        $data[StoreInformation::$updateTime] = $time;
        $data[StoreInformation::$createTime] = $time;

        session()->remove('store_name');

        return $data;
    }

    /**
     * 获取店铺信息
     */
    public function getStoreInfoByStore(array $data): array
    {
        $storeDataByPerson = session()->get('store_data_by_person');

        if (empty($storeDataByPerson['id']) || $storeDataByPerson['id'] !== $data['id']) {
            return [];
        }
        return $this->getQueryBuilderProxy()
            ->field(array_values($this->getStaticProperties()))
            ->where(StoreInformation::$storeId, $data['id'])
            ->where(StoreInformation::$status, $storeDataByPerson['type'])
            ->find();
    }

    /**
     * 保存信息
     *
     * @return bool
     */
    public function saveInformation(array $post): bool
    {
        Db::beginTransaction();

        if (!$this->traceStation($this->saveData($post))) {
            return false;
        }

        return true;
    }

    /**
     * 保存
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $update[StoreInformation::$id] = session()->get('store_information_id');

        $update[StoreInformation::$updateTime] = time();

        unset($update['class']);

        return $update;
    }

    /**
     * 获取店铺信息（审核）
     */
    public function getStoreInfoByStoreByApproval(): array
    {
        $storeDataByPerson = session()->get('add_join_company_id');

        if (!$storeDataByPerson) {
            $this->errorMessage = '数据错误';

            return [];
        }

        $data = $this->getQueryBuilderProxy()
            ->field(array_values($this->getStaticProperties()))
            ->where(StoreInformation::$storeId, $storeDataByPerson)
            ->where(StoreInformation::$status, session()->get('store_type'))
            ->find();

        if (0 === count($data)) {
            $this->errorMessage = '暂无数据';
            return [];
        }

        session()->put('store_information_id', $data[StoreInformation::$id]);

        return $data;
    }
}
