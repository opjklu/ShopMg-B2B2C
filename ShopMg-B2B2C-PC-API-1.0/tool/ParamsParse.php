<?php
declare(strict_types = 1);
namespace Tool;

/**
 * 参数实体
 *
 * @author wq
 */
class ParamsParse implements ParamsParseInterface
{

    /**
     * 数据来源
     *
     * @var array
     */
    private $dataSources = [];

    /**
     * 字段数组
     *
     * @var array
     */
    private $field = [];

    /**
     * 关联key
     *
     * @var string
     */
    private $correlationKey = '';

    /**
     * 分割键
     *
     * @var string
     */
    private $splitKey = '';

    /**
     * 架构方法
     */
    public function __construct(array $dataSources, array $field, string $correlationKey, string $splitKey)
    {
        $this->dataSources = $dataSources;
        
        $this->field = $field;
        
        $this->correlationKey = $correlationKey;
        
        $this->splitKey = $splitKey;
    }

    /**
     *
     * @return the $dataSources
     */
    public function getDataSources(): array
    {
        return $this->dataSources;
    }

    /**
     *
     * @return the $field
     */
    public function getField(): array
    {
        return $this->field;
    }

    /**
     *
     * @return the $correlationKey
     */
    public function getCorrelationKey(): string
    {
        return $this->correlationKey;
    }

    /**
     *
     * @return the $splitKey
     */
    public function getSplitKey(): string
    {
        return $this->splitKey;
    }

    /**
     * 组合数据 （map）
     *
     * @return array
     */
    public function compositeData(array $correlationData): array
    {
        if (0 === count($correlationData)) {
            return $this->dataSources;
        }
        
        $temp = array();
        
       
        
        foreach ($correlationData as $key => &$value) {
            if (! isset($value[$this->correlationKey])) {
                continue;
            }
            
            $temp[$value[$this->correlationKey]] = $value;
        }
        
        $flagArray = array();
        
        foreach ($this->dataSources as $key => &$source) {
            
           
            
            
            $flagArray[$source[$this->correlationKey]] = array_merge(empty($temp[$source[$this->splitKey]]) ? [] : $temp[$source[$this->splitKey]], $source);
        }
        
        unset($temp);
        return $flagArray;
    }

    /**
     * 组合数据 list
     */
    public function compositeList(array $correlationData): array
    {
        $correlationKey = $this->getCorrelationKey();
        
        $temp = array();
        
        foreach ($correlationData as $key => &$value) {
            if (! isset($value[$correlationKey])) {
                continue;
            }
            $temp[$value[$correlationKey]] = $value;
        }
        
        $splitKey = $this->getSplitKey();
        
        $data = $this->getDataSources();
        
        foreach ($data as $key => &$combination) {
            
            $combination = array_merge(empty($temp[$combination[$splitKey]]) ? [] : $temp[$combination[$splitKey]], $combination);
        }
        return $data;
    }

    /**
     * 析构方法
     */
    public function __destruct()
    {
        $this->correlationKey = '';
        
        $this->dataSources = [];
        
        $this->field = [];
        
        $this->splitKey = '';
    }
}