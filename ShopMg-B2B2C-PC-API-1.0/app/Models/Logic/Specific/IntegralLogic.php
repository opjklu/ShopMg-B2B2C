<?php
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\IntegralUse;
use App\Models\Entity\DbIntegral;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 用户积分逻辑处理层
 * @Bean()
 */
class IntegralLogic extends AbstractLogic
{

    public function __construct()
    {
        $this->tableName = DbIntegral::class;
    }

    public function getResult()
    {}

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return IntegralUse::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
        return [
            IntegralUse::$id
        ];
    }

    /**
     * 会员积分明细日志
     */
    public function integralLog()
    {
        $userId = session('user_id');
        
        // #TODO 这里是查询条件
        $this->searchTemporary = [
            IntegralUse::$userId => $userId
        ];
        
        // #TODO 这里是要查询的字段如果不传的话默认为表中的所有字段
        $this->searchField = "integral, goods_id, FROM_UNIXTIME(trading_time,'%Y-%m-%d') as trading_time, remarks, type, status, used";
        
        // #TODO 这里是按照什么排序查询，如果不传默认为ID DESC排序
        $this->searchOrder = 'trading_time DESC';
        
        // #TODO 调用通用的获取列表的接口并返回数据 data=>['countTotal'=>2, 'records'=>[.....]]
        $data = parent::getDataList();
        return $data;
    }
}
