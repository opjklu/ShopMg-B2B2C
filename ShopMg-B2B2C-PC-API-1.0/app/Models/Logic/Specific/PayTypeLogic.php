<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\PayType;
use App\Models\Entity\DbPayType;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\ParamsParse;

/**
 * 支付类型逻辑处理层
 * @Bean()
 * @author
 */
class PayTypeLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbPayType::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return PayType::class;
    }

    /**
     * 获取结果(支付列表)
     */
    public function getResult()
    {
        $cache = &$this->cache;

        $data = $cache->get('pay_type_wap');

        if ($data) {

            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                PayType::$status => 1
            ])
            ->select();
        if (0 === count($data)) {
            return [];
        }

        $cache->set('pay_type_wap', json_encode($data, JSON_UNESCAPED_UNICODE), 600);

        return $data;
    }

    /**
     * 获取结果(支付列表)
     */
    public function getPayType()
    {
        $cache = &$this->cache;

        $data = $cache->get('pay_type_special');

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                PayType::$isSpecial => 0,
                PayType::$status => 1
            ])
            ->select();

        if (0 === count($data)) {
            return [];
        }
        $cache->set('pay_type_special', json_encode($data, JSON_UNESCAPED_UNICODE), 600);

        return $data;
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
            PayType::$isDefault,
            PayType::$logo
        ];
    }

    public function getPayName(array $data, string $splitKey): array
    {
        return $this->getQueryBuilderProxy()
            ->where(PayType::$id, $data[$splitKey])
            ->field(PayType::$typeName)
            ->find();
    }

    /**
     *
     * @return array
     */
    public function isPayedCache(array $data, string $splitKey): array
    {
        $key = 'pay_type_id_what' . $data[$splitKey];

        $cache = &$this->cache;

        $cacheData = $cache->get($key);

        if ($cacheData) {
            return json_decode($cacheData, true);
        }

        $cacheData = $this->getPayName($data, $splitKey);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($cacheData), 45);

        return $cacheData;
    }

    /**
     *
     * @return Generator
     */
    public function gePayNameByCash(array $dataSources, string $splitKey): array
    {
        $field = [
            PayType::$id,
            PayType::$typeName
        ];

        $paramEntity = new ParamsParse($dataSources, $field, PayType::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }
}
