<?php

namespace Modules\Shop\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class PaymentKlarnaPaymentController extends Controller
{

    public function createPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:1',
            'currency' => 'required|string|size:3',
            'order_lines' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $response = Http::withBasicAuth(config('services.klarna.username'), config('services.klarna.password'))
            ->post('https://api.playground.klarna.com/checkout/v3/orders', [
                'purchase_country' => 'DK',
                'purchase_currency' => $request->currency,
                'order_amount' => $request->amount,
                'order_lines' => $request->order_lines,
            ]);

        return response()->json($response->json(), $response->status());
    }
}
