<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\GETConfigTrait;
use App\Models\Logic\Specific\UploadImageLogic;
use Swoft\App;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Tool\CURL;
use Validate\CheckParam;

/**
 * @Controller(prefix="/uploadImage")
 *
 * @author Administrator
 */
class UploadImageController
{

    use GETConfigTrait;

    /**
     * @Inject()
     *
     * @var UploadImageLogic
     */
    private $logic;

    /**
     * 上传企业相关图片
     * @RequestMapping(route="uploadImage", method=RequestMethod::POST)
     */
    public function uploadImageByShopMGNd(Request $req): array
    {
        $file = $req->file();

        if (!isset($file['adv_content'])) {
            return AjaxReturn::error('请上传图片');
        }

        $fileArray = $file['adv_content']->toArray();

        $checkObj = new CheckParam($this->logic->getMessageByPic(), $fileArray);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $config = $this->getGroupConfig('enter_upload_config');

        if (0 === count($config)) {
            return AjaxReturn::error('无法获取上传配置');
        }

        if (!$this->logic->checkImageWidthAndHeight($config, $fileArray)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $curlFile = new CURL($fileArray, App::getBean('config')->get('create_enter_image'));

        $file = $curlFile->uploadFile();

        return json_decode($file, true);
    }

    /**
     * 删除企业相关图片
     * @RequestMapping(route="delPic", method=RequestMethod::POST)
     */
    public function delPicByShopMGDh(Request $req): array
    {
        $curlFile = new CURL($req->post(), config('unlink_image_no_thumb'));

        return json_decode($curlFile->deleteFile(), true);
    }
}