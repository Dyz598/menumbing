<?php

use Symfony\Component\Serializer\Encoder;
use Symfony\Component\Serializer\Normalizer;

return [
    'default' => [
        'normalizers' => [
            Normalizer\ObjectNormalizer::class,
            Normalizer\DateTimeNormalizer::class,
            Normalizer\DateTimeZoneNormalizer::class,
            Normalizer\DateIntervalNormalizer::class,
            Normalizer\JsonSerializableNormalizer::class,
            Normalizer\ArrayDenormalizer::class,
        ],
        'encoders' => [
            Encoder\JsonEncoder::class,
        ],
    ],
];
