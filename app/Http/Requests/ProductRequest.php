<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Validation\Rule;

class ProductRequest extends BaseRequest
{
    public function rules(): array
    {
        $table_vendor = $this->model()->table(Vendor::class);

        return [
            'name'      => ['required', 'string', 'max:255', $this->getUnique(Product::class)],
            'price'     => ['required', 'integer', 'min:1'],
            'vendor_id' => ['required', 'integer', Rule::exists($table_vendor, 'id')],
        ];
    }

    public function attributes(): array
    {
        return [
            'vendor_id' => __('forms.vendor'),
        ];
    }
}
