<?php

namespace App\Models\Logic\Specific;

use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class UploadImageLogic
{

    private $errorMessage = '';

    /**
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * 上传图片验证
     *
     * @return []
     */
    public function getMessageByPic()
    {
        $message = [
            'tmp_name' => [
                'checkIsPicture' => '请上传图片'
            ]
        ];
        return $message;
    }

    /**
     * 验证图片宽高度
     *
     * @return bool
     */
    public function checkImageWidthAndHeight(array $config, array $file): bool
    {
        $header_min_width = $config['enter_min_width'];

        $header_max_width = $config['enter_max_width'];

        $header_max_height = $config['enter_max_height'];

        $header_min_height = $config['enter_min_height'];

        $imageInfo = getimagesize($file['tmp_file']);

        $width = $imageInfo[0];

        $height = $imageInfo[1];

        if ($width > $header_max_width || $width < $header_min_width) {

            $this->errorMessage = '宽度必须介于' . $header_min_width . '~' . $header_max_width . '之间，此图宽度' . $width;

            return false;
        }

        if ($height > $header_max_height || $width < $header_min_height) {

            $this->errorMessage = '高度必须介于' . $header_min_height . '~' . $header_max_height . '之间，此图高度' . $height;

            return false;
        }
        return true;
    }
}
