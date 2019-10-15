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
 * 运费模板表
 *
 * @Entity()
 * @Table(name="mg_freights")
 * 
 * @uses DbFreights
 */
class DbFreights extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var string $expressTitle 运费模板名称
     *      @Column(name="express_title", type="string", length=50)
     *      @Required()
     */
    private $expressTitle;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isFreeShipping 运费类型【0自定义运费1卖家包邮】
     *      @Column(name="is_free_shipping", type="tinyint", default=1)
     */
    private $isFreeShipping;

    /**
     *
     * @var int $isSelectCondition 是否指定条件包邮 【0=>false 1=>true】
     *      @Column(name="is_select_condition", type="tinyint", default=0)
     */
    private $isSelectCondition;

    /**
     *
     * @var int $sendTime 发货时间【几个小时内发货】
     *      @Column(name="send_time", type="bigint", default=0)
     */
    private $sendTime;

    /**
     *
     * @var int $stockId 关联仓库
     *      @Column(name="stock_id", type="integer", default=0)
     */
    private $stockId;

    /**
     *
     * @var int $storeId 商户【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $valuationMethod 计价方式【0:按件 1:按重量 2:按体积】
     *      @Column(name="valuation_method", type="tinyint", default=1)
     */
    private $valuationMethod;

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
     * 运费模板名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setExpressTitle(string $value): self
    {
        $this->expressTitle = $value;
        
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
     * 运费类型【0自定义运费1卖家包邮】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsFreeShipping(int $value): self
    {
        $this->isFreeShipping = $value;
        
        return $this;
    }

    /**
     * 是否指定条件包邮 【0=>false 1=>true】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsSelectCondition(int $value): self
    {
        $this->isSelectCondition = $value;
        
        return $this;
    }

    /**
     * 发货时间【几个小时内发货】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSendTime(int $value): self
    {
        $this->sendTime = $value;
        
        return $this;
    }

    /**
     * 关联仓库
     * 
     * @param int $value            
     * @return $this
     */
    public function setStockId(int $value): self
    {
        $this->stockId = $value;
        
        return $this;
    }

    /**
     * 商户【编号】
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
     * 计价方式【0:按件 1:按重量 2:按体积】
     * 
     * @param int $value            
     * @return $this
     */
    public function setValuationMethod(int $value): self
    {
        $this->valuationMethod = $value;
        
        return $this;
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
     * 运费模板名称
     * 
     * @return string
     */
    public function getExpressTitle()
    {
        return $this->expressTitle;
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
     * 运费类型【0自定义运费1卖家包邮】
     * 
     * @return mixed
     */
    public function getIsFreeShipping()
    {
        return $this->isFreeShipping;
    }

    /**
     * 是否指定条件包邮 【0=>false 1=>true】
     * 
     * @return int
     */
    public function getIsSelectCondition()
    {
        return $this->isSelectCondition;
    }

    /**
     * 发货时间【几个小时内发货】
     * 
     * @return int
     */
    public function getSendTime()
    {
        return $this->sendTime;
    }

    /**
     * 关联仓库
     * 
     * @return int
     */
    public function getStockId()
    {
        return $this->stockId;
    }

    /**
     * 商户【编号】
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
     * 计价方式【0:按件 1:按重量 2:按体积】
     * 
     * @return mixed
     */
    public function getValuationMethod()
    {
        return $this->valuationMethod;
    }
}
