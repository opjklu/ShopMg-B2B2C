<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreJoinCompany;
use App\Common\FieldMapping\User;
use App\Models\Entity\DbStoreJoinCompany;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Log\Log;
use Tool\Db;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class StoreJoinCompanyLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbStoreJoinCompany::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin(): array
    {
        $message = [
            'company_name' => [
                'required' => '公司名称必填'
            ],
            'company_mobile' => [
                'required' => '公司电话必填'
            ],
            'registered_capital' => [
                'required' => '注册资金必填',
                'number' => '注册资金必须为数字'
            ],
            'name' => [
                'required' => '联系人姓名必填'
            ],
            'mobile' => [
                'required' => '联系人手机号必填',
                'number' => '请填入正确的手机号'
            ],
            'prov_id' => [
                'required' => '省ID必填',
                'number' => '省ID必须为数字'
            ],
            'city' => [
                'required' => '市ID必填',
                'number' => '市ID必须为数字'
            ],
            'dist' => [
                'required' => '省ID必填',
                'number' => '区ID必须为数字'
            ],
            'address' => [
                'required' => '公司具体地址必填'
            ],
            'license_number' => [
                'required' => '营业执照号必填'
            ],
            'validity_start' => [
                'required' => '营业执照开始时间必填'
            ],
            'validity_end' => [
                'required' => '营业执照结束时间必填'
            ],
            'electronic_version' => [
                'required' => '营业执照电子版'
            ],
            'scope_of_operation' => [
                'required' => '法定企业经营范围'
            ],
            'organization_code' => [
                'required' => '组织机构代码必填'
            ],
            'organization_electronic' => [
                'required' => '组织机构代码证明必填'
            ],
            'taxpayer_certificate' => [
                'required' => '一般纳税人证明照片必填'
            ]
        ];
        return $message;
    }

    /**
     * 编辑（未审核或者）
     *
     * @return array
     */
    public function getValidateByApproval(): array
    {
        $validate = $this->getValidateByLogin();

        $validate['id'] = [
            'number' => 'id必须是数字'
        ];

        $validate['address_id'] = [
            'number' => '店铺编号必须是数字'
        ];

        return $validate;
    }

    public function getValidateByBankInfo()
    {
        $message = [
            'store_id' => [
                'required' => '公司入驻表编号必填'
            ],
            'shop_account' => [
                'required' => '商家账号必填'
            ],
            'shop_name' => [
                'required' => '店铺名称必填'
            ],
            'level_id' => [
                'required' => '店铺等级必填'
            ],
            'shop_long' => [
                'required' => '开店时长必填'
            ],
            'shop_class' => [
                'required' => '店铺分类必填'
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
        return StoreJoinCompany::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [];
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
            User::$userName
        ];
    }

    /**
     * 企业入驻信息提交
     */
    public function addCompanyInfo(array $data): int
    {
        Db::beginTransaction();

        $status = $this->addData($data);

        if (!$this->traceStation($status)) {

            $this->errorMessage .= '开店失败或者重复开店';
            return 0;
        }

        return $status;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $data = $this->filterDataByPost($insert);

        $time = time();

        $data[StoreJoinCompany::$createTime] = $time;
        $data[StoreJoinCompany::$updateTime] = $time;

        $data[StoreJoinCompany::$validityStart] = strtotime($data[StoreJoinCompany::$validityStart]);
        $data[StoreJoinCompany::$validityEnd] = strtotime($data[StoreJoinCompany::$validityEnd]);

        $data[StoreJoinCompany::$userId] = session()->get('user_id');

        $data[StoreJoinCompany::$status] = 0;

        return $data;
    }

    /**
     * 是否可以入住
     */
    public function isCheckIn(): bool
    {
        $data = $this->getQueryBuilderProxy()
            ->field([
                StoreJoinCompany::$id
            ])
            ->where(StoreJoinCompany::$userId, session()->get('user_id'))
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

        if ($data[StoreJoinCompany::$status] === '0' || $data[StoreJoinCompany::$status] === '3') {

            session()->put('store_name', $data['store_name']);

            session()->put('add_join_company_id', $data['id']);

            session()->put('store_type', 1); // 企业入驻
        } else if ($data[StoreJoinCompany::$status] === '2') {
            session()->put('store_data_by_person', [
                'id' => $data[StoreJoinCompany::$id],
                'type' => 1
            ]);
        }

        return $data;
    }

    /**
     * 获取店铺信息
     *
     * @return array
     */
    public function getStore()
    {
        return $this->getQueryBuilderProxy()
            ->field(array_values($this->getStaticProperties()))
            ->where(StoreJoinCompany::$userId, session()->get('user_id'))
            ->find();
    }

    /**
     * 修改状态
     *
     * @return bool
     */
    public function editStatus(array $param)
    {
        $status = $this->saveData($param);
        if (!$this->traceStation($status)) {
            Log::error('企业开店支付失败', [
                get_last_sql()
            ]);
            return false;
        }

        Db::commit();

        return true;
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

        $result[StoreJoinCompany::$id] = $update['id'];

        $result[StoreJoinCompany::$status] = 1;

        return $result;
    }

    /**
     * 保存编辑基本开店信息
     */
    public function saveEdit(array $data): bool
    {
        $data = $this->filterDataByPost($data);

        $data[StoreJoinCompany::$updateTime] = time();

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
}
