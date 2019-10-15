<?php
declare(strict_types = 1);

namespace Search;

/**
 * 搜索处理
 * @author wq
 */
interface ParseParamBySearchInterface
{
    /**
     * 处理参数生成查询条件
     * @param string $data
     * @param array $search
     * @return array
     */
    public function parse(string $data) :array;
}