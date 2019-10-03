<?php
declare(strict_types = 1);
namespace Tool;
use Swoft\Db\QueryBuilder;
use Swoft\Core\ResultInterface;
use Swoft\Db\Bean\Collector\EntityCollector;
use Swoft\Db\Exception\DbException;


/**
 * Query 代理
 * @author wq
 */
class QueryBuilderProxy
{
    /**
     * 实例
     * @var QueryBuilderProxy
     */
    private static $instance;
    
    /**
     * @var QueryBuilder
     */
    private $queryBuild;
    
    
    /**
     *
     * @var array
     */
    private $field = [];
    
    /**
     * @return QueryBuilder
     */
    public function getQueryBuild()
    {
        return $this->queryBuild;
    }
    
    private function __construct(string $tableName, string $alias = null)
    {
//         CollectionParserTool::init();
        
        $this->queryBuild = new QueryBuilder();
        $this->queryBuild->table($tableName, $alias);
    }
    
   
    
    /**
     * @return Query
     */
    public static function getInstance(string $tableName, string $alias = null) : self
    {
        return new static($tableName, $alias);   
    }
    
    /**
     * @param mixed $column
     * @param int   $amount
     *
     * @return \Swoft\Core\ResultInterface
     */
    public function counter($column, $amount = 1): int
    {
        return $this->queryBuild->counter($column, $amount)->getResult('items');
    }
    /**
     * where语句
     * @param string $column
     * @param mixed  $value
     * @param string $operator
     * @param string $connector
     * @return QueryBuilder
     */
    public function where(string $column, $value, $operator = QueryBuilder::OPERATOR_EQ, $connector = QueryBuilder::LOGICAL_AND): QueryBuilderProxy
    {
        $this->queryBuild->where($column, $value, $operator, $connector);
        
        return $this;
    }
    
    /**
     * limit语句
     *
     * @param int $limit
     * @param int $offset
     *
     * @return QueryBuilder
     */
    public function limit(int $limit, $offset = 0) :self
    {
        $this->queryBuild->limit($limit, $offset);
        
        return $this;
    }
    
    /**
     * 字段
     */
    public function field($field, bool $isTicket = false) :self
    {
        $this->field= is_string($field) ? explode(',', $field) : $field;
        
        return $this;
    }
    
    
    public function order(string $column, string $order = 'ASC') :self
    {
        $this->queryBuild->orderBy($column, $order);
        
        return $this;
    }
    
    /**
     * where条件中，括号开始(左括号)
     *
     * @param string $connector
     *
     * @return QueryBuilder
     */
    public function openWhere($connector = 'AND'): self
    {
        $this->queryBuild->openWhere($connector);
        
        return $this;
    }
    
    /**
     * where条件中，括号结束(右括号)
     *
     * @return QueryBuilder
     */
    public function closeWhere(): self
    {
        $this->queryBuild->closeWhere();
        
        return $this;
    }
    
    
    /**
     * 查询结果(一条数据)
     * @return ResultInterface
     */
    public function find() :array
    {
        $data = $this->queryBuild->one($this->field)->getResult('items');
        
        $this->field = [];
        
        return $data;
    }
    
    
    /**
     * 查询结果
     * @return ResultInterface
     */
    public function select() :array
    {
        $data = $this->queryBuild->get($this->field)->getResult('items');
        
        $this->field = [];
        
        return $data;
    }
    
    /**
     * 清理
     */
    public function clear() :void
    {
        $this->queryBuild = null;
    }
    
    /**
     * inner join语句
     *
     * @param string       $table
     * @param string|array $criteria
     * @param string       $alias
     *
     * @return QueryBuilder
     * @throws \Swoft\Db\Exception\DbException
     */
    public function innerJoin(string $table, $criteria = null, string $alias = null): self
    {
        $this->queryBuild->innerJoin($table, $criteria, $alias);
        
        return $this;
    }
    
