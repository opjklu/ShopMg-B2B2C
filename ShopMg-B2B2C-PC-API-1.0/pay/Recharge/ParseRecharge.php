<?php
declare(strict_types = 1);
namespace Pay\Recharge;

use Swoft\Db\Query;
use Swoft\Db\Db;
use App\Common\FieldMapping\Balance;

/**
 * 余额处理
 * 
 * @author wq
 *        
 */
class ParseRecharge
{
    const  TABLE_NAME = 'mg_balance';

    /**
     * 计算总价
     */
    private static function totaMoney(array $data): float
    {
        
        $totalMoney = 0;
        
        foreach ($data as $value) {
            $totalMoney += $value['total_money'];
        }
        
        return $totalMoney;
    }

    /**
     * 处理余额
     * @param array $data
     * @param string $description
     * @return array
     */
    public static function getResult(array $data, string $description) :array
    {
        $totalMoney = static::totaMoney($data);
        
        return static::parseBalance($totalMoney, 0, $description);
    }
    
    /**
     * 开店
     * @return array
     */
    public static function openShopParse(array $data, string $description) :array
    {
        return static::parseBalance($data['money'], 0, $description);
    }

    /**
     * 处理金额
     *
     * @param $totalMoney
     * @param int $type
     * @param string $description
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    private static function parseBalance($totalMoney, int $type = 0, string $description = ''): array
    {
        $moery = static::getMoneyByLock();
        
        if ($moery < $totalMoney) {
            
           Db::rollBack();
            
            return [
                'status' => 0,
                'message' => '余额不足',
                'data' => 0
            ];
        }
        $result = [
            Balance::$userId => session()->get('user_id'),
            Balance::$accountBalance => floatval($moery - $totalMoney),
            Balance::$description => $description,
            Balance::$type => $type,
            Balance::$changesBalance => $totalMoney,
            Balance::$lockBalance => 0,
            Balance::$status => 1,
            Balance::$modifyTime => time()
        ];
        
        try {
            $status = Query::table(static::TABLE_NAME)->insert($result)->getResult('items');
            
            if ($status === 0) {
                Db::rollback();
                
                return [
                    'status' => 0,
                    'message' => '减少余额失败',
                    'data' => '',
                    'balance_id' => $status
                ];
            }
            
            Db::commit();
            
            return [
                'status' => 1,
                'data' => '',
                'message' => '余额充足',
                'balance_id' => $status
            ];
        } catch (\Exception $e) {
            
            Db::rollBack();
            
            return [
                'status' => 0,
                'message' => $e->getMessage(),
                'data' => ''
            ];
        }
    }

    /**
     * 加锁获取金额
     * 
     * @return float
     */
    private static function getMoneyByLock(): float
    {
        Db::beginTransaction();
        
        $data = Query::table(static::TABLE_NAME)->forUpdate()
            ->where(Balance::$userId, session()->get('user_id'))
            ->where(Balance::$status, 1)
            ->orderBy(Balance::$id, 'DESC')
            ->one([
            Balance::$accountBalance,
            Balance::$lockBalance
        ])
            ->getResult('items');
        
        if (0 === count($data)) {
            return 0;
        }
        
        $money = floatval($data[Balance::$accountBalance] - $data[Balance::$lockBalance]);
        
        return $money;
    }
}