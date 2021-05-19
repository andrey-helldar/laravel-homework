<?php

namespace App\Observers;

use App\Mail\CompletedOrderMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    public function updated(Order $order)
    {
        if ($order->isDirty('status') && $order->status === 20) {
            $mail = new CompletedOrderMail($order);

            Mail::send($mail);
        }
    }
}
