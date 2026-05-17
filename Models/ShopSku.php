<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ShopSku extends Model
{
    
    protected $table = 'shop_skus';

    protected $fillable = [
        'skuable_type',
        'skuable_id',
        'sku',
        'stock',
        'price',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
        'price' => 'decimal:2',
    ];

    /**
     * Polymorphic relation to the owning product.
     */
    public function skuable()
    {
        return $this->morphTo();
    }

    /**
     * Helper to get the actual product instance.
     */
    public function product()
    {
        return $this->skuable();
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }


    /**
     * Decrease stock by given quantity.
     */
    public function decreaseStock(int $quantity = 1): bool
    {
        if ($quantity <= 0 || $this->stock < $quantity) {
            return false;
        }

        $this->stock -= $quantity;
        return $this->save();
    }

}
