<?php

namespace Modules\Shop\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;


class ShopOrderCreate
{
    use Dispatchable, SerializesModels;

    public $orderData;
    public $customer;

    public function __construct(User $customer, array $orderData)
    {

      
        $this->orderData = $orderData;
        $this->customer = $customer;

    }
}
