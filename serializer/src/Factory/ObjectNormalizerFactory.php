<?php

declare(strict_types=1);

namespace Menumbing\Serializer\Factory;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class ObjectNormalizerFactory
{
    public function __invoke(): ObjectNormalizer
    {
        return new ObjectNormalizer(propertyTypeExtractor: new PropertyInfoExtractor(
            [new PhpDocExtractor()],
            [new ReflectionExtractor()],
        ));
    }
}
