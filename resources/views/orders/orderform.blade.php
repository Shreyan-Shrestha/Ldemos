@extends('partials.layout')

@section('title', 'Create Order')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="d-flex align-items-center mb-4 gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1 class="fw-bold mb-0">Create Order</h1>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('orders.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="customer_name" class="form-label fw-semibold">Customer Name</label>
                            <input type="text"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   id="customer_name" name="customer_name"
                                   value="{{ old('customer_name') }}"
                                   placeholder="Enter customer name">
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order_amount" class="form-label fw-semibold">Order Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       class="form-control @error('order_amount') is-invalid @enderror"
                                       id="order_amount" name="order_amount"
                                       value="{{ old('order_amount') }}"
                                       placeholder="0">
                                @error('order_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Create Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection