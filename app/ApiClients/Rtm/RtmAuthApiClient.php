<?php

namespace App\ApiClients\Rtm;

use App\ApiClients\ApiClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Rtm\RtmAccessToken;
use Exception;

class RtmAuthApiClient extends ApiClient
{
    protected string $baseUrl;
    protected string $clientId;
    protected string $clientSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.rtm.base_url');
        $this->clientId = config('services.rtm.username');
        $this->clientSecret = config('services.rtm.password');
    }

    public function getAccessToken(): string
    {
        $tokenRecord = RtmAccessToken::latest()->first();
        if ($tokenRecord && time() < $tokenRecord->expires_at) {
            return $tokenRecord->access_token;
        }

        return $this->authenticate();
    }

    private function authenticate(): string
    {
        $url = "{$this->baseUrl}/auth/uaa/oauth/token";
        $headers = [
            'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->clientSecret}"),
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $payload = ['grant_type' => 'client_credentials'];

        $apiRequest = $this->logRequest('POST', $payload, $headers, $url);

        try {
            $response = Http::asForm()
                ->withHeaders($headers)
                ->post($url, $payload);

            $this->logResponse($response, $apiRequest);

            if ($response->successful()) {
                $data = $response->json();
                RtmAccessToken::create([
                    'access_token' => $data['access_token'],
                    'expires_at' => time() + $data['expires_in']
                ]);
                return $data['access_token'];
            }
        } catch (Exception $e) {
            Log::error("Authentication failed: " . $e->getMessage());
        }

        throw new Exception("Failed to authenticate with RTM API");
    }
}
