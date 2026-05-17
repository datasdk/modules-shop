<?php

namespace Modules\Shop\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PaymentPensopayController extends Controller
{

    public function createPayment(Request $request)
    {

        $request->validate([
            'amount' => 'required|integer|min:1',
            'currency' => 'required|string|size:3',
            'payment_method' => 'required|string',
            // add other validations as needed
        ]);

        // Prepare payload
        $payload = [
            'amount' => $request->amount,
            'currency' => strtoupper($request->currency),
            'payment_method' => $request->payment_method,
            // Add other required fields here
        ];


        // Call Pensopay API (example URL and token)
        $response = Http::withToken(config('shop.services.pensopay.api_token'))
            ->post('https://api.pensopay.com/v2/payments', $payload);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Payment creation failed',
                'errors' => $response->json()
            ], 422);
        }

        return response()->json($response->json());

    }

}
