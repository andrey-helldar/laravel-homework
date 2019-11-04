<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use App\Services\PartnersService;
use Illuminate\Http\Request;

use function api_response;
use function trans;

class PartnersController extends Controller
{
    private $service;

    public function __construct(PartnersService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $items = $this->service->index();

        return api_response($items);
    }

    /**
     * @param PartnerRequest $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function store(PartnerRequest $request)
    {
        if ($this->service->store($request)) {
            return api_response(trans('statuses.stored'));
        }

        return api_response(trans('errors.0'), 400);
    }

    public function show(Partner $partner)
    {
        $item = $this->service->show($partner);

        return api_response($item);
    }

    /**
     * @param PartnerRequest $request
     * @param Partner $partner
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(PartnerRequest $request, Partner $partner)
    {
        if ($this->service->update($request, $partner)) {
            return api_response(trans('statuses.updated'));
        }

        return api_response(trans('errors.0'), 400);
    }

    /**
     * @param Request $request
     * @param Partner $partner
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function destroy(Request $request, Partner $partner)
    {
        $request->request->add(['count' => $partner->orders()->count()]);

        $this->validate($request, [
            'count' => ['required', 'integer', 'size:0'],
        ], [
            'count.size' => trans('validation.partner_used', ['name' => $partner->name]),
        ]);

        if ($this->service->destroy($partner)) {
            return api_response(trans('statuses.deleted'));
        }

        return api_response(trans('errors.0'), 400);
    }
}
