<?php

namespace Modules\Shop\Http\Livewire;

use Livewire\Component;
use Modules\Shop\Models\Product;

class SelectProduct extends Component
{
    public $productId = null;
    public $product = null;
    public $searchText = '';
    public $returnObject = false;
    public $products = [];
    public $mainLoading = false;
    public $loading = false;
    public $notFound = false;
    public $minChars = 2;

    protected $updatesQueryString = ['searchText'];

    protected $listeners = [
        'resetProduct' => 'remove',
    ];

    public function mount($value = null, $return_object = false)
    {
        $this->productId = $value;
        $this->returnObject = $return_object;

        if ($this->productId) {
            $this->mainLoading = true;
            $this->product = Product::find($this->productId);
            if (!$this->product) {
                $this->notFound = true;
            }
            $this->mainLoading = false;
        }
    }

    public function updatedSearchText()
    {
        $this->products = [];
        $this->notFound = false;

        if (strlen($this->searchText) >= $this->minChars) {
            $this->loading = true;

            $this->products = Product::query()
                ->where('name->da', 'like', '%' . $this->searchText . '%')
                ->orWhere('sku', 'like', '%' . $this->searchText . '%')
                ->limit(5)
                ->get();

            if ($this->products->isEmpty()) {
                $this->notFound = true;
            }

            $this->loading = false;
        }
    }

    public function choose(Product $product)
    {
        $this->product = $product;
        $this->searchText = '';
        $this->products = [];
        $value = $this->returnObject ? $product : $product->id;

        $this->emit('changed', $this->returnObject);
        $this->emitUp('input', $value); // emitterer til parent v-model
    }

    public function remove()
    {
        $this->product = null;
        $this->productId = null;
        $this->emitUp('input', null);
    }

    public function render()
    {
        return view('shop::livewire.select-product');
    }
}
