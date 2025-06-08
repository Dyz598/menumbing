<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Menumbing\Serializer;

use Menumbing\Serializer\Factory\ObjectNormalizerFactory;
use Menumbing\Serializer\Factory\SerializerFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                ObjectNormalizer::class => ObjectNormalizerFactory::class,
                SerializerFactory::class => SerializerFactory::class,
                Serializer::class => fn(ContainerInterface $container) => $container->get(SerializerFactory::class)->get('default'),
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for serializer.',
                    'source' => __DIR__ . '/../publish/serializer.php',
                    'destination' => BASE_PATH . '/config/autoload/serializer.php',
                ],
            ]
        ];
    }
}
