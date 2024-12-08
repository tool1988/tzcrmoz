<?php
declare(strict_types=1);
namespace App\Services\Zoho;

use Illuminate\Support\Facades\Cache;

class AuthorizeCode
{
    const API_URL = 'https://accounts.zoho.com/oauth/v2/auth';

    public function get()
    {
        $authorizeCode = Cache::get('zoho_authorize_code');

        if ($authorizeCode) {
            return $authorizeCode;
        }
        return null;
    }

    public function getAuthUrl()
    {
        $clientId = config('zoho.client_id');
        $redirectUri = config('zoho.redirect_uri');

        return self::API_URL . "?scope=ZohoCRM.modules.ALL&client_id=$clientId&redirect_uri=$redirectUri&response_type=code&access_type=offline";
    }

    public function set($code)
    {
        Cache::put('zoho_authorize_code', $code);

        return $code;
    }
}
