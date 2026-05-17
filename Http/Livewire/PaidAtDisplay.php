<?php

namespace Modules\Shop\Http\Livewire;

use Livewire\Component;

class PaidAtDisplay extends Component
{
    public $paidAt = null;

    public function mount($paidAt = null)
    {
        $this->paidAt = $paidAt;
    }

    public function render()
    {
        return view('shop::livewire.paid-at-display');
    }
}
