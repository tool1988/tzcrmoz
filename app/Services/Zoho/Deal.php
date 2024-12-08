<?php
declare(strict_types=1);
namespace App\Services\Zoho;

use Illuminate\Support\Facades\Http;
use App\Services\Zoho\AccessToken;

class Deal
{
    const API_URL = 'https://www.zohoapis.eu/crm/v2/Deals';

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
                    'Deal_Name' => $data['deal_name'],
                    'Stage' => $data['deal_stage']
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
