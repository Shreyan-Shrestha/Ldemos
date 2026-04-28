@extends('partials.layout')

@section('title', 'Orders')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Orders</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New Order
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Customer ID</th>
                        <th>Customer Name</th>
                        <th>Order Amount</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="ps-4 text-muted fw-semibold">#{{ $order->customer_id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>${{ number_format($order->order_amount, 2) }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('orders.edit', $order->customer_id) }}"
                                   class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('orders.destroy', $order->customer_id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this order?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
@endsection