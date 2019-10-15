<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

use App\Models\Logic\Specific\SysLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 获取系统配置组件
 *
 * @author Administrator
 */
trait GETConfigTrait
{

    /**
     * @Inject()
     *
     * @var SysLogic
     */
    private $sysLogic;

    /**
     * 获取系统配置
     */
    public function getConfig($key)
    {
        return $this->sysLogic->getConfigByDetailKey($key);
    }

    /**
     * 获取无缓存具体配置
     *
     * @return array
     */
    protected function getNoCacheConfig($key)
    {
        return $this->sysLogic->getDetailCacheConfig($key);
    }

    /**
     * 获取组数据 配置
     */
    protected function getGroupConfig(string $key): array
    {
        return $this->sysLogic->covertMapByConfig($key);
    }

    /**
     * 获取网站信息
     */
    public function getIntnetInformation()
    {
        // 获取组配置
        $information = $this->getGroupConfig('information_by_intnet');

        return $information;
    }

    public function get_intnetConfig()
    {
        // 获取组配置
        $information = $this->getGroupConfig('intnetConfig');

        return $information;
    }
}