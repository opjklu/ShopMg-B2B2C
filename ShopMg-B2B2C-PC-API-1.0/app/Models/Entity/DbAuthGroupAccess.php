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
 * 权限访问表
 *
 * @Entity()
 * @Table(name="mg_auth_group_access")
 * 
 * @uses DbAuthGroupAccess
 */
class DbAuthGroupAccess extends Model
{

    /**
     *
     * @var int $groupId 分组id
     *      @Id()
     *      @Column(name="group_id", type="smallint")
     */
    private $groupId;

    /**
     *
     * @var int $uid 用户id
     *      @Id()
     *      @Column(name="uid", type="smallint")
     */
    private $uid;

    /**
     * 分组id
     * 
     * @param int $value            
     * @return $this
     */
    public function setGroupId(int $value)
    {
        $this->groupId = $value;
        
        return $this;
    }

    /**
     * 用户id
     * 
     * @param int $value            
     * @return $this
     */
    public function setUid(int $value)
    {
        $this->uid = $value;
        
        return $this;
    }

    /**
     * 分组id
     * 
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * 用户id
     * 
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }
}
