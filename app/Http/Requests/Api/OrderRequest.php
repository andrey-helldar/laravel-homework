<?php

namespace App\Http\Requests\Api;

use App\Models\Partner;
use App\Models\Product;
use Helldar\Support\Laravel\Models\ModelHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function trans;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return array
     */
    public function rules(): array
    {
        $partners_table = $this->getTable(Partner::class);
        $products_table = $this->getTable(Product::class);

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
            'status'      => trans('forms.status'),
            'products'    => trans('forms.products'),
            'partner_id'  => trans('forms.partner'),
            'delivery_at' => trans('statuses.deliveryAt'),
        ];
    }

    /**
     * @param string $model
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return string
     */
    private function getTable(string $model): string
    {
        $helper = new ModelHelper();

        return $helper->table($model);
    }
}
