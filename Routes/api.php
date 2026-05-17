<?php

use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;
use Modules\Shop\Http\Controllers\Api\TermsController;


Route::group([
    'prefix' => 'shop',
    'as' => 'api.shop.'
], function ($router) {


    // Routes protected by 'auth.both:api' middleware
    // Only allow index, show, and search actions on terms resource
    Route::middleware(['auth.both:api'])->group(function () {

        Orion::resource('terms', 'Api\TermsController', ['only' => ['index', 'show', 'search']]);

    });
    

    // Routes protected by Sanctum authentication
    // Allow all actions on terms resource except index, show, and search
    Route::group([
        'middleware' => 'auth:api',
    ], function ($router) {

        Orion::resource('terms', 'Api\TermsController', ['except' => ['index', 'show', 'search']]);

    });


    /*
     Route::group([
        'middleware' => 'auth:api',
    ], function ($router) {


        Orion::resource('customers', 'Api\CustomerController');
        Orion::resource('orders', 'Api\OrderController');
        Orion::resource('products', 'Api\ProductController');

    });
*/


   require_once "includes/payments.php";
   

});
