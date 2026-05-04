<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Events\OrderCreatedMailEvent;
use App\Events\OrderUpdatedEvent;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\DemoLogger;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {
        $startTime = microtime(true);
        $source = "database";
        $page = request()->input('page', 1);
        $cacheKey = 'orders.cache.page.' . $page;

        if (Cache::has($cacheKey)) {
            $source = "cache";
        }

        $cachedOrders = Cache::remember($cacheKey, 60, function () use ($page) {
            $paginator = Order::latest('customer_id')->paginate(10, ['*'], 'page', $page);

            return [
                'total'   => $paginator->total(),
                'items'   => $paginator->items() ? collect($paginator->items())->map(fn($order) => [
                    'customer_id'    => $order->customer_id,
                    'customer_name'  => $order->customer_name,
                    'customer_email' => $order->customer_email,
                    'order_amount'   => $order->order_amount,
                ])->toArray() : [],
            ];
        });

        // Rebuild paginator from plain array
        $orders = new LengthAwarePaginator(
            $cachedOrders['items'],
            $cachedOrders['total'],
            10,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $timeTaken = microtime(true) - $startTime;

        return view('orders/index', compact('orders', 'timeTaken', 'source'));
    }

    public function store(StoreOrderRequest $request)
    {

        $order = Order::create($request->validated());
        Cache::tags(['orders'])->flush();
        
        // Mail to customer if email provided
        // event (new OrderCreatedMailEvent($order));

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function create()
    {
        return view('orders/create');
    }

    public function show(Order $order)
    {
        return view('orders/show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders/edit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {

        $oldamount = $order->order_amount;
        $order->update($request->validated());
        // event(new OrderUpdatedEvent($order, $oldamount));
        Cache::tags(['orders'])->flush();
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        Cache::tags(['orders'])->flush();
        // $this->demoLogger->log("User deleted order for " . $order->customer_name);
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
