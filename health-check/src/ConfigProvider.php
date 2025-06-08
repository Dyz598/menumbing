<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Menumbing\HealthCheck;

use Menumbing\HealthCheck\Checker\CheckManager;
use Menumbing\HealthCheck\Factory\CheckManagerFactory;
use Menumbing\HealthCheck\Http\Controller\HealthCheckController;
use Menumbing\HealthCheck\Listener\RegisterRoutesListener;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                CheckManager::class => CheckManagerFactory::class,
                HealthCheckController::class => HealthCheckController::class,
            ],
            'listeners' => [
                RegisterRoutesListener::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for health-check.',
                    'source' => __DIR__ . '/../publish/health-check.php',
                    'destination' => BASE_PATH . '/config/autoload/health-check.php',
                ],
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
        ];
    }
}
