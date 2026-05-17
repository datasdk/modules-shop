<?php

namespace Modules\Shop\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\PaymentIntent;


class PaymentStripePaymentController extends Controller
{

    public function createPayment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:1',
            'currency' => 'required|string|size:3',
            'payment_method' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        Stripe::setApiKey(config('services.stripe.secret'));


        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount,
            'currency' => $request->currency,
            'payment_method' => $request->payment_method,
            'confirmation_method' => 'manual',
            'confirm' => true,
        ]);


        return response()->json($paymentIntent);

    }
    
}
