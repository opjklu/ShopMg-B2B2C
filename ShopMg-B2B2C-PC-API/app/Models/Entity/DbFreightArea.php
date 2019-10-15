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
 * 包邮地区表
 *
 * @Entity()
 * @Table(name="mg_freight_area")
 * 
 * @uses DbFreightArea
 */
class DbFreightArea extends Model
{

    /**
     *
     * @var int $freightId 包邮条件【编号】
     *      @Id()
     *      @Column(name="freight_id", type="integer")
     */
    private $freightId;

    /**
     *
     * @var int $mailArea 地区编号
     *      @Id()
     *      @Column(name="mail_area", type="integer")
     */
    private $mailArea;

    /**
     * 包邮条件【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setFreightId(int $value)
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
    public function setMailArea(int $value)
    {
        $this->mailArea = $value;
        
        return $this;
    }

    /**
     * 包邮条件【编号】
     * 
     * @return mixed
     */
    public function getFreightId()
    {
        return $this->freightId;
    }

    /**
     * 地区编号
     * 
     * @return mixed
     */
    public function getMailArea()
    {
        return $this->mailArea;
    }
}
