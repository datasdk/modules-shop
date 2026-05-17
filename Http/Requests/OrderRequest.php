<?php

namespace Modules\Shop\Http\Requests;

use Orion\Http\Requests\Request;

class OrderRequest extends Request
{
    public function storeRules(): array
    {
        $res = [
            'type'              => 'sometimes|nullable',
            'description'       => 'nullable',

            'paid_at'           => 'nullable|date',
            'refunded_at'       => 'nullable|date',
            'payment_method'    => 'nullable|string|max:255',
            'status'            => 'required|string',

            'new_user'          => 'sometimes|boolean',
            'user_id'           => 'required_if:new_user,false|exists:users,id',

            'products'          => 'required|array|min:1',
            'products.*.id'     => 'required|exists:shop_products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];

        if ($this->boolean('new_user')) {
            $res += [
                'customer'                => 'required|array',
                'customer.first_name'     => 'required|string|max:255',
                'customer.middle_name'    => 'nullable|string|max:255',
                'customer.last_name'      => 'required|string|max:255',
                'customer.email'          => 'required|email|max:255|' . $this->getEmailRule(),
                'customer.contact.phone'  => 'nullable|string|max:20',
                'customer.invite'         => 'required|boolean',
                'customer.password'       => 'required_unless:customer.invite,true|string|min:6',
            ];
        }

        return $res;
    }

    public function updateRules(): array
    {
        $res = [
            'type'              => 'sometimes|nullable',
            'description'       => 'nullable',

            'paid_at'           => 'nullable|date',
            'refunded_at'       => 'nullable|date',
            'payment_method'    => 'nullable|string|max:255',
            'status'            => 'required|string',

            'new_user'          => 'sometimes|boolean',
            'user_id'           => 'required_if:new_user,false|exists:users,id',

            'products'          => 'sometimes|array',
            'products.*.id'     => 'required|exists:shop_products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];

        if ($this->boolean('new_user')) {
            $res += [
                'customer'                => 'required|array',
                'customer.first_name'     => 'required|string|max:255',
                'customer.middle_name'    => 'nullable|string|max:255',
                'customer.last_name'      => 'required|string|max:255',
                'customer.email'          => 'required|email|max:255|' . $this->getEmailRule(),
                'customer.contact.phone'  => 'nullable|string|max:20',
                'customer.invite'         => 'required|boolean',
                'customer.password'       => 'required_unless:customer.invite,true|string|min:6',
            ];
        }

        return $res;
    }

    protected function getEmailRule(): string
    {
        return $this->boolean('new_user')
            ? 'unique:users,email'
            : 'exists:users,email';
    }

    public function messages(): array
    {
        return [
            'new_user.required'            => 'Du skal vælge, om det er en ny eller eksisterende kunde.',
            'new_user.boolean'             => 'Ugyldigt format for kunde-type.',

            'user_id.required_if'          => 'Du skal vælge en eksisterende bruger.',
            'user_id.exists'               => 'Den valgte bruger findes ikke.',

            'customer.required'            => 'Kundeoplysninger er påkrævede for ny kunde.',
            'customer.array'               => 'Kundeoplysninger skal være et gyldigt objekt.',

            'customer.first_name.required' => 'Fornavn er påkrævet for ny kunde.',
            'customer.last_name.required'  => 'Efternavn er påkrævet for ny kunde.',

            'customer.email.required'      => 'E-mail er påkrævet for ny kunde.',
            'customer.email.email'         => 'E-mail skal være en gyldig e-mail-adresse.',
            'customer.email.exists'        => 'Denne e-mail findes ikke i systemet.',
            'customer.email.unique'        => 'Denne e-mail er allerede registreret.',

            'customer.contact.phone.max'   => 'Telefonnummer må maksimalt være 20 tegn.',
            'customer.invite.required'     => 'Du skal angive om kunden skal inviteres.',
            'customer.invite.boolean'      => 'Ugyldigt format for inviter-feltet.',
            'customer.password.required_unless' => 'Password er påkrævet, hvis ikke der sendes invitation.',
            'customer.password.min'        => 'Password skal være mindst 6 tegn.',

            'products.required'            => 'Du skal tilføje mindst ét produkt til ordren.',
            'products.array'               => 'Produkter skal være et gyldigt array.',
            'products.min'                 => 'Du skal tilføje mindst ét produkt.',
            'products.*.id.required'       => 'Produkt-id er påkrævet.',
            'products.*.id.exists'         => 'Det valgte produkt findes ikke.',
            'products.*.quantity.required' => 'Mængde er påkrævet for hvert produkt.',
            'products.*.quantity.integer'  => 'Mængde skal være et helt tal.',
            'products.*.quantity.min'      => 'Mængden skal være mindst 1.',
        ];
    }
}
