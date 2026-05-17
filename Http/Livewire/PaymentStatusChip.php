<?php

namespace Modules\Shop\Http\Livewire;

use Livewire\Component;

class PaymentStatusChip extends Component
{
    public string $status;

    public function mount(string $status)
    {
        $this->status = $status;
    }

    public function getTranslatedStatusProperty(): string
    {
        return match($this->status) {
            'pending'  => 'Afventer',
            'paid'     => 'Betalt',
            'failed'   => 'Mislykket',
            'refunded' => 'Refunderet',
            default    => $this->status,
        };
    }

    public function getChipColorProperty(): string
    {
        return match($this->status) {
            'pending'  => 'orange',
            'paid'     => 'green',
            'failed'   => 'red',
            'refunded' => 'blue',
            default    => 'grey',
        };
    }

    public function render()
    {
        return view('shop::livewire.payment-status-chip');
    }
}
