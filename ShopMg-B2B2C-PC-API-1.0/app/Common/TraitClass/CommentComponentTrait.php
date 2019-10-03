<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Common\TraitClass;

use Swoft\Db\Db;

/**
 * 评论组件
 *
 * @author Administrator
 */
trait CommentComponentTrait
{

    /**
     * 验证评论数据
     *
     * @return array
     */
    public function validateDataByComment(): array
    {
        $model = $this->getMapperClassName();

        return [
            $model::$orderId => [
                'number' => '订单编号必须是数字'
            ],

            $model::$content => [
                'required' => '填写评论内容',
                'checkChineseAndEnglish' => '请不要填写特殊字符'
            ],
            $model::$orderId => [
                'number' => '订单编号必须是数字'
            ],

            $model::$anonymous => [
                'number' => '是否匿名必须是数字且介于${0-1}'
            ],

            $model::$score => [
                'number' => '评分必须是数字，且介于${0-5}'
            ],
            $model::$storeId => [
                'number' => '店铺id必须是数字'
            ],

            $model::$goodsId => [
                'number' => '商品id必须是数字'
            ],
            $model::$labels => [
                'number' => '商品标签必须是数字且介于${0-9}'
            ],
            $model::$havePic => [
                'number' => '是否有图片必须是数字且介于${0-1}'
            ]
        ];
    }

    /**
     * 添加评价
     *
     * @return bool
     */
    public function recordConmment(array $data): int
    {
        $model = $this->getMapperClassName();

        $data[$model::$havePic] = empty($data[$model::$havePic]) ? 0 : 1;

        Db::beginTransaction();

        $status = $this->addData($data);

        if (!$this->traceStation($status)) {

            $this->errorMessage = '添加评论失败';

            return 0;
        }
        return $status;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Common\Logic\AbstractGetDataLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $model = $this->getMapperClassName();

        $insert[$model::$level] = $this->rateByOrder($insert);

        $insert[$model::$createTime] = time();

        $insert[$model::$userId] = session()->get('user_id');

        unset($insert['path']);

        return $insert;
    }

    /**
     * 评分计算评级
     *
     * @return array
     */
    protected function rateByOrder(array $data): int
    {
        // 评级【 0.差评(1,2分) 1.一般(3,4分) 2.好评(5分)】
        $tmp = [
            0,
            0,
            0,
            1,
            1,
            2
        ];

        $model = $this->getMapperClassName();

        return $tmp[$data[$model::$score]];
    }
    
    /*
     * 获取评价详情
     */
    public function getEvaluateDetails(array $post): array
    {
        return $this->getQueryBuilderProxy()
        ->field($this->getTableColum())
        ->condition([
            'order_id' => $post['order_id'],
            'goods_id' => $post['goods_id'],
            'user_id' => session()->get('user_id')
        ])
        ->find();
    }
    
}