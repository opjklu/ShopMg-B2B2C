<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsPackageCart;
use App\Models\Entity\DbGoodsPackageCart;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\ArrayChildren;
use Tool\Db;
use Tool\SessionManager;

/**
 * 加入购物车
 * @Bean()
 */
class GoodsPackageCartLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbGoodsPackageCart::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateById(): array
    {
        return [
            'id' => [
                'required' => '购物车ID必填',
                'checkStringIsNumber' => '字符串必须是以逗号为分隔符的数字'
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
        return GoodsPackageCart::class;
    }

    // 套餐购物车列表
    public function getCartGoodsList(): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                'id',
                'package_id',
                'package_num'
            ])
            ->where('user_id', session()->get('user_id'))
            ->order('create_time', 'DESC')
            ->select();
    }

    // 购物车商品数量减
    public function getCartNumReduce(array $post): bool
    {
        return $this->saveData($post) !== 0;
    }

    // 购物车商品数量(修改))
    public function getCartNumModify(array $post): bool
    {
        return $this->saveData($post) !== 0;
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

    protected function getWhereBySaveAndDelete(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }

    /**
     *
     * @param array $data
     * @return array
     */
    protected function getAddData(array $data, array $packageData, string $splitKey): array
    {
        $data = (new ArrayChildren($data))->convertIdByData(GoodsPackageCart::$packageId);

        $addCart = [];
        $i = 0;

        $time = time();

        $userId = session()->get('user_id');

        $alreadyAdd = [];

        foreach ($packageData as $key => $value) {

            if (isset($data[$value[$splitKey]])) {

                $alreadyAdd[] = $data[$value[$splitKey]][GoodsPackageCart::$id];

                continue;
            }

            $addCart[$i] = [];

            $addCart[$i][GoodsPackageCart::$packageNum] = 1;

            $addCart[$i][GoodsPackageCart::$packageId] = $value[$splitKey];

            $addCart[$i][GoodsPackageCart::$storeId] = $value['store_id'];

            $addCart[$i][GoodsPackageCart::$userId] = $userId;

            $addCart[$i][GoodsPackageCart::$createTime] = $time;

            $addCart[$i][GoodsPackageCart::$updateTime] = $time;

            $i++;
        }

        return [
            $addCart,
            $alreadyAdd
        ];
    }

    /**
     * 组合套餐加入购物车
     */
    public function addPackageToCart(array $args, array $packageData, string $splitKey): bool
    {
        $userId = session()->get('user_id');

        $field = [
            GoodsPackageCart::$id,
            GoodsPackageCart::$packageId,
            GoodsPackageCart::$packageNum
        ];

        $goodsCartData = $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn(GoodsPackageCart::$packageId, $args['id'])
            ->where(GoodsPackageCart::$userId, $userId)
            ->select();

        $receiveGroupData = $this->getAddData($goodsCartData, $packageData, $splitKey);

        list ($addCart, $alreadyData) = $receiveGroupData;

        Db::beginTransaction();

        try {

            if (count($alreadyData)) {

                $sql = $this->buildUpdateSql($alreadyData);

                $result = Db::query($sql)->getResult('items');
            }

            if (count($addCart)) {

                $result = $this->getQueryBuilderProxy()->addAll($addCart);
            }

            if (!$this->traceStation($result)) {
                return false;
            }

            Db::commit();

            return true;
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();

            Db::rollback();

            return false;
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getDataToBeUpdated()
     */
    protected function getDataToBeUpdated(array $data): array
    {
        $save = [];

        $time = time();

        foreach ($data as $key => $value) {
            $save[$value][] = GoodsPackageCart::$packageNum . ' + 1';

            $save[$value][] = $time;
        }

        return $save;
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
            GoodsPackageCart::$packageNum,
            GoodsPackageCart::$updateTime
        ];
    }

    /**
     * 获取套餐购物车信息用于购买
     *
     * @return array
     */
    public function getPackageInfoByCart(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn(GoodsPackageCart::$id, explode(',', $post['id']))
            ->where('user_id', session()->get('user_id'))
            ->select();
    }
    
    /**
     * 删除套餐购物车
     * @return bool
     */
    public function getCartGoodsDel(array $post):int
    { 
        return $this->getQueryBuilderProxy()
            ->whereIn('id', explode(',', $post['id']))
            ->where('user_id', session()->get('user_id'))
            ->delete();
    }
    
    /**
     * 创建订单删除购物车
     *
     * @return bool
     */
    public function deletePackageCart(): bool
    {
        $packageCart = SessionManager::GET_GOODS_DATA_SOURCE();

        $idString = array_column($packageCart, 'id');

        try {
            $status = $this->getQueryBuilderProxy()
                ->whereIn(GoodsPackageCart::$id, $idString)
                ->delete();

            if (!$this->traceStation($status)) {
                $this->errorMessage = '删除购物车失败';
                return false;
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            $this->errorMessage = '删除购物车失败';
            return false;
        }
    }

    /**
     * 套餐关联字段
     *
     * @return string
     */
    public function getSplitKeyByPackage(): string
    {
        return GoodsPackageCart::$packageId;
    }

    public function getSplitKeyByStore()
    {
        return GoodsPackageCart::$storeId;
    }

    /**
     * 删除购物车
     *
     * @param array $post
     * @return bool
     */
    public function toDelOrder(array $post): bool
    {
        return $this->delete($post);
    }
}
