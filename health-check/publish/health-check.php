<?php

return [
    'checks' => [
        'liveness' => [
            'memory_consumption' => [
                'checker' => 'memory',
                'options' => ['max_memory' => 1000] // 1 Gb
            ]
        ],

        'readiness' => [
            'database' => [
                'checker' => 'db',
                'options' => ['connection' => 'default']
            ],
            'redis' => [
                'checker' => 'redis',
                'options' => ['pool' => 'default']
            ],
        ]
    ],

    'route' => [
        'server' => 'http',
        'paths' => [
            'liveness' => '/health/liveness',
            'readiness' => '/health/readiness',
        ]
    ],

    'checkers' => [
        Menumbing\HealthCheck\Checker\DbChecker::class,
        Menumbing\HealthCheck\Checker\MemoryChecker::class,
        Menumbing\HealthCheck\Checker\RedisChecker::class,
    ],
];
