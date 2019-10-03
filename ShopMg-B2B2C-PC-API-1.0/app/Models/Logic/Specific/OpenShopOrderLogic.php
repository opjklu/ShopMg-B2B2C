<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OpenShopOrder;
use App\Models\Entity\DbOpenShopOrder;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Log\Log;
use Tool\Db;
use Tool\Token;

/**
 *
 * @author Administrator
 *
 * @Bean()
 */
class OpenShopOrderLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOpenShopOrder::class;
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
        return OpenShopOrder::class;
    }

    protected function getParseResultByAdd(array $insert): array
    {
        $result = [];
        $result[OpenShopOrder::$userId] = session()->get('user_id');

        $result[OpenShopOrder::$orderSn] = $insert[OpenShopOrder::$orderSn];
        $result[OpenShopOrder::$createTime] = time();
        $result[OpenShopOrder::$storeId] = $insert['id'];
        $result[OpenShopOrder::$type] = $insert['type'];

        return $result;
    }

    /**
     *
     * @param array $data
     * @return string
     */
    public function pushOpenShopOrder(array $data): array
    {
        $orderSn = Token::toGUID();

        $data[OpenShopOrder::$orderSn] = $orderSn;

        $insertId = $this->addData($data);

        return $insertId === 0 ? [] : [
            'order_id' => $insertId,
            'order_sn' => $orderSn
        ];
    }

    /**
     * 修改状态
     *
     * @return boolean
     */
    public function saveStatus(array $data): bool
    {
        Db::beginTransaction();

        $status = $this->saveData($data);

        if (!$status) {

            Db::rollback();

            $this->errorMessage = '修改状态失败';

            Log::error('修改状态失败', [
                get_last_sql()
            ]);

            return false;
        }

        return true;
    }

    /**
     * 保存时处理参数
     */
    protected function getParseResultBySave(array $update = []): array
    {
        return [
            OpenShopOrder::$id => $update['order_id'],
            OpenShopOrder::$payTime => time(),
            OpenShopOrder::$orderStatus => 1,
            OpenShopOrder::$payType => $update['pay_id'],
            OpenShopOrder::$payPlatform => 1
        ];
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
     * 获取支付状态
     *
     * @return int
     */
    public function getPayStatusById(array $post): int
    {
        $status = $this->getQueryBuilderProxy()
            ->field([
                OpenShopOrder::$orderStatus
            ])
            ->where(OpenShopOrder::$id, $post['order_id'])
            ->find();

        return (int)$status[OpenShopOrder::$orderStatus];
    }

    /**
     * 检查是否已支付
     *
     * @return bool
     */
    public function isCheckPay(array $post): bool
    {
        $status = $this->getPayStatusById($post);

        return $status === 1;
    }
}