<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Pay;
use App\Common\FieldMapping\PayType;
use App\Common\TraitClass\PayTrait;
use App\Models\Entity\DbPay;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 *
 * @author Administrator
 * @Bean()
 */
class PayLogic extends AbstractLogic
{

    use PayTrait;

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    /**
     * 微信回调数据
     *
     * @var array
     */
    private $resource = [];

    /**
     * 获取订单编号
     *
     * @return []
     */
    public function getResource()
    {
        return $this->resource;
    }


    public function __construct()
    {
        $this->tableName = DbPay::class;
    }

    /**
     * 验证参数
     */
    public function getValidateByPay(): array
    {
        return [
            Pay::$payType_id => [
                'number' => '支付编号必须是数字'
            ],
            'money' => [
                'number' => '余额充值必须是数字, 且介于${0.01-100000}'
            ]
        ];
    }

    /**
     * 获取支付信息
     */
    public function getResult(): array
    {
        return [];
    }

    /**
     * 根据支付类型获取支付信息
     *
     * @return array
     */
    public function getPayInfoByType(array $post, array $cookie): array
    {
        $cache = &$this->cache;

        $key = 'MONERYD' . $post[Pay::$payType_id] . 'WHERE_IS_YOU' . $post['platform'];
        $data = $cache->get($key);

//         if ($data) {
//             return json_decode($data, true);
//         }

        $data = $this->getPayConfig($post, $cookie);

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 360);

        return $data;
    }

    /**
     * 获取支付配置
     *
     * @return array
     */
    public function getPayConfig(array $post, array $cookie): array
    {
        $field = [
            Pay::$id,
            Pay::$mchid,
            Pay::$notifyUrl,
            Pay::$openId,
            Pay::$payAccount,
            Pay::$payKey,
            Pay::$privatePem,
            Pay::$publicPem,
            Pay::$type,
            Pay::$returnUrl,
            Pay::$payType_id,
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition([
                Pay::$payType_id => $post[Pay::$payType_id],
                Pay::$type => $post['platform'],
            ])
            ->find();
        if (0 === count($data)) {
            return array();
        }

        $data['token'] = $cookie['SWOFT_SESSION_ID'];

        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return Pay::class;
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
            PayType::$id,
            PayType::$typeName,
            PayType::$isDefault
        ];
    }
}