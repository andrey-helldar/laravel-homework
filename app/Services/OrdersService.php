<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Mail\CompletedOrderMail;
use App\Models\Order;
use Carbon\Carbon;
use Helldar\Support\Laravel\Models\ModelHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

use function compact;

class OrdersService
{
    private $model;

    public function __construct(ModelHelper $model)
    {
        $this->model = $model;
    }

    public function index(): ?Collection
    {
        return Order::get()
            ->load('partner', 'products');
    }

    /**
     * @param OrderRequest $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return bool
     */
    public function store(OrderRequest $request): bool
    {
        $order = Order::create(
            $this->model->onlyFillable(Order::class, $request)
        );

        $this->syncProducts($request, $order);

        return true;
    }

    public function show(Order $order): Order
    {
        return $order->load('products');
    }

    /**
     * @param OrderRequest $request
     * @param Order $order
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return bool
     */
    public function update(OrderRequest $request, Order $order): bool
    {
        $order->update(
            $this->model->onlyFillable($order, $request)
        );

        $this->syncProducts($request, $order);
        $this->sendEmail($order);

        return true;
    }

    /**
     * @param Order $order
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function destroy(Order $order): bool
    {
        return $order->delete();
    }

    private function syncProducts(OrderRequest $request, Order $order): void
    {
        $products = $request->get('products');
        $items    = [];

        array_map(function ($product) use (&$items, $order) {
            $id         = Arr::get($product, 'id');
            $price      = Arr::get($product, 'price');
            $quantity   = Arr::get($product, 'pivot.quantity');
            $created_at = $order->created_at;
            $updated_at = Carbon::now();

            Arr::set($items, $id, compact('price', 'quantity', 'created_at', 'updated_at'));
        }, $products);

        $order->products()->sync($items);
    }

    private function sendEmail(Order $order)
    {
        if ($order->status === 20) {
            $mail = new CompletedOrderMail($order);

            Mail::send($mail);
        }
    }
}
