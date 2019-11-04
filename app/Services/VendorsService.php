<?php

namespace App\Services;

use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use Helldar\Support\Laravel\Models\ModelHelper;
use Illuminate\Database\Eloquent\Collection;

class VendorsService
{
    private $model;

    public function __construct(ModelHelper $model)
    {
        $this->model = $model;
    }

    public function index(): ?Collection
    {
        return Vendor::get();
    }

    /**
     * @param VendorRequest $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return Vendor
     */
    public function store(VendorRequest $request): Vendor
    {
        return Vendor::create(
            $this->model->onlyFillable(Vendor::class, $request)
        );
    }

    public function show(Vendor $vendor): Vendor
    {
        return $vendor;
    }

    /**
     * @param VendorRequest $request
     * @param Vendor $vendor
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return bool
     */
    public function update(VendorRequest $request, Vendor $vendor): bool
    {
        return $vendor->update(
            $this->model->onlyFillable($vendor, $request)
        );
    }

    /**
     * @param Vendor $vendor
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function destroy(Vendor $vendor): bool
    {
        return (bool) $vendor->delete();
    }
}
