<?php
declare(strict_types = 1);

namespace Tool;

/**
 * 处理参数接口
 * @author wq
 *
 */
interface ParamsParseInterface
{
    /**
     * 组合数据
     * @return array
     */
    public function compositeData(array $correlationData) :array;
    
    /**
     * @return the $dataSources
     */
    public function getDataSources() :array;
    
    
    /**
     * @return the $field
     */
    public function getField() :array;
    
    
    /**
     * @return the $correlationKey
     */
    public function getCorrelationKey() :string;
    
    /**
     * @return the $splitKey
     */
    public function getSplitKey() :string;
    
    /**
     * 组合数据 list
     */
    public function compositeList(array $correlationData) :array;
}