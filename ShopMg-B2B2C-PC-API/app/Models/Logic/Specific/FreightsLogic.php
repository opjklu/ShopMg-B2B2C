<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Freights;
use App\Models\Entity\DbFreights;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\ArrayChildren;
use Tool\SessionManager;

/**
 * 运费处理
 * @Bean()
 *
 * @author 米糕网络团队
 */
class FreightsLogic extends AbstractLogic
{

    /**
     * 包邮数组
     */
    private $isToPost = [];

    private $isAllToPost = FALSE;

    /**
     * 店铺编号
     *
     * @var integer
     */
    private $storeId = 0;

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    /**
     *
     * @return number
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     *
     * @return []
     */
    public function getIsPost()
    {
        return $this->isToPost;
    }

    /**
     *
     * @return bool
     */
    public function getIsAllPost()
    {
        return $this->isAllToPost;
    }


    public function __construct()
    {
        //
        //
        // $this->getQueryBuilderProxy() = Base::getInstance('Freights');
        $this->tableName = DbFreights::class;
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
        return Freights::class;
    }

    /**
     * 验证数据(计算运费运算量大 特此简化验证操作)
     *
     * @return bool
     */
    public function getValidateSource(array $post)
    {
        $expressId = SessionManager::GET_EXPRESS_ID();

        if (empty($expressId)) {
            $this->errorMessage = '运费模板为空';
            return false;
        }

        if (!isset($post['prov_id']) || !is_numeric($post['prov_id'])) {
            $this->errorMessage = '省级必须都是数字';
            return false;
        }

        if (!isset($post['city_id']) || !is_numeric($post['city_id'])) {
            $this->errorMessage = '市级必须都是数字';
            return false;
        }

        if (!isset($post['dist_id']) || !is_numeric($post['dist_id'])) {
            $this->errorMessage = '县级必须都是数字';
            return false;
        }

        return true;
    }

    /**
     * 获取运费配置
     *
     * @return float
     */
    public function getFreightTemplate()
    {
        $cache = &$this->cache;

        $expressId = SessionManager::GET_EXPRESS_ID();

        $expressIdByFreight = array_keys($expressId);

        $idString = implode(',', $expressIdByFreight);

        $cacheKey = base64_encode($idString);

        $data = $cache->get($cacheKey);

        if (!empty($data)) {

            return json_decode($data, true);
        }
        try {
            $data = $this->getQueryBuilderProxy()
                ->field($this->getTableColum())
                ->whereIn(Freights::$id, $expressIdByFreight)
                ->select();
        } catch (\Exception $e) {
            \Swoft\Log\Log::error('运费处理' . print_r($expressId, true), [
                $e->getMessage()
            ]);
            $this->errorMessage = '运费计算异常';
            return [];
        }
        if (empty($data)) {
            $this->errorMessage = '运费模板配置错误';
            return [];
        }

        $data = (new ArrayChildren($data))->convertIdByData(Freights::$id);

        $flag = 0;

        foreach ($expressId as $key => $storeData) {

            if (empty($data[$key])) {

                $this->errorMessage = '该商铺没有设置对应的模板';

                $this->storeId = $storeData;

                return [];
            }
        }

        // 谁指定条件包邮
        foreach ($data as $key => $value) {

            if ($value[Freights::$isFree_shipping] == 1 && $value[Freights::$isSelect_condition] == 0) {
                $flag++;
            } elseif ($value[Freights::$isFree_shipping] == 0 && $value[Freights::$isSelect_condition] == 1) {
                $this->isToPost[$key] = $value;
            }
        }

        $this->isAllToPost = $flag === count($data);

        $cache->set($cacheKey, json_encode($data, JSON_UNESCAPED_UNICODE), 72);
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
            Freights::$id,
            Freights::$expressTitle,
            Freights::$isFree_shipping,
            Freights::$valuationMethod,
            Freights::$isSelect_condition,
            Freights::$sendTime
        ];
    }
}