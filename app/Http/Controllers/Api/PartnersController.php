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
        return $this->service->store($request)
            ? api_response(trans('statuses.stored'))
            : api_response(trans('errors.0'), 400);
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
        return $this->service->update($request, $partner)
            ? api_response(trans('statuses.updated'))
            : api_response(trans('errors.0'), 400);
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

        $this->validate($request,
            ['count' => ['required', 'integer', 'size:0']],
            ['count.size' => trans('validation.partner_used', ['name' => $partner->name])]
        );

        return $this->service->destroy($partner)
            ? api_response(trans('statuses.deleted'))
            : api_response(trans('errors.0'), 400);
    }
}
