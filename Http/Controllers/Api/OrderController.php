<?php

namespace Modules\Shop\Http\Controllers\Api;

use App\Http\Controllers\OrionBaseController;
use Modules\Shop\Models\Orders;
use Modules\Shop\Http\Requests\OrderRequest;
use Orion\Http\Requests\Request;
use Modules\Shop\Models\Product;
use Modules\Crm\Services\UserService;

class OrderController extends OrionBaseController
{
    protected $model = Order::class;
    protected $request = OrderRequest::class;

    protected $includes = [
        'products',
        'items',
        'user',
        'customer',
        'plans',
    ];

    protected $exposedScopes = [];

    public function store(Request $req)
    {
        $data = $req->validated();
        $newCustomer = $req->boolean("new_user");

        if ($newCustomer) {
            $customerData = $data['customer'] ?? null;
            unset($data['customer']);
            $customer = $this->createUser($customerData);
            $data['user_id'] = $customer->id;
        }

        $products = $data['products'] ?? [];
        unset($data['products']);

        $order = Order::create($data);

        foreach ($products as $productData) {
            $product = Product::findOrFail($productData['id'] ?? null);

            $order->items()->create([
                'product_name' => $product->getTranslations('name') ?? '',
                'description' => $product->getTranslations('description') ?? '',
                'slug' => $product->slug ?? '',
                'quantity' => $productData['quantity'] ?? 1,
                'price' => $product->price ?? 0,
                'total' => ($product->price ?? 0) * ($productData['quantity'] ?? 1),
            ]);
        }

        return $order->load('items');
    }

    public function update(Request $req, ...$args)
    {

        $id = $args[0];
        
        $order = Order::findOrFail($id);
        $data = $req->validated();
        $newCustomer = $req->boolean("new_user");

        if ($newCustomer) {
            $customerData = $data['customer'] ?? null;
            unset($data['customer']);
            $customer = $this->createUser($customerData);
            $data['user_id'] = $customer->id;
        }

        $products = $data['products'] ?? [];
        unset($data['products']);

        $order->update($data);
        $order->items()->delete();

        foreach ($products as $productData) {
            $product = Product::findOrFail($productData['id'] ?? null);

            $order->items()->create([
                'product_name' => $product->getTranslations('name') ?? '',
                'description' => $product->getTranslations('description') ?? '',
                'slug' => $product->slug ?? '',
                'quantity' => $productData['quantity'] ?? 1,
                'price' => $product->price ?? 0,
                'total' => ($product->price ?? 0) * ($productData['quantity'] ?? 1),
            ]);
        }

        return $order->load('items');
    }

    private function createUser(?array $customerData)
    {
        if (!$customerData || empty($customerData['email'])) {
            throw new \InvalidArgumentException("Customer data with valid email is required.");
        }

        $userService = app(UserService::class);
        $existingUser = $userService->findByEmail($customerData['email']);

        if ($existingUser) {
            return $existingUser;
        }

        return $userService->create($customerData);
    }
}
