<?php

namespace App\Classes\Factory;

use Redis;

class RedisFactory {
    /**
     * @param string $host
     * @param int $port
     * @param int $dbNumber
     * @return Redis
     */
    static public function get(string $host, int $port, int $dbNumber): Redis {

        $redis = new Redis();
        $redis->connect($host, $port);
        $redis->select($dbNumber);

        return $redis;
    }
}