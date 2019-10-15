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
 * 店铺表
 *
 * @Entity()
 * @Table(name="mg_store")
 * 
 * @uses DbStore
 */
class DbStore extends Model
{

    /**
     *
     * @var string $alipayAccount 支付宝账号
     *      @Column(name="alipay_account", type="string", length=50)
     */
    private $alipayAccount;

    /**
     *
     * @var string $bankAccount 银行卡号
     *      @Column(name="bank_account", type="string", length=50)
     */
    private $bankAccount;

    /**
     *
     * @var int $barType 店铺商品页面左侧显示类型【 0默认1商城相关分类品牌商品推荐】
     *      @Column(name="bar_type", type="tinyint", default=0)
     */
    private $barType;

    /**
     *
     * @var int $buildAll 自营店是否绑定全部分类【 0否1是】
     *      @Column(name="build_all", type="tinyint", default=0)
     */
    private $buildAll;

    /**
     *
     * @var int $classId 店铺分类【编号】
     *      @Column(name="class_id", type="integer", default=0)
     */
    private $classId;

    /**
     *
     * @var float $commission 佣金比例【0-100】
     *      @Column(name="commission", type="decimal", default=0)
     */
    private $commission;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $credibility 信誉
     *      @Column(name="credibility", type="integer", default=0)
     */
    private $credibility;

    /**
     *
     * @var int $decorationOnly 开启店铺装修【仅显示店铺装修(1-是 0-否】
     *      @Column(name="decoration_only", type="tinyint", default=0)
     */
    private $decorationOnly;

    /**
     *
     * @var int $decorationSwitch 店铺装修开关【0-关闭 装修编号-开启】
     *      @Column(name="decoration_switch", type="tinyint", default=0)
     */
    private $decorationSwitch;

    /**
     *
     * @var string $description 描述
     *      @Column(name="description", type="string", length=100, default="")
     */
    private $description;

    /**
     *
     * @var int $endTime 店铺营业结束时间
     *      @Column(name="end_time", type="bigint", default=0)
     */
    private $endTime;

    /**
     *
     * @var float $freePrice 超出该金额免运费【大于0才表示该值有效】
     *      @Column(name="free_price", type="decimal")
     */
    private $freePrice;

    /**
     *
     * @var int $gradeId 店铺等级
     *      @Column(name="grade_id", type="integer", default=0)
     */
    private $gradeId;

    /**
     *
     * @var int $id 主键编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $imageCount 店铺装修相册图片数量
     *      @Column(name="image_count", type="integer", default=0)
     */
    private $imageCount;

    /**
     *
     * @var int $isDistribution 是否分销店铺【0-否，1-是】
     *      @Column(name="is_distribution", type="tinyint", default=0)
     */
    private $isDistribution;

    /**
     *
     * @var int $isOwn 是否自营店铺 【1是 0否】
     *      @Column(name="is_own", type="tinyint", default=0)
     */
    private $isOwn;

    /**
     *
     * @var int $mobile 联系方式
     *      @Column(name="mobile", type="bigint", default=0)
     */
    private $mobile;

    /**
     *
     * @var string $personName 联系人姓名
     *      @Column(name="person_name", type="string", length=20)
     *      @Required()
     */
    private $personName;

    /**
     *
     * @var string $printDesc 打印订单页面下方说明文字
     *      @Column(name="print_desc", type="string", length=255)
     */
    private $printDesc;

    /**
     *
     * @var string $shopName 店铺名称
     *      @Column(name="shop_name", type="string", length=50, default="")
     */
    private $shopName;

    /**
     *
     * @var int $startTime 店铺营业开始时间
     *      @Column(name="start_time", type="bigint", default=0)
     */
    private $startTime;

    /**
     *
     * @var int $status 推荐【0为否，1为是，默认为0】
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeAddress 地址编号
     *      @Column(name="store_address", type="integer", default=0)
     */
    private $storeAddress;

    /**
     *
     * @var int $storeCollect 店铺收藏数量
     *      @Column(name="store_collect", type="integer", default=0)
     */
    private $storeCollect;

    /**
     *
     * @var string $storeLogo 店铺logo
     *      @Column(name="store_logo", type="char", length=70, default="")
     */
    private $storeLogo;

    /**
     *
     * @var int $storeSales 店铺销量
     *      @Column(name="store_sales", type="integer", default=0)
     */
    private $storeSales;

    /**
     *
     * @var int $storeSort 店铺排序
     *      @Column(name="store_sort", type="integer", default=50)
     */
    private $storeSort;

    /**
     *
     * @var int $storeState 店铺状态【0关闭，1开启，2审核中】
     *      @Column(name="store_state", type="tinyint", default=0)
     */
    private $storeState;

