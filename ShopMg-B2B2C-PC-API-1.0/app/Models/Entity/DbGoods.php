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
 * 商品表
 *
 * @Entity()
 * @Table(name="mg_goods")
 * 
 * @uses DbGoods
 */
class DbGoods extends Model
{

    /**
     *
     * @var int $advanceDate 预售日期
     *      @Column(name="advance_date", type="integer", default=0)
     */
    private $advanceDate;

    /**
     *
     * @var int $approvalStatus 审核状态【0未审核， 1审核通过， 2审核失败】
     *      @Column(name="approval_status", type="tinyint", default=0)
     */
    private $approvalStatus;

    /**
     *
     * @var int $attrType 商品属性编号【为goods_type表中数据】
     *      @Column(name="attr_type", type="integer", default=0)
     */
    private $attrType;

    /**
     *
     * @var int $brandId 品牌【编号】
     *      @Column(name="brand_id", type="integer")
     */
    private $brandId;

    /**
     *
     * @var int $classId 商品分类ID
     *      @Column(name="class_id", type="integer")
     */
    private $classId;

    /**
     *
     * @var int $classThree 三级分类【编号】
     *      @Column(name="class_three", type="integer", default=0)
     */
    private $classThree;

    /**
     *
     * @var int $classTwo 二级分类【编号】
     *      @Column(name="class_two", type="integer", default=0)
     */
    private $classTwo;

    /**
     *
     * @var string $code 商品货号
     *      @Column(name="code", type="string", length=20)
     */
    private $code;

    /**
     *
     * @var int $commentMember 评论次数
     *      @Column(name="comment_member", type="integer", default=0)
     */
    private $commentMember;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var string $description 商品简介
     *      @Column(name="description", type="string", length=50)
     */
    private $description;

    /**
     *
     * @var int $expressId 运费模板编号
     *      @Column(name="express_id", type="integer")
     *      @Required()
     */
    private $expressId;

    /**
     *
     * @var int $extend 扩展分类
     *      @Column(name="extend", type="integer", default=0)
     */
    private $extend;

    /**
     *
     * @var int $goodsType 商品类型
     *      @Column(name="goods_type", type="integer")
     */
    private $goodsType;

    /**
     *
     * @var int $id 主键编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $pId 父级产品 SPU
     *      @Column(name="p_id", type="integer", default=0)
     */
    private $pId;

    /**
     *
     * @var float $priceMarket 市场价
     *      @Column(name="price_market", type="decimal", default=0)
     */
    private $priceMarket;

    /**
     *
     * @var float $priceMember 会员价
     *      @Column(name="price_member", type="decimal", default=0)
     */
    private $priceMember;

    /**
     *
     * @var int $recommend 是否推荐【1推荐 0不推荐】
     *      @Column(name="recommend", type="tinyint", default=0)
     */
    private $recommend;

    /**
     *
     * @var int $salesSum 商品销量
     *      @Column(name="sales_sum", type="integer", default=0)
     */
    private $salesSum;

    /**
     *
     * @var int $seasonHot 当季热卖
     *      @Column(name="season_hot", type="tinyint", default=0)
     */
    private $seasonHot;

    /**
     *
     * @var int $selling 是否是热销 0 不是 1 是
     *      @Column(name="selling", type="tinyint", default=0)
     */
    private $selling;

