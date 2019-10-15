<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
namespace Tool;

/**
 * 数组操作子类
 */
class ArrayChildren
{

    private $data = array();

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return the $data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 三维数组 转二维数组
     */
    public function d3ToD2()
    {
        $data = $this->data;
        if (empty($data)) {
            return array();
        }
        
        $tmp = [];
        
        foreach ($data as $value) {
            foreach ($value as $v) {
                $tmp[] = $v;
            }
        }
        return $tmp;
    }

    /**
     *
     * @param
     *            Ambigous <multitype:, array> $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * 以相同的状态重组数组
     * 
     * @param string $statusKey
     *            状态键
     * @return array
     */
    public function inTheSameState($statusKey)
    {
        $array = $this->data;
        
        if (empty($array)) {
            return [];
        }
        
        $temp = [];
        
        foreach ($array as $value) {
            $temp[$value[$statusKey]][] = $value;
        }
        
        return $temp;
    }

    /**
     * 去除空字段
     * 
     * @param array $array
     *            要处理的数组
     * @return array
     */
    public function deleteEmptyByArray(array $array)
    {
        if (empty($array)) {
            return array();
        }
        
        foreach ($array as $key => $value) {
            if (empty($value)) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * 处理属性数组【组成 规格 属性】【根据post传值】以后优化
     */
    public function parseSpecific()
    {
        $data = & $this->data;
        
        if (empty($data)) {
            return array();
        }
        // 倒序排序
        foreach ($data as $key => & $value) {
            $value = $this->rsort($value);
        }
        
        $specArrSort = $parseData = array();
        
        // 排序
        foreach ($data as $k => $v) {
            $specArrSort[$k] = count($v);
        }
        
        asort($specArrSort);
        
        foreach ($specArrSort as $key => $val) {
            $parseData[$key] = $data[$key];
        }
        
        unset($data);
        $array = array();
        // 笛卡尔积
        $array['cartesianProduct'] = $this->combineDika($parseData);
        
        $array['arrayKeys'] = array_keys($specArrSort);
        
        return $array;
    }

    /**
     * 多个数组的笛卡尔积
     *
     * @param unknown_type $data            
     * @return array
     */
    public function combineDika()
    {
        $data = func_get_args();
        
        $data = current($data);
        $cnt = count($data);
        $result = array();
        $arr1 = array_shift($data);
        
        foreach ($arr1 as $key => $item) {
            $result[] = array(
                $item
            );
        }
        
        foreach ($data as $key => $item) {
            $result = $this->combineArray($result, $item);
        }
        return $result;
    }

    /**
     * 两个数组的笛卡尔积
     *
     * @param array $arr1            
     * @param array $arr2            
     * @return array;
     */
    public function combineArray(array $arr1, array $arr2)
    {
        if (empty($arr1) || empty($arr2)) {
            return array();
        }
        $result = array();
        foreach ($arr1 as $item1) {
            foreach ($arr2 as $item2) {
                $temp = $item1;
                $temp[] = $item2;
                $result[] = $temp;
            }
        }
        return $result;
    }

    /**
     * 根据 标识 删除数组数据
     */
    public function deleteByCondition($condition = '_')
    {
        $array = $this->data;
        if (empty($array)) {
            return array();
        }
        
        foreach ($array as $key => $value) {
            if (false === strpos($key, $condition)) {
                continue;
            }
            
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * 组装 筛选控件
     * @param array $data 数据
     * @return array
     */
    public function buildActive(array $data = array())
    {
        $data = empty($data) ? $this->data : $data;
        
        if (0 === count($data)) {
            return array();
        }
        foreach ($data as $key => $value) {
            if (($value === 0 || $value === '0')) {
                continue;
            }
            if (!$value) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * 合并数组
     * 
     * @param array $arrayByMerge
     *            被合并的数组
     * @param array $arrayMaster
     *            合并到该数组上
     * @return array；
     */
    public function mergeArray(array $arrayByMerge, array $arrayMaster)
    {
        if (empty($arrayByMerge) || empty($arrayMaster)) {
            return array();
        }
        sort($arrayByMerge);
        sort($arrayMaster);
        
        foreach ($arrayByMerge as $key => $value) {
            if (! isset($arrayMaster[$key])) {
                $arrayMaster[$key] = $arrayMaster[$key - 1];
            }
            $arrayMaster[$key] = array_merge($arrayMaster[$key], $value);
        }
        return $arrayMaster;
    }

    /**
     * 是否存在相同的键值
     */
    public function isExitsSameValue($key)
    {
        $value = $this->data;
        if (($number = count($value)) < 1 || ! isset($value[$key])) {
            return $value;
        }
        
        $shiftValue = array_shift($value);
        
        $end = array();
        
        if ($number === 2) {
            
            $end = end($value);
        }
        
        if ($end[$key] === $shiftValue[$key]) {
            return true;
        }
        
        $num = 0;
        
        foreach ($value as $name => $same) {
            if (in_array($shiftValue[$key], $same, true)) {
                $num ++;
            }
        }
        
        return $num > 1 ? true : false;
    }

    /**
     * 倒序排序
     * 
     * @param array $data
     *            待排序的数组
     * @return array
     */
    public function rsort(array $data = null)
    {
        $data = empty($data) ? $this->data : $data;
        // 排序
        $length = count($data);
        
        $temp = null;
        
        for ($i = 0; $i < $length / 2; $i ++) {
            $temp = $data[$i];
            $data[$i] = $data[$length - 1 - $i];
            $data[$length - 1 - $i] = $temp;
        }
        return $data;
    }

    /**
     * 数组两两交换值【迭代】
     * 
     * @param mixed $arg1
     *            要交换的键
     * @param mixed $arg2
     *            被交换的键
     * @return array
     */
    public function arrayExchange($arg1, $arg2)
    {
        $arr = $this->data;
        $r = range(0, count($arr) - 1);
        $res = $res_bak = array_combine($r, array_keys($arr));
        $change = array(
            $arg1,
            $arg2
        );
        list ($res[array_search($change[0], $res_bak)], $res[array_search($change[1], $res_bak)]) = array(
            $change[1],
            $change[0]
        );
        foreach ($res as $v) {
            $array[$v] = $arr[$v];
        }
        return $array;
    }

    /**
     * 转换为一位数组
     * 
     * @param string $key
     *            以哪个键转换
     * @return array
     */
    public function betchArray($key)
    {
        $data = $this->data;
        
        if (empty($data)) {
            return array();
        }
        
        $tmp = array();
        
        foreach ($data as $value) {
            $tmp[] = $value[$key];
        }
        
        return $tmp;
    }
   
    /**
     * 以id作为数组序号
     * @param string $keyId 分割键
     * @return multitype:[]
     */
    public function convertIdByData (string $covertKey) :array
    {
        $data = $this->data;
        
        if (empty($data)) {
            return [];
        }
        
        $temp = [];
        
        foreach ($data as $key => $value) {
            if (!isset($value[$covertKey])) {  
                return [];
            }
            
            $temp[$value[$covertKey]] = $value;
        }
        unset($data);
        return $temp;
    }
    
    /**
     * 数组两两交换值
     * @return array
     */
    public function easyExchange()
    {
        $array = $this->data;
        $i = 1;
        $j = 0;
        $length = count($array);
        
        if ($length === 0) {
            return $array;
        }
        
        foreach ($array as $key => $value) {
            if ($i >= $length || $j >= $length) {
                break;
            }
            
            list ($array[$i], $array[$j]) = array(
            		$array[$j],
            		$array[$i]
            );
            $i += 2;
            $j += 2;
        }
        return $array;
    }
    
    /**
     * 状态 改为键 value改为汉字提示；
     * @param array $prompt 提示的数组
     * @return array
     */
    public function changeKeyValueToPrompt(array $prompt)
    {
        $array = $this->data;
      
        if (empty($array)) {
            return [];
        }
        
        $flag = array();
        foreach ($array as $key => $value) {
            if (! array_key_exists($key, $prompt)) {
                continue;
            }
            $flag[$value] = $prompt[$key];
        }
        unset($array, $prompt);
        return $flag;
    }
    /**
     * 根据配置删除数组中特定建
     * @param string $suffix 后缀
     * @return []
     */
    public function deleteKeyByArray($suffix)
    {
        if (empty($this->data)) {
            return [];
        }
        
        $data = $this->data;
        
        foreach ($data as $key => & $value) {
            if (false === strpos($key, $suffix)) {
                unset($data[$key]);
            }
        }
        return $data;
    }
    
    /**
     * 按值排序 不改变 键
     * @return array;
     */
    public function  sortByValue()
    {
        $array = $this->data;
        
        if (empty($array)) {
            return array();
        }
    
        $tempArray  = $array; //复制一份 用于恢复键
    
        sort($array);
         
        $returnArray = array();
    
        foreach ($array as $key => $value) {
    
            if (!in_array($value, $tempArray, true)) {
                continue;
            }
    
            $returnArray[array_search($value, $tempArray)] = $value;
        }
        unset($tempArray);
        return $returnArray;
    }
    
    /**
     * 根据关联数组获取数据
     * @return []
     */
    public function getArrayAssocByData(array $data)
    {
    	$modeConf = [];
    	foreach ($this->data as $key => $value) {
    		
    		if (!empty($data[$key])) {
    			$modeConf[$key] = $value;
    		}
    	}
    	return $modeConf;
    }
    
    /**
     * 析构方法
     */
    public function __destruct()
    {
        $this->data  = [];
    }
}