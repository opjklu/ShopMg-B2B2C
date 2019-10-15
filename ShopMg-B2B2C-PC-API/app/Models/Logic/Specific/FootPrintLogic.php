<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\FootPrint;
use App\Models\Entity\DbFootPrint;
use Swoft\App;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 * @Bean()
 */
class FootPrintLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbFootPrint::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByDel()
    {
        return [
            'id' => [
                'required' => '必须输入浏览id',
                'checkStringIsNumber' => '字符串必须是以逗号组成的字符串'
            ]
        ];
    }

    /**
     * 返回验证数据
     */
    public function getValidateBySearch()
    {
        $message = [
            'keyWords' => [

                'required' => '必须输入搜索关键词'
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
        return FootPrint::class;
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
     * 猜你喜欢逻辑处理
     */
    public function guessLove($uid)
    {
        $where['uid'] = (int)$uid; // 用户id
        $goods = $this->getQueryBuilderProxy()->getLoveGoods($uid);
        if (empty($goods)) {
            $maybe_love = $this->goodsModel->getMaybeLoveGoods();
        } else {
            $maybe_love = $goods;
        }
        return $maybe_love;
    }

    /**
     * 最近浏览--删除
     */
    public function getMyFootFrintDel(array $post): int
    {
        return $this->getQueryBuilderProxy()
            ->whereIn('id', explode(',', $post['id']))
            ->where('uid', session()->get('user_id'))
            ->delete();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $data = &$insert;

        $temp = [];

        $temp[FootPrint::$gid] = $data['id'];

        $temp[FootPrint::$uid] = App::getBean('sessionManager')->getSession()->get('user_id');

        $temp[FootPrint::$createTime] = time();

        return $temp;
    }

    /**
     * 个人中心
     *
     * @return array
     */
    public function guessYouLikeGoods(): array
    {
        $field = [
            'id',
            'gid'
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where('uid', session()->get('user_id'))
            ->limit(6)
            ->order('create_time', 'desc')
            ->select();
    }

    /**
     * 获取商品关联字段
     *
     * @return string
     */
    public function getSplitKeyByGoods(): string
    {
        return FootPrint::$gid;
    }

    protected function parseOption(array $options): array
    {
        $options['where']['uid'] = session()->get('user_id');

        return $options;
    }

    /**
     *
     * @param unknown $limit
     * @return array|unknown
     */
    public function getMyLikeFootFrint(int $limit = 6): array
    {
        $field = [
            'id',
            'gid'
        ];

        $result = DbFootPrint::findAll([
            'uid' => session()->get('user_id')
        ], [
            'field' => $field,
            'limit' => $limit
        ])->getResult([
            'items'
        ]);

        if (empty($result)) {

            $this->errorMessage = '没有收藏商品';

            return [];
        } else {
            return $result->toArray();
        }
    }
}
