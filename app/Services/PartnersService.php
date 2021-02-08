<?php

namespace App\Services;

use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use Illuminate\Support\Collection;

class PartnersService extends BaseService
{
    public function index(): Collection
    {
        return Partner::get();
    }

    public function store(PartnerRequest $request): Partner
    {
        return Partner::create(
            $this->model()->onlyFillable(Partner::class, $request)
        );
    }

    public function show(Partner $partner): Partner
    {
        return $partner;
    }

    public function update(PartnerRequest $request, Partner $partner): bool
    {
        return $partner->update(
            $this->model()->onlyFillable($partner, $request)
        );
    }

    public function destroy(Partner $partner): bool
    {
        return $partner->delete();
    }
}
