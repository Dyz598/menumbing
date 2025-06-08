<?php

declare(strict_types=1);

namespace Menumbing\HealthCheck\Listener;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\HttpServer\Router\DispatcherFactory;
use Hyperf\HttpServer\Router\RouteCollector;
use Menumbing\HealthCheck\Http\Controller\HealthCheckController;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class RegisterRoutesListener implements ListenerInterface
{
    public function __construct(
        private DispatcherFactory $dispatcherFactory,
        private ConfigInterface $config
    ) {
    }

    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    public function process(object $event): void
    {
        $paths = $this->config->get('health-check.route.paths', []);

        if (null !== $paths['liveness'] ?? null) {
            $this->getRouter()->addRoute('GET', $paths['liveness'], [HealthCheckController::class, 'liveness']);
        }

        if (null !== $paths['readiness'] ?? null) {
            $this->getRouter()->addRoute('GET', $paths['readiness'], [HealthCheckController::class, 'readiness']);
        }
    }

    private function getRouter(): RouteCollector
    {
        return $this->dispatcherFactory->getRouter(
            $this->config->get('health-check.route.server', 'http')
        );
    }
}
