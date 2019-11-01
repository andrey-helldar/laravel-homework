<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Services\VendorsService;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    private $service;

    public function __construct(VendorsService $service)
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

    public function show(Vendor $vendor)
    {
        $item = $this->service->show($vendor);

        return api_response($item);
    }

    public function update(Request $request, Vendor $vendor)
    {
        $message = $this->service->update($request, $vendor)
            ? trans('statuses.updated')
            : trans('errors.0');

        return api_response($message);
    }

    public function destroy(Vendor $vendor)
    {
        $message = $this->service->destroy($vendor)
            ? trans('statuses.deleted')
            : trans('errors.0');

        return api_response($message);
    }
}
