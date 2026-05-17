<?php

namespace Modules\Shop\Listeners;

use Modules\Shop\Events\ShopOrderCreate;
use Modules\Shop\Events\ShopOrderProductCreate;
use Modules\Shop\Models\ShopSku;
use Illuminate\Support\Facades\Log;



class HandleShopOrderCreate
{
    /**
     * Handle the event.
     */
    public function handle(ShopOrderCreate $event): void
    {
        $orderData = $event->orderData;
        $customer = $event->customer;

        if (empty($orderData['products']) || !is_array($orderData['products'])) {
            Log::warning('ShopOrderProductCreate: Missing or invalid "products" key in order data', [
                'order_id' => $orderData['order_id'] ?? null,
                'data' => $orderData,
            ]);
            return;
        }

        foreach ($orderData['products'] as $product) {
            if (empty($product['sku'])) {
                Log::warning('ShopOrderProductCreate: Product missing SKU', ['product' => $product]);
                continue;
            }

            $shopSku = ShopSku::where('sku', $product['sku'])->first();

            if (!$shopSku) {
                Log::warning('ShopOrderProductCreate: No matching ShopSku found', ['sku' => $product['sku']]);
                continue;
            }

            $relatedProduct = $shopSku->product;

            if (!$relatedProduct) {
                Log::warning('ShopOrderProductCreate: ShopSku has no related product model', ['sku' => $product['sku']]);
                continue;
            }

            
            // 🔥 Fyr eventet for hver gyldig SKU
            event(new ShopOrderProductCreate($customer,$relatedProduct,$orderData));

          

        }
    }
}
