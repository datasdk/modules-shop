<?php

namespace Modules\Shop\Http\Requests;

use Orion\Http\Requests\Request;

class TermsRequest extends Request
{
    /**
     * Validation rules for storing a term.
     */
    public function storeRules(): array
    {
        return [
            'title' => 'required',
            'content' => 'required',
        ];
    }

    /**
     * Validation rules for updating a term.
     */
    public function updateRules(): array
    {
        return [
            'title' => 'required',
            'content' => 'required',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Titel er påkrævet.',
            'title.string' => 'Titel skal være en tekststreng.',

            'content.required' => 'Indhold er påkrævet.',
            'content.string' => 'Indhold skal være en tekststreng.',
        ];
    }
}
