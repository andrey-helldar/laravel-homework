<?php

namespace App\Services;

use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use Illuminate\Support\Collection;

class VendorsService extends BaseService
{
    public function index(): Collection
    {
        return Vendor::get();
    }

    public function store(VendorRequest $request): Vendor
    {
        return Vendor::create(
            $this->model()->onlyFillable(Vendor::class, $request)
        );
    }

    public function show(Vendor $vendor): Vendor
    {
        return $vendor;
    }

    public function update(VendorRequest $request, Vendor $vendor): bool
    {
        return $vendor->update(
            $this->model()->onlyFillable($vendor, $request)
        );
    }

    public function destroy(Vendor $vendor): bool
    {
        return $vendor->delete();
    }
}
