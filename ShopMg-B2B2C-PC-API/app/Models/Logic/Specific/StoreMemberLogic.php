<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 米糕网络团队 All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreMember;
use App\Models\Entity\DbStoreMember;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Log\Log;
use Tool\Db;

/**
 * 店铺会员逻辑处理
 *
 * @author Administrator
 *
 * @Bean()
 */
class StoreMemberLogic extends AbstractLogic
{

    /**
     * 要添加的会员
     *
     * @var array
     */
    private $thereIsNo = [];


    public function __construct()
    {
        $this->tableName = DbStoreMember::class;
    }

    /**
     * 获取结果
     */
    public function getResult()
    {
    }

    /**
     *
     * @param array $result
     */
    public function parseMember(array $result)
    {
        $data = $this->getDetailMember($result);

        $already = [];

        $thereIsNo = [];

        foreach ($result as $key => $value) {
            if (!empty($data[$value[StoreMember::$storeId]])) {
                $already[$key] = $value;
            } else {
                $thereIsNo[$key] = $value;
            }
        }

        if (0 !== count($already)) {
            // 更新
            $sql = $this->buildUpdateSql($already);

            try {

                $status = Db::query($sql)->getResult('items');

                if (!$this->traceStation($status)) {
                    return false;
                }
            } catch (\Exception $e) {

                Db::rollback();

                Log::error('店铺会员更新失败 --', [
                    $sql,
                    $e->getMessage()
                ]);

                return false;
            }
        }

        $addStatus = 0;

        if (0 !== count($thereIsNo)) {
            // 添加

            $addStatus = $this->addAll($thereIsNo);
        }

        if (!$this->traceStation($addStatus)) {
            return false;
        }

        Db::commit();
        return true;
    }

    /**
     * 获取具体的店铺会员
     *
     * @return array
     */
    public function getDetailMember(array $result)
    {
        $storeIdString = array_keys($result);

        return $this->getQueryBuilderProxy()
            ->field([
                StoreMember::$storeId,
                StoreMember::$memberId,
                StoreMember::$totalTransaction,
                StoreMember::$transactionNumber
            ])
            ->whereIn(StoreMember::$storeId, $storeIdString)
            ->where('member_id', session()->get('user_id'))
            ->getField();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAddAll()
     */
    protected function getParseResultByAddAll(array $post): array
    {
        $result = [];

        $index = 0;

        $userId = session()->get('user_id');

        foreach ($post as $key => $value) {
            $result[$index] = [
                StoreMember::$memberId => $userId,
                StoreMember::$storeId => $value['store_id'],
                StoreMember::$totalTransaction => $value['total_money'],
                StoreMember::$transactionNumber => 1
            ];
            $index++;
        }
        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getColumToBeUpdated()
     */
    protected function getColumToBeUpdated(): array
    {
        return [
            StoreMember::$totalTransaction,
            StoreMember::$transactionNumber,
            StoreMember::$updateTime
        ];
    }

    /**
     * 要更新的数据【已经解析好的】
     *
     * @return array
     */
    protected function getDataToBeUpdated(array $data): array
    {
        $result = [];

        $i = 0;

        $time = time();

        foreach ($data as $key => $value) {
            $result[$this->userId][$i] = StoreMember::$totalTransaction . ' + ' . $value['total_money'];

            $result[$this->userId][$i] = StoreMember::$transactionNumber . ' + 1';

            $result[$this->userId][$i] = $time;

            $i++;
        }

        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return StoreMember::class;
    }

    /**
     * 当前登录用户是否是店铺会员缓存
     */
    public function isMemberbByCurrentStore(array $post): bool
    {
        return count($this->getMember($post)) === 0;
    }

    /**
     * 当前登录用户是否是店铺会员
     */
    public function getMember(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(StoreMember::$storeId, $post['store_id'])
            ->where(StoreMember::$memberId, session()->get('user_id'))
            ->find();
    }
}