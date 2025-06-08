<?php

declare(strict_types=1);

namespace Menumbing\HealthCheck\Http\Controller;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Menumbing\HealthCheck\Checker\CheckManager;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class HealthCheckController
{
    #[Inject]
    protected CheckManager $checkManager;

    #[Inject]
    protected ConfigInterface $config;

    #[Inject]
    protected ResponseInterface $response;

    public function liveness(): PsrResponseInterface
    {
        $results = $this->checkManager->checkAll($this->config->get('health-check.checks.liveness', []));

        $results['status'] = 'ready' === $results['status'] ? 'alive' : 'dead';
        $statusCode = $results['status'] === 'alive' ? 200 : 503;

        return $this->response($results, $statusCode);
    }

    public function readiness(): PsrResponseInterface
    {
        $results = $this->checkManager->checkAll($this->config->get('health-check.checks.readiness', []));

        $statusCode = $results['status'] === 'ready' ? 200 : 503;

        return $this->response($results, $statusCode);
    }

    protected function response(array $result, int $statusCode): PsrResponseInterface
    {
        return $this->response
            ->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(new SwooleStream(json_encode($result)));
    }
}
