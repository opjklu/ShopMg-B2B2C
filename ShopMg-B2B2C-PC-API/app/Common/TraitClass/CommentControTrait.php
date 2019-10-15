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

use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 评论控制器组件
 *
 * @author Administrator
 *
 */
trait CommentControTrait
{

    /**
     * 评论组件
     */
    private function commonByComment(array $data): array
    {
        $checkParam = new CheckParam($this->logic->validateDataByComment(), $data);

        $status = $checkParam->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }

        // 发表评价
        $recordconmment = $this->logic->recordConmment($data);

        if ($recordconmment === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return [
            'insert_id' => $recordconmment
        ];
    }
}