<?php
declare(strict_types = 1);

namespace Search\Goods\Item;

use Search\ParseParamBySearchInterface;
use Search\AbstractParamParse;

/**
 * 品牌搜索
 * @author wq
 */
class GoodsBrandSearchParam extends AbstractParamParse implements ParseParamBySearchInterface
{
    /**
     * {@inheritDoc}
     * @see ParseParamBySearchInterface::parse()
     */
    public function parse(string $data): array
    {
        return [$this->columnKey, '=', (int)$data];
    }
}