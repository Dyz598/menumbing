<?php

declare(strict_types=1);

namespace Menumbing\Orm\Factory;

use Menumbing\Orm\Persistent\DatabasePersistent;
use Psr\Container\ContainerInterface;

use function Hyperf\Config\config;
use function Hyperf\Support\make;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class PersistentFactory
{
    public function __invoke(ContainerInterface $container, array $parameters = [])
    {
        $middlewares = config('orm.persistent.middlewares', []);

        return make(config('orm.persistent.class', DatabasePersistent::class), compact('middlewares'));
    }
}
