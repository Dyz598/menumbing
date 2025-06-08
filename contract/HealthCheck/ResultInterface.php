<?php

declare(strict_types=1);

namespace Menumbing\Contract\HealthCheck;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
interface ResultInterface
{
    public function getName(): string;

    public function getStatus(): bool;

    public function getMessage(): string;

    public function toArray(): array;
}
