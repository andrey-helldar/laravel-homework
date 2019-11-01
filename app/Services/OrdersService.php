<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrdersService
{
    public function index(): ?Collection
    {
        return Order::get()
            ->load('partner', 'products');
    }

    public function store(Request $request): bool
    {
        return true;
    }

    public function update(Request $request, Order $order): bool
    {
        return true;
    }

    public function destroy(Order $order): bool
    {
        return true;
    }
}
