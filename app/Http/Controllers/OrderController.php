<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Events\OrderUpdatedEvent;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\DemoLogger;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct(public DemoLogger $demoLogger) {}

    public function index()
    {
        $orders = Order::latest('customer_id')->paginate(10);
        $this->demoLogger->log("User accessed Orders page");
        return view('orders/ordersindex', compact('orders'));
    }

    public function create()
    {
        $this->demoLogger->log("User accessed Create Order page");
        return view('orders/orderform');
    }

    public function store(StoreOrderRequest $request)
    {
        DB::Transaction(function () use ($request) {
            $order = Order::create($request->validated());
            event(new OrderCreatedEvent($order));
        });
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        return view('orders/ordersshow', compact('order'));
    }

    public function edit(Order $order)
    {
        $this->demoLogger->log("User accessed Edit Order page for " . $order->customer_name);
        return view('orders/orderedit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        DB::Transaction(function () use ($request, $order) {
            $oldamount = $order->order_amount;
            $order->update($request->validated());
            event(new OrderUpdatedEvent($order, $oldamount));
        });
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        $this->demoLogger->log("User deleted order for " . $order->customer_name);
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
