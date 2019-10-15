<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Models\Logic;

use Exception;
use ReflectionClass;
use Swoft\Db\Exception\DbException;
use Tool\ArrayChildren;
use Tool\Db;
use Tool\ParamsParseInterface;
use Tool\QueryBuilderProxy;

/**
 * 逻辑处理层抽象类
 *
 * @author 米糕网络科技团队
 * @version 1.1.2
 */
abstract class AbstractLogic
{
    /**
     * 错误消息
     *
     * @var string
     */
    protected $errorMessage = '';

    /**
     * 时间临时缓存键 // 时间搜索键
     *
     * @var string
     */
    private $timeGpKey = 'timegp';

    /**
     * 搜索标记 该条件是否有数据
     *
     * @var boolean[]
     */
    protected $whereExits = [];

    /**
     *
     * @var string
     */
    protected $tableName = '';

    /**
     *
     * @return the $whereExits
     */
    public function getWhereExits(): bool
    {
        return array_pop($this->whereExits) === false;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * 设置模糊查询字段
     */
    protected function likeSerachArray(): array
    {
        return [];
    }

    /**
     * 获取搜索时间key
     */
    protected function getSearchTimeKey()
    {
        $model = $this->getMapperClassName();

        return $model::$createTime;
    }

    /**
     * 获取排序
     */
    protected function getSearchOrderKey(): array
    {
        $model = $this->getMapperClassName();
        return [
            $model::$id => 'DESC'
        ];
    }

    /**
     * 获取关联条件
     *
     * @return array
     */
    public function getAssociationCondition(array $post)
    {
        $where = $this->getSearchBuildWhere($post);
        if (0 === count($where)) {
            return [];
        }

        $model = $this->getMapperClassName();

        $data = $this->getQueryBuilderProxy()
            ->field($model::$id)
            ->condition($where)
            ->select();

        if (0 === count($data)) {
            $this->whereExits[] = FALSE;

            return [];
        }

        return array_column($data, $model::$id);
    }

    /**
     * 处理时间 搜索条件
     *
     * @return array
     */
    protected function parseTimeWhere(array $post)
    {
        $key = $this->timeGpKey;

        if (empty($post[$key])) {
            return [];
        }

        $timeParam = $post[$key];
        if (empty($timeParam) || false === strpos($timeParam, ' - ')) {
            return array();
        }

        list ($startTime, $endTime) = explode(' - ', $timeParam);

        $startTime = strtotime($startTime);

        $endTime = strtotime($endTime);

        return [$this->getSearchTimeKey(), 'between', $startTime, $endTime];
    }

    /**
     * 获取列表并转换成map
     *
     * @return array
     */
    public function getDataList(): array
    {
        $data = $this->getParseDataByList();

        if (empty($data['data'])) {
            $this->errorMessage = '暂无数据';

            return [];
        }


        $data['data'] = (new ArrayChildren($data['data']))->convertIdByData('id');

        return $data;
    }

    /**
     * 获取分页数据列表
     *
     * @param array $post
     * @param array $where
     * @return array
     */
    public function getParseDataByList(array $post, array $where = []): array
    {
        $options = $this->buildWhere($post, $where);

        $data = $this->getDataByPage($post, $options);
        return $data;
    }

    /**
     * 介于搜索（普通的）
     * @param array $post
     * @return array
     */
    protected function getIntermediateQuery(array $post)
    {
        $colum = $this->getIntermediateQueryColumn();

        $where = [];

        foreach ($colum as $key => $value) {

            list ($left, $right) = $value;

            if (empty($post[$left])) {
                continue;
            }

            $rightValue = empty($post[$right]) ? $post[$left] + 10000 : $post[$right];

            $where[] = [
                $key,
                'between',
                (int)$post[$left],
                (int)$rightValue
            ];
        }

        return $where;
    }

    /**
     * 获取介于查询字段
     *
     * @return array
     */
    protected function getIntermediateQueryColumn(): array
    {
        return [];
    }

    /**
     *
     * @param array $post
     * @param array $associationWhere
     * @return array
     */
    protected function buildWhere(array $post = [], array $associationWhere = []): array
    {
        // 店铺搜索条件
        $where = $this->getSearchBuildWhere($post);

        // 匹配搜索条件
        $matchWhere = $this->getMatchingSearchBuildWhere($post);

        $where = array_merge($where, $associationWhere, $matchWhere);

        if (!empty($post[$this->timeGpKey])) {

            $timeWhere = $this->parseTimeWhere($post);
            $where[] = $timeWhere;
        }

        $options = [
            'field' => $this->getTableColum(),
            'order' => $this->getOrderBySearch($post),
            'where' => $where
        ];

        return $options;
    }

    /**
     * 专用于搜索
     *
     * @param array $post
     * @return array
     */
    protected function getOrderBySearch(array $post): array
    {
        $orderBy = $this->getSearchOrderKey();

        $condition = [
            'ASC',
            'DESC'
        ];

        $buildWhere = [];

        foreach ($orderBy as $key => $value) {
            if (!isset($post[$key])) {
                continue;
            }
            $buildWhere[$key] = $condition[$post[$key]];
        }
        return $buildWhere;
    }

    /**
     * 组装搜索条件
     *
     * @param array $post
     *            搜索条件
     * @return array
     */
    public function getSearchBuildWhere(array $post): array
    {
        unset($post['page']);

        if (0 === count($post)) {

            return array();
        }

        $likeSearch = $this->likeSerachArray();

        if (0 === count($likeSearch)) {
            return [];
        }

        $search = [];

        foreach ($likeSearch as $key => $value) {
            if (empty($post[$value])) {

                continue;
            }

            $search[] = [
                $value,
                'like',
                $post[$value] . '%'
            ];
        }
        return $search;
    }

    /**
     * 获取具体搜索字段（非模糊）
     *
     * @return array
     */
    protected function searchArray(): array
    {
        return [];
    }

    /**
     * 获取分页数据列表 无搜索
     *
     * @param array $post
     * @return array
     */
    public function getParseDataByListNoSearch(array $post): array
    {
        // 匹配搜索条件
        $fixedSearchConditions = $this->fixedSearchConditions();

        $data = $this->getDataByPage($post, [
            'where' => $fixedSearchConditions,
            'order' => $this->getSearchOrderKey()
        ]);

        return $data;
    }

    /**
     * 获取固定条件
     *
     * @return array
     */
    protected function fixedSearchConditions(): array
    {
        return [];
    }

    /**
     * 组装搜索条件（匹配搜索）
     *
     * @return array
     */
    protected function getMatchingSearchBuildWhere(array $post): array
    {
        if (0 === count($post)) {
            return [];
        }

        $search = $this->searchArray();

        if (0 === count($search)) {
            return [];
        }

        $lenth = count($search);

        $splFixedArray = [];

        $j = 0;

        for ($i = 0; $i < $lenth; $i++) {

            if (!isset($post[$search[$i]])) {
                continue;
            }

            $splFixedArray[$j] = [
                $search[$i],
                '=',
                (int)$post[$search[$i]]
            ];

            $j++;
        }

        return $splFixedArray;
    }

    /**
     * 分页读取数据
     *
     * @param array $post
     * @param array $options
     * @return array
     */
    protected function getDataByPage(array $post, array $options): array
    {
        $pageNumber = $this->getPageNumber();

        $options = $this->parseOption($options);

        $count = $this->getQueryBuilderProxy()
            ->condition($options['where'])
            ->count();

        $page = $post['page'];

        $page = ($page - 1) * $pageNumber;
        $proxyQueryOBj = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition($options['where']);

        $order = $options['order'];
        foreach ($order as $key => $value) {
            $proxyQueryOBj->order($key, $value);
        }
        $data = $proxyQueryOBj->limit($pageNumber, $page)->select();

        $array['page'] = $count;
        $array['page_size'] = $pageNumber;

        return [
            'data' => $data,
            'count' => $count,
            'page_size' => $pageNumber
        ];
    }

    /**
     * 获取无分页数据列表
     *
     * @param array $post
     * @return array
     */
    public function getNoPageList(array $post): array
    {
        $options = $this->buildWhere($post);

        $options = $this->parseOption($options);

        $queryObj = $this->getQueryBuilderProxy()
            ->field($options['field'])
            ->condition($options['where']);

        foreach ($options['order'] as $key => $value) {
            $queryObj->order($key, $value);
        }

        return $queryObj->select();
    }

    /**
     * 获取 单条数据
     *
     * @param array $post
     * @return array
     */
    public function getFindOne(array $post)
    {
        $model = $this->getMapperClassName();

        $where = $this->getWhereByFindOne();

        $where[$model::$id] = $post['id'];

        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition($where)
            ->find();
    }

    /**
     * 获取条件根据单条
     *
     * @return array
     */
    protected function getWhereByFindOne(): array
    {
        return [];
    }

    /**
     * 析构方法
     */
    public function __destruct()
    {
        $this->tableName = '';

        $this->errorMessage = '';
    }

    /**
     * 获取结果
     */
    abstract public function getResult();

    /**
     * 获取当前模型类名
     */
    abstract public function getMapperClassName(): string;

    /**
     * 获取要隐藏注释的字段
     *
     * @return array
     */
    protected function hideenComment()
    {
        return [];
    }

    /**
     * 获取本模型静态属性【数据库字段】
     *
     * @return array
     * @throws \ReflectionException
     */
    protected function getStaticProperties(): array
    {
        return (new ReflectionClass($this->getMapperClassName()))->getStaticProperties();
    }

    /**
     * 获取本表字段
     *
     * @return array
     * @throws \ReflectionException
     */
    protected function getTableColum(): array
    {
        return array_values($this->getStaticProperties());
    }

    /**
     * 根据其他模型数据 获取相应的数据 适应于一对一关系map
     *
     * @param ParamsParseInterface $paramEntity
     * @return array
     */
    protected function getDataByOtherModel(ParamsParseInterface $paramEntity): array
    {
        $getData = $this->getAssociatedData($paramEntity);

        if (empty($getData)) {
            return $paramEntity->getDataSources();
        }

        $data = $this->parseReflectionData($getData, $paramEntity);

        return $data;
    }

    /**
     * getDataByOtherModel附属方法
     */
    protected function parseReflectionData(array $getData, ParamsParseInterface $paramEntity)
    {
        return $paramEntity->compositeData($getData);
    }

    /**
     * 获取关联数据
     *
     * @return array
     */
    protected function getAssociatedData(ParamsParseInterface $paramEntity): array
    {
        return $this->getAssciatedSource($paramEntity, $this->getIdString($paramEntity));
    }

    /**
     * 获取数据源
     *
     * @param ParamsParseInterface $paramEntity
     * @param array $ids
     * @return array
     */
    protected function getAssciatedSource(ParamsParseInterface $paramEntity, array $ids): array
    {
        if (0 === count($ids)) {
            $this->errorMessage = '条件为空';
            return [];
        }

        $queryBuilder = $this->getQueryBuilderProxy()->whereIn($paramEntity->getCorrelationKey(), $ids);

        $this->parseWhere($queryBuilder);

        return $queryBuilder->field($paramEntity->getField())
            ->select();
    }

    /**
     * 根据字段获取字符串
     *
     * @param ParamsParseInterface $paramEntity
     * @return array
     */
    protected function getIdString(ParamsParseInterface $paramEntity): array
    {
        return array_column($paramEntity->getDataSources(), $paramEntity->getSplitKey());
    }

    /**
     * 处理关联数据 list
     * @param ParamsParseInterface $paramEntity
     * @return array
     */
    protected function parseAssociatedData(ParamsParseInterface $paramEntity): array
    {
        $getData = $this->getAssociatedData($paramEntity);

        if (0 === count($getData)) {
            return $paramEntity->getDataSources();
        }

        return $paramEntity->compositeList($getData);
    }

    /**
     * getDataByOtherModel 附属方法
     * @param QueryBuilderProxy $queryBuilder
     */
    protected function parseWhere(QueryBuilderProxy $queryBuilder): void
    {
    }

    /**
     * 根据主表数据查从表数据
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getSlaveDataByMaster(array $data, string $splitKey)
    {
        if (0 === count($data)) {
            return [];
        }

        $field = $this->getSlaveField();

        $idArray = array_column($data, $splitKey);

        if (0 === count($idArray)) {
            return $data;
        }

        $slaveColumnWhere = $this->getSlaveColumnByWhere();

        $slaveData = $this->getAccessData($field, $idArray, $slaveColumnWhere);

        if (0 === count($slaveData)) {
            return $data;
        }

        $slaveData = $this->parseSlaveData($data, $splitKey, $slaveData, $slaveColumnWhere);

        return $slaveData;
    }

    /**
     * 获取关联数据
     *
     * @return array
     */
    protected function getAccessData(array $field, array $idArray, string $slaveColumnWhere): array
    {
        $queryBuild = $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn($slaveColumnWhere, $idArray);

        // 再次处理
        $this->parseSlaveWhereAgain($queryBuild);

        return $queryBuild->select();
    }

    /**
     * 数据处理组合
     *
     * @param array $data
     * @param string $splitKey
     * @param array $slaveData
     * @param string $slaveColumnWhere
     * @return array
     */
    protected function parseSlaveData(array $data, string $splitKey, array $slaveData, $slaveColumnWhere)
    {
        foreach ($slaveData as $key => &$value) {
            if (empty($data[$value[$slaveColumnWhere]])) {
                continue;
            }
            $value = array_merge($value, $data[$value[$slaveColumnWhere]]);
        }

        return $slaveData;
    }

    /**
     * 获取从表字段（根据主表数据查从表数据的附属方法）
     *
     * @return array
     */
    protected function getSlaveField()
    {
        return [];
    }

    /**
     * 获取从表生成where条件的字段（根据主表数据查从表数据的附属方法）
     */
    protected function getSlaveColumnByWhere()
    {
        $model = $this->getMapperClassName();
        return $model::$id;
    }

    /**
     * 再次处理where 根据主表数据查从表数据
     *
     * @return string
     */
    protected function parseSlaveWhereAgain(QueryBuilderProxy $queryBuild)
    {
    }

    /**
     * 获取分页数目
     */
    protected function getPageNumber(): int
    {
        return 15;
    }

    /**
     * 处理条件
     *
     * @param array $options
     * @return array
     */
    protected function parseOption(array $options): array
    {
        return $options;
    }

    /**
     * 获取提示消息
     *
     * @return string[][]
     */
    public function getMessageNotice()
    {
        return [];
    }

    /**
     * 添加
     * @param array $insert
     * @return int
     */
    public function addData(array $insert = []): int
    {
        $insertId = 0;

        $data = $this->getParseResultByAdd($insert);

        try {

            $insertId = $this->getQueryBuilderProxy()->add($data);
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return 0;
        }

        return $insertId;
    }

    /**
     * 批量添加
     * @param array $post
     * @return boolean
     */
    public function addAll(array $post = [])
    {
        $data = $this->getParseResultByAddAll($post);
        try {
            $status = $this->getQueryBuilderProxy()->addAll($data);
            return $status;
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage() . '，添加失败';
            return false;
        }
    }

    /**
     * 批量添加时处理
     *
     * @param array $post
     * @return array []
     */
    protected function getParseResultByAddAll(array $post): array
    {
        return $post;
    }

    /**
     * 保存
     * @param array $update
     * @return int
     */
    public function saveData(array $update = []): int
    {
        $status = 0;

        $data = $this->getParseResultBySave($update);
        try {
            $status = $this->updateCommonAction($data);
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
        return $status;
    }

    /**
     * @param array $data
     * @return int
     */
    private function updateCommonAction(array $data): int
    {
        $objectColumn = $this->getMapperClassName();

        $where = [
            'id' => $data[$objectColumn::$id]
        ];

        unset($data[$objectColumn::$id]);

        $where = array_merge($this->getWhereBySaveAndDelete(), $where);

        return $this->getQueryBuilderProxy()
            ->condition($where)
            ->save($data);
    }

    /**
     * 保存时条件处理
     *
     * @param array $post
     * @return array
     */
    protected function getWhereBySaveAndDelete(): array
    {
        return [];
    }

    /**
     * 保存时处理参数
     *
     * @param array $update
     * @return array
     */
    protected function getParseResultBySave(array $update = []): array
    {
        return $update;
    }

    /**
     * 添加时处理参数
     *
     * @param array $insert
     * @return array
     */
    protected function getParseResultByAdd(array $insert): array
    {
        return $insert;
    }

    /**
     * 删除
     * @param array $post
     * @return int
     */
    public function delete(array $post): int
    {
        $where = [
            'id' => $post['id']
        ];

        $where = array_merge($this->getWhereBySaveAndDelete(), $where);

        return $this->getQueryBuilderProxy()
            ->condition($where)
            ->delete();
    }

    /**
     * 要更新的数据【已经解析好的】
     *
     * @param array $data
     * @return array
     */
    protected function getDataToBeUpdated(array $data): array
    {
        return $data;
    }

    /**
     * 要更新的字段
     *
     * @return array
     */
    protected function getColumToBeUpdated(): array
    {
        return [];
    }

    /**
     * 批量更新 组装sql语句【核心】
     *
     * @param array $data
     * @return string
     * @throws DbException
     */
    protected function buildUpdateSql(array $data): string
    {
        $parseData = $this->getDataToBeUpdated($data);

        if (0 === count($parseData)) {
            return '';
        }

        $keyArray = $this->getColumToBeUpdated();

        if (0 === count($keyArray)) {
            return '';
        }

        $sql = 'UPDATE ' . QueryBuilderProxy::getTableNameByClassName($this->tableName) . '  SET ';

        $flag = 0;

        $primaryKey = $this->bitchPrimaryKey();

        $coulumValue = null;

        foreach ($keyArray as $k => $v) {
            $sql .= '`' . $v . '`' . '= CASE ' . '`' . $primaryKey . '`';
            foreach ($parseData as $a => $b) {
                $coulumValue = $this->parseUpdateValue($b[$flag]);

                $sql .= sprintf(" WHEN %s THEN %s \t\n ", $a, $coulumValue);
            }
            $flag++;
            $sql .= 'END,';
        }

        $sql = substr($sql, 0, -1);

        $where = ' WHERE `' . $primaryKey . '` in(' . implode(',', array_keys($parseData)) . ')';
        // 监听条件
        $sql .= $where;
        return $sql;
    }

    /**
     * 更新时处理值
     *
     * @param string $args
     * @return string
     */
    protected function parseUpdateValue($args)
    {
        return $args;
    }

    /**
     * 获取批量更新条件字段
     *
     * @return string
     */
    protected function bitchPrimaryKey(): string
    {
        $modelName = $this->getMapperClassName();

        $primaryKey = $modelName::$id;

        return $primaryKey;
    }

    /**
     * 事务消息
     *
     * @param $status
     * @return bool
     * @throws DbException
     */
    protected function traceStation($status): bool
    {
        if (!$status) {
            Db::rollback();
            $this->errorMessage .= '、事务更新失败';
            return false;
        }
        return true;
    }

    /**
     * 获取主键编号
     */
    public function getPrimaryKey(): string
    {
        $model = $this->getMapperClassName();

        return $model::$id;
    }

    /**
     * 获取build代理
     *
     * @param string|null $alias
     * @return QueryBuilderProxy
     */
    public function getQueryBuilderProxy(string $alias = null): QueryBuilderProxy
    {
        return QueryBuilderProxy::getInstance($this->tableName, $alias);
    }

    /**
     * 筛选数据
     *
     * @param array $data
     * @return array
     */
    protected final function filterDataByPost(array $data): array
    {
        $field = $this->getStaticProperties();

        $result = [];

        foreach ($field as $key => $value) {

            if (!isset($data[$value])) {
                continue;
            }
            $result[$value] = $data[$value];
        }
        return $result;
    }
}