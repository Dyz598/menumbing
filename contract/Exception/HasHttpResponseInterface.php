<?php

declare(strict_types=1);

namespace Menumbing\Contract\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
interface HasHttpResponseInterface
{
    public function generateHttpResponse(ResponseInterface $response): ResponseInterface;
}
