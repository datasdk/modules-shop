<?php

namespace Modules\Shop\Http\Requests;

use Orion\Http\Requests\Request;

class ProductRequest extends Request
{

    public function storeRules(): array
    {

        return [
            'name' => 'required',
            'description' => 'sometimes|nullable',
            'price' => 'required|numeric|min:0',
            'quantity' => 'sometimes|nullable|integer|min:0',
            'status' => 'required',
            "categories" => "sometimes|nullable|array",
            "categories.*" => "sometimes|int|exists:categories,id",
        ];

    }


    public function updateRules(): array
    {

         return [
            'name' => 'sometimes',
            'description' => 'sometimes|nullable',
            'price' => 'sometimes|required|numeric|min:0',
            'quantity' => 'sometimes|nullable|integer|min:0',
            'status' => 'sometimes|required',
            "categories" => "sometimes|nullable|array",
            "categories.*" => "sometimes|int|exists:categories,id",
        ];
        
    }

}
