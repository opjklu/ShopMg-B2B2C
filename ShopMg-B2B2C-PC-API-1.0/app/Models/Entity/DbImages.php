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
 * 图片表【备用】
 *
 * @Entity()
 * @Table(name="mg_images")
 * 
 * @uses DbImages
 */
class DbImages extends Model
{

    /**
     *
     * @var int $createTime 添加时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $path 图片路径
     *      @Column(name="path", type="string", length=150, default="")
     */
    private $path;

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
     * 图片路径
     * 
     * @param string $value            
     * @return $this
     */
    public function setPath(string $value): self
    {
        $this->path = $value;
        
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
     * id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 图片路径
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
