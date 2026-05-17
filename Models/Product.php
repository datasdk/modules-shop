<?php
namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DataSDK\Tools\Traits\Language;
use ActionModel;


class Product extends ActionModel
{

    use HasFactory;
    use Language;

    protected $table = "shop_products";

    public $sluggable = 'name';
    
    protected $translatable = ['name','slug', 'description'];   


    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
    ];


    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'purchasable');
    }

}