    /**
     * left join语句
     *
     * @param string       $table
     * @param string|array $criteria
     * @param string       $alias
     *
     * @return QueryBuilder
     * @throws \Swoft\Db\Exception\DbException
     */
    public function leftJoin(string $table, $criteria = null, string $alias = null): self
    {
        $this->queryBuild->leftJoin($table, $criteria, $alias);
        
        return $this;
    }
    
    /**
     * where and 语句
     *
     * @param string $column
     * @param mixed  $value
     * @param string $operator
     *
     * @return QueryBuilder
     */
    public function andWhere(string $column, $value, $operator = '='): self
    {
        $this->queryBuild->andWhere($column, $value, $operator);
        
        return $this;
    }
    
    
    /**
     * where or 语句
     *
     * @param string $column
     * @param mixed  $value
     * @param string $operator
     *
     * @return QueryBuilder
     */
    public function orWhere($column, $value, $operator = '='): self
    {
        $this->queryBuild->orWhere($column, $value, $operator);
        
        return $this;
    }
    /**
     * group by语句
     *
     * @param string $column
     * @param string $order
     *
     * @return QueryBuilder
     */
    public function groupBy(string $column, string $order = null): self
    {
        $this->queryBuild->groupBy($column, $order);
        
        return $this;
    }
    
    /**
     * having语句
     *
     * @param string $column
     * @param mixed  $value
     * @param string $operator
     * @param string $connector
     *
     * @return QueryBuilder
     */
    public function having(string $column, $value, string $operator = '=', string $connector = 'and'): self
    {
        $this->queryBuild->having($column, $value, $operator, $connector);
        
        return $this;
    }
    
    /**
     * where in 语句
     *
     * @param string $column
     * @param array  $values
     * @param string $connector
     *
     * @return QueryBuilder
     */
    public function whereIn(string $column, array $values, string $connector = 'AND'): self
    {
        
        $this->queryBuild->whereIn($column, $values, $connector);
        
        return $this;
    }
    
    
    /**
     * between语句
     * @param string $column
     * @param mixed  $min
     * @param mixed  $max
     * @param string $connector
     *
     * @return QueryBuilder
     */
    public function whereBetween(string $column, $min, $max, string $connector = 'AND'): self
    {
        $this->queryBuild->whereBetween($column, $min, $max, $connector);
        
        return $this;
    }
    
    /**
     * The $condition is array
     *
     * Format `['column1' => value1, 'column2' => value2, ...]`
     * - ['name' => 'swoft', 'status' => 1] => ('name'='swoft' and 'status' = 1)
     * - ['id' => [1, 2, 3], 'status' => 1] => ('id' in (1, 2, 3) and 'status' = 1)
     *
     * Format `[operator, operand1, operand2, ...]`
     * - ['id', '>', 12]
     * - ['id', '<', 13]
     * - ['id', '>=', 13]
     * - ['id', '<=', 13]
     * - ['id', '<>', 13]
     *
     * - ['id', 'in', [1, 2, 3]]
     * - ['id', 'not in', [1, 2, 3]]
     *
     * - ['id', 'between', 2, 3]
     * - ['id', 'not between', 2, 3]
     *
     * - ['name', 'like', '%swoft%']
     * - ['name', 'not like', '%swoft%']
     *
     *
     * @param array $condition
     *
     * @return \Swoft\Db\QueryBuilder
     */
    public function condition(array $condition): self
    {
        $this->queryBuild->condition($condition);
        
        return $this;
    }
    
    /**
     * @param array $condition
     */
    public function andCondition(array $condition) :self
    {
        $this->queryBuild->andCondition($condition);
        
        return $this;
    }
    
    /**
     * 处理字段对应关系
     * @return array
     */
    public function getField() :array
    {
        $data = $this->queryBuild->get($this->field)->getResult(['items']);
        
        if (count($data) === 0) {
            return [];
        }
        
        $keyTwo = $this->field[1];
        
        
        $keyOne = $this->field[0];
        
        return $this->parseAssocData($data, $keyOne, $keyTwo);
    }
    
