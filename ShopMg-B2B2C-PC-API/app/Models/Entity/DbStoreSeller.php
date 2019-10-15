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
 * 卖家用户表
 *
 * @Entity()
 * @Table(name="mg_store_seller")
 * 
 * @uses DbStoreSeller
 */
class DbStoreSeller extends Model
{

    /**
     *
     * @var int $createTime 添加时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $groupId 卖家组编号
     *      @Column(name="group_id", type="integer")
     */
    private $groupId;

    /**
     *
     * @var int $id 卖家编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isAdmin 是否管理员(0-不是 1-是)
     *      @Column(name="is_admin", type="tinyint")
     *      @Required()
     */
    private $isAdmin;

    /**
     *
     * @var int $isClient 是否客户端用户 0-否 1-是
     *      @Column(name="is_client", type="tinyint", default=0)
     */
    private $isClient;

    /**
     *
     * @var string $lastLoginIp 最后登录ip
     *      @Column(name="last_login_ip", type="string", length=50, default="")
     */
    private $lastLoginIp;

    /**
     *
     * @var int $lastLoginTime 最后登录时间
     *      @Column(name="last_login_time", type="bigint")
     */
    private $lastLoginTime;

    /**
     *
     * @var int $loginNum 登录次数
     *      @Column(name="login_num", type="integer", default=0)
     */
    private $loginNum;

    /**
     *
     * @var string $password 登录密码
     *      @Column(name="password", type="string", length=50)
     *      @Required()
     */
    private $password;

    /**
     *
     * @var string $sellerName 卖家用户名
     *      @Column(name="seller_name", type="string", length=50)
     *      @Required()
     */
    private $sellerName;

    /**
     *
     * @var string $sellerQuicklink 卖家快捷操作
     *      @Column(name="seller_quicklink", type="string", length=255)
     */
    private $sellerQuicklink;

    /**
     *
     * @var int $status 0正常1禁用
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺编号
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户编号
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 添加时间
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
     * 卖家组编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setGroupId(int $value): self
    {
        $this->groupId = $value;
        
        return $this;
    }

    /**
     * 卖家编号
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
     * 是否管理员(0-不是 1-是)
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsAdmin(int $value): self
    {
        $this->isAdmin = $value;
        
        return $this;
    }

    /**
     * 是否客户端用户 0-否 1-是
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsClient(int $value): self
    {
        $this->isClient = $value;
        
        return $this;
    }

    /**
     * 最后登录ip
     * 
     * @param string $value            
     * @return $this
     */
    public function setLastLoginIp(string $value): self
    {
        $this->lastLoginIp = $value;
        
        return $this;
    }

    /**
     * 最后登录时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setLastLoginTime(int $value): self
    {
        $this->lastLoginTime = $value;
        
        return $this;
    }

    /**
     * 登录次数
     * 
     * @param int $value            
     * @return $this
     */
    public function setLoginNum(int $value): self
    {
        $this->loginNum = $value;
        
        return $this;
    }

    /**
     * 登录密码
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
     * 卖家用户名
     * 
     * @param string $value            
     * @return $this
     */
    public function setSellerName(string $value): self
    {
        $this->sellerName = $value;
        
        return $this;
    }

    /**
     * 卖家快捷操作
     * 
     * @param string $value            
     * @return $this
     */
    public function setSellerQuicklink(string $value): self
    {
        $this->sellerQuicklink = $value;
        
        return $this;
    }

    /**
     * 0正常1禁用
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
     * 店铺编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreId(int $value): self
    {
        $this->storeId = $value;
        
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
     * 用户编号
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
     * 添加时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 卖家组编号
     * 
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * 卖家编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 是否管理员(0-不是 1-是)
     * 
     * @return int
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * 是否客户端用户 0-否 1-是
     * 
     * @return int
     */
    public function getIsClient()
    {
        return $this->isClient;
    }

    /**
     * 最后登录ip
     * 
     * @return string
     */
    public function getLastLoginIp()
    {
        return $this->lastLoginIp;
    }

    /**
     * 最后登录时间
     * 
     * @return int
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * 登录次数
     * 
     * @return int
     */
    public function getLoginNum()
    {
        return $this->loginNum;
    }

    /**
     * 登录密码
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 卖家用户名
     * 
     * @return string
     */
    public function getSellerName()
    {
        return $this->sellerName;
    }

    /**
     * 卖家快捷操作
     * 
     * @return string
     */
    public function getSellerQuicklink()
    {
        return $this->sellerQuicklink;
    }

    /**
     * 0正常1禁用
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺编号
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
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
     * 用户编号
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
