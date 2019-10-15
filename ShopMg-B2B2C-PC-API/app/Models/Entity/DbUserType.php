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
 * 用户类型表
 *
 * @Entity()
 * @Table(name="mg_user_type")
 * 
 * @uses DbUserType
 */
class DbUserType extends Model
{

    /**
     *
     * @var int $id 用户类型id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $type 类型名称
     *      @Column(name="type", type="string", length=10)
     */
    private $type;

    /**
     * 用户类型id
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
     * 类型名称
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
     * 用户类型id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 类型名称
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
