<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DataSDK\Tools\Traits\DateFormat;
use DataSDK\Tools\Traits\Language;
use Modules\Shop\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Orders extends Model
{
    use HasFactory;
    use DateFormat;
    use Language;

    protected $table = "shop_orders";

    protected $translatable = ['description'];  

    protected $with = ["items"];

    protected $fillable = [
        'type',
        'user_id',
        'description',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'paid_at',
        'refunded_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    /**
     * Relation til bruger (kunde)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function customer()
    {
        return $this->user();
    }

    /**
     * Har mange ordrelinjer
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }


    
    public function products()
    {

        return $this->morphedByMany(
            Product::class,       // Den relaterede model
            'purchasable',        // Navnet på morph (altså: purchasable_id + purchasable_type)
            'shop_order_items',   // Pivot-tabel (OrderItem)
            'order_id',           // Foreign key på pivot til Order
            'purchasable_id'      // Foreign key på pivot til Product
        );

    }

}
