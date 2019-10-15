<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Balance;
use App\Models\Entity\DbBalance;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 逻辑处理层
 * @Bean
 */
class BalanceLogic extends AbstractLogic
{

    /**
     * 简介
     *
     * @var string
     */
    private $description = '';

    /**
     * 提现
     *
     * @var integer
     */
    const CASH_WIDTHDRAWAL = 2;


    public function __construct()
    {
        $this->tableName = DbBalance::class;
    }

    /**
     * 获取验证数据
     *
     * @return string[][]
     */
    public function getValidateByBankCard(): array
    {
        $message = [
            'id' => [
                'required' => '银行卡用户ID必填'
            ],
            'realname' => [
                'required' => '开户人姓名必填'
            ],
            'card_num' => [
                'required' => '银行卡号必填'
            ],
            'belong' => [
                'required' => '银行开户名必填'
            ]
        ];
        return $message;
    }


    public function getResult()
    {

    }

    /**
     * 获取余额
     *
     * @return float
     */
    public function getBalanceMoney(): float
    {
        $data = $this->getQueryBuilderProxy()
            ->field(Balance::$accountBalance . ',' . Balance::$lockBalance)
            ->where(Balance::$userId, session()->get('user_id'))
            ->where(Balance::$status, 1)
            ->order(Balance::$id, 'DESC')
            ->find();

        if (0 === count($data)) {
            return 0;
        }

        $money = (int)($data[Balance::$accountBalance] - $data[Balance::$lockBalance]);

        return $money;
    }

    /**
     * 加锁获取金额
     *
     * @return float
     */
    public function getMoneyByLock(): float
    {
        Db::beginTransaction();

        $data = $this->getQueryBuilderProxy()
            ->lock(true)
            ->field(Balance::$accountBalance . ',' . Balance::$lockBalance)
            ->where(Balance::$userId . '=%d and ' . Balance::$status . '= 1', session()->get('user_id'))
            ->order(Balance::$id . ' DESC ')
            ->find();
        if (empty($data)) {
            return 0;
        }

        $money = floatval($data[Balance::$accountBalance] - $data[Balance::$lockBalance]);

        return $money;
    }

    /**
     * 提现
     *
     * @return bool
     */
    public function cashDelMoney(array $balance): bool
    {
        $this->description = '提现';

        $data = $this->parseBalance($balance['money'], static::CASH_WIDTHDRAWAL);

        if ($data['status'] === 0) {
            $this->rollback();

            $this->errorMessage = '余额不足';

            return false;
        }

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return Balance::class;
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
            'id',
            'account_balance',
            'lock_balance',
            'recharge_time',
            'changes_balance',
            'type',
            'description'
        ];
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
     *
     * @name 我的账户-收入
     *
     */
    public function getDetailsIncome(array $post): array
    {
        return $this->getDataByPage($post, [
            'order' => $this->getSearchOrderKey(),
            'where' => [
                'type' => 1
            ]
        ]);
    }

    /**
     *
     * @name 我的账户-支出
     */
    public function getDetailsPay(array $post): array
    {
        return $this->getDataByPage($post, [
            'order' => $this->getSearchOrderKey(),
            'where' => [
                'type',
                'in',
                [
                    0,
                    2
                ]
            ]
        ]);
    }

    /**
     * 余额充值
     *
     * @param array $recharge
     * @param string $className
     */
    public function rechargeMoney(array $recharge): bool
    {
        $userId = session()->get('user_id');

        $isHas = $this->getQueryBuilderProxy()
            ->field([
                Balance::$id,
                Balance::$accountBalance,
                Balance::$lockBalance
            ])
            ->where(Balance::$userId, $userId)
            ->order(Balance::$id, 'DESC')
            ->find();

        $status = $this->addData([
            $isHas,
            $recharge
        ]);

        if (!$this->traceStation($status)) {
            return false;
        }
        // $key = $userId . '_' . $recharge['trade_no'];

        // Cache::getInstance('', [
        // 'expire' => 1440
        // ])->set($key, $recharge['trade_no']);

        Db::commit();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        list ($balance, $add) = $insert;

        if (0 !== count($balance)) {
            $money = floatval($balance[Balance::$accountBalance] + $add['total_amount'] - $balance[Balance::$lockBalance]);
        } else {
            $money = $add['total_amount'];
        }

        $data = [
            Balance::$userId => session()->get('user_id'),
            Balance::$description => '余额充值',
            Balance::$changesBalance => $add['total_amount'],
            Balance::$accountBalance => $money,
            Balance::$type => 1,
            Balance::$lockBalance => 0,
            Balance::$rechargeTime => time(),
            Balance::$status => 1,
            Balance::$modifyTime => 0
        ];
        return $data;
    }

    /**
     * 获取余额
     *
     * @return float
     */
    public function getBalance()
    {
        $data = $this->getQueryBuilderProxy()
            ->field([
                'account_balance'
            ])
            ->condition([
                'user_id' => session()->get('user_id'),
                "status" => 1
            ])
            ->order('id', 'DESC')
            ->find();
        if (empty($data)) {
            return array(
                "status" => 1,
                "meaasge" => "获取成功",
                "data" => 0
            );
        }

        return array(
            "status" => 1,
            "message" => "获取成功",
            "data" => $data['account_balance']
        );
    }

    public function rollBack(): bool
    {
        return Db::rollback();
    }
}
