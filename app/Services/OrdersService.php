<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Mail\CompletedOrderMail;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

use function compact;

class OrdersService extends BaseService
{
    public function index(): ?Collection
    {
        return Order::get()->load('partner', 'products');
    }

    public function store(OrderRequest $request): bool
    {
        $order = Order::create(
            $this->model()->onlyFillable(Order::class, $request)
        );

        $this->syncProducts($request, $order);

        return true;
    }

    public function show(Order $order): Order
    {
        return $order->load('products');
    }

    public function update(OrderRequest $request, Order $order): bool
    {
        $order->update(
            $this->model()->onlyFillable($order, $request)
        );

        $this->syncProducts($request, $order);
        $this->sendEmail($order);

        return true;
    }

    public function destroy(Order $order): bool
    {
        return $order->delete();
    }

    protected function syncProducts(OrderRequest $request, Order $order): void
    {
        $products = $request->get('products');
        $items    = [];

        foreach ($products as $product) {
            $id       = Arr::get($product, 'id');
            $price    = Arr::get($product, 'price');
            $quantity = Arr::get($product, 'pivot.quantity');

            Arr::set($items, $id, compact('price', 'quantity'));
        }

        $order->products()->sync($items);
    }

    protected function sendEmail(Order $order)
    {
        if ($order->status === 20) {
            $mail = new CompletedOrderMail($order);

            Mail::send($mail);
        }
    }
}
