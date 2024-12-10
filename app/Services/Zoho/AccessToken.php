<?php
declare(strict_types=1);
namespace App\Services\Zoho;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AccessToken
{
    const API_URL = 'https://accounts.zoho.eu/oauth/v2/token';

    public function __construct(
        private AuthorizeCode $authorizeCode
    ) {
    }

    public function get()
    {
        $accessToken = Cache::get('zoho_access_token');

        if ($accessToken) {
            return $accessToken;
        }

        $refreshToken = Cache::get('zoho_refresh_token');
        if ($refreshToken) {
            return $this->refreshAccessToken($refreshToken);
        }

        return $this->getAccessToken();

    }

    private function getAccessToken() {
        $clientId = config('zoho.client_id');
        $clientSecret = config('zoho.client_secret');
        $redirectUri = config('zoho.redirect_uri');

        $response = Http::asForm()->post(self::API_URL, [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $this->authorizeCode->get(),
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
        ]);

        if ($response->failed()) {
            throw new \Exception("Failed to get Zoho access token");
        }

        $data = $response->json();
        if (array_key_exists('error', $data)) {
            throw new \Exception($data['error']);
        }
        $accessToken = $data['access_token'];
        $refreshToken = $data['refresh_token'];
        $expiresIn = $data['expires_in'];
        Cache::put('zoho_access_token', $accessToken, $expiresIn - 60);
        Cache::put('zoho_refresh_token', $refreshToken, $expiresIn - 60);

        return $accessToken;
    }

    private function refreshAccessToken($refreshToken)
    {
        $clientId = config('zoho.client_id');
        $clientSecret = config('zoho.client_secret');

        $response = Http::asForm()->post(self::API_URL, [
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->failed()) {
            throw new \Exception("Failed to refresh Zoho access token");
        }

        $data = $response->json();

        if (array_key_exists('error', $data)) {
            throw new \Exception($data['error']);
        }

        $accessToken = $data['access_token'];
        $refreshToken = $data['refresh_token'];
        $expiresIn = $data['expires_in'];
        Cache::put('zoho_access_token', $accessToken, $expiresIn - 60);
        Cache::put('zoho_refresh_token', $refreshToken, $expiresIn - 60);

        return $accessToken;
    }

    public function getRefreshToken()
    {
        return Cache::get('zoho_refresh_token');
    }
}
