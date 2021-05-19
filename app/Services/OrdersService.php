<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

use function compact;

class OrdersService extends BaseService
{
    public function index(): ?Collection
    {
        return Order::with('partner', 'products')->get();
    }

    public function store(OrderRequest $request): bool
    {
        $data = $this->model()->onlyFillable(Order::class, $request);

        $order = Order::create($data);

        $this->syncProducts($request, $order);

        return true;
    }

    public function show(Order $order): Order
    {
        return $order->loadMissing('products');
    }

    public function update(OrderRequest $request, Order $order): bool
    {
        $values = $this->model()->onlyFillable($order, $request);

        $order->update($values);

        $this->syncProducts($request, $order);

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
}
