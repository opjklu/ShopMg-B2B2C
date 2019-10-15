<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreCompanyBankInformation;
use App\Models\Entity\DbStoreCompanyBankInformation;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class StoreCompanyBankInformationLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbStoreCompanyBankInformation::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'store_id' => [
                'required' => '申请开店ID必填'
            ],
            'account_name' => [
                'required' => '开户银行信息'
            ],
            'company_account' => [
                'required' => '公司银行账号'
            ],
            'branch_bank' => [
                'required' => '开户银行支行名称'
            ],
            'settle_name' => [
                'required' => '结算账户开户名'
            ],
            'settle_account' => [
                'required' => '结算公司银行账号'
            ],
            'settle_bank' => [
                'required' => '结算开户银行支行名称'
            ],
            'certificate_number' => [
                'required' => '税务登记证号'
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
        return StoreCompanyBankInformation::class;
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
     * 企业入驻--填写银行卡结算信息
     */
    public function addBankInfo(array $data)
    {
        return $this->addData($data);
    }

    /**
     * 验证添加信息
     */
    public function getMessageValidateBankInfo(): array
    {
        return [
            StoreCompanyBankInformation::$accountName => [
                'required' => '开户名必填',
                'specialCharFilter' => '开户名必须是中英文及其字符串的组合'
            ],
            StoreCompanyBankInformation::$companyAccount => [
                'number' => '公司银行账号必填'
            ],
            StoreCompanyBankInformation::$branchBank => [
                'required' => '开户银行支行名称必填',
                'specialCharFilter' => '开户银行支行名称必须是中英文及其字符串的组合'
            ],
            StoreCompanyBankInformation::$settleName => [
                'required' => '结算账户开户名必填',
                'specialCharFilter' => '结算账户开户名必须是中英文及其字符串的组合'
            ],
            StoreCompanyBankInformation::$settleAccount => [
                'number' => '结算公司银行账号必填'
            ],
            StoreCompanyBankInformation::$settleBank => [
                'required' => '结算开户银行支行名称必填',
                'specialCharFilter' => '结算开户银行支行名称必须是中英文及其字符串的组合'
            ],
            StoreCompanyBankInformation::$certificateNumber => [
                'required' => '税务登记证号必填',
                'combinationOfDigitalEnglish' => '税务登记证号必须是数字及其字母的组合'
            ],
            StoreCompanyBankInformation::$registrationElectronic => [
                'required' => '税务登记证号电子版必填'
            ],
            StoreCompanyBankInformation::$wxAccount => [
                'required' => '微信支付账号必填',
                'specialCharFilter' => '微信支付账号必须是中英文及其字符串的组合'
            ],
            StoreCompanyBankInformation::$alipayAccount => [
                'required' => '支付宝支付账号必填',
                'specialCharFilter' => '支付宝支付账号必须是中英文及其字符串的组合'
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $insert[StoreCompanyBankInformation::$storeId] = session()->get('add_join_company_id');

        $time = time();

        $insert[StoreCompanyBankInformation::$createTime] = $time;

        $insert[StoreCompanyBankInformation::$updateTime] = $time;

        return $insert;
    }

    /**
     * 获取银行卡信息
     */
    public function getBankInformation(): array
    {
        $storeDataByPerson = session()->get('add_join_company_id');

        if (!$storeDataByPerson) {
            $this->errorMessage = '数据错误';

            return [];
        }

        $data = $this->getQueryBuilderProxy()
            ->field(array_values($this->getStaticProperties()))
            ->where(StoreCompanyBankInformation::$storeId, $storeDataByPerson)
            ->find();

        if (0 === count($data)) {
            return [];
        }

        session()->put('store_company_id', $data[StoreCompanyBankInformation::$id]);

        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $update[StoreCompanyBankInformation::$id] = session()->get('store_company_id');

        $update[StoreCompanyBankInformation::$updateTime] = time();
        return $update;
    }
}
