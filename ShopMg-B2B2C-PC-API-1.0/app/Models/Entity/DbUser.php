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
 * 会员表
 *
 * @Entity()
 * @Table(name="mg_user")
 * 
 * @uses DbUser
 */
class DbUser extends Model
{

    /**
     *
     * @var int $birthday 生日
     *      @Column(name="birthday", type="bigint", default=0)
     */
    private $birthday;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var string $email 邮箱
     *      @Column(name="email", type="string", length=64)
     *      @Required()
     */
    private $email;

    /**
     *
     * @var int $id 用户编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $idCard 身份证号码
     *      @Column(name="id_card", type="string", length=64)
     */
    private $idCard;

    /**
     *
     * @var int $lastLogonTime 上次登录时间
     *      @Column(name="last_logon_time", type="integer", default=0)
     */
    private $lastLogonTime;

    /**
     *
     * @var float $memberDiscount 折扣率
     *      @Column(name="member_discount", type="decimal", default=100)
     */
    private $memberDiscount;

    /**
     *
     * @var string $mobile 电话号码
     *      @Column(name="mobile", type="string", length=11)
     *      @Required()
     */
    private $mobile;

    /**
     *
     * @var string $nickName 昵称
     *      @Column(name="nick_name", type="string", length=64)
     */
    private $nickName;

    /**
     *
     * @var string $openId openid是公众号的普通用户的一个唯一的标识
     *      @Column(name="open_id", type="string", length=50)
     */
    private $openId;

    /**
     *
     * @var int $pId 父级会员编号
     *      @Column(name="p_id", type="integer", default=0)
     */
    private $pId;

    /**
     *
     * @var string $password 密码
     *      @Column(name="password", type="string", length=40)
     */
    private $password;

    /**
     *
     * @var string $recommendcode 推荐人编码
     *      @Column(name="recommendcode", type="string", length=100, default="0")
     */
    private $recommendcode;

    /**
     *
     * @var string $salt 加盐字段【： 和密码进行加密，增加密码强度】
     *      @Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     *
     * @var int $sex 性别【0女，1男】
     *      @Column(name="sex", type="tinyint", default=0)
     */
    private $sex;

    /**
     *
     * @var int $status 账号状态【1正常 0禁用】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer", default=0)
     */
    private $updateTime;

    /**
     *
     * @var string $userName 用户名
     *      @Column(name="user_name", type="string", length=64)
     */
    private $userName;

    /**
     *
     * @var int $validateEmail 是否验证邮箱【0没有， 1已验证】
     *      @Column(name="validate_email", type="tinyint", default=0)
     */
    private $validateEmail;

    /**
     * 生日
     * 
     * @param int $value            
     * @return $this
     */
    public function setBirthday(int $value): self
    {
        $this->birthday = $value;
        
        return $this;
    }

    /**
     * 创建时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setCreateTime(int $value): self
    {
        $this->createTime = $value;
        
        return $this;
    }

    /**
     * 邮箱
     * 
     * @param string $value            
     * @return $this
     */
    public function setEmail(string $value): self
    {
        $this->email = $value;
        
        return $this;
    }

    /**
     * 用户编号
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
     * 身份证号码
     * 
     * @param string $value            
     * @return $this
     */
    public function setIdCard(string $value): self
    {
        $this->idCard = $value;
        
        return $this;
    }

    /**
     * 上次登录时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setLastLogonTime(int $value): self
    {
        $this->lastLogonTime = $value;
        
        return $this;
    }

    /**
     * 折扣率
     * 
     * @param float $value            
     * @return $this
     */
    public function setMemberDiscount(float $value): self
    {
        $this->memberDiscount = $value;
        
        return $this;
    }

    /**
     * 电话号码
     * 
     * @param string $value            
     * @return $this
     */
    public function setMobile(string $value): self
    {
        $this->mobile = $value;
        
        return $this;
    }

    /**
     * 昵称
     * 
     * @param string $value            
     * @return $this
     */
    public function setNickName(string $value): self
    {
        $this->nickName = $value;
        
        return $this;
    }

    /**
     * openid是公众号的普通用户的一个唯一的标识
     * 
     * @param string $value            
     * @return $this
     */
    public function setOpenId(string $value): self
    {
        $this->openId = $value;
        
        return $this;
    }

    /**
     * 父级会员编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setPId(int $value): self
    {
        $this->pId = $value;
        
        return $this;
    }

    /**
     * 密码
     * 
     * @param string $value            
     * @return $this
     */
    public function setPassword(string $value): self
    {
        $this->password = $value;
        
        return $this;
    }

    /**
     * 推荐人编码
     * 
     * @param string $value            
     * @return $this
     */
    public function setRecommendcode(string $value): self
    {
        $this->recommendcode = $value;
        
        return $this;
    }

    /**
     * 加盐字段【： 和密码进行加密，增加密码强度】
     * 
     * @param string $value            
     * @return $this
     */
    public function setSalt(string $value): self
    {
        $this->salt = $value;
        
        return $this;
    }

    /**
     * 性别【0女，1男】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSex(int $value): self
    {
        $this->sex = $value;
        
        return $this;
    }

    /**
     * 账号状态【1正常 0禁用】
     * 
     * @param int $value            
     * @return $this
     */
    public function setStatus(int $value): self
    {
        $this->status = $value;
        
        return $this;
    }

    /**
     * 更新时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setUpdateTime(int $value): self
    {
        $this->updateTime = $value;
        
        return $this;
    }

    /**
     * 用户名
     * 
     * @param string $value            
     * @return $this
     */
    public function setUserName(string $value): self
    {
        $this->userName = $value;
        
        return $this;
    }

    /**
     * 是否验证邮箱【0没有， 1已验证】
     * 
     * @param int $value            
     * @return $this
     */
    public function setValidateEmail(int $value): self
    {
        $this->validateEmail = $value;
        
        return $this;
    }

    /**
     * 生日
     * 
     * @return int
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 邮箱
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * 用户编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 身份证号码
     * 
     * @return string
     */
    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * 上次登录时间
     * 
     * @return int
     */
    public function getLastLogonTime()
    {
        return $this->lastLogonTime;
    }

    /**
     * 折扣率
     * 
     * @return mixed
     */
    public function getMemberDiscount()
    {
        return $this->memberDiscount;
    }

    /**
     * 电话号码
     * 
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * 昵称
     * 
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * openid是公众号的普通用户的一个唯一的标识
     * 
     * @return string
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * 父级会员编号
     * 
     * @return int
     */
    public function getPId()
    {
        return $this->pId;
    }

    /**
     * 密码
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 推荐人编码
     * 
     * @return string
     */
    public function getRecommendcode()
    {
        return $this->recommendcode;
    }

    /**
     * 加盐字段【： 和密码进行加密，增加密码强度】
     * 
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * 性别【0女，1男】
     * 
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * 账号状态【1正常 0禁用】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 更新时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 用户名
     * 
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * 是否验证邮箱【0没有， 1已验证】
     * 
     * @return int
     */
    public function getValidateEmail()
    {
        return $this->validateEmail;
    }
}
