<?php

require_once( dirname(__DIR__) . '/vendor/autoload.php');

use App\Classes\Factory\RedisFactory;
use App\Services\AvastService;

echo "\n====================================\n";
echo "Start parse data to Redis cache \n";

$key = ($argv[1] == '-v') ? 2 : 1;

try {
    $service = new AvastService(RedisFactory::get($argv[$key + 1], $argv[$key + 2], $argv[$key + 3]), $argv[$key]);
    $service->run($argv[1] == '-v');
} catch (Exception $e) {
    echo "\n====================================\n";
    printf("Error: %s", $e->getMessage());
    echo "\n====================================\n\n";
    exit();
}

echo "Succeed !";
echo "\n====================================\n";