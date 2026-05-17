<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table="shop_customers";

    protected $fillable = [
        'name', 
        'email', 
        'password',
    ];
}
