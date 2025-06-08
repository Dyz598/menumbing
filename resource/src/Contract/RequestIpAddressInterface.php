<?php

declare(strict_types=1);

namespace Menumbing\Resource\Contract;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
interface RequestIpAddressInterface
{
    public function getClientIp(): ?string;

    public function getClientIps(): array;

    public function isFromTrustedProxy(): bool;

    public function isSecure(): bool;
}
