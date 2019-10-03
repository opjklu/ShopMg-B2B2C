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

/**
 * 评论图片相关组件
 *
 * @author Administrator
 */
trait CommentComponentImgTrait
{

    /**
     *
     * @param string $insertId
     * @return bool
     */
    public function addCommentPic(array $data): bool
    {
        $status = $this->addAll($data);

        if (!$this->traceStation($status)) {

            $this->errorMessage = '添加评论图片失败';

            return false;
        }

        return true;
    }

    protected function getParseResultByAddAll(array $post): array
    {
        $temp = [];

        foreach ($post['path'] as $key => $value) {

            $temp[$key] = [
                'path' => $value,
                'comment_id' => $post['comment_id']
            ];
        }

        return $temp;
    }
}