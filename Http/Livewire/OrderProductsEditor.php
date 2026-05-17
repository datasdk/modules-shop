<?php

namespace Modules\Shop\Http\Livewire;

use Livewire\Component;
use Modules\Shop\Models\Product;

class OrderProductsEditor extends Component
{
    public array $products = [];           // v-model fra parent
    public $selectedProduct = null;       // valgt produkt til tilføjelse
    public int $selectedQuantity = 1;     
    public bool $dialog = false;

    public function mount($products = [])
    {
        $this->products = $products;
    }

    public function addProduct()
    {
        if ($this->selectedProduct && $this->selectedQuantity > 0) {
            $newProduct = $this->selectedProduct;
            $newProduct['quantity'] = $this->selectedQuantity;

            $this->products[] = $newProduct;

            $this->emitUp('input', $this->products);

            // nulstil form
            $this->selectedProduct = null;
            $this->selectedQuantity = 1;
            $this->dialog = false;
        }
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
        $this->emitUp('input', $this->products);
    }

    public function getSubtotalProperty()
    {
        return array_sum(array_map(fn($p) => $p['price'] * $p['quantity'], $this->products));
    }

    public function getVatProperty()
    {
        return $this->subtotal * 0.25;
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->vat;
    }

    public function render()
    {
        $allProducts = Product::all(); // brug Product model i stedet for API
        return view('shop::livewire.order-products-editor', [
            'productOptions' => $allProducts
        ]);
    }
}
