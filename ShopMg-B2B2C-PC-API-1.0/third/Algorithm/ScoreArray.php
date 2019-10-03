<?php
declare(strict_types=1);
namespace Algorithm;

/**
 * 打分类
 * @author Administrator
 */
class ScoreArray
{
	/**
	 * 获取皮尔逊相关系数
	 * @param array $me 当前登录用户评分数据
	 * @param array $otherPerson 其他用户 评分数据
	 * @return array
	 */
	public static function score( array $me, array $otherPerson) :array
	{
		$item = [];
		
		$tmpKey = '';
		
		$keyArray = [];
		
		$result = 0;
		
		foreach ($me as $key => $value) {
			
			foreach ($otherPerson as $goodsId => $rec) {
				
				if ($key == $goodsId) {
					continue;
				}
				
				$tmpKey = $key > $goodsId ? $goodsId.'_'.$key : $key.'_'.$goodsId;
				
				if (isset($keyArray[$tmpKey])) {
					continue;
				}
				
				$keyArray[$tmpKey] = $tmpKey;
				
				$result = Correlation::pearson($value, $rec);
				
				if (is_nan($result)) {
					continue;
				}
				
				$item[$tmpKey] = $result;
			}
		}
		
		return $item;
	}
	
	/**
	 * 选区相关性高的
	 * @param array $score 评分
	 */
	public static function filter( array $fiter) :array
	{
		$temp = [];
		foreach ($fiter as $key => $value) {
			if ($value > 0.5) {
				$temp[$key] = $value;
			}
		}
		return $temp;
	}
}