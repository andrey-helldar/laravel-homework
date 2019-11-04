<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Mail\CompletedOrderMail;
use App\Models\Order;
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

        $this->attachProduct($request, $order);

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

        $this->deleteProducts($request, $order);
        $this->attachProduct($request, $order);
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

    private function deleteProducts(OrderRequest $request, Order $order): void
    {
        $products = $request->get('products');
        $ids      = Arr::pluck($products, 'id');

        $order->products()->sync($ids);
    }

    private function attachProduct(OrderRequest $request, Order $order): void
    {
        foreach ($request->get('products') as $product) {
            $product_id = Arr::get($product, 'id');
            $price      = Arr::get($product, 'price');
            $quantity   = Arr::get($product, 'pivot.quantity');
            $created_at = $order->created_at;

            $order->pivotProduct()->updateOrCreate(
                compact('product_id'),
                compact('price', 'quantity', 'created_at')
            );
        }
    }

    private function sendEmail(Order $order)
    {
        if ($order->status === 20) {
            $mail = new CompletedOrderMail($order);

            Mail::send($mail);
        }
    }
}
