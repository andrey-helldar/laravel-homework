<?php

namespace App\Mail;

use App\Models\{Order, OrderProduct, Product};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function __;
use function config;

class CompletedOrderMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Order $order,
        public int $total_cost = 0
    ) {
    }

    public function build(): CompletedOrderMail
    {
        $this->setFrom();
        $this->setTo();
        $this->setSubject();
        $this->totalCost();

        return $this->markdown('emails.edited-order');
    }

    protected function setSubject(): void
    {
        $this->subject(
            __('info.orderCompleted', ['id' => $this->order->id])
        );
    }

    protected function setFrom(): void
    {
        $this->from(
            config('mail.from.address'),
            config('mail.from.name')
        );
    }

    protected function setTo(): void
    {
        $this->to($this->order->partner->email);

        $this->order->products
            ->each(function (Product $product) {
                $this->to($product->vendor->email);
            })
            ->toArray();
    }

    protected function totalCost(): void
    {
        $this->total_cost = $this->order->pivotProduct
            ->sum(static fn (OrderProduct $order_product) => $order_product->price * $order_product->quantity);
    }
}
