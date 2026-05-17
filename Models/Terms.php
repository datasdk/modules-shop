<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DataSDK\Tools\Traits\Language;
use ActionModel;;

class Terms extends ActionModel
{
    
    use HasFactory;
   
    // Define the table name if it's different from the model's name
    protected $table = 'shop_terms';
        
    public $sluggable = 'title';

    protected $translatable = [
        'title',
        'content',
        'slug'
    ];

    // Define the fillable properties
    protected $fillable = [
        'title',
        'content'
    ];

}
