<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\UserData;
use App\Models\Entity\DbUserData;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\Db;

/**
 * 用户数据处理
 * @Bean()
 *
 * @author wq
 */
class UserDataLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;



    public function __construct()
    {
        $this->tableName = DbUserData::class;
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
        return UserData::class;
    }

    /**
     * 积分
     *
     * @param array $integer
     * @return bool
     */
    public function updateIntegralByAdd(array $integer): bool
    {
        $data = $this->getIntegralByUserIdCache();

        $status = false;

        if (empty($data)) {
            $status = $this->addData($integer);
        } else {
            $status = $this->getQueryBuilderProxy()
                ->where('id', $data['id'])
                ->counter('current_integral', $integer['total_integral']);
        }
        return $this->traceStation($status);
    }

    /**
     * 根据用户获取积分
     *
     * @return array
     */
    public function getIntegralByUserId(): array
    {
        $userId = session()->get('user_id');

        $data = $this->getQueryBuilderProxy()
            ->field([
                UserData::$id,
                UserData::$currentIntegral
            ])
            ->where(UserData::$userId, $userId)
            ->find();

        if (empty($data)) {
            return [
                UserData::$currentIntegral => 0
            ];
        }

        return $data;
    }

    public function getIntegralAndSaveSession(): array
    {
        $data = $this->getIntegralByUserId();

        if (empty($data)) {
            return [];
        }

        session()->put('my_integ_number', $data[UserData::$currentIntegral]);

        return $data;
    }

    /**
     * 根据用户获取积分
     *
     * @return array
     */
    public function getIntegralByUserIdCache(): array
    {
        $key = 'whar_user_integral_s' . session()->get('user_id');

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getIntegralByUserId();

        if (0 === count($data)) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 45);

        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $data = [];

        $data[UserData::$userId] = session()->get('user_id');

        $data[UserData::$currentIntegral] = $insert['total_integral'];

        $data[UserData::$alreadyIntegral] = 0;

        $data[UserData::$createTime] = $time = time();

        $data[UserData::$updateTime] = $time;

        return $data;
    }

    /**
     * 积分结算
     */
    public function integralSettleMement(array $data): int
    {
        $integralNumber = $this->integralIsEnough($data);

        if (0 === $integralNumber) {
            return 0;
        }

        $userId = session()->get('user_id');

        Db::beginTransaction();

        $tableName = $this->getQueryBuilderProxy()->getTableName();

        $time = time();

        $sql = <<<aaa
		Update {$tableName} set current_integral = current_integral - {$this->integralShopping}, 
		already_integral = already_integral + {$this->integralShopping},
		update_time = {$time}
		where user_id = {$userId};
aaa;

        $status = Db::query($sql)->getResult('items');

        if (!$this->traceStation($status)) {
            $this->errorMessage = '积分操作失败';
            return 0;
        }

        return $integralNumber;
    }

    /**
     * 积分是否足够
     */
    private function integralIsEnough(array $data)
    {

        $integral = $this->sumShoppingIntegral($data);

        $myIntegral = session()->get('my_integ_number');

        if ($myIntegral - $integral < 0) {
            $this->errorMessage = '积分订不足';
            return 0;
        }

        return $integral;
    }

    /**
     *
     * @return number
     */
    private function sumShoppingIntegral(array $data)
    {
        $integral = 0;

        foreach ($data as $key => $value) {
            $integral += $value['integral'];
        }

        return $integral;
    }

    /**
     * 积分关联字段
     *
     * @return string
     */
    public function getSplitKeyByIntegral(): string
    {
        return UserData::$currentIntegral;
    }
}
