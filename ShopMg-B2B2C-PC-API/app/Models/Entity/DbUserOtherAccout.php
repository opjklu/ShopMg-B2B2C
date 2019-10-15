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
 * 三方授权账号
 *
 * @Entity()
 * @Table(name="mg_user_other_accout")
 * 
 * @uses DbUserOtherAccout
 */
class DbUserOtherAccout extends Model
{

    /**
     *
     * @var string $qqId qq授权id---app建
     *      @Column(name="qq_id", type="char", length=32)
     */
    private $qqId;

    /**
     *
     * @var string $sinaId 新浪授权id---app建
     *      @Column(name="sina_id", type="char", length=32)
     */
    private $sinaId;

    /**
     *
     * @var int $userId 三方授权账号
     *      @Id()
     *      @Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     *
     * @var string $weixinOpenid 微信授权open_id---app建
     *      @Column(name="weixin_openid", type="char", length=32)
     */
    private $weixinOpenid;

    /**
     * qq授权id---app建
     * 
     * @param string $value            
     * @return $this
     */
    public function setQqId(string $value): self
    {
        $this->qqId = $value;
        
        return $this;
    }

    /**
     * 新浪授权id---app建
     * 
     * @param string $value            
     * @return $this
     */
    public function setSinaId(string $value): self
    {
        $this->sinaId = $value;
        
        return $this;
    }

    /**
     * 三方授权账号
     * 
     * @param int $value            
     * @return $this
     */
    public function setUserId(int $value)
    {
        $this->userId = $value;
        
        return $this;
    }

    /**
     * 微信授权open_id---app建
     * 
     * @param string $value            
     * @return $this
     */
    public function setWeixinOpenid(string $value): self
    {
        $this->weixinOpenid = $value;
        
        return $this;
    }

    /**
     * qq授权id---app建
     * 
     * @return string
     */
    public function getQqId()
    {
        return $this->qqId;
    }

    /**
     * 新浪授权id---app建
     * 
     * @return string
     */
    public function getSinaId()
    {
        return $this->sinaId;
    }

    /**
     * 三方授权账号
     * 
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 微信授权open_id---app建
     * 
     * @return string
     */
    public function getWeixinOpenid()
    {
        return $this->weixinOpenid;
    }
}
