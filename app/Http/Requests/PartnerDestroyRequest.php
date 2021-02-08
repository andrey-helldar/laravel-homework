<?php

namespace App\Http\Requests;

use App\Models\Partner;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;

final class PartnerDestroyRequest extends BaseRequest
{
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        Arr::set($request, 'count', $this->getPartner()->orders()->count());

        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function rules(): array
    {
        return [
            ['count' => ['required', 'integer', 'size:0']],
            ['count.size' => trans('validation.partner_used', ['name' => $this->getPartner()->name])],
        ];
    }

    protected function getPartner(): Route|Partner
    {
        return $this->route('partner');
    }
}

