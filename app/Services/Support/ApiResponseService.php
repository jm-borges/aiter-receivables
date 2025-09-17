<?php

namespace App\Services\Support;

use App\Models\Support\ApiResponse;
use Illuminate\Http\Client\Response;

class ApiResponseService
{
    /**
     * Registra a resposta da API na tabela `api_responses`.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @param string $apiRequestId
     * @param string $url
     * @param string $api
     * @return void
     */
    public function log(Response $response, string $apiRequestId, string $method, string $url, string $api): void
    {
        ApiResponse::create([
            'method' => $method,
            'url' => $url,
            'body' => $response->body(),
            'status' => $response->status(),
            'headers' => $response->headers(),
            'api_request_id' => $apiRequestId,
            'api' => $api,
        ]);
    }
}
