<?php

namespace App\Services;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class VendorsService
{
    public function index(): ?Collection
    {
        return Vendor::get();
    }

    public function store(Request $request): bool
    {
        return true;
    }

    public function show(Vendor $vendor): Vendor
    {
        return $vendor;
    }

    public function update(Request $request, Vendor $vendor): bool
    {
        return true;
    }

    public function destroy(Vendor $vendor): bool
    {
        return true;
    }
}
