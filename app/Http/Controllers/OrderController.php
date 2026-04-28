<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest('customer_id')->paginate(10);
        return view('orders/ordersindex', compact('orders'));
    }

    public function create()
    {
        return view('orders/orderform');
    }

    public function store(StoreOrderRequest $request)
    {
        Order::create($request->validated());
        return redirect()->route('orders/orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        return view('orders/ordersshow', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders/orderedit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}