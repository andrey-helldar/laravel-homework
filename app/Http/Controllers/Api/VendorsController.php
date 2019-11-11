<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
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

    /**
     * @param VendorRequest $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function store(VendorRequest $request)
    {
        return $this->service->store($request)
            ? api_response(trans('statuses.stored'))
            : api_response(trans('errors.0'), 400);
    }

    public function show(Vendor $vendor)
    {
        $item = $this->service->show($vendor);

        return api_response($item);
    }

    /**
     * @param VendorRequest $request
     * @param Vendor $vendor
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(VendorRequest $request, Vendor $vendor)
    {
        return $this->service->update($request, $vendor)
            ? api_response(trans('statuses.updated'))
            : api_response(trans('errors.0'), 400);
    }

    /**
     * @param Request $request
     * @param Vendor $vendor
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function destroy(Request $request, Vendor $vendor)
    {
        $request->request->add(['count' => $vendor->products()->count()]);

        $this->validate($request,
            ['count' => ['required', 'integer', 'size:0']],
            ['count.size' => trans('validation.vendor_used', ['name' => $vendor->name])]
        );

        return $this->service->destroy($vendor)
            ? api_response(trans('statuses.deleted'))
            : api_response(trans('errors.0'), 400);
    }
}
