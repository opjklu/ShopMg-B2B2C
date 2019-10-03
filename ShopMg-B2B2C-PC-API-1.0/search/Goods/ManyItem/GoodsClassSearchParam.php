<?php
declare(strict_types = 1);
namespace Search\Goods\ManyItem;

use Search\ParseParamBySearchInterface;

/**
 * 商品分类搜索
 * @author wq
 */
class GoodsClassSearchParam implements ParseParamBySearchInterface
{
    /**
     * 分类等级
     * @var array
     */
    private $level = [
        'class_id',
        'class_two',
        'class_three'
    ];
    
    /**
     * {@inheritDoc}
     * @see ParseParamBySearchInterface::parse()
     */
    public function parse(string $data): array
    {
        $classData = explode('-', $data);
        
        $length = count($classData);
        
        $index = 0;
        
        $classCondition = [];
        
        for ($index; $index < $length; $index++) {
            $classCondition[$index] = [$this->level[$index], '=', (int)$classData[$index]];
        }
        return $classCondition;
    }
}