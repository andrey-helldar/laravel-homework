<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function config;
use function trans;

class CompletedOrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    public $total_cost = 0;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $this->setFrom();
        $this->setTo();
        $this->setSubject();
        $this->totalCost();

        return $this->markdown('emails.edited-order');
    }

    private function setSubject()
    {
        $this->subject(
            trans('info.orderCompleted', ['id' => $this->order->id])
        );
    }

    private function setFrom()
    {
        $this->from(
            config('mail.from.address'),
            config('mail.from.name')
        );
    }

    private function setTo()
    {
//        $vendors = $this->order->products
//            ->transform(function (Product $product) {
//                return $product->vendor->email;
//            })
//            ->toArray();

        $this->to($this->order->partner->email);
//        $this->bcc(array_values($vendors));
    }

    private function totalCost()
    {
        $this->total_cost = $this->order->pivotProduct
            ->transform(function (OrderProduct $order_product) {
                return $order_product->price * $order_product->quantity;
            })
            ->sum();
    }
}
