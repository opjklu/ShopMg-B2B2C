<?php
namespace Tool;


class Tool
{

    protected static $handler;

    protected static $curret;

    /**
     * 连接子类引擎
     */
    public static function connect($className, $args = null)
    {
        $classObj = 'Tool\\Extend\\' . $className;
        try {
            $args = ($className == 'ArrayParse' || $className == 'ArrayChildren') ? (array) $args : $args;
            self::$handler[$className] = empty(self::$handler[$classObj]) ? new $classObj($args) : self::$handler[$className];
            self::$curret = self::$handler[$className];
            return self::$curret;
        } catch (\Exception $e) {}
    }

    /**
     * 处理多对多数组
     * 
     * @param array $oneArray
     *            被合并得数组
     * @param array $twoMany
     *            合并到得数组
     * @param string $conditionKey
     *            根据某个键 合并数据
     * @return array
     */
    public static function oneReflectManyArray(array $oneArray, array $twoMany, string $conditionKey, string $splitKey): array
    {
        $temp = array();
        
        foreach ($oneArray as $key => &$value) {
            if (empty($value[$conditionKey])) {
                continue;
            }
            
            $temp[$value[$conditionKey]] = $value;
        }
        
        foreach ($twoMany as $key => &$name) {
            $name = array_merge(empty($temp[$name[$splitKey]]) ? [] : $temp[$name[$splitKey]], $name);
        }
        
        return $twoMany;
    }

    /**
     * 静态调用子类的方法
     */
    public static function __callstatic($methods, $args)
    {
        return call_user_func_array(array(
            self::$curret,
            $methods
        ), $args);
    }
}