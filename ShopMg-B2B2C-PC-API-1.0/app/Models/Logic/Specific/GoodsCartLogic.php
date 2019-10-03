<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsCart;
use App\Common\FieldMapping\User;
use App\Common\TraitClass\SmsVerification;
use App\Models\Entity\DbGoodsCart;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\ArrayChildren;
use Tool\Db;

/**
 * 加入购物车
 * @Bean()
 */
class GoodsCartLogic extends AbstractLogic
{
    use SmsVerification;

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    /**
     * 购物车临时数据
     *
     * @var array
     */
    private $resultTmp = [];

    /**
     * 要更新的购物车数据
     *
     * @var array
     */
    private $alreadyGoods = [];

    /**
     * 要添加的购物车数据
     *
     * @var array
     */
    private $addGoodsCart = [];

    /**
     * 获取缓存管理
     *
     * @return \Swoft\Cache\Cache
     */
    public function getCacheManager()
    {
        return $this->cache;
    }


    public function __construct()
    {
        //
        //

        // $this->getQueryBuilderProxy() = Base::getInstance('GoodsCart');
        $this->tableName = DbGoodsCart::class;
    }

    /**
     * 返回验证数据
     */
    public function getMessageNotice()
    {
        return [
            'goods_id' => [
                'number' => '必须是数字'
            ],
            'goods_num' => [
                'number' => '商品数量必须是数字'
            ],
            'price_new' => [
                'number' => '商品价格必须是数字'
            ],

            'store_id' => [
                'required' => '必须传入商铺ID',
                'number' => '商铺ID必须是数字'
            ]
        ];
    }

