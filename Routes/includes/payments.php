<?php


 // Grouped routes under 'quickpay' prefix and route name prefix 'quickpay.'
    Route::group([
        'as' => 'payments.',
        'prefix' => 'payments'
    ], function ($router) {


        Route::group([
            'as' => 'quickpay.',
            'prefix' => 'quickpay'
        ], function ($router) {


            // Payment and subscription endpoints
            Route::post("payment", "Api\PaymentQuickpayController@payment")->name("payment");
            Route::post("subscription", "Api\PaymentQuickpayController@subscription")->name("subscription");

            // Callback route for payment gateway notifications
            Route::post("callback", "Api\PaymentQuickpayController@callback")->name("callback");

            // Success and cancellation endpoints for payments
            Route::get("success", "Api\PaymentQuickpayController@success")->name("success");
            Route::get("cancel", "Api\PaymentQuickpayController@cancel")->name("cancel");


        });



        Route::group([
            'as' => 'pensopay.',
            'prefix' => 'pensopay'
        ], function ($router) {

             Route::post('payment', "Api\PaymentPensopayController@createPayment")->name('payment');

        });


        Route::group([
            'as' => 'paypal.',
            'prefix' => 'paypal'
        ], function ($router) {

             Route::post('payment', "Api\PayPalPaymentController@createPayment")->name('payment');

        });


        Route::group([
            'as' => 'klarna.',
            'prefix' => 'klarna'
        ], function ($router) {

             Route::post('payment', "Api\KlarnaPaymentController@createPayment")->name('payment');

        });


    });