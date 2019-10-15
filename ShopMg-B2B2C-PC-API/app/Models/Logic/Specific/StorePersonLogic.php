<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StorePerson;
use App\Models\Entity\DbStorePerson;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Log\Log;
use Tool\Db;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class StorePersonLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbStorePerson::class;
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
        return StorePerson::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    protected function getTableColum(): array
    {
        return [];
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin(): array
    {
        return [
            'store_name' => [
                'required' => '店铺名称必填'
            ],
            'person_name' => [
                'required' => '姓名必填'
            ],
            'id_card' => [
                'number' => '身份证号必填'
            ],
            'prov_id' => [
                'number' => '省份必选'
            ],
            'city' => [
                'number' => '市必选'
            ],
            'dist' => [
                'number' => '区必选'
            ],
            'address' => [
                'required' => '具体地址必填'
            ],
            'mobile' => [
                'number' => '联系方式必填'
            ],
            'wx_account' => [
                'required' => '微信支付账号必填'
            ],
            'alipay_account' => [
                'required' => '支包付账号必填'
            ],
            'bank_account' => [
                'required' => '银行卡号必填'
            ],
            'bank_name' => [
                'required' => '银行名称必填'
            ],
            'idcard_positive' => [
                'required' => '身份证正面必填'
            ],
            'other_side' => [
                'required' => '身份证反面必填'
            ],
            'bank_name' => [
                'required' => '银行名称必填'
            ],
            'bank_account' => [
                'required' => '银行账号必填'
            ]
        ];
    }

    /**
     * 编辑时
     *
     * @return array
     */
    public function getValidateByLoginMergeAddess(): array
    {
        $validate = $this->getValidateByLogin();

        $validate['address_id'] = [
            'number' => '必须是数字'
        ];

        $validate['id'] = [
            'number' => 'id必须是数字'
        ];

        return $validate;
    }

    /**
     * 个人开店
     *
     * @return boolean
     */
    public function personEnter(array $data): int
    {
        Db::beginTransaction();

        $insertId = $this->addData($data);

        if (!$this->traceStation($insertId)) {
            $this->errorMessage = '、已开店';
            return 0;
        }

        return $insertId;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $result = $this->filterDataByPost($insert);

        $time = time();

        $result[StorePerson::$status] = 0;

        $result[StorePerson::$userId] = session()->get('user_id');

        $result[StorePerson::$createTime] = $time;

        $result[StorePerson::$updateTime] = $time;

        return $result;
    }

    /**
     * 是否可以入住
     */
    public function isCheckIn(): bool
    {
        $data = $this->getQueryBuilderProxy()
            ->field([
                StorePerson::$id
            ])
            ->where(StorePerson::$userId, session()->get('user_id'))
            ->find();

        if (0 !== count($data)) {

            $this->errorMessage = '企业不能重复开店';
            return false;
        }

        return true;
    }

    /**
     * 获取店铺信息
     */
    public function getStoreInfo(): array
    {
        $data = $this->getStore();

        if (0 === count($data)) {
            return [];
        }

        if ($data[StorePerson::$status] === '0' || $data[StorePerson::$status] === '3') {

            session()->put('store_name', $data['store_name']);

            session()->put('add_join_company_id', $data['id']);

            session()->put('store_type', 0); // 个人入住
        } else if ($data[StorePerson::$status] === '2') {
            session()->put('store_data_by_person', [
                'id' => $data[StorePerson::$id],
                'type' => 0
            ]);
        }

        return $data;
    }

    /**
     * 获取店铺信息
     *
     * @return array
     */
    public function getStore(): array
    {
        return $this->getQueryBuilderProxy()
            ->field(array_values($this->getStaticProperties()))
            ->where(StorePerson::$userId, session()->get('user_id'))
            ->find();
    }

    /**
     * 修改状态
     *
     * @return bool
     */
    public function editStatus(array $param): bool
    {
        $status = $this->saveData($param);

        if (!$this->traceStation($status)) {
            Log::error('个人开店支付失败', [
                get_last_sql()
            ]);
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 保存编辑基本开店信息
     */
    public function saveEdit(array $data): bool
    {
        $data = $this->filterDataByPost($data);

        $data[StorePerson::$updateTime] = time();

        Db::beginTransaction();

        try {

            $id = $data['id'];

            unset($data['id']);
            if (!$this->traceStation($this->getQueryBuilderProxy()
                ->where('id', $id)
                ->save($data))) {

                return false;
            }
            return true;
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            Db::rollback();

            return false;
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $result = [];

        $result[StorePerson::$id] = $update['id'];

        $result[StorePerson::$status] = 1;

        return $result;
    }
}
