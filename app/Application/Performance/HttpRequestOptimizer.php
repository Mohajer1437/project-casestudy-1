<?php

namespace IdealBoresh\Application\Performance;

use IdealBoresh\Contracts\RegistersHooks;

class HttpRequestOptimizer implements RegistersHooks
{
    private const TARGET_HOST = 'public-api.wordpress.com';

    public function register(): void
    {
        add_filter('http_request_args', [$this, 'limitRequestTime'], 10, 2);
        add_filter('pre_http_request', [$this, 'shortCircuitExperiments'], 10, 3);
    }

    public function limitRequestTime(array $args, string $url): array
    {
        $args['timeout'] = 12;

        $host = wp_parse_url($url, PHP_URL_HOST);
        if ($host && stripos($host, self::TARGET_HOST) !== false) {
            $args['timeout'] = 3;
            $args['redirection'] = 1;
        }

        return $args;
    }

    public function shortCircuitExperiments($preempt, array $args, string $url)
    {
        $host = wp_parse_url($url, PHP_URL_HOST);
        if ($host && stripos($host, self::TARGET_HOST) !== false) {
            return [
                'headers'  => [],
                'body'     => wp_json_encode(['assignments' => []]),
                'response' => ['code' => 200, 'message' => 'OK'],
                'cookies'  => [],
                'filename' => null,
            ];
        }

        return $preempt;
    }
}
