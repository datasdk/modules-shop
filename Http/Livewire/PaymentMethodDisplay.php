<?php

namespace Modules\Shop\Http\Livewire;

use Livewire\Component;

class PaymentMethodDisplay extends Component
{
    public string $method;

    public function mount(string $method)
    {
        $this->method = $method;
    }

    public function getTranslatedMethodProperty(): string
    {
        return match($this->method) {
            'credit_card' => 'Betalingskort',
            'paypal'      => 'PayPal',
            'cash'        => 'Kontant',
            default       => $this->method,
        };
    }

    public function getIconProperty(): string
    {
        return match($this->method) {
            'credit_card' => 'mdi-credit-card-outline',
            'paypal'      => 'mdi-paypal',
            'cash'        => 'mdi-cash',
            default       => 'mdi-help-circle-outline',
        };
    }

    public function render()
    {
        return view('shop::livewire.payment-method-display');
    }
}
