<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Collection;
use App\Common\FieldMapping\Common;
use App\Models\Entity\DbCollection;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\ArrayChildren;
use Tool\Db;

/**
 * 逻辑处理层
 * @Bean()
 */
class CollectionLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbCollection::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidate(): array
    {
        return [
            'goods_id' => [
                'required' => '必须传入商品ID',
                'checkStringIsNumber' => '商品字符串必须是以数字逗号组成的'
            ],

            'id' => [
                'required' => '必须传入购物车ID',
                'checkStringIsNumber' => '购物车字符串必须是以数字逗号组成的'
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
     * 获取 商品相关字段
     */
    public function getSplitKeyByGoods(): string
    {
        return Collection::$goodsId;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return Collection::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [];
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
            Collection::$id
        ];
    }

    /**
     * 购物车添加商品收藏
     */
    public function collectGoods(array $post): bool
    {
        $userId = session()->get('user_id');

        $condition = [];

        $condition['goods_id'] = $post['goods_id'];

        $condition['user_id'] = $userId;

        Db::beginTransaction();

        $res = $this->getQueryBuilderProxy()
            ->condition($condition)
            ->delete();

        if (!$this->traceStation($res)) {
            return false;
        }
        $status = $this->addData($condition);

        if (!$this->traceStation($status)) {
            return false;
        }

        return true;
    }

    /**
     * 购物车批量收藏
     */
    public function batchCollectGoods(array $post): bool
    {
        $userId = session()->get('user_id');

        $goodsIds = explode(',', $post['goods_id']);

        Db::beginTransaction();

        $res = $this->getQueryBuilderProxy()
            ->whereIn('goods_id', $goodsIds)
            ->where('user_id', $userId)
            ->delete();

        if (!$this->traceStation($res)) {
            return false;
        }
        $status = $this->addAll($goodsIds);
        if (!$this->traceStation($status)) {
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
        $insert[Collection::$addTime] = time();
        $insert[Collection::$status] = 0;

        return $insert;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAddAll()
     */
    protected function getParseResultByAddAll(array $post): array
    {
        $time = time();

        $add = [];

        $length = count($post);

        $userId = session()->get('user_id');

        $i = 0;

        for ($i; $i < $length; $i++) {

            $add[$i] = [
                'add_time' => $time,
                'user_id' => $userId,
                'goods_id' => $post[$i],
                'status' => 0
            ];
        }
        return $add;
    }

    /**
     * 取消我收藏的商品
     */
    public function cancelUserCollection(array $post): int
    {
        return $this->getQueryBuilderProxy()
            ->where('user_id', session()->get('user_id'))
            ->where('id', $post['id'])
            ->delete();
    }

    /**
     * 我的收藏--商品
     */
    public function getMyCollectionGoods()
    {
        return $this->getQueryBuilderProxy()
            ->field([
                'id',
                'goods_id'
            ])
            ->where('user_id', session()->get('user_id'))
            ->limit(8)
            ->order('add_time', 'DESC')
            ->select();
    }

    /**
     * 根据搜索条件获取数据
     *
     * @param array $post
     * @param array $where
     * @return array
     */
    public function getCollectionBySearch(array $post, array $where): array
    {
        return $this->getParseDataByList($post, [
            [
                'goods_id',
                'in',
                $where
            ]
        ]);
    }

    /**
     * 收藏商品
     */
    public function getCollectGoods(array $post): bool
    {
        $userId = session()->get('user_id');

        // 验证是否收藏过这个商品
        $where['goods_id'] = $post['goods_id'];
        $where['user_id'] = $userId;

        $res = $this->getQueryBuilderProxy()
            ->condition($where)
            ->find();

        $result = false;

        if (0 !== count($res)) {

            $result = $this->getQueryBuilderProxy()
                ->condition($where)
                ->delete();
        } else {
            $result = $this->addData([
                'user_id' => $userId,
                'goods_id' => $post['goods_id']
            ]);
        }

        return $result && true;
    }

    /**
     * 我的收藏--删除
     */
    public function getMyCollectionDel(array $post): int
    {
        return $this->getQueryBuilderProxy()
            ->whereIn('id', explode(',', $post['id']))
            ->where('user_id', session()->get('user_id'))
            ->delete();
    }

    /**
     * 删除检测是否是数字字符串
     *
     * @return array
     */
    public function getValidateByDel(): array
    {
        return [
            'id' => [
                'required' => 'id参数必传',
                'checkStringIsNumber' => '字符串必须为数字组成的字符串'
            ]
        ];
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

    /**
     *
     * @return array
     */
    public function checkAlreadyCollect(array $goods): array
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return $goods;
        }

        $collectGoods = $this->getQueryBuilderProxy()
            ->whereIn('goods_id', array_column($goods, 'id'))
            ->where('user_id', $userId)
            ->select();

        if (0 === count($collectGoods)) {
            return $goods;
        }

        $covertData = (new ArrayChildren($collectGoods))->convertIdByData('goods_id');

        foreach ($goods as $key => & $value) {

            if (isset($covertData[$value['id']])) {
                $value['is_collect'] = '1';
            } else {
                $value['is_collect'] = '0';
            }
        }
        return $goods;
    }
}