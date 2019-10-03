<?php
declare(strict_types = 1);
namespace Common\Tool\Extend;

/**
 * 处理三级分类
 * @author Administrator
 *
 */
class ClassificationTreatment
{
	/**
	 * 分类数据
	 * @var array
	 */
	private $data = [];
	
	/**
	 * 分类key
	 * @var array
	 */
	private $classKey = [];
	
	/**
	 * 
	 * @param array $classData
	 */
	public function __construct(array $classData, array $classKey)
	{
		$this->data = $classData;
		
		$this->classKey = $classKey;
	}
	
	/**
	 * 
	 * @param array $classKey
	 */
	public function setClassKey (array $classKey) :void
	{
		$this->classKey = $classKey;	
	}
	
	/**
	 *
	 * @param array $classKey
	 */
	public function setClassData (array $classData) :void
	{
		$this->data = $classData;
	}
	
	/**
	 * 获取分类id组成的数组
	 * @return array
	 */
	public function getClassIdArray() :array
	{
		$classOne = array_column($this->data, $this->classKey[0]);
		
		$classTwo = array_column($this->data, $this->classKey[1]);
		
		$classThree = array_column($this->data, $this->classKey[2]);
		
		$allClass =  array_merge($classOne, $classTwo, $classThree);
		
		return $allClass;
	}
	
	/**
	 * 析构方法
	 */
	public function __destruct()
	{
		unset($this->data, $this->classKey);
	}
}
