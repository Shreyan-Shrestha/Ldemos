
<div class="container mx-auto p-4 mt-8 bg-gray-100">
    <h1 class="text-2xl font-bold">New Order has been created</h1> 
    <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
    <p><strong>Amount:</strong> ${{ $order->order_amount }}</p>
</div>
