<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\UserAuths;
use App\Models\Entity\DbUserAuth;
use App\Models\Entity\DbUserAuths;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 *
 * @author Administrator
 *
 * @Bean()
 */
class UserAuthLogic extends AbstractLogic
{

    /**
     * @Inject(name="cache")
     * @var Cache
     */
    private $cache;
    /**
     * open_id 数据
     *
     * @var array
     */
    private $open = [];

    /**
     * 授权是否过期
     *
     * @var bool
     */
    private $isLate = false;

    /**
     *
     * @return boolean
     */
    public function getIsLate()
    {
        return $this->isLate;
    }

    /**
     * 构造方法
     *
     * @param array $data
     * @param array $open
     *            open_id
     */
    public function __construct()
    {
        $this->tableName = DbUserAuths::class;
    }

    /**
     * 检测是否已授权(qq)
     */
    public function getResult()
    {

    }

    public function checkGrantByQQ(array $data): array
    {
        $accessToken = $data['access_token'];

        $openId = $data['openid'];

        $key = $accessToken . $openId . $data['identity_type'];

        $cache = & $this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data);
        }

        $field = [UserAuths::$local];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(UserAuths::$identityType, $data['identity_type'])
            ->where(UserAuths::$credential, $accessToken)
            ->where(UserAuths::$identifier .$openId)
            ->find();
        if (0 === count($data)) {
            return [];
        }

        $time = $data[UserAuths::$expiresIn] + $data[UserAuths::$updateAt] - time();

        if ($time < 21600) {
            // 授权过期
            $this->isLate = true;
            return $data;
        }

        $cache->set($key, $data);

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
        return UserAuths::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $openIdData = session()->get('open_id_data');
        $accessToken = session()->get('access_token');
        $data = [];

        $time = time();

        $data[UserAuths::$userId] = session()->get('user_id');

        $data[UserAuths::$identifier] = $openIdData['openid'];

        $data[UserAuths::$expiresIn] = $accessToken['expires_in'];

        $data[UserAuths::$identityType] = session()->get('identitifer');

        $data[UserAuths::$credential] = $accessToken['access_token'];

        $data[UserAuths::$updateAt] = $time;

        $data[UserAuths::$createAt] = $time;

        $data[UserAuths::$refreshToken] = $accessToken['refresh_token'];

        $data[UserAuths::$unionid] = isset($accessToken['unionid']) ? "" : $accessToken['unionid'];

        return $data;
    }

}