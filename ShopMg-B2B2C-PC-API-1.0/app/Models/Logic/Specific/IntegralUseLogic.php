<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\IntegralUse;
use App\Common\FieldMapping\User;
use App\Models\Entity\DbIntegralUse;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Log\Log;
use Tool\Db;
use Tool\SessionManager;

/**
 * 积分逻辑处理层
 * @Bean()
 */
class IntegralUseLogic extends AbstractLogic
{

    /**
     * 支出
     *
     * @var integer
     */
    const SPENDING = 0;

    /**
     * 收入
     *
     * @var integer
     */
    const INCOME = 1;

    /**
     *
     * @var integer
     */
    private $integralShopping = 0;

    public function setAlreadyIntegral(int $integral): void
    {
        $this->integralShopping = $integral;
    }


    public function __construct()
    {
        $this->tableName = DbIntegralUse::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin(): array
    {
        return [
            'integral' => [
                'required' => '必须输入本次使用积分'
            ],
            'goods_id' => [
                'required' => '必须输入商品ID'
            ],
            'address_id' => [
                'required' => '请选择收货地址'
            ],
            'platform' => [
                'required' => '请写明下单平台'
            ],
            'store_id' => [
                'required' => '请标明商品所属店铺ID'
            ]
        ];
    }

    public function getValidateByOrder(): array
    {
        return [
            'orderId' => [
                'required' => '获取订单信息失败'
            ]
        ];
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
        return IntegralUse::class;
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
        return [
            User::$userName
        ];
    }

    /**
     * 获取积分列表
     */
    public function getIntegralList(array $post): array
    {
        $data = $this->getParseDataByList($post);

        return $data;
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
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            IntegralUse::$id,
            IntegralUse::$orderId,
            IntegralUse::$integral,
            IntegralUse::$type,
            IntegralUse::$tradingTime
        ];
    }

    /**
     * 获取商品关联字段
     *
     * @return string
     */
    public function getSplitKeyByOrderId(): string
    {
        return IntegralUse::$orderId;
    }

    /**
     * 添加积分记录
     *
     * @return boolean
     */
    public function addIntegral(array $data, float $payIntegral): array
    {
        // 增加积分
        $time = time();

        $integralData = [];

        $integral = 0;

        $i = 0;

        $userId = session()->get('user_id');

        $totalIntegral = 0;

        foreach ($data as $k => $vo) {

            $integral = (int)($vo['total_money'] / $payIntegral);
            if ($integral <= 0) {
                continue;
            }

            $integralData[$i] = [
                'user_id' => $userId,
                'integral' => $integral,
                'order_id' => $vo['order_id'],
                'trading_time' => $time,
                'remarks' => '订单积分',
                'type' => self::INCOME
            ];

            $totalIntegral += $integral;
            $i++;
        }
        if (0 === count($integralData)) {
            return [
                'status' => true,
                'total_number' => 0
            ];
        }

        $status = false;

        try {
            $status = $this->getQueryBuilderProxy()->addAll($integralData);
        } catch (\Exception $e) {

            Log::error('积分操作错误 -- ', [
                $integralData,
                $e->getMessage()
            ]);

            Db::rollback();

            return [
                'status' => false
            ];
        }

        if ($status === 0) {
            Db::rollback();

            Log::error('积分操作错误 -- ', [
                get_last_sql()
            ]);
            return [
                'status' => false
            ];
        }

        $this->totalIntegral = $totalIntegral;

        return [
            'status' => true,
            'total_number' => $totalIntegral
        ];
    }

    /**
     *
     * @return bool
     */
    public function addIntegralLog(array $orderData, int $integralNumber): bool
    {
        $orderData['integral_number'] = $integralNumber;

        $status = $this->addData($orderData);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '积分';
            return false;
        }

        $this->getQueryBuilderProxy()->commit();

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
        $data = [];

        $userId = session()->get('user_id');

        $orderData = SessionManager::GET_ORDER_DATA();

        $data[IntegralUse::$userId] = $userId;

        $data[IntegralUse::$integral] = $insert['integral_number'];

        $data[IntegralUse::$orderId] = $orderData[0]['order_id'];

        $data[IntegralUse::$tradingTime] = time();

        $data[IntegralUse::$remarks] = "积分支付";

        $data[IntegralUse::$type] = self::SPENDING;

        $data[IntegralUse::$status] = 1;

        return $data;
    }
}
