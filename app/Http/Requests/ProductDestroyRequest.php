<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;

final class ProductDestroyRequest extends BaseRequest
{
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        Arr::set($request, 'count', $this->getProduct()->orders()->count());

        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function rules(): array
    {
        return [
            ['count' => ['required', 'integer', 'size:0']],
            ['count.size' => trans('validation.product_used', ['name' => $this->getProduct()->name])],
        ];
    }

    protected function getProduct(): Route|Product
    {
        return $this->route('product');
    }
}
