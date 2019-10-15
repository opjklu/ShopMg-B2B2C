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
 * 配送地区表
 *
 * @Entity()
 * @Table(name="mg_freight_send")
 * 
 * @uses DbFreightSend
 */
class DbFreightSend extends Model
{

    /**
     *
     * @var int $freightId 运费设置【编号】
     *      @Column(name="freight_id", type="integer", default=0)
     */
    private $freightId;

    /**
     *
     * @var int $mailArea 地区编号
     *      @Column(name="mail_area", type="integer")
     */
    private $mailArea;

    /**
     * 运费设置【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setFreightId(int $value): self
    {
        $this->freightId = $value;
        
        return $this;
    }

    /**
     * 地区编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setMailArea(int $value): self
    {
        $this->mailArea = $value;
        
        return $this;
    }

    /**
     * 运费设置【编号】
     * 
     * @return int
     */
    public function getFreightId()
    {
        return $this->freightId;
    }

    /**
     * 地区编号
     * 
     * @return int
     */
    public function getMailArea()
    {
        return $this->mailArea;
    }
}
