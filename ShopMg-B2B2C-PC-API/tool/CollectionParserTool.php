<?php
declare(strict_types = 1);

namespace Tool;

use Swoft\Db\Bean\Annotation\Connection;
use Swoft\Db\Driver\Driver;
use Swoft\Db\Bean\Collector\ConnectionCollector;

class CollectionParserTool
{
    /**
     * 覆盖注解
     */
    public static function init(): void
    {
        static $connection;
        
        if (!$connection) {
            
            $connection = new Connection(['driver' => Driver::MYSQL]);
            
            ConnectionCollector::collect(MysqlConnection::class, $connection);
        }
    }
}