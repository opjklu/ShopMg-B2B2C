<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use Algorithm\ScoreArray;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GuessLogic;
use App\Models\Logic\Specific\OrderCommentLogic;
use Swoft\App;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 猜你喜欢
 * @Controller(perfix="/guessYouLike")
 *
 * @author Administrator
 */
class GuessYouLikeController
{

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $imageLogic;

    /**
     * @Inject()
     *
     * @var GuessLogic
     */
    private $guessLogic;

    /**
     * 方法名称
     *
     * @var array
     */
    private $data = [
        'guessLikeByTourist',
        'guessLikeByLogin'
    ];

    /**
     * 猜你喜欢
     * @RequestMapping(route="guessYouLike", method = RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function guessYouLikeByShopMGQu(Request $req): array
    {
        $userId = session()->get('user_id');

        $index = $userId ? 1 : 0;

        $data = $this->{$this->data[$index]}($req);

        $data = $this->imageLogic->getImageByArrayGoods($data);

        return AjaxReturn::sendData($data);
    }

    /**
     * 游客
     */
    private function guessLikeByTourist(Request $req): array
    {
        return $this->guessLogic->getGuessLikeGoods($req->post(), $req->getCookieParams());
    }

    /**
     * 登录用户
     */
    private function guessLikeByLogin(Request $req): array
    {
        $post = $req->post();

        $score = App::getBean(OrderCommentLogic::class)->getGoodsRecommend($post);

        if (count($score) === 0) {
            return [];
        }
        // 计算相似度
        $goods = ScoreArray::score($score['me'], $score['otherPerson']);

        if (count($goods) === 0) {
            return [];
        }

        // 筛选相似度高的
        $goods = ScoreArray::filter($goods);

        return $this->guessLogic->getGoodsByScoreCache($post, $goods);
    }
}