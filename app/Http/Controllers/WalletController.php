<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function sendEWalletOTP(Request $request, string $eWallet)
    {
        $brickToken = $request->header('X-Brick-Public-Token');
        if (!$brickToken) {
            return $this->responseJson(403, 'Missing Brick Public Token');
        }

        if ($eWallet != 'gopay') {
            return $this->responseJson(400, 'Unsupported eWallet');
        }

        $institutionID = '11';
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $brickToken])
            ->post(env('BRICK_URL') . '/auth', [
                'institution_id' => $institutionID,
                'username' => $request->phone_number,
            ]);

        return $this->responseJson(201, 'OTP Code sent', [
            'unique_id' => $response->json()['data']['uniqueId'],
            'session_id' => $response->json()['data']['sessionId'],
            'otp_token' => $response->json()['data']['otpToken'],
        ]);
    }

    public function registerWallet(Request $request)
    {
        $brickToken = $request->header('X-Brick-Public-Token');
        if (!$brickToken) {
            return $this->responseJson(403, 'Missing Brick Public Token');
        }

        $authResponse = Http::withHeaders(['Authorization' => 'Bearer ' . $brickToken])
            ->post(env('BRICK_URL') . '/auth/gopay', [
                'username' => $request->phone_number,
                'uniqueId' => $request->unique_id,
                'sessionId' => $request->session_id,
                'otpToken' => $request->otp_token,
                'otp' => $request->otp
            ]);

        if ($authResponse->json()['status'] == 401) {
            return $this->responseJson(401, $authResponse->json()['error_message']);
        }

        $accountsResponse = Http::withHeaders(['Authorization', 'Bearer ' . $authResponse->json()['data']])
            ->get(env('BRICK_URL') . '/account/list');

        $accountDetails = null;
        foreach ($accountsResponse->json() as $account) {
            if ($account['account_number'] == $request->phone_number) {
                $accountDetails = $account;
                break;
            }
        }

        Wallet::create([
            'user_id' => $request->user()->id,
            'currency_id' => 2,
            'account_id' => $accountDetails['accountId'],
            'account_holder' => $accountDetails['accountHolder'],
            'account_number' => $accountDetails['accountNumber'],
            'balance' => $accountDetails['balances']['current'],
        ]);

        return $this->responseJson(200, 'Successfully linked to gopay');
    }
}
