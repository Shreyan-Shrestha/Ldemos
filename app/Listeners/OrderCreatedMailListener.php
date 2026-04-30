<?php

namespace App\Listeners;

use App\Events\OrderCreatedMailEvent;
use App\Mail\OrderCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class OrderCreatedMailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedMailEvent $event): void
    {
        $order = $event->order;
        if($order->customer_email) {
        Mail::to($order->customer_email)->send(new OrderCreatedMail($order));
        }
    }
}
