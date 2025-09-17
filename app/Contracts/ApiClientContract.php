<?php

namespace App\Contracts;

use Illuminate\Http\Client\Response;

interface ApiClientContract
{
    public function makeRequest(string $method, string $endpoint, ?array $content = null): array;
    public function buildUrl(string $method, string $endpoint, ?array &$content = null): string;
    public function getHeaders(): array;
    public function send(string $method, string $url, array $headers, ?array $content = null): Response;
    public function handleResponse(Response $response, string $method, string $url, array $headers, ?array $content = null): array;
}
