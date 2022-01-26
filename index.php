<?php

require './vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\Exception\StorageException;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis;

Redis::setDefaultOptions(
    [
        'host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
        'port' => $_ENV['REDIS_PORT'] ?? '',
        'password' => $_ENV['REDIS_PASSWORD'] ?? null,
        'timeout' => $_ENV['REDIS_TIMEOUT'] ?? 0.1, // in seconds
        'read_timeout' => $_ENV['REDIS_READ_TIMEOUT'] ?? '10', // in seconds
        'persistent_connections' => $_ENV['REDIS_PERSISTENT_CONNECTIONS'] ?? false,
    ]
);

try {
    header('Content-type: ' . RenderTextFormat::MIME_TYPE);

    echo (new RenderTextFormat())->render(CollectorRegistry::getDefault()->getMetricFamilySamples());
} catch (StorageException) {
    header('Content-type: ' . RenderTextFormat::MIME_TYPE, true, 500);
}
