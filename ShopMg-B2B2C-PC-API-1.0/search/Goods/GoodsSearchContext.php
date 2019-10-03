<?php
declare(strict_types = 1);
namespace Search\Goods;

use Swoft\Log\Log;

/**
 * 搜索上下文
 * @author wq
 */
class GoodsSearchContext
{

    /**
     * 栈对象
     * 
     * @var \SplStack
     */
    private $splStack;

    /**
     * 具体处理的命名空间
     */
    private const PARSE_PARAM_NAMESPACE = [
        'price_member' => 'Search\Goods\Item\GoodsPriceSearchParam',
        'brand_id' => 'Search\Goods\Item\GoodsBrandSearchParam'
    ];

    /**
     * 处理多维搜索参数的具体命名空间
     */
    private const PARSE_MANY_PARAM_NAMESPACE = [
        'class_id' => 'Search\Goods\ManyItem\GoodsClassSearchParam'
    ];

    /**
     * 静态对象
     * 
     * @var GoodsSearchContext
     */
    private static $context;
    

    /**
     *
     * @return the $splStack
     */
    public function getSplStack()
    {
        return $this->splStack;
    }

    private function __construct()
    {
        $this->splStack = new \SplStack();
    }

    /**
     * 获取实例
     * 
     * @return self
     */
    public static function getInstance(array $searchParam): self
    {
        if (! static::$context instanceof GoodsSearchContext) {
            static::$context = new static();
        }
        static::$context->splStack->push($searchParam);
        
        return static::$context;
    }

    /**
     * 处理流程
     * @return array
     */
    public function start(): array
    {
        $param = static::$context->splStack->shift();
        
        $i = 0;
        
        try {
            
            /**
             * @var Search\ParseParamBySearchInterface $reflection
             */
            $reflection = null;
            
            $condition = [];
            
            foreach (static::PARSE_MANY_PARAM_NAMESPACE as $key => $value) {
                
                if (! isset($param[$key])) {
                    continue;
                }
                // 如果不需要知道这个类的其他信息那么就用 可变变量的方式，反之用ReflectionClass
                $reflection = new $value();
                
                $condition[$i] = $reflection->parse($param[$key]);
                
                $i ++;
            }
            
            $singleData = [];
            $i = 0;
            
            foreach (static::PARSE_PARAM_NAMESPACE as $columnKey => $parseClass) {
                
                if (! isset($param[$columnKey])) {
                    continue;
                }
              
                // 如果不需要知道这个类的其他信息那么就用 可变变量的方式，反之用ReflectionClass
                $reflection = new $parseClass($columnKey);
                
                $singleData[$i] = $reflection->parse($param[$columnKey]);
                $i ++;
            }
            
            foreach ($condition as $id => $merge) {
                
                $singleData = array_merge($merge, $singleData);
            }
            
            return $singleData;
            
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['商品搜索']);
            return [];
        }
    }
    /**
     * 关闭复制方法
     */
    private function __clone()
    {}
    
    /**
     * 销毁数据
     */
    public function destory() :void
    {
        while (static::$context->splStack->valid()) {
            
            static::$context->splStack->pop();
            
            static::$context->splStack->next();
            
        }
    }
}