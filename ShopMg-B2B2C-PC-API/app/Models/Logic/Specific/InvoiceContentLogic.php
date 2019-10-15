<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\InvoiceContent;
use App\Models\Entity\DbInvoiceContent;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 发票内容
 *
 * @author Administrator
 *
 * @Bean()
 */
class InvoiceContentLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    public function __construct()
    {
        $this->tableName = DbInvoiceContent::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return InvoiceContent::class;
    }

    /**
     * 根据商品销量获取商品
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
            InvoiceContent::$id,
            InvoiceContent::$name
        ];
    }

    /**
     * 发票内容数据
     *
     * @return array
     */
    public function invoiceContentData(): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(InvoiceContent::$status, 1)
            ->select();
    }

    /**
     * 发票内容缓存
     *
     * @return array
     */
    public function invoiceContentDataCache(): array
    {
        $key = 'invoice_cache_content45';

        $cache = & $this->cache;

        $data = $cache->get($key);
        
        if ($data) {
            return json_encode($data);
        }

        $data = $this->invoiceContentData();

        if (count($data) === 0) {
            $this->errorMessage = '未设置发票类型';
            return [];
        }

        $cache->set($key, json_encode($data), 100);
        
        return $data;
    }
}