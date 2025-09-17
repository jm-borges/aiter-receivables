<?php

namespace App\ApiClients\Rtm;

use Closure;
use Exception;
use App\ApiClients\ApiClient;
use App\Contracts\ApiClientContract;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RtmApiClient extends ApiClient implements ApiClientContract
{
    protected string $baseUrl;
    protected RtmAuthApiClient $authClient;

    public function __construct(RtmAuthApiClient $authClient)
    {
        $this->baseUrl = config('services.rtm.base_url');
        $this->authClient = $authClient;
    }

    public function buildUrl(string $method, string $endpoint, ?array &$content = null): string
    {
        $url = $this->baseUrl . '/' . $endpoint;

        if (strtolower($method) === 'get' && !empty($content)) {
            $url .= '?' . http_build_query($content);
            $content = [];
        }

        return $url;
    }

    public function getHeaders(): array
    {
        return  [
            'Authorization' => 'Bearer ' . $this->authClient->getAccessToken(),
            'Content-Type' => 'application/json'
        ];
    }

    public function makeRequest(string $method, string $endpoint, ?array $content = null): array
    {
        $url = $this->buildUrl(endpoint: $endpoint, method: $method, content: $content);
        $headers = $this->getHeaders($method, $content);

        $response = $this->send(method: $method, url: $url, headers: $headers, content: $content);

        return $this->handleResponse(response: $response, method: $method, url: $url, headers: $headers, content: $content);
    }

    public function send(string $method, string $url, array $headers, ?array $content = null): Response
    {
        $method = strtolower($method);

        if ($method === 'get') {
            return Http::withHeaders($headers)->get($url);
        }

        if ($method === 'delete') {
            return Http::withHeaders($headers)->delete($url);
        }

        return Http::withHeaders($headers)->$method($url, $content);
    }

    public function handleResponse(Response $response, string $method, string $url, array $headers, ?array $content = null): array
    {
        $request = $this->logRequest($method, $content, $headers, $url);
        $this->logResponse($response, $request);

        return ['status_code' => $response->status(), 'body' => $response->json()];
    }
}
