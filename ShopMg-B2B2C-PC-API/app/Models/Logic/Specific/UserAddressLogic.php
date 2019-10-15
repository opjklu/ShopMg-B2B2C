<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\UserAddress;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 用户收货逻辑处理层
 * @Bean()
 */
class UserAddressLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = 'mg_user_address';
    }

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
        return UserAddress::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [
            UserAddress::$realname
        ];
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
            UserAddress::$realname
        ];
    }

    /**
     *
     * @name 新增或者编辑收货地址验证规则
     *
     *
     */
    public function getRuleByAddEditAddress()
    {
        $message = [
            'realname' => [
                'required' => '请输入收货人姓名',
                'specialCharFilter' => '收货人姓名不正确'
            ],
            'mobile' => [
                'required' => '请输入手机号',
                'specialCharFilter' => '手机号不正确'
            ],
            'prov' => [
                'required' => '请选择省份',
                'specialCharFilter' => '省份选择不正确'
            ],
            'city' => [
                'required' => '请选择城市',
                'specialCharFilter' => '城市选择不正确'
            ],
            'dist' => [
                'required' => '请选择街道'
            ],
            'address' => [
                'required' => '请输入详细地址'
            ],
            'status' => [
                'required' => '请选择是否为默认',
                'specialCharFilter' => '参数不正确'
            ]
        ];
        return $message;
    }

    /**
     *
     * @name 添加收货地址
     */
    public function addAddress(array $post): bool
    {
        Db::beginTransaction();

        if ($post['status'] === '1') {

            $where['user_id'] = session()->get('user_id');

            $where['status'] = 1;

            $ret = $this->getQueryBuilderProxy()
                ->condition($where)
                ->save([
                    'status' => 0,
                    'update_time' => time()
                ]);
            if (!$this->traceStation($ret)) {
                return false;
            }
        }
        $ret = $this->addData($post);

        if (!$this->traceStation($ret)) {
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $insert['user_id'] = session()->get('user_id');

        $time = time();

        $insert['create_time'] = $time;

        $insert['type'] = 0;

        $insert['update_time'] = $time;

        return $insert;
    }

    /**
     *
     * @name 修改收货地址
     *
     */
    public function editAddress(array $post)
    {
        Db::beginTransaction();

        if ($post['status'] === '1') {

            $where['user_id'] = session()->get('user_id');
            $where['status'] = 1;
            $ret = $this->getQueryBuilderProxy()
                ->condition($where)
                ->save([
                    'status' => 0,
                    'update_time' => time()
                ]);
            if (!$this->traceStation($ret)) {
                return false;
            }
        }

        $ret = $this->saveData($post);

        if (!$this->traceStation($ret)) {
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 保存时处理参数
     *
     * @return array
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $update['update_time'] = time();

        return $update;
    }

    /**
     *
     * @name 收货地址列表验证规则
     * @author 田利屏
     */
    public function getRuleByAddressLists()
    {
        $message = [
            'page' => [
                'required' => '参数不正确',
                'specialCharFilter' => '参数不正确'
            ]
        ];
        return $message;
    }

    // 收货地址列表
    public function getAddressLists(): array
    {
        $where = [];

        $where['user_id'] = \Swoft\App::getBean('sessionManager')->getSession()->get('user_id');
        $where['type'] = 0;
        $field = 'id,realname,mobile,prov,city,dist,address,status';
        return $this->getQueryBuilderProxy()
            ->field($field)
            ->condition($where)
            ->order('status', 'DESC')
            ->select();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getWhereByFindOne()
     */
    protected function getWhereByFindOne(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getWhereBySaveAndDelete()
     */
    protected function getWhereBySaveAndDelete(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }

    /**
     *
     * @name 设置默认收货地址
     */
    public function setAddressDefault(array $post): bool
    {
        Db::beginTransaction();

        $time = time();

        $userId = session()->get('user_id');

        $res = $this->getQueryBuilderProxy()
            ->condition([
                'user_id' => $userId,
                'status' => 1
            ])
            ->save([
                'status' => 0,
                'update_time' => $time
            ]);

        $res = $this->getQueryBuilderProxy()
            ->condition([
                'id' => $post['id'],
                'user_id' => $userId
            ])
            ->save([
                'status' => 1,
                'update_time' => $time
            ]);

        if (!$this->traceStation($res)) {
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     *
     * @name 查看默认收货地址
     * @author 米糕网络团队
     */
    public function getDefaultAddress(): array
    {
        $session = \Swoft\App::getBean('sessionManager')->getSession();

        $where = [];

        $where['user_id'] = $session->get('user_id');
        $where['status'] = 1;
        $field = 'id,realname,mobile,prov,city,dist,address,status';

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->condition($where)
            ->find();
    }

    /**
     * 获取地区ids
     *
     * @param array $areaData
     * @return array
     */
    public function getAreaIds(array $areaData): array
    {
        return array_merge(array_column($areaData, 'prov'), array_column($areaData, 'city'), array_column($areaData, 'dist'));
    }

    /**
     * 获取收货地址
     */
    public function getAddressByOrder(array $post, string $splitKey): array
    {
        $field = $this->getTableColum();

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where(UserAddress::$id, $post[$splitKey])
            ->find();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            UserAddress::$id,
            UserAddress::$realname,
            UserAddress::$city,
            UserAddress::$prov,
            UserAddress::$dist,
            UserAddress::$address,
            UserAddress::$mobile,
            UserAddress::$status
        ];
    }
}
