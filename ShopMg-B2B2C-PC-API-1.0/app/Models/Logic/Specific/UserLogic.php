<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\User;
use App\Models\Entity\DbUser;
use App\Models\Entity\DbUserHeader;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\ParamsParse;
use Validate\Children\CheckEmail;
use Validate\Children\CheckTelphone;

/**
 * 用户逻辑处理层
 * @Bean()
 */
class UserLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    /**
     *
     * @return the $cache
     */
    public function getCache()
    {
        return $this->cache;
    }


    public function __construct()
    {
        $this->tableName = DbUser::class;
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
        return User::class;
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

    /**
     * 身份认证验证
     *
     * @return array
     */
    public function getValidateByIdCard(): array
    {
        return [
            'card_positive' => [
                'required' => '请上传身份证正面'
            ],

            'card_side' => [
                'required' => '请上传身份证反面'
            ],

            'person_name' => [
                'rquired' => '请填写真实姓名',
                'checkChineseAndEnglish' => '请输入中文或英文名字'
            ]
        ];
    }

    /**
     * 身份认证
     *
     * @return bool
     */
    public function authentication(array $post): bool
    {
        $res = false;

        try {

            $post['update_time'] = time();

            $res = $this->getQueryBuilderProxy()
                ->where('id', session()->get('user_id'))
                ->save($post);
        } catch (\Exception $e) {

            $this->errorMessage = $e->getMessage();

            return false;
        }
        return $res !== false;
    }

    /**
     * 用户登录逻辑
     */
    public function userLogin(array $post): bool
    {
        // 因为这里是多种情况登录 所以分开检测
        $checkTelObj = new CheckTelphone($post);

        $isPhone = $checkTelObj->check('account');

        $checkEmail = new CheckEmail($post);

        $isEmail = $checkEmail->check('account');

        if ((!$isEmail || !$isPhone) && !$post['account']) {
            $this->errorMessage = '用户名或者密码不正确';
            return false;
        }

        $field = [
            User::$id,
            User::$userName,
            User::$password,
            User::$mobile
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->orWhere(User::$mobile, $post['account'])
            ->orWhere(User::$userName, $post['account'])
            ->orWhere(User::$email, $post['account'])
            ->find();
        if (empty($data)) {
            $this->errorMessage = '用户名或者密码不正确';
            return false;
        }

        if (($data[User::$password]) !== md5($post[User::$password])) {
            $this->errorMessage = '用户名或者密码不正确';
            return false;
        }
        session()->put('user_id', $data[User::$id]);
        session()->put('user_name', $data[User::$userName]);
        session()->put('mobile', $data[User::$mobile]);
        // 更新最后登录时间
        $this->getQueryBuilderProxy()
            ->where(User::$id, $data[User::$id])
            ->save([
                User::$lastLogon_time => time()
            ]);
        return true;
    }

    /**
     * 注册发送验证码验证规则
     */
    public function getRuleByRegSendSms()
    {
        return [
            User::$mobile => [
                'required' => '请输入手机号码',
                'checkMobile' => '手机号码不能输入特殊字符'
            ]
        ];
    }

    /**
     * 检测用户是否已经注册
     */
    public function checkUserMobileIsExits(array $post): bool
    {
        return count($this->getUserId($post)) === 0;
    }

    /**
     * 获取用户id
     *
     * @return array
     */
    protected function getUserId(array $data): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                User::$id
            ])
            ->where('mobile', $data['mobile'])
            ->find();
    }

    /**
     * 用户注册验证规则
     *
     * @author 米糕网络团队
     */
    public function getRuleByMobileRegister()
    {
        return [
            User::$mobile => [
                'required' => '请输入手机号码',
                'specialCharFilter' => '手机号码不能输入特殊字符'
            ],
            'verify' => [
                'required' => '请输入短信验证码',
                'specialCharFilter' => '短信验证码不能输入特殊字符'
            ],
            'code' => [
                'required' => '请输入图形验证码',
                'specialCharFilter' => '图形验证码不能输入特殊字符'
            ],
            'email' => [
                'required' => '请输入邮箱',
                'checkEmail' => '请输入正确的邮箱'
            ]
        ];
    }

    /**
     *
     * 账户注册
     *
     * @author 米糕网络团队
     */
    public function userAccountRegister(array $post): array
    {
        if ($post['password'] != $post['repassword']) {
            return array(
                'status' => 0,
                'message' => '密码不一致',
                'data' => ''
            );
        }
        $verify = $post['code'];

        $rand_numer = $this->cache->get('rand_numer');

        if ($verify !== $rand_numer) {
            return array(
                'status' => 0,
                'message' => '手机号验证码错误',
                'data' => ''
            );
        }

        $res = $this->addData($post);

        if (!$res) {
            return array(
                'status' => 0,
                'message' => $this->errorMessage,
                'data' => ''
            );
        }
        return array(
            'status' => 1,
            'message' => '注册成功',
            'data' => ''
        );
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $time = time();

        return array(
            'user_name' => $insert['user_name'],
            'mobile' => $insert['mobile'],
            'email' => $insert['email'],
            'password' => md5($insert['password']),
            'create_time' => $time,
            'update_time' => $time
        );
    }

    /**
     * 用户注册验证规则
     */
    public function getRuleByAccountRegister()
    {
        $message = [
            'user_name' => [
                'required' => '请输入用户名',
                'specialCharFilter' => '用户名不能输入特殊字符'
            ],
            'email' => [
                'required' => '请输入邮箱'
            ],
            'password' => [
                'required' => '请输入密码'
            ],
            'repassword' => [
                'required' => '请确认密码'
            ],
            'code' => [
                'required' => '请输入手机验证码',
                'specialCharFilter' => '手机验证码不能输入特殊字符'
            ]
        ];
        return $message;
    }

    /**
     * 用户短信登录-发送短信 验证规则
     */
    public function getRuleBySendSmsLogin()
    {
        $message = [
            User::$mobile => [
                'number' => '请输入手机号码'
            ],
            'verify' => [
                'number' => '请输入短信验证码'
            ]
        ];
        return $message;
    }

    /**
     * 短信登录逻辑
     */
    public function smsUserLogin(array $post): bool
    {
        if ($this->cache->get('rand_numer') != $post['verify']) {
            $this->errorMessage = '手机验证码不正确';
            return false;
        }

        if ($post['mobile'] != $this->cache->get('mobile')) {
            $this->errorMessage = '手机号码与接收验证码手机不匹配';
            return false;
        }

        $field = [
            User::$id,
            User::$userName,
            User::$mobile
        ];

        $findUserDetails = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(User::$mobile, $post['mobile'])
            ->find();
        if (0 === count($findUserDetails)) {

            $this->errorMessage = '没有找到用户数据';
            return false;
        }

        session()->put('user_id', $findUserDetails[User::$id]);
        session()->put('user_name', $findUserDetails[User::$userName]);
        session()->put('mobile', $findUserDetails[User::$mobile]);

        // 更新最后登录时间
        $this->getQueryBuilderProxy()
            ->where('id', $findUserDetails[User::$id])
            ->save([
                User::$lastLogon_time => time()
            ]);
        return true;
    }

    /**
     * 第三方登录验证规则
     */
    public function getRuleByOtherLogin()
    {
        $message = [
            'type' => [
                'required' => '请输入登录类型',
                'specialCharFilter' => '登录类型不能输入特殊字符'
            ],
            'third_account' => [
                'required' => '请输入要登录的账号',
                'specialCharFilter' => '登录的账号不能输入特殊字符'
            ]
        ];
        return $message;
    }

    /**
     *
     * @name 第三方账号绑定验证规则
     *
     *       第三方账号绑定验证规则
     *
     */
    public function getRuleBybindOther()
    {
        $message = [
            'type' => [
                'required' => '请输入登录类型',
                'specialCharFilter' => '登录类型不能输入特殊字符'
            ],
            'third_account' => [
                'required' => '请输入第三方登录账号',
                'specialCharFilter' => '登录的账号不能输入特殊字符'
            ],
            'account' => [
                'required' => '请输入要绑定的手机号',
                'specialCharFilter' => '手机号不能输入特殊字符'
            ],
            'password' => [
                'required' => '请输入密码'
            ]
        ];
        return $message;
    }

    /**
     * 找回密码验证规则
     */
    public function getRuleByBackPwd()
    {
        $message = [
            User::$mobile => [
                'required' => '请输入手机号码',
                'specialCharFilter' => '手机号码不能输入特殊字符'
            ],
            'verify' => [
                'required' => '请输入短信验证码',
                'specialCharFilter' => '短信验证码不能输入特殊字符'
            ],
            'password' => [
                'required' => '请输入密码'
            ],
            're_password' => [
                'required' => '请输入确认密码'
            ]
        ];
        return $message;
    }

    /**
     * 找回密码逻辑
     */
    public function backUserPwd(array $data)
    {
        if ($data['password'] !== $data['re_password']) {
            $this->errorMessage = '两次密码设置不一致';
            return [];
        }

        $randNumber = $this->cache->get('rand_numer');

        if ($randNumber !== $data['verify']) {
            $this->errorMessage = '手机验证码不正确或已过期';
            return false;
        }

        $mobile = $this->cache->get('mobile');

        if ($data['mobile'] !== $mobile) {
            $this->errorMessage = '手机号码与接收验证码手机不匹配';
            return false;
        }

        $field = [
            User::$id
        ];
        // #TODO 查询有没有该账号
        $result = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(User::$mobile, $mobile)
            ->find();

        if (0 === count($result)) {
            $this->errorMessage = '手机号不正确';
            return false;
        }
        // #TODO 修改用户的密码

        $ret = $this->getQueryBuilderProxy()
            ->where(User::$id, $result[User::$id])
            ->save([
                'password' => md5($data['re_password'])
            ]);

        if (!$ret) {
            $this->errorMessage = '找回失败，请重试!';
            return false;
        }

        return true;
    }

    /**
     * 获取个人信息逻辑
     */
    public function getUserInfo(): array
    {
        $userId = session()->get('user_id');

        $userData = $this->getQueryBuilderProxy()
            ->field([
                User::$userName,
                User::$birthday,
                User::$email,
                User::$nickName,
                User::$lastLogon_time,
                User::$mobile
            ])
            ->where(User::$id, $userId)
            ->find();

        if (!$userData) {
            return [];
        }

        $header = DbUserHeader::findOne([
            'user_id' => $userId
        ], [
            'column' => [
                'user_header'
            ]
        ])->getResult([
            'items'
        ]);

        if ($header) {
            $userData['user_header'] = $header->getuserHeader();
        }

        $birthday = (int)$userData['birthday'];

        $userData['year'] = date("Y", $birthday);
        $userData['month'] = date("m", $birthday);
        $userData['day'] = date("d", $birthday);
        return $userData;
    }

    /**
     * 修改密码验证规则
     */
    public function getRuleByModifyPassword()
    {
        $message = [
            'password' => [
                'required' => '请输入原密码'
            ],
            'new_password1' => [
                'required' => '请输入新密码'
            ],
            'new_password2' => [
                'required' => '请输入确认密码'
            ]
        ];
        return $message;
    }

    /**
     * 修改个人资料验证规则
     */
    public function getRuleByEditUserInfo(): array
    {
        return [
            'nick_name' => [
                'required' => '请输入昵称',
                'checkChineseAndEnglish' => '昵称必须是字符或数字或中文'
            ],
            'birthday' => [
                'number' => '生日必须时数字'
            ]
        ];
    }

    /**
     *
     * @return int
     */
    public function editUserInfo(array $post): int
    {
        $post['id'] = session()->get('user_id');

        return $this->saveData($post);
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
     * 修改手机号验证规则
     */
    public function getRuleByEditMobile()
    {
        return [
            User::$mobile => [
                'required' => '请输入手机号码',
                'specialCharFilter' => '手机号码不能输入特殊字符'
            ],
            'verify' => [
                'required' => '请输入短信验证码',
                'specialCharFilter' => '短信验证码不能输入特殊字符'
            ]
        ];
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
            User::$email,
            User::$userName
        ];
    }

    public function getUserIntegral()
    {
        $where['id'] = session('user_id');
        $field = "integral";
        return $this->getQueryBuilderProxy()
            ->where($where)
            ->field($field)
            ->find();
    }

    /**
     * 根据评论获取用户信息
     *
     * @param array $data
     * @param string $splitKeys
     * @return array|array
     */
    public function getNameByComment(array $dataSources, string $splitKey)
    {
        $field = [
            User::$id,
            User::$nickName
        ];

        $paramEntity = new ParamsParse($dataSources, $field, User::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }
}
