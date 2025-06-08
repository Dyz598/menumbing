<?php

declare(strict_types=1);

namespace Menumbing\Serializer\Factory;

use Hyperf\Contract\ConfigInterface;
use RuntimeException;
use Symfony\Component\Serializer\Serializer;

use function Hyperf\Support\make;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class SerializerFactory
{
    /**
     * @var array <string, Serializer>
     */
    protected array $serializers = [];

    public function __construct(protected ConfigInterface $config)
    {
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->serializers);
    }

    public function get(string $serializer): Serializer
    {
        if ($this->has($serializer)) {
            return $this->serializers[$serializer];
        }

        $config = $this->config->get('serializer.' . $serializer, []);

        if (empty($config)) {
            throw new RuntimeException(sprintf('Serializer "%s" is not exists.', $serializer));
        }

        $this->serializers[$serializer] = new Serializer(
            normalizers: $this->makeArray($config['normalizers'] ?? []),
            encoders: $this->makeArray($config['encoders'] ?? []),
        );

        return $this->serializers[$serializer];
    }

    protected function makeArray(array $classes): array
    {
        return array_map(function (string $class) {
            return make($class);
        }, $classes);
    }
}
