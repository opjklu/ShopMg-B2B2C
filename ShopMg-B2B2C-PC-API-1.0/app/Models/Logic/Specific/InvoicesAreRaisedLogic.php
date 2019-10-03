<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\InvoicesAreRaised;
use App\Models\Entity\DbInvoicesAreRaised;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 发票抬头逻辑
 *
 * @author Administrator
 *
 * @Bean()
 */
class InvoicesAreRaisedLogic extends AbstractLogic
{
    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    public function __construct()
    {
        $this->tableName = DbInvoicesAreRaised::class;
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
        return InvoicesAreRaised::class;
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
            InvoicesAreRaised::$id,
            InvoicesAreRaised::$name
        ];
    }

    public function getValidateByAddAreRaised(): array
    {
        return [
            'name' => [
                'required' => '发票抬头参数必须',
                'checkChineseOrEnglish' => '抬头必须是中文或者英文'
            ]
        ];
    }

    /**
     * 处理条件
     *
     * @return array
     */
    protected function parseOption(array $options): array
    {
        $options['where']['user_id'] = session()->get('user_id');
        return $options;
    }

    /**
     * 发票抬头数据
     *
     * @return array
     */
    public function invoiceAreRaiseData(): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(InvoicesAreRaised::$status . ' = 1 and ' . InvoicesAreRaised::$userId . ' = ' . session()->get('user_id'))
            ->select();
    }

    /**
     * 发票抬头缓存
     *
     * @return array
     */
    public function invoiceAreRaiseDataCache(): array
    {
        $key = 'invoice_cache_what' . session()->get('user_id');

        $cache = & $this->cache;
        

        $data = $cache->get($key);
        
        if ($data) {
            return json_encode($data);
        }

        $data = $this->invoiceAreRaiseData();

        if (count($data) === 0) {
            $this->errorMessage = '未设置发票类型';
            return [];
        }

        $cache->set($key, json_encode($data), 5);
        
        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $update['user_id'] = session()->get('user_id');

        $update['update_time'] = time();

        return $update;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $update): array
    {
        $update['user_id'] = session()->get('user_id');

        $time = time();

        $update['update_time'] = $time;

        $update['create_time'] = $time;

        return $update;
    }
}