<?php

namespace App\Services;

use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use Helldar\Support\Laravel\Models\ModelHelper;
use Illuminate\Database\Eloquent\Collection;

class PartnersService
{
    private $model;

    public function __construct(ModelHelper $model)
    {
        $this->model = $model;
    }

    public function index(): ?Collection
    {
        return Partner::get();
    }

    /**
     * @param PartnerRequest $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return Partner
     */
    public function store(PartnerRequest $request): Partner
    {
        return Partner::create(
            $this->model->onlyFillable(Partner::class, $request)
        );
    }

    public function show(Partner $partner): Partner
    {
        return $partner;
    }

    /**
     * @param PartnerRequest $request
     * @param Partner $partner
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return bool
     */
    public function update(PartnerRequest $request, Partner $partner): bool
    {
        return $partner->update(
            $this->model->onlyFillable($partner, $request)
        );
    }

    /**
     * @param Partner $partner
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function destroy(Partner $partner): bool
    {
        return (bool) $partner->delete();
    }
}
