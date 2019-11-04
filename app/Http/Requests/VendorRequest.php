<?php

namespace App\Http\Requests;

use App\Models\Vendor;
use App\Traits\ModelHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class VendorRequest extends FormRequest
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
        return [
            'email' => ['required', 'string', 'email', 'max:255', $this->getUnique()],
            'name'  => ['required', 'string', 'max:255', $this->getUnique()],
        ];
    }

    /**
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return array
     */
    private function getUnique(): Unique
    {
        $table_name = $this->getTable(Vendor::class);

        if ($id = $this->request->get('id')) {
            return Rule::unique($table_name)->ignore($id);
        }

        return Rule::unique($table_name);
    }
}
