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
        $data = $this->model()->onlyFillable(Vendor::class, $request);

        return Vendor::create($data);
    }

    public function show(Vendor $vendor): Vendor
    {
        return $vendor;
    }

    public function update(VendorRequest $request, Vendor $vendor): bool
    {
        $data = $this->model()->onlyFillable($vendor, $request);

        return $vendor->update($data);
    }

    public function destroy(Vendor $vendor): bool
    {
        return $vendor->delete();
    }
}
