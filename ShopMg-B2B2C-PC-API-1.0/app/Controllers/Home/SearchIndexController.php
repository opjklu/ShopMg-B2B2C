<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\GoodsImagesLogic;
use Exception;
use Swoft\App;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller(perfix="/searchIndex")
 * 首页搜索
 *
 * @author Administrator
 */
class SearchIndexController
{

    /**
     * 搜索类型
     *
     * @var array
     */
    private $searchType = [
        'App\\Models\\Logic\\GoodsLogic', // 宝贝
        'App\\Models\\Logic\\StoreLogic' // 店铺
    ];

    /**
     * 回调方法
     *
     * @var array
     */
    private $callBack = [
        'parseGoodsImage',
        'parseStoreImage'
    ];

    /**
     * 搜索验证
     *
     * @var array
     */
    private $searchValidate = [
        'title' => [
            'specialCharFilter' => '搜索内容必须是中英文及数字下划线空格的组合'
        ]
    ];

    /**
     * 搜索
     * @RequestMapping(route="search", method=RequestMethod::POST)
     * @Number(name="type", min=0)
     * @Number(name="page", min=1)
     */
    public function searchByShopMGBp(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->searchValidate, $post);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        try {

            $logic = App::getBean($this->searchType[$post['type']]);

            $data = $logic->searchByIndexHome($post);

            if (0 === count($data['data'])) {
                return AjaxReturn::error('暂无数据');
            }

            $method = $this->callBack[$post['type']];

            $data['data'] = $this->$method($data['data']);

            return AjaxReturn::sendData($data);
        } catch (Exception $e) {
            return AjaxReturn::error($e->getMessage());
        }
    }

    /**
     * 回调方法
     *
     * @return array
     */
    private function parseGoodsImage(array $data): array
    {
        $data = App::getBean(GoodsImagesLogic::class)->getImageByArrayGoods($data);

        return $data;
    }

    private function parseStoreImage(array $data): array
    {
        return $data;
    }
}