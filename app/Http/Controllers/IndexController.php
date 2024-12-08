<?php

namespace App\Http\Controllers;

use App\Services\Zoho\AccessToken;
use App\Services\Zoho\Account;
use App\Services\Zoho\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function createAccountDeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|max:100',
            'website' => 'required|max:100',
            'phone' => 'required|max:100',
            'deal_name' => 'required|max:100',
            'deal_stage' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        try {
            $this->account->create($request->all());
            $status = $this->deal->create($request->all());
        } catch (\Exception $e) {
            $status = 'error';
        }

        $message = ($status == 'success') ? 'Deal and Account created' : 'Error, invalid data';

        return response()->json([
            'status' => $status,
            'message' => $message,
        ], 200);
    }

    public function createAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|max:100',
            'website' => 'required|max:100',
            'phone' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        try {
            $status = $this->account->create($request->all());
        } catch (\Exception $e) {
            $status = 'error';
        }

        $message = ($status == 'success') ? 'Account created' : 'Error, invalid data';

        return response()->json([
            'status' => $status,
            'message' => $message,
        ], 200);
    }

    public function createDeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deal_name' => 'required|max:100',
            'deal_stage' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        try {
            $status = $this->deal->create($request->all());
        } catch (\Exception $e) {
            $status = 'error';
        }

        $message = ($status == 'success') ? 'Deal created' : 'Error, invalid data';

        return response()->json([
            'status' => $status,
            'message' => $message,
        ], 200);
    }
}
