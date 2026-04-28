<?php

namespace App\Listeners;

use App\Events\OrderUpdatedEvent;
use App\Services\DemoLogger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class OrderUpdatedListener implements ShouldQueue
{
    public function __construct(public DemoLogger $demoLogger)
    {
        
    }

    public function handle(OrderUpdatedEvent $event): void
    {
        sleep(5); // Simulate a time-consuming task
        $order = $event->order;
        $oldamount = $event->oldamount;

        $this->demoLogger->log(
            "OrderUpdatedListener: Sent to Queue to Update Order for:" . $order->customer_name . 
            " from amount: " . $oldamount . 
            " to new amount: " . $order->order_amount
            );
    }
}
