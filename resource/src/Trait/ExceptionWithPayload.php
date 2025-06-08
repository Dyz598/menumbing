<?php

declare(strict_types=1);

namespace Menumbing\Resource\Trait;

use Psr\Http\Message\ResponseInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
trait ExceptionWithPayload
{
    protected array $payload = [];

    protected ?int $httpStatusCode;

    public function generateHttpResponse(ResponseInterface $response): ResponseInterface
    {
        $headers = $this->getHttpHeaders();

        $payload = $this->getPayload();

        foreach ($headers as $header => $content) {
            $response = $response->withHeader($header, $content);
        }

        $jsonEncodedPayload = json_encode($payload);

        $responseBody = false === $jsonEncodedPayload ? 'JSON encoding of payload failed' : $jsonEncodedPayload;

        $response->getBody()->write($responseBody);

        return $response->withStatus($this->getHttpStatusCode());
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode ?? 500;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getHttpHeaders(): array
    {
        return [
            'Content-type' => 'application/json',
        ];
    }
}
