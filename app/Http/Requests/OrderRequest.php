<?php

namespace App\Http\Requests;

use App\Models\{Partner, Product};
use Illuminate\Validation\Rule;

class OrderRequest extends BaseRequest
{
    public function rules(): array
    {
        $partners_table = $this->model()->table(Partner::class);
        $products_table = $this->model()->table(Product::class);

        return [
            'status'       => ['required', 'integer', Rule::in([0, 10, 20])],
            'client_email' => ['required', 'string', 'email', 'max:255'],
            'partner_id'   => ['required', 'integer', Rule::exists($partners_table, 'id')],
            'delivery_at'  => ['required', 'date'],

            'products'                  => ['required', 'array', 'min:0'],
            'products.*.id'             => ['required', 'integer', Rule::exists($products_table, 'id')],
            'products.*.price'          => ['required', 'numeric', 'min:1'],
            'products.*.pivot'          => ['required', 'array'],
            'products.*.pivot.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'status'      => __('forms.status'),
            'products'    => __('forms.products'),
            'partner_id'  => __('forms.partner'),
            'delivery_at' => __('forms.deliveryAt'),
        ];
    }
}
