<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Zoho\AccessToken;
use App\Services\Zoho\AuthorizeCode;
use Illuminate\Http\Request;

class ZohoController extends Controller
{
    public function __construct(
        private AccessToken $accessToken,
        private AuthorizeCode $authorizeCode
    ) {
    }

    public function authorize()
    {
        $authCode = $this->authorizeCode->get();
        if ($authCode) {
            $redirectUrl = config('zoho.redirect_uri');
        } else {
            $redirectUrl = $this->authorizeCode->getAuthUrl();
        }

        return redirect($redirectUrl);
    }

    public function callback(Request $request)
    {
        $code = $request->get('code');
        $clientId = config('zoho.client_id');
        $clientSecret = config('zoho.client_secret');
        $redirectUri = config('zoho.redirect_uri');
        $this->authorizeCode->set($code);
        try {
            $accessToken = $this->accessToken->get();
        } catch (\Exception $e) {
            return redirect(route('zoho.authorize'));
        }

        return redirect(route('home'));
    }

}
