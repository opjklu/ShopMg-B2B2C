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
 * 银行卡表
 *
 * @Entity()
 * @Table(name="mg_bank_card")
 * 
 * @uses DbBankCard
 */
class DbBankCard extends Model
{

    /**
     *
     * @var string $belong 所属银行
     *      @Column(name="belong", type="string", length=50)
     */
    private $belong;

    /**
     *
     * @var string $cardNum 卡号
     *      @Column(name="card_num", type="string", length=20)
     */
    private $cardNum;

    /**
     *
     * @var int $createTime 时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $id 银行卡表
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $idCard 身份证
     *      @Column(name="id_card", type="string", length=20)
     */
    private $idCard;

    /**
     *
     * @var string $mobile 手机号码
     *      @Column(name="mobile", type="string", length=11)
     */
    private $mobile;

    /**
     *
     * @var string $realname 开户姓名
     *      @Column(name="realname", type="string", length=30)
     */
    private $realname;

    /**
     *
     * @var string $type 类型
     *      @Column(name="type", type="string", length=10)
     */
    private $type;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * 所属银行
     * 
     * @param string $value            
     * @return $this
     */
    public function setBelong(string $value): self
    {
        $this->belong = $value;
        
        return $this;
    }

    /**
     * 卡号
     * 
     * @param string $value            
     * @return $this
     */
    public function setCardNum(string $value): self
    {
        $this->cardNum = $value;
        
        return $this;
    }

    /**
     * 时间
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
     * 银行卡表
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
     * 身份证
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
     * 手机号码
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
     * 开户姓名
     * 
     * @param string $value            
     * @return $this
     */
    public function setRealname(string $value): self
    {
        $this->realname = $value;
        
        return $this;
    }

    /**
     * 类型
     * 
     * @param string $value            
     * @return $this
     */
    public function setType(string $value): self
    {
        $this->type = $value;
        
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
     * 所属银行
     * 
     * @return string
     */
    public function getBelong()
    {
        return $this->belong;
    }

    /**
     * 卡号
     * 
     * @return string
     */
    public function getCardNum()
    {
        return $this->cardNum;
    }

    /**
     * 时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 银行卡表
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 身份证
     * 
     * @return string
     */
    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * 手机号码
     * 
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * 开户姓名
     * 
     * @return string
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * 类型
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
