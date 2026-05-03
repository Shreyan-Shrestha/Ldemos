@extends('partials.layout')
@section('title', 'Homepage')

@section('content')
<div class="container mx-auto p-4 mt-8 bg-gray-100">
    <div class="flex justify-end">
        <a href="{{ route('data.addDataForm') }}" class="inline-block mt-6 px-4 py-2 btn btn-primary">Add Data</a>
        <a href="{{ route('orders.index') }}" class="inline-block mt-6 px-4 py-2 btn btn-secondary ml-4">View Orders</a>
    </div>

    <div class="text-center mt-3">
        <h1 class="text-4xl font-bold text-blue-600 my-6">Homepage</h1>
        @if($demos->isEmpty())
        <p class="text-lg text-gray-600">No data available.</p>

        @else
        <ul class="list-group text-start my-3 gap-2">
            @foreach($demos as $demo)
            <li class="text-lg list-group-item">{{ $demo->name }} : {{ $demo->description }}</li>
            @endforeach
        </ul>

        <div class="flex justify-center mt-6">
            <a href="{{route('data.deletedHistory')}}" class="inline-block mt-6 px-4 py-2 btn btn-outline-secondary">View Deleted History</a>
        </div>
        @endif

    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Activity Log</h2>
        @if($activity->isEmpty())
        <p class="text-lg text-gray-600">No activity recorded.</p>
        @else
        <ul class="list-group text-start my-3 gap-2">
            @foreach($activity as $act)
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Subject Type</th>
                        <th class="border px-4 py-2">Customer Name</th>
                        <th class="border px-4 py-2">Order Amount</th>
                        <th class="border px-4 py-2">Customer Email</th>
                    </tr>
                </thead>
                <tr>
                    <td class="border px-4 py-2">{{ $act->description }}</td>
                    <td class="border px-4 py-2">{{ $act->created_at }}</td>
                    <td class="border px-4 py-2">{{ $act->subject_type }}</td>
                    <td class="border px-4 py-2">{{ $orders[$act->subject_id]->customer_name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $orders[$act->subject_id]->order_amount  ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $orders[$act->subject_id]->customer_email  ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </ul>
        @endif

</div>



@endsection