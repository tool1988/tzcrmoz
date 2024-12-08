<?php
declare(strict_types=1);
namespace App\Services\Zoho;

use Illuminate\Support\Facades\Http;
use App\Services\Zoho\AccessToken;

class Account
{
    const API_URL = 'https://www.zohoapis.eu/crm/v2/Accounts';

    public function __construct(
        private AccessToken $accessToken
    ) {
    }

    public function create($data)
    {
        $accessToken = $this->accessToken->get();
        $data = [
            'data' => [
                [
                    'Account_Name' => $data['account_name'],
                    'Website' => $data['website'],
                    'Phone' => $data['phone']
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post(self::API_URL, $data);

        $result = $response->json();

        return $result['data'][0]['status'];

    }
}
