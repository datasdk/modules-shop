<?php

namespace Modules\Shop\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuickPay\QuickPay;

class PaymentQuickpayController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('QUICKPAY_API_KEY');
    }

    private function connect()
    {
        return new QuickPay($this->apiKey);
     
    }

    public function payment()
    {
        return $this->makePaymentLink("payment");
    }

    public function subscription()
    {
        return $this->makePaymentLink("subscription");
    }

    public function makePaymentLink($paymentType)
    {
        $order_id = time();
        $currency = 'DKK';
        $amount = 100;
        $description = "Test";
        $payment_methods = "creditcard,visa,mastercard,maestro,dankort";
        $callback_url = route('api.quickpay.callback');
        $continue_url = route('api.quickpay.success');
        $cancel_url = route('api.quickpay.cancel');
        $auto_capture = false;

        $client = $this->connect();

        try {

            if ($paymentType === "payment") {

                $requestUrl = "/payments";
                $endpointUrl = "/payments/%s/link";

            } elseif ($paymentType === "subscription") {

                $requestUrl = "/subscriptions";
                $endpointUrl = "/subscriptions/%s/link";

            } else {

                return response('Invalid payment type', 400);

            }

       

            $payment = $client->request->post($requestUrl, [
                'order_id' => $order_id,
                'currency' => $currency,
                'description' => $description,
            ]);

            $status = $payment->httpStatus();

            if ($payment->isSuccess()) {

                $paymentObject = $payment->asObject();
                
                $endpoint = sprintf($endpointUrl, $paymentObject->id);


                $link = $client->request->put($endpoint, [
                    'amount' => $amount,
                    'callback_url' => $callback_url,
                    'auto_capture' => $auto_capture,
                    'continue_url' => $continue_url,
                    'cancel_url' => $cancel_url,
                    'payment_methods' => $payment_methods,
                ]);


                if ($link->httpStatus() === 200) {
                    return [
                        "link" => $link->asObject()->url,
                    ];
                }

            } else {
                
                $status = $payment->httpStatus();

                if($status == "404"){ 

                    return response("Not found", $status );

                }

                $response = $payment->asObject();

                return response($response->message, $response->error_code);

            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function callback(Request $request)
    {
        $request_body = $request->getContent();
        $checksum = $this->sign($request_body, $this->apiKey);

        if ($checksum == $request->header('Quickpay-Checksum-Sha256')) {
            // Request is authenticated
            // Process the callback data
            // Example: Log the callback data
      
        } else {
            // Request is NOT authenticated
            return response(__('unauthenticated'), 401);
        }
    }

    private function sign($base, $private_key)
    {
        return hash_hmac("sha256", $base, $private_key);
    }
}
