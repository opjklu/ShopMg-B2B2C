<?php
declare(strict_types = 1);

namespace Search\Goods\Item;

use Search\ParseParamBySearchInterface;
use Search\AbstractParamParse;

/**
 * 价格搜索
 * @author wq
 */
class GoodsPriceSearchParam extends AbstractParamParse implements ParseParamBySearchInterface
{
   
    /**
     * {@inheritDoc}
     * @see ParseParamBySearchInterface::parse()
     */
    public function parse(string $data): array
    {
        // TODO Auto-generated method stub
        
        list($minPrice, $maxPrice) = explode('-', $data);
        
        return [$this->columnKey, 'between', (float)$minPrice, (float)$maxPrice];
    }
}