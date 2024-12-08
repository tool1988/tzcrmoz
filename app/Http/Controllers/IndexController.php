<?php

namespace App\Http\Controllers;

use App\Services\Zoho\AccessToken;
use App\Services\Zoho\Account;
use App\Services\Zoho\Deal;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        private AccessToken $accessToken,
        private Account $account,
        private Deal $deal
    ) {
    }

    public function index()
    {
        try {
            $accessToken = $this->accessToken->get();
        } catch (\Exception $e) {
            return redirect(route('zoho.authorize'));
        }

        return view('index', [
            'user' => 'User',
        ]);
    }

    public function createAccount(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|max:255',
            'website' => 'required|max:255',
            'phone' => 'required|max:255',
        ]);

        try {
            $status = $this->account->create($validated);
        } catch (\Exception $e) {
            $status = 'error';
        }

        if ($status == 'success') {
            return back()->with('success', 'Account created');
        } else {
            return back()->with('error', 'Error, invalid data');
        }
    }

    public function createDeal(Request $request)
    {
        $validated = $request->validate([
            'deal_name' => 'required|max:255',
            'deal_stage' => 'required|max:255',
        ]);

        try {
            $status = $this->deal->create($validated);
        } catch (\Exception $e) {
            $status = 'error';
        }

        if ($status == 'success') {
            return back()->with('success', 'Deal created');
        } else {
            return back()->with('error', 'Error, invalid data');
        }
    }
}
