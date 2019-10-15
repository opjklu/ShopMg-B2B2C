<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\CashWithdrawal;
use App\Models\Entity\DbCashWithdrawal;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 提现日志
 *
 * @author 米糕网络团队
 * @Bean()
 */
class CashWithDrawalLogic extends AbstractLogic
{

    /**
     * 审核中
     *
     * @var integer
     */
    const APPROVAL_CASHING = 0;

    /**
     * 审核成功
     *
     * @var integer
     */
    const APPROVAL_SUCCESS = 1;

    /**
     * 审核失败
     *
     * @var integer
     */
    const APPROVAL_FAIL = 2;

    /**
     * 提现成功
     *
     * @var integer
     */
    const CASH_SUCCESS = 3;


    public function __construct()
    {
        $this->tableName = DbCashWithdrawal::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return CashWithDrawal::class;
    }

    /**
     * 获取支付信息
     */
    public function getResult()
    {
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
            CashWithdrawal::$id,
            CashWithdrawal::$account,
            CashWithdrawal::$cashType,
            CashWithdrawal::$createTime,
            CashWithdrawal::$money,
            CashWithdrawal::$platformType,
            CashWithdrawal::$status,
            CashWithdrawal::$alipayOrder
        ];
    }

    /**
     *
     * @return array
     */
    public function getSplitKeyByPay(): string
    {
        return CashWithdrawal::$cashType;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $data = [];

        $data[CashWithDrawal::$userId] = session()->get('user_id');

        $data[CashWithDrawal::$account] = $insert['payee_account'];

        $data[CashWithDrawal::$money] = $insert['money'];

        $data[CashWithDrawal::$status] = static::APPROVAL_CASHING;

        $data[CashWithDrawal::$cashType] = $insert['pay_type_id'];

        $data[CashWithDrawal::$createTime] = $time = time();

        $data[CashWithDrawal::$updateTime] = $time;

        return $data;
    }

    /**
     *
     * @return array
     */
    public function getValidateByCash(): array
    {
        return [
            'pay_type_id' => [
                'number' => '支付编号必须是数字'
            ],
            'money' => [
                'number' => '提现金额必须是数字，且介于${0.01-100000}'
            ],
            'payee_account' => [
                'required' => '请填写账号',
                'combinationOfDigitalEnglish' => '账号必须是数字或英文'
            ]
        ];
    }

    /**
     * 提现行为 修改状态
     *
     * @param array $result
     *            回调结果
     */
    public function cashBehaviorEditStatus(array $post, array $payResult): bool
    {
        $result = $this->getQueryBuilderProxy()
            ->where(CashWithdrawal::$userId, session()->get('user_id'))
            ->where(CashWithdrawal::$id, $post['id'])
            ->where(CashWithdrawal::$status, static::APPROVAL_SUCCESS)
            ->save([
                CashWithdrawal::$status => static::CASH_SUCCESS,
                CashWithdrawal::$orderSn => $payResult['out_biz_no'],
                CashWithdrawal::$alipayOrder => $payResult['order_id'],
                CashWithdrawal::$successTime => strtotime($payResult['pay_date'])
            ]);

        if (empty($result)) {
            $this->errorMessage = '提现修改状态失败';

            $this->getQueryBuilderProxy()->rollback();

            return false;
        }

        $this->getQueryBuilderProxy()->commit();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::parseOption()
     */
    protected function parseOption(array $options): array
    {
        $options['where']['user_id'] = session()->get('user_id');

        return $options;
    }

    /**
     * 获取提现信息
     *
     * @return array
     */
    public function getCashInfo(array $post): array
    {
        Db::beginTransaction();

        $data = $this->getQueryBuilderProxy()
            ->forUpdate()
            ->field([
                CashWithdrawal::$account,
                CashWithdrawal::$money,
                CashWithdrawal::$cashType . ' as pay_type_id'
            ])
            ->where(CashWithdrawal::$userId, session()->get('user_id'))
            ->where(CashWithdrawal::$id, $post['id'])
            ->where(CashWithdrawal::$status, static::APPROVAL_SUCCESS)
            ->find();

        if ($data === null || $data === false) {
            $this->getQueryBuilderProxy()->rollback();

            $this->errorMessage = '未找到提现信息';

            return [];
        }

        return $data;
    }
}