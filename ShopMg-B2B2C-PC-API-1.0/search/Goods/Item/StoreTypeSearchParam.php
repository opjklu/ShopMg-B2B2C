<?php
declare(strict_types = 1);
namespace Search\Goods\Item;

use Search\ParseParamBySearchInterface;
use Search\AbstractParamParse;

/**
 * 是否自营
 * @author wq
 */
class StoreTypeSearchParam extends AbstractParamParse implements ParseParamBySearchInterface
{

    /**
     * {@inheritdoc}
     *
     * @see ParseParamBySearchInterface::parse()
     */
    public function parse(string $data): array
    {
        return [
            $this->columnKey,
            '=',
            (int)$data
        ];
    }
}