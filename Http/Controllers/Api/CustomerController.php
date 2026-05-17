<?php

namespace Modules\Shop\Http\Controllers\Api;

use App\Http\Controllers\OrionBaseController;
use Modules\Shop\Models\Customer;
use Modules\Shop\Http\Requests\CustomerRequest;
use Orion\Http\Requests\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends OrionBaseController
{
    protected $model = Customer::class;
    protected $request = CustomerRequest::class;

    protected $includes = [];

    protected $exposedScopes = [];

    // Opretter ny kunde, her krypteres password
    public function store(Request $req)
    {
        $data = $req->validated();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $customer = Customer::create($data);

        return $customer;
    }

    // Opdaterer kunde, krypterer password hvis medsendt
    public function update(Request $req, ...$args)
    {

        $id = $args[0];
        
        $customer = Customer::findOrFail($id);

        $data = $req->validated();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $customer->update($data);

        return $customer;
    }
}
