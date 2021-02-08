<?php

namespace App\Http\Requests;

use App\Models\Partner;

class PartnerRequest extends BaseRequest
{
    public function rules(): array
    {
        $unique = $this->getUnique(Partner::class);

        return [
            'email' => ['required', 'string', 'email', 'max:255', $unique],
            'name'  => ['required', 'string', 'max:255', $unique],
        ];
    }
}
