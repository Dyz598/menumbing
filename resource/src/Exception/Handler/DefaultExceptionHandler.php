<?php

declare(strict_types=1);

namespace Menumbing\Resource\Exception\Handler;

use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Menumbing\Contract\Exception\HasHttpResponseInterface;
use Menumbing\Resource\Contract\ResourceStrategyInterface;
use Menumbing\Resource\Trait\MergeResponse;
use Psr\Http\Message\ResponseInterface;
use Swow\Psr7\Message\ResponsePlusInterface;
use Throwable;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class DefaultExceptionHandler extends ExceptionHandler
{
    use MergeResponse;

    #[Inject]
    protected ResourceStrategyInterface $resource;

    public function handle(Throwable $throwable, ResponsePlusInterface $response)
    {
        if ($this->resource->supports($throwable)) {
            $this->stopPropagation();

            if ($throwable instanceof HasHttpResponseInterface) {
                return $throwable->generateHttpResponse($response);
            }

            $resource = $this->resource->render($throwable);

            if ($resource instanceof ResponseInterface) {
                $resource = $this->mergeAll($response, $resource);
            }

            return $resource;
        }

        return $response
            ->setStatus($this->getStatusCode($throwable))
            ->setBody(new SwooleStream($throwable->getMessage()));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }

    protected function getStatusCode(Throwable $throwable): int
    {
        if ($throwable instanceof HttpException) {
            return $throwable->getStatusCode();
        }

        if ($throwable->getCode()
            && is_int($throwable->getCode())
            && $throwable->getCode() >= 400
            && $throwable->getCode() < 500) {
            return $throwable->getCode();
        }

        return 500;
    }
}
