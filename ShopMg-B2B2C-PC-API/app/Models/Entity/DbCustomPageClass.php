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
 * 自定义页面分类表
 *
 * @Entity()
 * @Table(name="mg_custom_page_class")
 * 
 * @uses DbCustomPageClass
 */
class DbCustomPageClass extends Model
{

    /**
     *
     * @var int $id 主键编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $nameChina 中文分组名称
     *      @Column(name="name_china", type="string", length=50)
     */
    private $nameChina;

    /**
     *
     * @var string $nameEnglish 英文分组名称
     *      @Column(name="name_english", type="string", length=50)
     */
    private $nameEnglish;

    /**
     * 主键编号
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
     * 中文分组名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setNameChina(string $value): self
    {
        $this->nameChina = $value;
        
        return $this;
    }

    /**
     * 英文分组名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setNameEnglish(string $value): self
    {
        $this->nameEnglish = $value;
        
        return $this;
    }

    /**
     * 主键编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 中文分组名称
     * 
     * @return string
     */
    public function getNameChina()
    {
        return $this->nameChina;
    }

    /**
     * 英文分组名称
     * 
     * @return string
     */
    public function getNameEnglish()
    {
        return $this->nameEnglish;
    }
}
