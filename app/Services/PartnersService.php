<?php

namespace App\Services;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PartnersService
{
    public function index(): ?Collection
    {
        return Partner::get();
    }

    public function store(Request $request): bool
    {
        return true;
    }

    public function show(Partner $partner): Partner
    {
        return $partner;
    }

    public function update(Request $request, Partner $partner): bool
    {
        return true;
    }

    public function destroy(Partner $partner): bool
    {
        return true;
    }
}
