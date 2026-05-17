<?php

namespace Modules\Shop\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Shop\Contracts\ProductInterface;
use App\Models\User;

class ShopOrderProductCreate
{

    use Dispatchable, SerializesModels;

    public $product;

    public $customer;

    public array $orderData;


    /**
     * Create a new event instance.
     */
    
    public function __construct(User $customer, $product, array $orderData)
    {

    
        $this->product = $product;
        $this->orderData = $orderData;
        $this->customer = $customer;
    }

}
