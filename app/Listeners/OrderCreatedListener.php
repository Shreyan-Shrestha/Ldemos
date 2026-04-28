<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Services\DemoLogger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener
{
    public function __construct(public DemoLogger $demoLogger)
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        $order = $event->order;
        $this->demoLogger->log("OrderCreatedListener: Created Order for:" . $order->customer_name . " with amount: " . $order->order_amount);
    }
}
