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
        $data = $this->model()->onlyFillable(Partner::class, $request);

        return Partner::create($data);
    }

    public function show(Partner $partner): Partner
    {
        return $partner;
    }

    public function update(PartnerRequest $request, Partner $partner): bool
    {
        $data = $this->model()->onlyFillable($partner, $request);

        return $partner->update($data);
    }

    public function destroy(Partner $partner): bool
    {
        return $partner->delete();
    }
}
