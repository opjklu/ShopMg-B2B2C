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

use Psr\SimpleCache\CacheInterface;
use Sms\Send\SendSmsByPhone;

/**
 * 短信验证 及其 系统配置
 */
trait SmsVerification
{

    private $error = '';

    /**
     * 注册发送验证码
     *
     * @return array
     */
    public function sendVerification(array $post, CacheInterface $cache): array
    {
        return $this->configSendSms('register_account', $post, $cache);
    }

    /**
     * 修改密码发送验证码
     *
     * @return array
     */
    public function sendVerificationByEditPassWord(array $post, CacheInterface $cache): array
    {
        return $this->configSendSms('edit_password_template', $post, $cache);
    }

    /**
     * 重要信息变更 发送短信
     */
    public function sendVerificationByInformationChange(array $post, CacheInterface $cache): array
    {
        return $this->configSendSms('intnet_change', $post, $cache);
    }

    /**
     * 配置发送短信
     *
     * @param string $key
     * @return array
     */
    private function configSendSms(string $key, array $post, CacheInterface $cache): array
    {
        $randNumber = mt_rand(100000, 999999);

        $config = $this->getGroupConfig('alipay_config');

        $cacheKey = session()->get('user_id');

        $cache->set($cacheKey . 'rand_numer', $randNumber, 120);

        $cache->set($cacheKey . 'mobile', $post['mobile'], 120);

        $param = [
            'PhoneNumbers' => $post['mobile'],
            'SignName' => $config['sign_name'],
            'TemplateCode' => $config[$key],
            'TemplateParam' => json_encode([
                'code' => $randNumber
            ], JSON_UNESCAPED_UNICODE)
        ];

        $sendSms = new SendSmsByPhone($config['access_key_id'], $config['access_key_secret'], $param);

        $res = $sendSms->sendMsg();

        $this->error = $sendSms->getError();
        return $res;
    }
}