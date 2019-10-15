<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderComment;
use App\Common\TraitClass\CommentComponentTrait;
use App\Models\Entity\DbOrderComment;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class OrderCommentLogic extends AbstractLogic
{
    use CommentComponentTrait;

    /**
     * @Inject(name="cache")
     *
     * @var unknown
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbOrderComment::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'goods_id' => [
                'required' => '必须输入商品ID'
            ]
        ];
        return $message;
    }

    public function getValidatesByLogin()
    {
        $message = [
            'goods_id' => [
                'required' => '必须输入商品ID'
            ]
        ];
        return $message;
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
        return OrderComment::class;
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

    protected function getTableColum(): array
    {
        return [
            OrderComment::$id,
            OrderComment::$anwser,
            OrderComment::$score,
            OrderComment::$status,
            OrderComment::$storeId,
            OrderComment::$level,
            OrderComment::$content,
            OrderComment::$labels,
            OrderComment::$goodsId,
            OrderComment::$createTime
        ];
    }

    /**
     * 获取商品分割键
     *
     * @return string
     */
    public function getSplitKeyByGoods(): string
    {
        return OrderComment::$goodsId;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::searchArray()
     */
    protected function searchArray(): array
    {
        return [
            OrderComment::$goodsId,
            OrderComment::$level
        ];
    }

    /**
     * 分组求数量
     */
    public function getCommentsListGroupCount(array $post): array
    {
        $count = $this->getQueryBuilderProxy()
            ->where('goods_id', $post['goods_id'])
            ->count();
        $img = $this->getQueryBuilderProxy()
            ->condition([
                'goods_id' => $post['goods_id'],
                'have_pic' => 1
            ])
            ->count();
        $nice = $this->getQueryBuilderProxy()
            ->condition([
                'goods_id' => $post['goods_id'],
                'level' => 2
            ])
            ->count();
        $height = $this->getQueryBuilderProxy()
            ->condition([
                'goods_id' => $post['goods_id'],
                'level' => 1
            ])
            ->count();
        $bad = $this->getQueryBuilderProxy()
            ->condition([
                'goods_id' => $post['goods_id'],
                'level' => 0
            ])
            ->count();

        return [
            'allCount' => $count,
            'allImg' => $img,
            'allNice' => $nice,
            'allHeight' => $height,
            'allBad' => $bad
        ];
    }

    /**
     * 用户关联key
     *
     * @return string
     */
    public function getSplitKeyByUser(): string
    {
        return OrderComment::$userId;
    }

    /**
     * 获取各个商品的评分
     */
    public function getGoodsRecommend(array $post): array
    {
        $score = [];

        $data = $this->getRecommend();

        if (count($data) === 0) {
            return [];
        }

        $meData = [];

        $otherUserData = [];

        $userId = session()->get('user_id');

        // 区分个人与其他用户
        foreach ($data as $key => $value) {

            if ($value['user_id'] == $userId) {

                $meData[] = $value;
            } else {
                $otherUserData[] = $value;
            }
        }

        // 没有购买商品
        if (count($meData) === 0 || count($otherUserData) === 0) {
            return [];
        }

        unset($data);

        $meDataParse = $this->parseArrayNumber($meData);

        $otherUserDataParse = $this->parseArrayNumber($otherUserData);

        $tmpDataParse = $meDataParse;

        $tmpOther = $otherUserDataParse;

        $mLength = count(array_shift($tmpDataParse));

        $tmpOtherLength = count(array_shift($tmpOther));

        $i = 0;

        $tmp = [];

        // 两个数组 中的值【一维数组 数量必须一致】
        if ($mLength < $tmpOtherLength) {

            for ($i = $mLength; $i < $tmpOtherLength; $i++) {
                $tmp[] = 1;
            }

            foreach ($meDataParse as $key => &$value) {

                $value = array_merge($value, $tmp);
            }
        } else if ($mLength > $tmpOtherLength) {

            for ($i = $tmpOtherLength; $i < $mLength; $i++) {
                $tmp[] = 1;
            }

            foreach ($otherUserDataParse as $key => &$value) {

                $value = array_merge($value, $tmp);
            }
        }

        return [
            'me' => $meDataParse,
            'otherPerson' => $otherUserDataParse
        ];
    }

    /**
     * 处理数组个数
     */
    private function parseArrayNumber(array $meData): array
    {
        $meScore = [];

        foreach ($meData as $key => $value) {
            $meScore[$value[OrderComment::$goodsId]][] = $value[OrderComment::$score];
        }

        $meNumber = [];

        foreach ($meScore as $key => $value) {
            $meNumber[$key] = count($value);
        }

        // 数组里个数的最大值
        $max = max($meNumber);

        // 填充数组达到个数一致
        foreach ($meScore as $key => & $value) {

            if ($meNumber[$key] === $max) {
                continue;
            }

            for ($i = $meNumber[$key]; $i < $max; $i++) {
                $value[$i] = 1;
            }
        }

        return $meScore;
    }

    /**
     * 根据评分推荐商品
     */
    public function getRecommend(): array
    {
        $cache = &$this->cache;

        $key = 'recommend-goods-list';

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field([
                OrderComment::$goodsId,
                OrderComment::$score,
                OrderComment::$userId
            ])
            ->order(OrderComment::$createTime, 'DESC')
            ->limit(500)
            ->select();

        if (0 === count($data)) {
            return [];
        }

        $cache->set($key, json_encode($data), 300);

        return $data;
    }
}
