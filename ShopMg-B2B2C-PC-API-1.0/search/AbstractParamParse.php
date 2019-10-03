<?php
declare(strict_types = 1);
namespace Search;

/**
 * 抽象参数解析类
 * @author wq
 */
abstract class AbstractParamParse
{
    /**
     * 查询key
     * @var string
     */
    protected $columnKey = '';
    
    public function __construct(string $columnKey) 
    {
        $this->columnKey = $columnKey;
    }
    
    public function __destruct()
    {
        $this->columnKey = '';
    }
}