<?php

namespace Modules\Shop\Http\Livewire;

use Livewire\Component;

class PurchaseSummary extends Component
{
    public array $items = [];
    public float $vatRate = 0.25;

    public function mount(array $items = [], float $vatRate = 0.25)
    {
        $this->items = $items;
        $this->vatRate = $vatRate;
    }

    public function getSubtotalProperty(): float
    {
        return array_sum(array_map(function ($item) {
            $price = $item['price'] ?? 0;
            $quantity = $item['quantity'] ?? 0;
            $discount = $item['discount'] ?? 0;
            return $price * $quantity - $discount;
        }, $this->items));
    }

    public function getVatAmountProperty(): float
    {
        return $this->subtotal * $this->vatRate;
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal + $this->vatAmount;
    }

    public function itemTotal(array $item): float
    {
        $price = $item['price'] ?? 0;
        $quantity = $item['quantity'] ?? 0;
        $discount = $item['discount'] ?? 0;
        return $price * $quantity - $discount;
    }

    public function formatPrice($value): string
    {
        if (!is_numeric($value)) return '-';
        return number_format($value, 2) . ' kr';
    }

    public function render()
    {
        return view('shop::livewire.purchase-summary');
    }
}