    public function getCartIdValidate()
    {
        return [
            'id' => [
                'required' => 'id必传',
                'checkStringIsNumber' => '购物车Id参数必须是以逗号间隔的数字'
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
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return GoodsCart::class;
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
            User::$userName
        ];
    }

    public function getConfigs()
    {
        $this->getConfig("integrat_price_exchange");
    }

    public function getGoodsCount()
    {
        $userId = session('user_id');
        $count['cartGoodsCount'] = $this->getQueryBuilderProxy()->getCounts($userId);
        return $count;
    }

    /**
     * 获取购物车列表
     */
    public function getCartGoodsList()
    {
        $field = [
            'id',
            'goods_id',
            'goods_num',
            'attribute_id',
            'price_new',
            'store_id'
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where('user_id', session()->get('user_id'))
            ->order('create_time', 'DESC')
            ->select();
    }

    /**
     * 获取购物车列表
     */
    public function getCartGoodsListByUser()
    {
        $userId = session()->get('user_id');
        $where['user_id'] = $userId;
        $where['is_del'] = 0;
        $this->searchField = 'id,goods_id,goods_num,attribute_id,price_new,store_id';
        $retData = parent::getNoPageList();
        return $retData;
    }

    public function addCart(array $goodsData): bool
    {
        $userId = session()->get('user_id');

        $where = [
            'user_id' => $userId,
            'goods_id' => $goodsData['id']
        ];

        $cart = $this->getQueryBuilderProxy()
            ->field([
                'id',
                'goods_num'
            ])
            ->condition($where)
            ->find();

        if (0 === count($cart)) {

            $goodsData['user_id'] = $userId;

            $res = $this->addData($goodsData);
        } else {

            $cart['goods_num'] = $goodsData['goods_num'] + $cart['goods_num'];

            $res = $this->saveData($cart);
        }

        return $res !== false;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResult()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $time = time();
        $data = [
            'create_time' => $time,
            'update_time' => $time,
            'goods_id' => $insert['id'],
            'goods_num' => $insert['goods_num'],
            'price_new' => $insert['price_member'],
            'store_id' => $insert['store_id'],
            'user_id' => $insert['user_id']
        ];
        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $update['update_time'] = time();

        return $update;
    }

    /**
     * 删除购物车商品
     */
    public function delGoodsCart(array $data)
    {
        $where = [];

        $where['id'] = $data['id'];

        $where['user_id'] = session()->get('user_id');

        $result = $this->getQueryBuilderProxy()
            ->condition($where)
            ->delete();

        return $result;
    }

    /**
     * 单个购物车移入收藏夹 删除购物车
     *
     * @param array $post
     * @return bool
     */
    public function delGoodsCartOneByTrancestation(array $post): bool
    {
        $status = $this->deleteCart($post);

        if (!$this->traceStation($status)) {
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 多个购物车移入收藏夹删除购物车商品
     */
    public function delManyGoodsCartsTrancsation(array $data): bool
    {
        $status = $this->delManyGoodsCarts($data);

        if (!$this->traceStation($status)) {
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 删除购物车商品
     */
    public function delManyGoodsCarts(array $data)
    {
        $userId = session()->get('user_id');

        return $this->getQueryBuilderProxy()
            ->whereIn('id', explode(',', $data['id']))
            ->where('user_id', $userId)
            ->delete();
    }

    // 购物车商品数量(修改))
    public function getCartNumModify(array $post)
    {
        return $this->getQueryBuilderProxy()
            ->condition([
                'id' => $post['id'],
                'user_id' => session()->get('user_id')
            ])
            ->save([
                'goods_num' => $post['num']
            ]);
    }

    /**
     * 删除购物车数据(购物车生成订单时)
     */
    public function deleteCartByTrans(array $cartId): bool
    {
        $status = $this->deleteCart($cartId);

        if (!$this->traceStation($status)) {
            $this->errorMessage .= '、删除购物车失败';
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 删除购物车(购物车生成订单时)
     *
     * @return boolean
     */
    public function deleteCart(array $cartId)
    {
        try {
            $status = $this->getQueryBuilderProxy()
                ->whereIn(GoodsCart::$id, $cartId)
                ->delete();
        } catch (\Exception $e) {
            $this->errorMessage .= $e->getMessage();
            return false;
        }

        if ($status === false) {
            $this->errorMessage .= '、删除购物车失败';
            return false;
        }
        return true;
    }

    /**
     * 获取购物车信息并缓存（用于购物车生成订单0）
     */
    public function getGoodsCartInfoCache(array $post): array
    {
        $cache = &$this->cache;

        $userId = session()->get('user_id');

        $key = $post['cartId'] . $userId . 'whate_cart';

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getGoodsCartInfo($post);

        if (0 === count($data)) {
            $this->errorMessage = '购物车异常';
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 45);

        return $data;
    }

    /**
     * 用于购物车生成订单
     */
    public function getGoodsCartInfo(array $post): array
    {
        $carryId = explode(',', $post['cartId']);

        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where('user_id', session()->get('user_id'))
            ->whereIn(GoodsCart::$id, $carryId)
            ->select();
        return $data;
    }

    public function getUserBuyCarGoodsInfo(): array
    {
        $message = [
            'cartId' => [
                'checkStringIsNumber' => '购物车必须是数字及其英文逗号的组合'
            ]
        ];
        return $message;
    }

    /**
     * 获取关联字段
     *
     * @return string
     */
    public function getSplitKeyByGoodsId(): string
    {
        return GoodsCart::$goodsId;
    }

    /**
     * 获取关联字段
     *
     * @return string
     */
    public function getSplitKeyByStoreId(): string
    {
        return GoodsCart::$storeId;
    }

    /**
     * 多个商品加入购物车
     *
     * @author 米糕网络团队
     */
    public function addCarAll(array $goods, string $splitKey): bool
    {
        $alreadyGoodsByUser = $this->getCartByGoodsIdAndUserId($goods, $splitKey);

        // 要更新的
        $cartByUpdate = [];

        // 要添加的
        $cartAdd = [];

        $alreadyGoods = [];

        $alreadyGoods = (new ArrayChildren($alreadyGoodsByUser))->convertIdByData(GoodsCart::$goodsId);

        foreach ($goods as $key => $value) {
            if (!isset($alreadyGoods[$value[$splitKey]])) {
                $cartAdd[$key] = $value;
            } else {
                $cartByUpdate[$key] = $alreadyGoods[$value[$splitKey]];
                $cartByUpdate[$key][GoodsCart::$goodsNum] = $alreadyGoods[$value[$splitKey]][GoodsCart::$goodsNum] + $value['goods_num'];
            }
        }


        Db::beginTransaction();

        // 更新数据
        if (count($cartByUpdate) !== 0) {

            $sql = $this->buildUpdateSql($cartByUpdate);
            try {

                $status = Db::query($sql)->getResult('items');
                if (!$this->traceStation($status)) {
                    return false;
                }
            } catch (\Exception $e) {
                $this->errorMessage = $e->getMessage();
                Db::rollback();
                return false;
            }
        }

        // 添加数据
        if (count($cartAdd) !== 0) {

            $addNum = $this->addAll($cartAdd);

            if (!$this->traceStation($addNum)) {
                return false;
            }
        }


        Db::commit();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAddAll()
     */
    protected function getParseResultByAddAll(array $post): array
    {
        $result = [];

        $i = 0;

        $userId = session()->get('user_id');

        $time = time();

        foreach ($post as $key => $value) {
            $result[$i][GoodsCart::$goodsId] = $value['id'];
            $result[$i][GoodsCart::$goodsNum] = $value['goods_num'];
            $result[$i][GoodsCart::$userId] = $userId;
            $result[$i][GoodsCart::$updateTime] = $time;
            $result[$i][GoodsCart::$createTime] = $time;
            $result[$i][GoodsCart::$storeId] = $value['store_id'];
            $i++;
        }
        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getColumToBeUpdated()
     */
    protected function getColumToBeUpdated(): array
    {
        return [
            GoodsCart::$goodsNum,
            GoodsCart::$updateTime
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getDataToBeUpdated()
     */
    protected function getDataToBeUpdated(array $data): array
    {
        $result = [];

        $time = time();

        foreach ($data as $key => $value) {
            $result[$value[GoodsCart::$id]][] = $value[GoodsCart::$goodsNum];
            $result[$value[GoodsCart::$id]][] = $time;
        }
        return $result;
    }

    /**
     * 根据商品和用户获取购物车数据
     */
    public function getCartByGoodsIdAndUserId(array $goods, string $splitKey): array
    {
        $idString = array_column($goods, $splitKey);

        $field = [
            GoodsCart::$id,
            GoodsCart::$goodsId,
            GoodsCart::$goodsNum
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn(GoodsCart::$goodsId, $idString)
            ->where(GoodsCart::$userId, session()->get('user_id'))
            ->getField();
    }
}
