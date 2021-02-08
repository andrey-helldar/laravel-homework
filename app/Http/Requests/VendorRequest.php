<?php

namespace App\Http\Requests;

use App\Models\Vendor;

class VendorRequest extends BaseRequest
{
    public function rules(): array
    {
        $unique = $this->getUnique(Vendor::class);

        return [
            'email' => ['required', 'string', 'email', 'max:255', $unique],
            'name'  => ['required', 'string', 'max:255', $unique],
        ];
    }
}
