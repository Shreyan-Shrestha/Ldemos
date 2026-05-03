@extends('partials.layout')

@section('title', 'Orders')

@section('content')
<div class="container p-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0" style="font-size: 1.75rem; letter-spacing: -0.02em;">Orders</h1>
            <p class="text-muted mb-0 mt-1" style="font-size: 0.875rem;">Manage and track all customer orders</p>
        </div>
        <a href="{{ route('orders.create') }}" class="btn btn-primary p-3" style="border-radius: 8px; font-size: 0.875rem; text-decoration: none; cursor: pointer;">
            <button type="button" class="rounded text-center" style="cursor: pointer;"> <i class="bi bi-plus-lg me-2"></i>New Order</button>
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-dismissible d-flex align-items-center gap-2 border-0 mb-4"
        style="background:#f0fdf4; color:#166534; border-radius:10px; font-size:0.875rem;">
        <i class="bi bi-check-circle-fill" style="font-size:1rem;"></i>
        {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
            style="font-size:0.7rem; filter:invert(27%) sepia(51%) saturate(400%) hue-rotate(95deg);"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-dismissible d-flex align-items-center gap-2 border-0 mb-4"
        style="background:#fef2f2; color:#991b1b; border-radius:10px; font-size:0.875rem;">
        <i class="bi bi-exclamation-circle-fill" style="font-size:1rem;"></i>
        {{ session('error') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
            style="font-size:0.7rem; filter:invert(19%) sepia(90%) saturate(600%) hue-rotate(340deg);"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert d-flex align-items-start gap-2 border-0 mb-4"
        style="background:#fef2f2; color:#991b1b; border-radius:10px; font-size:0.875rem;">
        <i class="bi bi-exclamation-circle-fill mt-1" style="font-size:1rem; flex-shrink:0;"></i>
        <ul class="mb-0 ps-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Table card --}}
    <div class="card border-0" style="border-radius: 14px; box-shadow: 0 1px 4px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.06);">
        <div class="card-body p-0">
            <table class="table mb-0" style="border-radius: 14px; overflow: hidden;">
                <thead>
                    <tr style="background: #f8f8f8; border-bottom: 1px solid #ebebeb;">
                        <th class="ps-4 py-3 text-muted fw-semibold" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.06em;">ID</th>
                        <th class="py-3 text-muted fw-semibold" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.06em;">Customer</th>
                        <th class="py-3 text-muted fw-semibold" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.06em;">Amount</th>
                        <th class="py-3 pe-4 text-muted fw-semibold text-end" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.06em;">Customer Email</th>
                        <th class="py-3 pe-4 text-muted fw-semibold text-end" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.06em;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr style="border-bottom: 1px solid #f3f3f3; transition: background 0.15s;"
                        onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''">

                        <td class="ps-4 py-3 align-middle">
                            <span class="badge fw-semibold"
                                style="background:#f1f1f1; color:#555; border-radius:6px; font-size:0.78rem; letter-spacing:0.01em;">
                                #{{ $order->customer_id }}
                            </span>
                        </td>

                        <td class="py-3 align-middle">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center fw-semibold text-white"
                                    style="width:34px; height:34px; border-radius:50%; background:#374151; font-size:0.8rem; flex-shrink:0;">
                                    {{ strtoupper(substr($order->customer_name, 0, 2)) }}
                                </div>
                                <span class="fw-medium" style="font-size:0.925rem;">{{ $order->customer_name }}</span>
                            </div>
                        </td>

                        <td class="py-3 align-middle">
                            <span class="fw-semibold" style="font-size:0.925rem;">${{ number_format($order->order_amount, 2) }}</span>
                        </td>

                        <td class="py-3 pe-4 align-middle text-end">
                            <span class="fw-medium" style="font-size:0.925rem;">
                                {{ $order->customer_email ?? '' }}
                            </span>
                        </td>
                        <td class="py-3 pe-4 align-middle text-end">
                            <a href="{{ route('orders.edit', $order->customer_id) }}"
                                class="btn btn-sm me-1"
                                style="background:#f3f4f6; border:none; border-radius:7px; font-size:0.8rem; color:#374151; padding: 5px 12px;">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <button type="button"
                                class="btn btn-sm"
                                style="background:#fff1f1; border:none; border-radius:7px; font-size:0.8rem; color:#c0392b; padding:5px 12px;"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-customer-name="{{ $order->customer_name }}"
                                data-delete-url="{{ route('orders.destroy', $order->customer_id) }}">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-inbox d-block mb-2" style="font-size:2rem; color:#d1d5db;"></i>
                            <span class="text-muted" style="font-size:0.875rem;">No orders found</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius:14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10);">
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center justify-content-center"
                            style="width:36px; height:36px; border-radius:50%; background:#fff1f1;">
                            <i class="bi bi-trash" style="color:#c0392b; font-size:1rem;"></i>
                        </div>
                        <h5 class="modal-title fw-semibold mb-0" id="deleteModalLabel">Delete Order</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Are you sure you want to delete the order for
                        <span class="fw-semibold" id="deleteCustomerName" style="color:#374151;"></span>?
                        This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0 gap-2">
                    <button type="button" class="btn py-2 px-4"
                        data-bs-dismiss="modal"
                        style="background:#f3f4f6; border:none; border-radius:9px; font-size:0.875rem; color:#374151;">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn py-2 px-4"
                            style="background:#fff1f1; border:none; border-radius:9px; font-size:0.875rem; color:#c0392b;">
                            <i class="bi bi-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            const customerName = btn.getAttribute('data-customer-name');
            const deleteUrl = btn.getAttribute('data-delete-url');

            document.getElementById('deleteCustomerName').textContent = customerName;
            document.getElementById('deleteForm').setAttribute('action', deleteUrl);
        });
    });
</script>
@endsection