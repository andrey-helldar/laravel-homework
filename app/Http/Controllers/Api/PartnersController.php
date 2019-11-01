<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Services\PartnersService;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    private $service;

    public function __construct(PartnersService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $items = $this->service->index();

        return api_response($items);
    }

    public function store(Request $request)
    {
        $message = $this->service->store($request)
            ? trans('statuses.stored')
            : trans('errors.0');

        return api_response($message);
    }

    public function show(Partner $partner)
    {
        $item = $this->service->show($partner);

        return api_response($item);
    }

    public function update(Request $request, Partner $partner)
    {
        $message = $this->service->update($request, $partner)
            ? trans('statuses.updated')
            : trans('errors.0');

        return api_response($message);
    }

    public function destroy(Partner $partner)
    {
        $message = $this->service->destroy($partner)
            ? trans('statuses.deleted')
            : trans('errors.0');

        return api_response($message);
    }
}
