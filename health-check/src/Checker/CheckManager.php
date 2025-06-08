<?php

declare(strict_types=1);

namespace Menumbing\HealthCheck\Checker;

use Menumbing\Contract\HealthCheck\CheckerInterface;
use Menumbing\Contract\HealthCheck\ResultInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class CheckManager
{
    protected array $checkers = [];

    public function __construct(array $checkers = [])
    {
        foreach ($checkers as $checker) {
            $this->addChecker($checker);
        }
    }

    public function addChecker(CheckerInterface $checker): void
    {
        $this->checkers[$checker->getName()] = $checker;
    }

    public function has(string $checkerName): bool
    {
        return array_key_exists($checkerName, $this->checkers);
    }

    public function check(string $checkerName, array $options = []): ResultInterface
    {
        if (!$this->has($checkerName)) {
            throw new \RuntimeException(sprintf('Checker "%s" is not registered', $checkerName));
        }

        return $this->checkers[$checkerName]->check($options);
    }

    public function checkAll(array $checks): array
    {
        $results = [];
        $ready = true;

        foreach ($checks as $check => $config) {
            $result = $this->check($config['checker'] ?? '', $config['options'] ?? []);

            $results[$check] = $result->toArray();

            if (!$result->getStatus()) {
                $ready = false;
            }
        }

        return [
            'status'   => $ready ? 'ready' : 'not_ready',
            'services' => $results,
        ];
    }
}