    /**
     *
     * @var int $shelves 是否上架【0下架，1表示选择上架】
     *      @Column(name="shelves", type="tinyint", default=1)
     */
    private $shelves;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="integer")
     */
    private $sort;

    /**
     *
     * @var int $status 促销活动【0没有活动，1尾货清仓，3积分商城,5抢购, 6团购】
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $stock 库存
     *      @Column(name="stock", type="integer", default=0)
     */
    private $stock;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var string $title 商品标题
     *      @Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     *
     * @var int $top 顶部推荐
     *      @Column(name="top", type="tinyint", default=0)
     */
    private $top;

    /**
     *
     * @var int $type 店铺商品类型【0个人，1公司，2自营】
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var int $updateTime 最后一次编辑时间
     *      @Column(name="update_time", type="integer", default=0)
     */
    private $updateTime;

    /**
     *
     * @var float $weight 重量
     *      @Column(name="weight", type="float", default=0)
     */
    private $weight;

    /**
     * 预售日期
     * 
     * @param int $value            
     * @return $this
     */
    public function setAdvanceDate(int $value): self
    {
        $this->advanceDate = $value;
        
        return $this;
    }

    /**
     * 审核状态【0未审核， 1审核通过， 2审核失败】
     * 
     * @param int $value            
     * @return $this
     */
    public function setApprovalStatus(int $value): self
    {
        $this->approvalStatus = $value;
        
        return $this;
    }

    /**
     * 商品属性编号【为goods_type表中数据】
     * 
     * @param int $value            
     * @return $this
     */
    public function setAttrType(int $value): self
    {
        $this->attrType = $value;
        
        return $this;
    }

    /**
     * 品牌【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setBrandId(int $value): self
    {
        $this->brandId = $value;
        
        return $this;
    }

    /**
     * 商品分类ID
     * 
     * @param int $value            
     * @return $this
     */
    public function setClassId(int $value): self
    {
        $this->classId = $value;
        
        return $this;
    }

    /**
     * 三级分类【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setClassThree(int $value): self
    {
        $this->classThree = $value;
        
        return $this;
    }

    /**
     * 二级分类【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setClassTwo(int $value): self
    {
        $this->classTwo = $value;
        
        return $this;
    }

    /**
     * 商品货号
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
     * 评论次数
     * 
     * @param int $value            
     * @return $this
     */
    public function setCommentMember(int $value): self
    {
        $this->commentMember = $value;
        
        return $this;
    }

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
     * 商品简介
     * 
     * @param string $value            
     * @return $this
     */
    public function setDescription(string $value): self
    {
        $this->description = $value;
        
        return $this;
    }

    /**
     * 运费模板编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setExpressId(int $value): self
    {
        $this->expressId = $value;
        
        return $this;
    }

    /**
     * 扩展分类
     * 
     * @param int $value            
     * @return $this
     */
    public function setExtend(int $value): self
    {
        $this->extend = $value;
        
        return $this;
    }

    /**
     * 商品类型
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsType(int $value): self
    {
        $this->goodsType = $value;
        
        return $this;
    }

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
     * 父级产品 SPU
     * 
     * @param int $value            
     * @return $this
     */
    public function setPId(int $value): self
    {
        $this->pId = $value;
        
        return $this;
    }

    /**
     * 市场价
     * 
     * @param float $value            
     * @return $this
     */
    public function setPriceMarket(float $value): self
    {
        $this->priceMarket = $value;
        
        return $this;
    }

    /**
     * 会员价
     * 
     * @param float $value            
     * @return $this
     */
    public function setPriceMember(float $value): self
    {
        $this->priceMember = $value;
        
        return $this;
    }

    /**
     * 是否推荐【1推荐 0不推荐】
     * 
     * @param int $value            
     * @return $this
     */
    public function setRecommend(int $value): self
    {
        $this->recommend = $value;
        
        return $this;
    }

    /**
     * 商品销量
     * 
     * @param int $value            
     * @return $this
     */
    public function setSalesSum(int $value): self
    {
        $this->salesSum = $value;
        
        return $this;
    }

    /**
     * 当季热卖
     * 
     * @param int $value            
     * @return $this
     */
    public function setSeasonHot(int $value): self
    {
        $this->seasonHot = $value;
        
        return $this;
    }

    /**
     * 是否是热销 0 不是 1 是
     * 
     * @param int $value            
     * @return $this
     */
    public function setSelling(int $value): self
    {
        $this->selling = $value;
        
        return $this;
    }

    /**
     * 是否上架【0下架，1表示选择上架】
     * 
     * @param int $value            
     * @return $this
     */
    public function setShelves(int $value): self
    {
        $this->shelves = $value;
        
        return $this;
    }

    /**
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setSort(int $value): self
    {
        $this->sort = $value;
        
        return $this;
    }

    /**
     * 促销活动【0没有活动，1尾货清仓，3积分商城,5抢购, 6团购】
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
     * 库存
     * 
     * @param int $value            
     * @return $this
     */
    public function setStock(int $value): self
    {
        $this->stock = $value;
        
        return $this;
    }

    /**
     * 店铺【编号】
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
     * 商品标题
     * 
     * @param string $value            
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;
        
        return $this;
    }

    /**
     * 顶部推荐
     * 
     * @param int $value            
     * @return $this
     */
    public function setTop(int $value): self
    {
        $this->top = $value;
        
        return $this;
    }

    /**
     * 店铺商品类型【0个人，1公司，2自营】
     * 
     * @param int $value            
     * @return $this
     */
    public function setType(int $value): self
    {
        $this->type = $value;
        
        return $this;
    }

    /**
     * 最后一次编辑时间
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
     * 重量
     * 
     * @param float $value            
     * @return $this
     */
    public function setWeight(float $value): self
    {
        $this->weight = $value;
        
        return $this;
    }

    /**
     * 预售日期
     * 
     * @return int
     */
    public function getAdvanceDate()
    {
        return $this->advanceDate;
    }

    /**
     * 审核状态【0未审核， 1审核通过， 2审核失败】
     * 
     * @return int
     */
    public function getApprovalStatus()
    {
        return $this->approvalStatus;
    }

    /**
     * 商品属性编号【为goods_type表中数据】
     * 
     * @return int
     */
    public function getAttrType()
    {
        return $this->attrType;
    }

    /**
     * 品牌【编号】
     * 
     * @return int
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * 商品分类ID
     * 
     * @return int
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * 三级分类【编号】
     * 
     * @return int
     */
    public function getClassThree()
    {
        return $this->classThree;
    }

    /**
     * 二级分类【编号】
     * 
     * @return int
     */
    public function getClassTwo()
    {
        return $this->classTwo;
    }

    /**
     * 商品货号
     * 
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 评论次数
     * 
     * @return int
     */
    public function getCommentMember()
    {
        return $this->commentMember;
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
     * 商品简介
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 运费模板编号
     * 
     * @return int
     */
    public function getExpressId()
    {
        return $this->expressId;
    }

    /**
     * 扩展分类
     * 
     * @return int
     */
    public function getExtend()
    {
        return $this->extend;
    }

    /**
     * 商品类型
     * 
     * @return int
     */
    public function getGoodsType()
    {
        return $this->goodsType;
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
     * 父级产品 SPU
     * 
     * @return int
     */
    public function getPId()
    {
        return $this->pId;
    }

    /**
     * 市场价
     * 
     * @return mixed
     */
    public function getPriceMarket()
    {
        return $this->priceMarket;
    }

    /**
     * 会员价
     * 
     * @return mixed
     */
    public function getPriceMember()
    {
        return $this->priceMember;
    }

    /**
     * 是否推荐【1推荐 0不推荐】
     * 
     * @return int
     */
    public function getRecommend()
    {
        return $this->recommend;
    }

    /**
     * 商品销量
     * 
     * @return int
     */
    public function getSalesSum()
    {
        return $this->salesSum;
    }

    /**
     * 当季热卖
     * 
     * @return int
     */
    public function getSeasonHot()
    {
        return $this->seasonHot;
    }

    /**
     * 是否是热销 0 不是 1 是
     * 
     * @return int
     */
    public function getSelling()
    {
        return $this->selling;
    }

    /**
     * 是否上架【0下架，1表示选择上架】
     * 
     * @return mixed
     */
    public function getShelves()
    {
        return $this->shelves;
    }

    /**
     * 排序
     * 
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 促销活动【0没有活动，1尾货清仓，3积分商城,5抢购, 6团购】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 库存
     * 
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * 店铺【编号】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 商品标题
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 顶部推荐
     * 
     * @return int
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * 店铺商品类型【0个人，1公司，2自营】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 最后一次编辑时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 重量
     * 
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
