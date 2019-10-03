<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\CooperativePartner;
use App\Models\Entity\DbCooperativePartner;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 合作伙伴 控制器
 *
 * @author Administrator
 * @Bean()
 */
class CooperativePartnerLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        //
        //

        // $this->getQueryBuilderProxy() = Base::getInstance('CooperativePartner');
        $this->tableName = DbCooperativePartner::class;
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
        return CooperativePartner::class;
    }

    /**
     * 获取合作伙伴列表
     *
     * @return array
     */
    public function getCooprativePartner(): array
    {
        $data = $this->getQueryBuilderProxy()
            ->field([
                CooperativePartner::$id,
                CooperativePartner::$picUrl
            ])
            ->where(CooperativePartner::$status, 1)
            ->order(CooperativePartner::$sort, 'DESC')
            ->select();
        return $data;
    }

    /**
     * 获取合作伙伴列表并缓存
     *
     * @return array
     */
    public function getCooprativePartnerCache(): array
    {
        $key = 'cooprative_partner222';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data != null) {
            return json_decode($data, true);
        }

        $data = $this->getCooprativePartner();

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 200);

        return $data;
    }
}