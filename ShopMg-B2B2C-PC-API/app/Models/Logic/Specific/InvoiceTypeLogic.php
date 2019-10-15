<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\InvoiceType;
use App\Models\Entity\DbInvoiceType;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class InvoiceTypeLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbInvoiceType::class;
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
        return InvoiceType::class;
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
            InvoiceType::$id,
            InvoiceType::$name
        ];
    }

    /**
     * 发票类型数据
     *
     * @return array
     */
    public function invoiceList(): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(InvoiceType::$status . ' = 1 ')
            ->select();
    }

    /**
     * 发票类型缓存
     *
     * @return array
     */
    public function invoiceListCache(): array
    {
        $key = 'invoice_cache_12c';

        $cache = & $this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_encode($data);
        }

        $data = $this->invoiceList();

        if (count($data) === 0) {
            $this->errorMessage = '未设置发票类型';
            return [];
        }

        $cache->set($key, json_encode($data), 100);

        return $data;
    }

    /**
     * 获取发票类型
     *
     * @return array
     */
    public function getInvoiceType(array $data, string $splitKey): array
    {
        return $this->getQueryBuilderProxy()
            ->field(InvoiceType::$name)
            ->where(InvoiceType::$id, $data[$splitKey])
            ->find();
    }

    /**
     * 获取发票类型
     *
     * @return array
     */
    public function getInvoiceTypeCache(array $data, string $splitKey): array
    {
        $key = $data[$splitKey] . '_invoice_type';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getInvoiceType($data, $splitKey);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data), 70);

        return $data;
    }

    /**
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function isOpenInvoice(array $data, string $splitKey): array
    {
        if ($data['translate'] != 1) {
            return [];
        }

        return $this->getInvoiceTypeCache($data, $splitKey);
    }
}
