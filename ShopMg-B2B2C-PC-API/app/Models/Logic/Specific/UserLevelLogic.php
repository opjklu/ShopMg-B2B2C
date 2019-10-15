<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\UserLevel;
use App\Models\Entity\DbUserLevel;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 用户等级逻辑处理
 * @Bean()
 *
 * @author Administrator
 */
class UserLevelLogic extends AbstractLogic
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

        // $this->getQueryBuilderProxy() = Base::getInstance('UserLevel');
        $this->tableName = DbUserLevel::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getResult()
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
        return UserLevel::class;
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
        ];
    }

    /**
     * 会员等级数据
     */
    public function getList(): array
    {
        $retData = $this->getQueryBuilderProxy()
            ->field([
                UserLevel::$id,
                UserLevel::$integralBig,
                UserLevel::$integralSmall,
                UserLevel::$levelName,
                UserLevel::$description
            ])
            ->where('status', 1)
            ->order('id', 'asc')
            ->select();

        return $retData;
    }

    /**
     * 会员会员等级数据缓存
     */
    /**
     * 会员等级数据
     */
    public function getListCache(): array
    {
        $key = 'user_level_data_112';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if (!empty($data)) {
            return json_decode($data, true);
        }

        $data = $this->getList();

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 300);

        return $data;
    }

    /**
     * 分析会员下一个等级
     */
    public function parseUserNextLevel(array $integral, string $splitKey)
    {
        $data = $this->getListCache();

        if (count($data) === 0) {
            $this->errorMessage = '没有会员等级';

            return [];
        }

        $currentIntergal = (int)$integral[$splitKey];

        $nextLevelName = '';

        $nextIntegral = 0;

        $currentLevel = '';

        $i = 0;

        foreach ($data as $key => $level) {

            // 积分下限
            $intergalSmall = (int)$level[UserLevel::$integralSmall];
            // 积分上限
            $intergalBig = (int)$level[UserLevel::$integralBig];

            if ($intergalSmall <= $currentIntergal && $currentIntergal < $intergalBig) {
                $currentLevel = $level[UserLevel::$levelName];
                $nextIntegral = $data[$key + 1][UserLevel::$integralSmall] - $currentIntergal;
                $nextLevelName = $data[$key + 1][UserLevel::$levelName];
                break;
            }
        }
        return [
            'next_level_name' => $nextLevelName,
            'next_integral' => $nextIntegral,
            'current_integral' => $currentIntergal,
            'current_level_name' => $currentLevel
        ];
    }
}