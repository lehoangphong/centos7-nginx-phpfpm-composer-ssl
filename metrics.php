<?php
require './vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

// // Tạo một instance của Prometheus\Storage\InMemory
// $adapter = new InMemory();

// // Tạo một CollectorRegistry với lưu trữ InMemory
// $registry = new CollectorRegistry($adapter);

// // Tạo metrics counter
// $counter = $registry->registerCounter('myapp', 'requests_total', 'Number of requests received', ['method', 'endpoint']);

// // Increment counter
// $counter->inc(['GET', '/metrics']);

// // Xuất metrics ở định dạng text/plain để Prometheus có thể scrape
// header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
// echo (new RenderTextFormat())->render($registry);

// use Prometheus\CollectorRegistry;
// use Prometheus\RenderTextFormat;
// use Prometheus\Storage\Redis;

// $adapter = $_GET['adapter'];
$adapter = new InMemory();

if ($adapter === 'redis') {
    Redis::setDefaultOptions(['host' => $_SERVER['REDIS_HOST'] ?? '127.0.0.1']);
    $adapter = new Prometheus\Storage\Redis();
} elseif ($adapter === 'apc') {
    $adapter = new Prometheus\Storage\APC();
} elseif ($adapter === 'apcng') {
    $adapter = new Prometheus\Storage\APCng();
} elseif ($adapter === 'in-memory') {
    $adapter = new Prometheus\Storage\InMemory();
}
$registry = new CollectorRegistry($adapter);
$renderer = new RenderTextFormat();
$result = $renderer->render($registry->getMetricFamilySamples());

header('Content-type: ' . RenderTextFormat::MIME_TYPE);
echo $result;
