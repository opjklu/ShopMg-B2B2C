<?php
namespace App\Models\Entity;

use Swoft\Db\Model;
use Swoft\Db\Bean\Annotation\Column;
use Swoft\Db\Bean\Annotation\Entity;
use Swoft\Db\Bean\Annotation\Id;
use Swoft\Db\Bean\Annotation\Required;
use Swoft\Db\Bean\Annotation\Table;
use Swoft\Db\Types;

/**
 * 用户授权表
 *
 * @Entity()
 * @Table(name="mg_user_auths")
 * 
 * @uses DbUserAuths
 */
class DbUserAuths extends Model
{

    /**
     *
     * @var int $createAt 创建时间
     *      @Column(name="create_at", type="integer", default=0)
     */
    private $createAt;

    /**
     *
     * @var string $credential 密码:如果是第三方登录就是第三方的access_tooken
     *      @Column(name="credential", type="string", length=255)
     */
    private $credential;

    /**
     *
     * @var int $expiresIn 第三方登录时的超期时间,本网站注册用户即为0
     *      @Column(name="expires_in", type="integer", default=0)
     */
    private $expiresIn;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $identifier 账户:如果是第三方登陆就是第三方用户唯一标识
     *      @Column(name="identifier", type="string", length=50, default="")
     */
    private $identifier;

    /**
     *
     * @var int $identityType 登录类型:0.支付宝登陆,1.qq登录2.微信登录,3.微博登录
     *      @Column(name="identity_type", type="tinyint")
     */
    private $identityType;

    /**
     *
     * @var int $local 账户登录类型:1.本地登录 0.三方登陆
     *      @Column(name="local", type="tinyint", default=1)
     */
    private $local;

    /**
     *
     * @var string $refreshToken 授权更新
     *      @Column(name="refresh_token", type="string", length=128)
     *      @Required()
     */
    private $refreshToken;

    /**
     *
     * @var string $unionid 微商城【打通一个企业对应多个公众号】
     *      @Column(name="unionid", type="string", length=80)
     */
    private $unionid;

    /**
     *
     * @var int $updateAt 更新密码的时间
     *      @Column(name="update_at", type="integer", default=0)
     */
    private $updateAt;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * 创建时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setCreateAt(int $value): self
    {
        $this->createAt = $value;
        
        return $this;
    }

    /**
     * 密码:如果是第三方登录就是第三方的access_tooken
     * 
     * @param string $value            
     * @return $this
     */
    public function setCredential(string $value): self
    {
        $this->credential = $value;
        
        return $this;
    }

    /**
     * 第三方登录时的超期时间,本网站注册用户即为0
     * 
     * @param int $value            
     * @return $this
     */
    public function setExpiresIn(int $value): self
    {
        $this->expiresIn = $value;
        
        return $this;
    }

    /**
     * id
     * 
     * @param int $value            
     * @return $this
     */
    public function setId(int $value)
    {
        $this->id = $value;
        
        return $this;
    }

    /**
     * 账户:如果是第三方登陆就是第三方用户唯一标识
     * 
     * @param string $value            
     * @return $this
     */
    public function setIdentifier(string $value): self
    {
        $this->identifier = $value;
        
        return $this;
    }

    /**
     * 登录类型:0.支付宝登陆,1.qq登录2.微信登录,3.微博登录
     * 
     * @param int $value            
     * @return $this
     */
    public function setIdentityType(int $value): self
    {
        $this->identityType = $value;
        
        return $this;
    }

    /**
     * 账户登录类型:1.本地登录 0.三方登陆
     * 
     * @param int $value            
     * @return $this
     */
    public function setLocal(int $value): self
    {
        $this->local = $value;
        
        return $this;
    }

    /**
     * 授权更新
     * 
     * @param string $value            
     * @return $this
     */
    public function setRefreshToken(string $value): self
    {
        $this->refreshToken = $value;
        
        return $this;
    }

    /**
     * 微商城【打通一个企业对应多个公众号】
     * 
     * @param string $value            
     * @return $this
     */
    public function setUnionid(string $value): self
    {
        $this->unionid = $value;
        
        return $this;
    }

    /**
     * 更新密码的时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setUpdateAt(int $value): self
    {
        $this->updateAt = $value;
        
        return $this;
    }

    /**
     * 用户id
     * 
     * @param int $value            
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->userId = $value;
        
        return $this;
    }

    /**
     * 创建时间
     * 
     * @return int
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * 密码:如果是第三方登录就是第三方的access_tooken
     * 
     * @return string
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * 第三方登录时的超期时间,本网站注册用户即为0
     * 
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 账户:如果是第三方登陆就是第三方用户唯一标识
     * 
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * 登录类型:0.支付宝登陆,1.qq登录2.微信登录,3.微博登录
     * 
     * @return int
     */
    public function getIdentityType()
    {
        return $this->identityType;
    }

    /**
     * 账户登录类型:1.本地登录 0.三方登陆
     * 
     * @return mixed
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * 授权更新
     * 
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * 微商城【打通一个企业对应多个公众号】
     * 
     * @return string
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     * 更新密码的时间
     * 
     * @return int
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * 用户id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
