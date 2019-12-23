<?php

declare(strict_types=1);

use Shlinkio\Shlink\Common\Cache\RedisFactory;
use Shlinkio\Shlink\Common\Lock\RetryLockStoreDelegatorFactory;
use Shlinkio\Shlink\Common\Logger\LoggerAwareDelegatorFactory;
use Symfony\Component\Lock;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

$localLockFactory = 'Shlinkio\Shlink\LocalLockFactory';

return [

    'locks' => [
        'locks_dir' => __DIR__ . '/../../data/locks',
    ],

    'dependencies' => [
        'factories' => [
            Lock\Store\FlockStore::class => ConfigAbstractFactory::class,
            Lock\Store\RedisStore::class => ConfigAbstractFactory::class,
            Lock\Factory::class => ConfigAbstractFactory::class,
            $localLockFactory => ConfigAbstractFactory::class,
        ],
        'aliases' => [
            // With this config, a user could alias 'lock_store' => 'redis_lock_store' to override the default
            'lock_store' => 'local_lock_store',

            'redis_lock_store' => Lock\Store\RedisStore::class,
            'local_lock_store' => Lock\Store\FlockStore::class,
        ],
        'delegators' => [
            Lock\Store\RedisStore::class => [
                RetryLockStoreDelegatorFactory::class,
            ],
            Lock\Factory::class => [
                LoggerAwareDelegatorFactory::class,
            ],
        ],
    ],

    ConfigAbstractFactory::class => [
        Lock\Store\FlockStore::class => ['config.locks.locks_dir'],
        Lock\Store\RedisStore::class => [RedisFactory::SERVICE_NAME],
        Lock\Factory::class => ['lock_store'],
        $localLockFactory => ['local_lock_store'],
    ],

];
