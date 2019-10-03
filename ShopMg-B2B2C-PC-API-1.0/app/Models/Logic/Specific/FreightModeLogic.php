<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\FreightMode;
use App\Models\Entity\DbFreightMode;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\ArrayChildren;

/**
 * 运送方式配置
 * @Bean()
 *
 * @author 米糕网络团队
 */
class FreightModeLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;


    public function __construct()
    {
        //
        //
        //
        $this->tableName = DbFreightMode::class;
    }

    /**
     * 获取运费(立即购买)
     *
     * @return float
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
        return FreightMode::class;
    }

    /**
     * 获取运费配置
     *
     * @return float
     */
    public function getFreightMoney(array $data): array
    {
        $cache = &$this->cache;

        $idArray = array_keys($data);

        $idString = implode(',', $idArray);

        $cacheKey = $idString . 'wdf';

        $parseData = $cache->get($cacheKey);

        if ($parseData) {
            return json_decode($parseData, true);
        }

        $parseData = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn(FreightMode::$freightId, $idArray)
            ->select();

        if (empty($parseData)) {
            $this->errorMessage = '运费模板设置错误';
            return [];
        }

        $parseData = (new ArrayChildren($parseData))->convertIdByData(FreightMode::$id);

        $tmp = 0;

        foreach ($parseData as $key => &$value) {

            if (empty($data[$value[FreightMode::$freightId]])) {
                return [];
            }
            $tmp = $value[FreightMode::$id];
            $value = array_merge($value, $data[$value[FreightMode::$freightId]]);

            $value[FreightMode::$id] = $tmp;
        }
        $cache->set($cacheKey, json_encode($parseData, JSON_UNESCAPED_UNICODE), 72);
        return $parseData;
    }
}