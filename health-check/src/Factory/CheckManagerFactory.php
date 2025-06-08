<?php

declare(strict_types=1);

namespace Menumbing\HealthCheck\Factory;

use Hyperf\Contract\ConfigInterface;
use Menumbing\HealthCheck\Checker\CheckManager;
use Psr\Container\ContainerInterface;

use function Hyperf\Support\make;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class CheckManagerFactory
{
    public function __construct(protected ContainerInterface $container, protected ConfigInterface $config)
    {
    }

    public function __invoke()
    {
        return new CheckManager(
            array_map(
                fn(string $checker) => make($checker),
                $this->config->get('health-check.checkers', [])
            )
        );
    }
}
