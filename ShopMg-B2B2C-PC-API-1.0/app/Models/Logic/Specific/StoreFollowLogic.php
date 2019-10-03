<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreFollow;
use App\Common\FieldMapping\User;
use App\Models\Entity\DbStoreFollow;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 店铺关注逻辑处理层
 * @Bean()
 */
class StoreFollowLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbStoreFollow::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateBySearch()
    {
        return [
            'shop_name' => [
                'checkChineseAndEnglish' => '店铺名称必须合法'
            ]
        ];
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
        return StoreFollow::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
        return [
            User::$userName
        ];
    }

    /**
     * 关注店铺
     */
    public function attenStore(array $post): bool
    {
        // 判断是否关注过这个店铺
        $where = [];
        $userId = session()->get('user_id');
        $where['user_id'] = $userId;
        $where['store_id'] = $post['id'];

        $result = $this->getQueryBuilderProxy()
            ->condition($where)
            ->field("id")
            ->find();

        if (count($result)) {
            // 已关注
            return false;
        }

        $data['user_id'] = $userId;
        $data['store_id'] = $post['id'];

        Db::beginTransaction();

        $result = $this->addData([
            'user_id' => $userId,
            'store_id' => $post['id']
        ]);

        if (!$result) {
            Db::rollback();
            return false;
        }
        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd($insert): array
    {
        $insert['create_time'] = $time = time();

        $insert['update_time'] = $time;

        return $insert;
    }

    /**
     * 店铺取消关注
     *
     * @return bool
     */
    public function cancelAttenStore(array $post): bool
    {
        Db::beginTransaction();

        $result = $this->getQueryBuilderProxy()
            ->where('user_id', session()->get('user_id'))
            ->where('store_id', $post['id'])
            ->delete();
        return $this->traceStation($result);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getWhereBySaveAndDelete()
     */
    protected function getWhereBySaveAndDelete(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }

    /**
     * 我的收藏--店铺收藏删除
     */
    public function getStoreFollowDel()
    {
        $res = parent::delete();

        return $res;
    }

    /**
     * 我的收藏--店铺收藏
     */
    public function getMyCollectionStore(): array
    {
        $field = [
            'id',
            'store_id'
        ];
        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where('user_id', session()->get('user_id'))
            ->order('create_time', 'DESC')
            ->limit(20)
            ->select();
    }

    /**
     * 获取店铺关联key
     *
     * @return string
     */
    public function getSplitKeyByStore(): string
    {
        return StoreFollow::$storeId;
    }

    /**
     * 搜索获取数据
     *
     * @param array $post
     * @return array
     */
    public function getStoreFollowSearch(array $post, array $accessWhere): array
    {
        return $this->getParseDataByList($post, [
            'store_id' => $accessWhere
        ]);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::parseOption()
     */
    protected function parseOption(array $options): array
    {
        $options['where']['user_id'] = session()->get('user_id');

        return $options;
    }
}