    /**
     * 处理字段对应关系(带有别名)
     * @return array
     */
    public function getAliasField() :array
    {
        $data = $this->queryBuild->get($this->field)->getResult(['items']);
        if (count($data) ===0) {
            $this->field = [];
            return [];
        }
        
        $field = array_keys($data[0]);
        
        $keyTwo = $field[1];
        
        $keyOne = $field[0];
        
        return $this->parseAssocData($data, $keyOne, $keyTwo);
    }
    
    /**
     *
     * @param array $data
     * @param string $keyTwo
     * @return array
     */
    private function parseAssocData(array $data, string $keyOne, string $keyTwo): array
    {
        $cols = [];
        
        $count = count($this->field);
        
        foreach ($data as $result){
            $name   =  $result[$keyOne];
            if(2 === $count) {
                $cols[$name]   =  $result[$keyTwo];
            } else {
                $cols[$name]   = $result;
            }
        }
        $this->field = [];
        
        return $cols;
    }
    
    /**
     * @param array $values
     *
     * @return ResultInterface
     */
    public function save(array $values): int
    {
        return $this->queryBuild->update($values)->getResult(['items']);
    }
    
    /**
     * @param array $values
     *
     * @return ResultInterface
     * @throws MysqlException
     */
    public function add(array $values): int
    {
        return $this->queryBuild->insert($values)->getResult('items');
    }
    
    /**
     * @param array $rows
     * @return ResultInterface
     * @throws MysqlException
     */
    public function addAll(array $rows): int
    {
        return  $this->queryBuild->batchInsert($rows)->getResult('items');
    }
    
    /**
     * delete语句
     */
    public function delete() :int
    {
        return $this->queryBuild->delete()->getResult(['items']);
    }
    
    /**
     * @param string $column
     * @param string $alias
     *
     * @return ResultInterface
     */
    public function avg(string $column, string $alias = 'avg'): int
    {
        return $this->queryBuild->avg($column, $alias)->getResult(['items']);
    }
    
    /**
     * @param string $column
     * @param string $alias
     *
     * @return ResultInterface
     */
    public function sum(string $column, string $alias = 'sum'): float
    {
        return $this->queryBuild->sum($column, $alias)->getResult('items');
    }
    
    /**
     * 排他锁语句
     */
    public function forUpdate(): self
    {
        $this->queryBuild->forUpdate();
        
        return $this;
    }
    /**
     * 设置多个参数
     *
     * @param array $parameters
     *    $parameters = [
     *    'key1' => 'value1',
     *    'key2' => 'value2',
     *    ]
     *    $parameters = [
     *    'value1',
     *    'value12',
     *    ]
     *    $parameters = [
     *    ['key', 'value', 'type'],
     *    ['key', 'value'],
     *    ['key', 'value', 'type'],
     *    ]
     * @throws \Swoft\Db\Exception\DbException
     * @return $this
     */
    public function bind(array $condition): self
    {
        $this->queryBuild->setParameters($condition);
        
        return $this;
    }
    
    
    /**
     * @param string $column
     * @param string $alias
     *
     * @return ResultInterface
     */
    public function count(string $column = '*', string $alias = 'count'): int
    {
        return (int)$this->queryBuild->count($column, $alias)->getResult('items');
    }
    
    /**
     * 实体类名获取表名
     * @param string $tableName
     * @return string
     * @throws DbException
     */
    public static function getTableNameByClassName($tableName): string
    {
        // 不是实体类名
        if (strpos($tableName, '\\') === false) {
            return $tableName;
        }
        
        $entities = EntityCollector::getCollector();
        if (!isset($entities[$tableName]['table']['name'])) {
            throw new DbException('Class is not an entity，className=' . $tableName);
        }
        return $entities[$tableName]['table']['name'];
    }
    
    /**
     * 析构方法
     */
    public function __destruct()
    {
        $this->queryBuild = null;
    }
}