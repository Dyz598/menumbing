<?php

declare(strict_types=1);

namespace Menumbing\HealthCheck\Checker;

use Menumbing\Contract\HealthCheck\CheckerInterface;
use Menumbing\Contract\HealthCheck\ResultInterface;
use Menumbing\HealthCheck\Result;

use function Hyperf\Collection\data_get;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class MemoryChecker implements CheckerInterface
{
    const CHECKER_NAME = 'memory';

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }

    public function check(array $options = []): ResultInterface
    {
        $maxMemory = data_get($options, 'max_memory');

        if (null === $maxMemory) {
            return new Result(self::CHECKER_NAME, true, 'Memory usage is OK');
        }

        $usedMemoryMb = memory_get_usage(true) / 1024 / 1024;

        if ($usedMemoryMb > $maxMemory) {
            return new Result(self::CHECKER_NAME, false, 'Memory usage is too high');
        }

        return new Result(self::CHECKER_NAME, true, 'Memory usage is OK');
    }
}
