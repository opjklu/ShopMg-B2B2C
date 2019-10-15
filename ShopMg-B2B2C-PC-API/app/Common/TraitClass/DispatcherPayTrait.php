<?php
declare(strict_types=1);
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
namespace App\Common\TraitClass;

use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\PayLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\SessionManager;

/**
 * 分发支付
 *
 * @author Administrator
 */
trait DispatcherPayTrait
{

    private $errorMessage = '';

    /**
     * @Inject()
     *
     * @var PayLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;


    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * 分发支付
     *
     * @param array $data
     */
    protected function dispatcherPay(array $payConfig, array $orderData, array $post): array
    {
        try {
            $index = (int)$post['pay_type_id'] - 1;


            $payConfig['notify_url'] = $payConfig['notify_url'] . $this->notifyURL[$index];

            $payConfig['return_url'] = $payConfig['return_url'] . $this->reuturnURL[$index];

            $payConfig['special_status'] = $post['special_status'];

            $obj = new \ReflectionClass($this->payName[$index]);
            $instance = $obj->newInstanceArgs([
                $payConfig,
                $orderData
            ]);

            $method = $obj->getMethod('pay');

            return $method->invoke($instance, $post);
        } catch (\Exception $e) {
            return [
                'status' => 0,
                'message' => $e->getMessage(),
                'data' => ''
            ];
        }
    }

    /**
     * 分发提现
     *
     * @param array $data
     * @param array $crash
     *            提现数据
     */
    protected function dispatcherCashWithdrawal(array $data, array $crash, array $post): array
    {
        try {

            $returnName = $this->refundName[$post['pay_type_id'] - 1];

            $obj = new \ReflectionClass($returnName);

            $instance = $obj->newInstanceArgs([
                $data,
                $crash
            ]);

            $rusult = $obj->getMethod('transfer')->invoke($instance); // 发起提现

            $this->errorMessage = $obj->getMethod('getError')->invoke($instance);

            return $rusult;
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            return [];
        }
    }

    /**
     * 发起支付处理
     */
    protected function initiate(array $post, array $cookie): array
    {
        if (!$this->checkStock()) {
            return [];
        }

        $payConfig = $this->logic->getPayInfoByType($post, $cookie);

        if (0 === count($payConfig)) {

            $this->errorMessage = '无法获取支付配置';

            return [];
        }

        $orderData = SessionManager::GET_ORDER_DATA();

        $result = $this->dispatcherPay($payConfig, $orderData, $post);

        if (empty($result)) {

            return [];
        }
        return $result;
    }

    /**
     * 检查 库存
     */
    protected function checkStock(): bool
    {
        // 判断库存是否足够
        $stock = SessionManager::GET_GOODS_ID_BY_USER();

        if (0 === count($stock)) {
            $this->errorMessage = '购买失效请在90秒内完成支付,谢谢';
            return false;
        }

        if ($this->goodsLogic->checkStock($stock) === false) {

            $this->errorMessage = $this->goodsLogic->getErrorMessage();

            return false;
        }
        return true;
    }
}