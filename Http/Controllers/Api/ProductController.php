<?php

namespace Modules\Shop\Http\Controllers\Api;

use App\Http\Controllers\OrionBaseController;
use Modules\Shop\Models\Product;
use Modules\Shop\Http\Requests\ProductRequest;
use Orion\Http\Requests\Request;

class ProductController extends OrionBaseController
{
    protected $model = Product::class;
    protected $request = ProductRequest::class;

    protected $includes = [];
    protected $exposedScopes = [];


    public function store(Request $req)
    {

        $product = Product::create($req->validated());

        $product->setCategories($req->categories);

        return $product;

    }


    public function update(Request $req, ...$args)
    {

        $id = $args[0];
        
        $product = Product::findOrFail($id);
            
        $product->setCategories($req->categories);

        $product->update($req->validated());

        return $product;
    }
    
}
