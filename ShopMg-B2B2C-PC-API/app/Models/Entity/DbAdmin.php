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
 * 后台管理员表
 *
 * @Entity()
 * @Table(name="mg_admin")
 * 
 * @uses DbAdmin
 */
class DbAdmin extends Model
{

    /**
     *
     * @var string $account 管理员账号
     *      @Column(name="account", type="string", length=32)
     */
    private $account;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $groupId 所属分组的ID
     *      @Column(name="group_id", type="integer")
     */
    private $groupId;

    /**
     *
     * @var int $id 管理员ID
     *      @Id()
     *      @Column(name="id", type="smallint")
     */
    private $id;

    /**
     *
     * @var int $loginCount 登录次数
     *      @Column(name="login_count", type="integer", default=0)
     */
    private $loginCount;

    /**
     *
     * @var int $loginTime 最后登录时间
     *      @Column(name="login_time", type="integer")
     */
    private $loginTime;

    /**
     *
     * @var string $password 管理员密码
     *      @Column(name="password", type="string", length=36)
     */
    private $password;

    /**
     *
     * @var int $status 账户状态，禁用为0 启用为1
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     * 管理员账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setAccount(string $value): self
    {
        $this->account = $value;
        
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
     * 所属分组的ID
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
     * 管理员ID
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
     * 登录次数
     * 
     * @param int $value            
     * @return $this
     */
    public function setLoginCount(int $value): self
    {
        $this->loginCount = $value;
        
        return $this;
    }

    /**
     * 最后登录时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setLoginTime(int $value): self
    {
        $this->loginTime = $value;
        
        return $this;
    }

    /**
     * 管理员密码
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
     * 账户状态，禁用为0 启用为1
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
     * 管理员账号
     * 
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
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
     * 所属分组的ID
     * 
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * 管理员ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 登录次数
     * 
     * @return int
     */
    public function getLoginCount()
    {
        return $this->loginCount;
    }

    /**
     * 最后登录时间
     * 
     * @return int
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }

    /**
     * 管理员密码
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 账户状态，禁用为0 启用为1
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
