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
 * 快递公司
 *
 * @Entity()
 * @Table(name="mg_express")
 * 
 * @uses DbExpress
 */
class DbExpress extends Model
{

    /**
     *
     * @var string $code 编码
     *      @Column(name="code", type="string", length=50)
     *      @Required()
     */
    private $code;

    /**
     *
     * @var float $discount 折扣
     *      @Column(name="discount", type="decimal", default=100)
     */
    private $discount;

    /**
     *
     * @var int $id 索引ID
     *      @Id()
     *      @Column(name="id", type="tinyint")
     */
    private $id;

    /**
     *
     * @var string $letter 首字母
     *      @Column(name="letter", type="char", length=1)
     *      @Required()
     */
    private $letter;

    /**
     *
     * @var string $name 公司名称
     *      @Column(name="name", type="string", length=50)
     *      @Required()
     */
    private $name;

    /**
     *
     * @var int $order 是否常用【1常用0不常用】
     *      @Column(name="order", type="tinyint", default=0)
     */
    private $order;

    /**
     *
     * @var int $status 是否启用【状态1启用 0弃用】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var string $tel 客服电话
     *      @Column(name="tel", type="string", length=50, default="0")
     */
    private $tel;

    /**
     *
     * @var string $url 公司网址
     *      @Column(name="url", type="string", length=100)
     *      @Required()
     */
    private $url;

    /**
     *
     * @var int $ztState 是否支持服务站配送【0否1是】
     *      @Column(name="zt_state", type="tinyint", default=0)
     */
    private $ztState;

    /**
     * 编码
     * 
     * @param string $value            
     * @return $this
     */
    public function setCode(string $value): self
    {
        $this->code = $value;
        
        return $this;
    }

    /**
     * 折扣
     * 
     * @param float $value            
     * @return $this
     */
    public function setDiscount(float $value): self
    {
        $this->discount = $value;
        
        return $this;
    }

    /**
     * 索引ID
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
     * 首字母
     * 
     * @param string $value            
     * @return $this
     */
    public function setLetter(string $value): self
    {
        $this->letter = $value;
        
        return $this;
    }

    /**
     * 公司名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setName(string $value): self
    {
        $this->name = $value;
        
        return $this;
    }

    /**
     * 是否常用【1常用0不常用】
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrder(int $value): self
    {
        $this->order = $value;
        
        return $this;
    }

    /**
     * 是否启用【状态1启用 0弃用】
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
     * 客服电话
     * 
     * @param string $value            
     * @return $this
     */
    public function setTel(string $value): self
    {
        $this->tel = $value;
        
        return $this;
    }

    /**
     * 公司网址
     * 
     * @param string $value            
     * @return $this
     */
    public function setUrl(string $value): self
    {
        $this->url = $value;
        
        return $this;
    }

    /**
     * 是否支持服务站配送【0否1是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setZtState(int $value): self
    {
        $this->ztState = $value;
        
        return $this;
    }

    /**
     * 编码
     * 
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 折扣
     * 
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * 索引ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 首字母
     * 
     * @return string
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * 公司名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 是否常用【1常用0不常用】
     * 
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * 是否启用【状态1启用 0弃用】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 客服电话
     * 
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * 公司网址
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 是否支持服务站配送【0否1是】
     * 
     * @return int
     */
    public function getZtState()
    {
        return $this->ztState;
    }
}
