<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use DataSDK\Tools\Traits\Language;


class OrderItem extends Model
{

    use Language;

    protected $table = 'shop_order_items';
    
    protected $translatable = ['product_name', 'description'];   

    protected $fillable = [
        'order_id',
        'product_name',
        'description',
        'purchasable_type',
        'purchasable_id',
        'quantity',
        'price',
        'discount',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function purchasable()
    {
        return $this->morphTo();
    }
}
