<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Recharge;
use App\Models\Entity\DbRecharge;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;
use Tool\Token;

/**
 * 充值记录逻辑处理层
 * @Bean()
 * @author
 */
class RechargeLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbRecharge::class;
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
        return Recharge::class;
    }

    /**
     * 添加余额数据
     *
     * @return bool
     */
    public function addRechargeData(array $data): array
    {
        $data[Recharge::$orderSn] = Token::toGUID();

        $status = $this->addData($data);

        print_r($this->errorMessage);
        return $status && true ? [
            $status,
            $data[Recharge::$orderSn]
        ] : [];
    }

    /**
     * 添加时处理参数
     *
     * @return array
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $data = [];

        $data[Recharge::$payType] = 1;

        $data[Recharge::$account] = $insert['money'];

        $data[Recharge::$payStatus] = 0;

        $data[Recharge::$payId] = $insert['pay_type_id'];

        $data[Recharge::$ctime] = time();

        $data[Recharge::$userId] = session()->get('user_id');

        $data[Recharge::$orderSn] = $insert['order_sn'];

        return $data;
    }

    /**
     * 修改状态
     *
     * @return boolean
     */
    public function saveStatus(array $rechargeData): bool
    {
        Db::beginTransaction();

        $status = $this->saveData($rechargeData);

        return $this->traceStation($status);
    }

    /**
     * 保存时处理参数
     */
    protected function getParseResultBySave(array $update = []): array
    {
        return [
            Recharge::$id => $update['order_id'],
            Recharge::$payTime => time(),
            Recharge::$payStatus => 1,
            Recharge::$payType => $update['pay_type_id'],
            Recharge::$payType => 1
        ];
    }

    /**
     *
     * @return string
     */
    public function getSplitKeyByPayType(): string
    {
        return Recharge::$payId;
    }

    /**
     * 获取具体搜索字段（非模糊）
     *
     * @return
     *
     */
    protected function searchArray(): array
    {
        return [
            Recharge::$payStatus,
            Recharge::$payId
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
     * 获取搜索时间key
     */
    protected function getSearchTimeKey()
    {
        return Recharge::$ctime;
    }

    /**
     *
     * @return array
     */
    public function getValidateByOrderCheck(): array
    {
        return [
            'order_id' => [
                'number' => '编号必须是数字'
            ]
        ];
    }

    /**
     * 是否已支付
     *
     * @return bool
     */
    public function isCheckPay(array $data): bool
    {
        $payStatus = $this->getPayStatusById($data);

        return $payStatus === 1;
    }

    /**
     * 获取订单支付状态
     *
     * @return bool
     */
    public function getPayStatusById(array $data): int
    {
        $status = $this->getQueryBuilderProxy()
            ->field([
                Recharge::$payStatus
            ])
            ->where(Recharge::$id, $data['order_id'])
            ->getField();

        return (int)$status[Recharge::$payStatus];
    }
}
