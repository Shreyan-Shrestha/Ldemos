@extends('partials.layout')

@section('title', 'Edit Order')

@section('content')
<div class="container p-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            {{-- Back + Title --}}
            <div class="mb-4">
                <a href="{{ route('orders.index') }}"
                   class="d-inline-flex align-items-center gap-1 text-decoration-none mb-3"
                   style="font-size:0.8rem; color:#6b7280;">
                    <i class="bi bi-arrow-left"></i> Back to orders
                </a>
                <h1 class="fw-bold mb-1" style="font-size:1.5rem; letter-spacing:-0.02em;">
                    Edit Order
                    <span class="fw-normal text-muted" style="font-size:1.1rem;">#{{ $order->customer_id }}</span>
                </h1>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Update the details for this order</p>

                @if(session('error'))
    <div class="alert d-flex align-items-center gap-2 border-0 mb-4"
         style="background:#fef2f2; color:#991b1b; border-radius:10px; font-size:0.875rem;">
        <i class="bi bi-exclamation-circle-fill" style="font-size:1rem;"></i>
        {{ session('error') }}
    </div>
@endif

            </div>

            {{-- Form card --}}
            <div class="card border-0" style="border-radius:14px; box-shadow: 0 1px 4px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.06);">
                <div class="card-body p-4">
                    <form action="{{ route('orders.update', $order->customer_id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="customer_name" class="form-label fw-semibold" style="font-size:0.85rem;">Customer Name</label>
                            <input type="text"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   id="customer_name" name="customer_name"
                                   value="{{ old('customer_name', $order->customer_name) }}"
                                   placeholder="e.g. Jane Cooper"
                                   style="border-radius:9px; font-size:0.9rem; border-color:#e5e7eb;">
                            @error('customer_name')
                                <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order_amount" class="form-label fw-semibold" style="font-size:0.85rem;">Order Amount</label>
                            <div class="input-group" style="border-radius:9px; overflow:hidden;">
                                <span class="input-group-text border-end-0"
                                      style="background:#f9fafb; border-color:#e5e7eb; font-size:0.9rem; color:#6b7280;">$</span>
                                <input
                                       class="form-control border-start-0 @error('order_amount') is-invalid @enderror"
                                       id="order_amount" name="order_amount"
                                       value="{{ old('order_amount', $order->order_amount) }}"
                                       placeholder="0"
                                       style="font-size:0.9rem; border-color:#e5e7eb;">
                                @error('order_amount')
                                    <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="customer_email" class="form-label fw-semibold" style="font-size:0.85rem;">Customer Email</label>
                            <input type="email"
                                   class="form-control @error('customer_email') is-invalid @enderror"
                                   id="customer_email" name="customer_email"
                                   value="{{ old('customer_email', $order->customer_email) }}"
                                   placeholder="e.g. jane@example.com"
                                   style="border-radius:9px; font-size:0.9rem; border-color:#e5e7eb;">
                            @error('customer_email')
                                <div class="invalid-feedback" style="font-size:0.8rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark py-2" style="border-radius:9px; font-size:0.9rem;">
                                <i class="bi bi-check-lg me-2"></i>Update Order
                            </button>
                            <a href="{{ route('orders.index') }}"
                               class="btn py-2"
                               style="border-radius:9px; font-size:0.9rem; background:#f3f4f6; border:none; color:#374151;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection