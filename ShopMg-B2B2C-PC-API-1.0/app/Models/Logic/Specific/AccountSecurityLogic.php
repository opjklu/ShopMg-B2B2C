<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\User;
use App\Models\Entity\DbUser;
use App\Models\Logic\AbstractLogic;
use PHPMailer\PHPMailer\PHPMailer;
use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Swoft\Core\Config;
use Tool\Verify;
use Validate\Children\CheckTelphone;

/**
 * 个人资料
 * 逻辑处理层
 * @Bean()
 */
class AccountSecurityLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    private  $editUserPassword = [
        // 密码验证修改密码
        'loginCheckPasswod',
        // 手机验证
        'phoneCheck'
    ];

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

    /*
     * 生成验证码
     */
    public function verify(): string
    {
        $config = [
            'fontSize' => 19, // 验证码字体大小
            'length' => 4, // 验证码位数
            'imageH' => 34
        ];
        $Verify = new Verify($config);

        ob_start();

        $Verify->entry();

        return ob_get_clean();
    }

    /**
     * 验证数据
     */
    public function getValidateByEditMobile(): array
    {
        return [
            'mobile' => [
                'required' => '请输入手机号',
                'checkMobile' => '请输入正确的手机号'
            ],
            'vertify' => [
                'required' => '请上传图形验证码',
                'combinationOfDigitalEnglish' => '验证码必须是数字及其英文的组合'
            ],
            'phone_code' => [
                'number' => '请填写手机验证码'
            ]
        ];
    }

    /*
     * 短信验证码
     */
    public function getShortMassageVerification(array $post): bool
    {
        if ($post['mobile'] !== $this->cache->get('mobile')) {

            $this->errorMessage = '手机号与发送验证码的手机号不一致';

            return false;
        }

        if ($this->cache->get('rand_numer') !== $post['phone_code']) {

            $this->errorMessage = '手机验证码已过期或填写错误';

            return false;
        }

        $vertify = new Verify();

        if (!$vertify->check($post['vertify'])) {
            $this->errorMessage = '验证码不正确';
            return false;
        }

        return true;
    }

    /*
     * 短信验证码
     * @param int sign 1 绑定手机 2修改绑定手机
     */
    public function getShortMassageVerif(array $post)
    {
        if (!$this->getShortMassageVerification($post)) {
            return false;
        }
        try {
            $newpassword = $this->getQueryBuilderProxy()
                ->where(User::$id, session()->get('user_id'))
                ->save([
                    User::$mobile => $post['mobile']
                ]);

            if (!$newpassword) {

                $this->errorMessage = '修改密码失败';

                return false;
            }
        } catch (\Exception $e) {

            $this->errorMessage = '手机号已存在';
            return false;
        }
        return true;
    }

    /**
     * 新密码
     * @param array $data
     * @return bool
     */
    public function newPassword(array $data): int
    {
        return $this->getQueryBuilderProxy()
            ->where('id', session()->get('user_id'))
            ->save(['password' => $data['newpassword'], 'update_time' => time()]);
    }

    /*
     * 发送邮件
     */
    public function addmailbox(array $post)
    {
        $address = $post['email'];

        $very = rand(1234567, 9999999); // 获取随机验证码
        $content = '邮箱验证码是' . $very . '此验证码90秒有效!';

        /**
         *
         * @var Config
         */
        $config = \Swoft\App::getBean('config');

        $success = false;

        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = $config->get('MAIL_HOST'); // Specify main and backup SMTP servers
            $mail->SMTPAuth = $config->get('MAIL_SMTPAUTH'); // Enable SMTP authentication
            $mail->Username = $config->get('MAIL_USERNAME'); // SMTP username
            $mail->Password = $config->get('MAIL_PASSWORD'); // SMTP password
            $mail->SMTPSecure = $config->get('MAIL_SMTPSECURE'); // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $config->get('MAIL_PORT'); // TCP port to connect to

            // Recipients
            $mail->setFrom($config->get('MAIL_FROM'), $config->get('MAIL_FROMNAME'));
            $mail->addAddress($address); // Name is optional

            $mail->CharSet = 'UTF-8';

            // Attachments
            // Content
            $mail->isHTML($config->get('MAIL_ISHTML')); // Set email format to HTML
            $mail->Subject = $config->get('MAIL_SUBJECT');
            $mail->Body = $content;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $success = $mail->send();
        } catch (\Exception $e) {

            return [
                'data' => [],
                'status' => 0,
                'message' => $e->getMessage()
            ];
        }

        if ($success === true) {

            $key = session()->get('user_id');

            $cahe = &$this->cache;

            $cahe->set($key . 'reg_email_code', $very, 90);

            $cahe->set($key . 'email', $address, 90);

            return [
                'data' => [],
                'status' => 1,
                'message' => '发送成功'
            ];
        }

        return [
            'data' => [],
            'status' => 0,
            'message' => '发送失败'
        ];
    }

    /*
     * 验证邮件
     */
    public function checkEmail(array $post)
    {
        $code = $post['code'];

        $userId = session()->get('user_id');

        $cache = &$this->cache;

        $email_code = $cache->get($userId . 'reg_email_code');

        if ($code != $email_code) {
            return [
                'data' => [],
                'status' => 0,
                'message' => '验证失败或验证码已过期'
            ];
        }

        $email = $cache->get($userId . 'email');

        if (!$email) {
            return [
                'data' => [],
                'status' => 0,
                'message' => '邮箱数据已过期请在90秒内完成，谢谢'
            ];
        }

        $res = $this->getQueryBuilderProxy()
            ->where('id', $userId)
            ->save([
                'email' => $email
            ]);

        if (!$res) {
            return [
                'data' => [],
                'status' => 0,
                'message' => '修改失败'
            ];
        }
        return [
            'data' => [],
            'status' => 1,
            'message' => '修改成功'
        ];
    }

    /**
     * 修改密码
     * @param array $data
     * @return bool
     */
    public function editUpdatePassword(array $data): bool
    {
        $method = $this->editUserPassword[$data['type']];

        try {

            $status = $this->$method($data);

            return $status;
        } catch (\Exception $e) {

            $this->errorMessage = $e->getMessage();

            return false;
        }
    }

    /**
     * 密码验证修改密码
     *
     * @return bool
     */
    protected function loginCheckPasswod(array $data): bool
    {
        if (!isset($data['password'])) {
            $this->errorMessage = '原密码必须传递密码';
            return false;
        }

        if (!isset($data['vertify'])) {
            $this->errorMessage = '验证码必须传递';
            return false;
        }

        $vertify = new Verify();

        if (!$vertify->check($data['vertify'])) {
            $this->errorMessage = '验证码不正确';
            return false;
        }

        if (md5($data['password']) !== $this->getPassWordByUser()) {
            $this->errorMessage = '密码不正确';
            return false;
        }
        return true;
    }

    /**
     * 获取密码
     *
     * @return string
     */
    private function getPassWordByUser(): string
    {
        return $this->getQueryBuilderProxy()
            ->where(User::$id . '=:u_id')
            ->bind([
                ':u_id' => session()->get('user_id')
            ])
            ->getField(User::$password)[User::$password];
    }

    /**
     * 密码验证修改密码
     *
     * @return bool
     */
    protected function phoneCheck(array $data): bool
    {
        if (!isset($data['phone_code']) || !isset($data['mobile']) || session()->get('rand_numer') != $data['phone_code'] || session()->get('mobile') !== $data['mobile']) {
            $this->errorMessage = '验证码不正确';
            return false;
        }

        session()->remove('rand_numer');
        session()->remove('phone_code');

        return true;
    }

    /**
     * 验证手机
     *
     * @return array
     */
    public function getValidatePhone(): array
    {
        return [
            'mobile' => [
                'required' => '手机号必填',
                'checkMobile' => '必须是正确的手机号码'
            ]
        ];
    }
}