    /**
     *
     * @var int $themeId 店铺当前主题
     *      @Column(name="theme_id", type="integer", default=0)
     */
    private $themeId;

    /**
     *
     * @var int $type 店铺类型【0个人入驻 1企业入驻】
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $userId 店主【编号】
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     *
     * @var string $wxAccout 微信账号
     *      @Column(name="wx_accout", type="string", length=50)
     */
    private $wxAccout;

    /**
     * 支付宝账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setAlipayAccount(string $value): self
    {
        $this->alipayAccount = $value;
        
        return $this;
    }

    /**
     * 银行卡号
     * 
     * @param string $value            
     * @return $this
     */
    public function setBankAccount(string $value): self
    {
        $this->bankAccount = $value;
        
        return $this;
    }

    /**
     * 店铺商品页面左侧显示类型【 0默认1商城相关分类品牌商品推荐】
     * 
     * @param int $value            
     * @return $this
     */
    public function setBarType(int $value): self
    {
        $this->barType = $value;
        
        return $this;
    }

    /**
     * 自营店是否绑定全部分类【 0否1是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setBuildAll(int $value): self
    {
        $this->buildAll = $value;
        
        return $this;
    }

    /**
     * 店铺分类【编号】
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
     * 佣金比例【0-100】
     * 
     * @param float $value            
     * @return $this
     */
    public function setCommission(float $value): self
    {
        $this->commission = $value;
        
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
     * 信誉
     * 
     * @param int $value            
     * @return $this
     */
    public function setCredibility(int $value): self
    {
        $this->credibility = $value;
        
        return $this;
    }

    /**
     * 开启店铺装修【仅显示店铺装修(1-是 0-否】
     * 
     * @param int $value            
     * @return $this
     */
    public function setDecorationOnly(int $value): self
    {
        $this->decorationOnly = $value;
        
        return $this;
    }

    /**
     * 店铺装修开关【0-关闭 装修编号-开启】
     * 
     * @param int $value            
     * @return $this
     */
    public function setDecorationSwitch(int $value): self
    {
        $this->decorationSwitch = $value;
        
        return $this;
    }

    /**
     * 描述
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
     * 店铺营业结束时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setEndTime(int $value): self
    {
        $this->endTime = $value;
        
        return $this;
    }

    /**
     * 超出该金额免运费【大于0才表示该值有效】
     * 
     * @param float $value            
     * @return $this
     */
    public function setFreePrice(float $value): self
    {
        $this->freePrice = $value;
        
        return $this;
    }

    /**
     * 店铺等级
     * 
     * @param int $value            
     * @return $this
     */
    public function setGradeId(int $value): self
    {
        $this->gradeId = $value;
        
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
     * 店铺装修相册图片数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setImageCount(int $value): self
    {
        $this->imageCount = $value;
        
        return $this;
    }

    /**
     * 是否分销店铺【0-否，1-是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsDistribution(int $value): self
    {
        $this->isDistribution = $value;
        
        return $this;
    }

    /**
     * 是否自营店铺 【1是 0否】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsOwn(int $value): self
    {
        $this->isOwn = $value;
        
        return $this;
    }

    /**
     * 联系方式
     * 
     * @param int $value            
     * @return $this
     */
    public function setMobile(int $value): self
    {
        $this->mobile = $value;
        
        return $this;
    }

    /**
     * 联系人姓名
     * 
     * @param string $value            
     * @return $this
     */
    public function setPersonName(string $value): self
    {
        $this->personName = $value;
        
        return $this;
    }

    /**
     * 打印订单页面下方说明文字
     * 
     * @param string $value            
     * @return $this
     */
    public function setPrintDesc(string $value): self
    {
        $this->printDesc = $value;
        
        return $this;
    }

    /**
     * 店铺名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setShopName(string $value): self
    {
        $this->shopName = $value;
        
        return $this;
    }

    /**
     * 店铺营业开始时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setStartTime(int $value): self
    {
        $this->startTime = $value;
        
        return $this;
    }

    /**
     * 推荐【0为否，1为是，默认为0】
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
     * 地址编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreAddress(int $value): self
    {
        $this->storeAddress = $value;
        
        return $this;
    }

    /**
     * 店铺收藏数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreCollect(int $value): self
    {
        $this->storeCollect = $value;
        
        return $this;
    }

    /**
     * 店铺logo
     * 
     * @param string $value            
     * @return $this
     */
    public function setStoreLogo(string $value): self
    {
        $this->storeLogo = $value;
        
        return $this;
    }

    /**
     * 店铺销量
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreSales(int $value): self
    {
        $this->storeSales = $value;
        
        return $this;
    }

    /**
     * 店铺排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreSort(int $value): self
    {
        $this->storeSort = $value;
        
        return $this;
    }

    /**
     * 店铺状态【0关闭，1开启，2审核中】
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreState(int $value): self
    {
        $this->storeState = $value;
        
        return $this;
    }

    /**
     * 店铺当前主题
     * 
     * @param int $value            
     * @return $this
     */
    public function setThemeId(int $value): self
    {
        $this->themeId = $value;
        
        return $this;
    }

    /**
     * 店铺类型【0个人入驻 1企业入驻】
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
     * 店主【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->userId = $value;
        
        return $this;
    }

    /**
     * 微信账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setWxAccout(string $value): self
    {
        $this->wxAccout = $value;
        
        return $this;
    }

    /**
     * 支付宝账号
     * 
     * @return string
     */
    public function getAlipayAccount()
    {
        return $this->alipayAccount;
    }

    /**
     * 银行卡号
     * 
     * @return string
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * 店铺商品页面左侧显示类型【 0默认1商城相关分类品牌商品推荐】
     * 
     * @return int
     */
    public function getBarType()
    {
        return $this->barType;
    }

    /**
     * 自营店是否绑定全部分类【 0否1是】
     * 
     * @return int
     */
    public function getBuildAll()
    {
        return $this->buildAll;
    }

    /**
     * 店铺分类【编号】
     * 
     * @return int
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * 佣金比例【0-100】
     * 
     * @return mixed
     */
    public function getCommission()
    {
        return $this->commission;
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
     * 信誉
     * 
     * @return int
     */
    public function getCredibility()
    {
        return $this->credibility;
    }

    /**
     * 开启店铺装修【仅显示店铺装修(1-是 0-否】
     * 
     * @return int
     */
    public function getDecorationOnly()
    {
        return $this->decorationOnly;
    }

    /**
     * 店铺装修开关【0-关闭 装修编号-开启】
     * 
     * @return int
     */
    public function getDecorationSwitch()
    {
        return $this->decorationSwitch;
    }

    /**
     * 描述
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 店铺营业结束时间
     * 
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * 超出该金额免运费【大于0才表示该值有效】
     * 
     * @return float
     */
    public function getFreePrice()
    {
        return $this->freePrice;
    }

    /**
     * 店铺等级
     * 
     * @return int
     */
    public function getGradeId()
    {
        return $this->gradeId;
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
     * 店铺装修相册图片数量
     * 
     * @return int
     */
    public function getImageCount()
    {
        return $this->imageCount;
    }

    /**
     * 是否分销店铺【0-否，1-是】
     * 
     * @return int
     */
    public function getIsDistribution()
    {
        return $this->isDistribution;
    }

    /**
     * 是否自营店铺 【1是 0否】
     * 
     * @return int
     */
    public function getIsOwn()
    {
        return $this->isOwn;
    }

    /**
     * 联系方式
     * 
     * @return int
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * 联系人姓名
     * 
     * @return string
     */
    public function getPersonName()
    {
        return $this->personName;
    }

    /**
     * 打印订单页面下方说明文字
     * 
     * @return string
     */
    public function getPrintDesc()
    {
        return $this->printDesc;
    }

    /**
     * 店铺名称
     * 
     * @return string
     */
    public function getShopName()
    {
        return $this->shopName;
    }

    /**
     * 店铺营业开始时间
     * 
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * 推荐【0为否，1为是，默认为0】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 地址编号
     * 
     * @return int
     */
    public function getStoreAddress()
    {
        return $this->storeAddress;
    }

    /**
     * 店铺收藏数量
     * 
     * @return int
     */
    public function getStoreCollect()
    {
        return $this->storeCollect;
    }

    /**
     * 店铺logo
     * 
     * @return string
     */
    public function getStoreLogo()
    {
        return $this->storeLogo;
    }

    /**
     * 店铺销量
     * 
     * @return int
     */
    public function getStoreSales()
    {
        return $this->storeSales;
    }

    /**
     * 店铺排序
     * 
     * @return mixed
     */
    public function getStoreSort()
    {
        return $this->storeSort;
    }

    /**
     * 店铺状态【0关闭，1开启，2审核中】
     * 
     * @return int
     */
    public function getStoreState()
    {
        return $this->storeState;
    }

    /**
     * 店铺当前主题
     * 
     * @return int
     */
    public function getThemeId()
    {
        return $this->themeId;
    }

    /**
     * 店铺类型【0个人入驻 1企业入驻】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
     * 店主【编号】
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 微信账号
     * 
     * @return string
     */
    public function getWxAccout()
    {
        return $this->wxAccout;
    }
}
