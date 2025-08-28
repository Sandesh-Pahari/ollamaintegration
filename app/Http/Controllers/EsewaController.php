<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EsewaController extends Controller
{
    public function initiate($amount)
    {
        $transaction_uuid = uniqid();

        $data = [
            'amount' => $amount,
            'tax_amount' => 0,
            'total_amount' => $amount,
            'transaction_uuid' => $transaction_uuid,
            'product_code' => env('ESEWA_MERCHANT_ID'),
            'success_url' => env('ESEWA_SUCCESS_URL'),
            'failure_url' => env('ESEWA_FAILURE_URL'),
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
        ];

        // Generate signature
        $signature_string = "total_amount={$data['total_amount']},transaction_uuid={$data['transaction_uuid']},product_code={$data['product_code']}";
        $data['signature'] = base64_encode(hash_hmac('sha256', $signature_string, env('ESEWA_SECRET_KEY'), true));

        return view('esewa.pay', compact('data'));
    }

    public function success(Request $request)
    {
        // You can verify transaction here with eSewa's verification API
        return "✅ Payment Success! Transaction: " . $request->transaction_code;
    }

    public function failure(Request $request)
    {
        return "❌ Payment Failed!";
    }
}
