<?php

declare(strict_types=1);

namespace Menumbing\HealthCheck\Checker;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\RedisFactory;
use Menumbing\Contract\HealthCheck\CheckerInterface;
use Menumbing\Contract\HealthCheck\ResultInterface;
use Menumbing\HealthCheck\Result;
use Psr\Container\ContainerInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class RedisChecker implements CheckerInterface
{
    const CHECKER_NAME = 'redis';

    #[Inject]
    protected ContainerInterface $container;

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }

    public function check(array $options = []): ResultInterface
    {
        $pool = $options['pool'] ?? 'default';

        try {
            $redis = $this->container->get(RedisFactory::class)->get($pool);
            $pong = $redis->ping();

            if ($this->isValidPingResponse($pong)) {
                return new Result(self::CHECKER_NAME, true, 'Redis connection is OK');
            }

            return new Result(self::CHECKER_NAME, false, 'Unexpected Redis ping result: ' . $pong);
        } catch (\Throwable $e) {
            return new Result(self::CHECKER_NAME, false, $e->getMessage());
        }
    }

    private function isValidPingResponse(string|bool $response): bool
    {
        if (true === $response) {
            return true;
        }

        return in_array(strtolower($response), ['+pong', 'pong'], true);
    }
}
