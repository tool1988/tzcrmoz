<?php
declare(strict_types=1);
namespace App\Services\Zoho;

use com\zoho\api\authenticator\OAuthBuilder;
use com\zoho\crm\api\InitializeBuilder;
use com\zoho\crm\api\UserSignature;
use com\zoho\crm\api\dc\EUDataCenter;

class Service
{
    public function __construct(
        private AccessToken $accessToken
    ) {
        $this->initialize();
    }

    private function initialize()
    {
        if ($this->accessToken->getRefreshToken()) {
            $clientId = config('zoho.client_id');
            $clientSecret = config('zoho.client_secret');
            $redirectUri = config('zoho.redirect_uri');

            $user = new UserSignature("hristenko.ivan@gmail.com");
            $environment = EUDataCenter::PRODUCTION();
            $token = (new OAuthBuilder())
                ->clientId($clientId)
                ->clientSecret($clientSecret)
                ->refreshToken($this->accessToken->getRefreshToken())
                ->redirectURL($redirectUri)
                ->build();

            (new InitializeBuilder())
                ->user($user)
                ->environment($environment)
                ->token($token)
                ->initialize();
        }
    }
}
