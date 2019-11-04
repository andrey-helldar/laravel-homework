<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Vendor;
use App\Traits\ModelHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

use function trans;

class ProductRequest extends FormRequest
{
    use ModelHelper;

    public function authorize()
    {
        return true;
    }

    /**
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return array
     */
    public function rules()
    {
        $table_vendor = $this->getTable(Vendor::class);

        return [
            'name'      => ['required', 'string', 'max:255', $this->getUnique()],
            'price'     => ['required', 'integer', 'min:1'],
            'vendor_id' => ['required', 'integer', Rule::exists($table_vendor, 'id')],
        ];
    }

    public function attributes()
    {
        return [
            'vendor_id' => trans('forms.vendor'),
        ];
    }

    /**
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return array
     */
    private function getUnique(): Unique
    {
        $table_name = $this->getTable(Product::class);

        if ($id = $this->request->get('id')) {
            return Rule::unique($table_name)->ignore($id);
        }

        return Rule::unique($table_name);
    }
}
