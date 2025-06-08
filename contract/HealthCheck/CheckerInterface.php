<?php

declare(strict_types=1);

namespace Menumbing\Contract\HealthCheck;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
interface CheckerInterface
{
    public function getName(): string;

    public function check(array $options = []): ResultInterface;
}
