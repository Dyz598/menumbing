<?php

declare(strict_types=1);

namespace Menumbing\HealthCheck;

use Menumbing\Contract\HealthCheck\ResultInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class Result implements ResultInterface
{
    public function __construct(
        public readonly string $name,
        public readonly bool $status,
        public readonly string $message
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function toArray(): array
    {
        return [
            'name'    => $this->name,
            'status'  => $this->status,
            'message' => $this->message,
        ];
    }
}
