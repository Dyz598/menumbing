<?php

declare(strict_types=1);

namespace Menumbing\HealthCheck\Checker;

use Hyperf\DbConnection\Db;
use Menumbing\Contract\HealthCheck\CheckerInterface;
use Menumbing\Contract\HealthCheck\ResultInterface;
use Menumbing\HealthCheck\Result;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class DbChecker implements CheckerInterface
{
    const CHECKER_NAME = 'db';

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }

    public function check(array $options = []): ResultInterface
    {
        $connection = $options['connection'] ?? 'default';

        try {
            Db::connection($connection)->select('SELECT 1');

            return new Result(self::CHECKER_NAME, true, 'Database connection is OK');
        } catch (\Throwable $e) {
            return new Result(self::CHECKER_NAME, false, $e->getMessage());
        }
    }
}
