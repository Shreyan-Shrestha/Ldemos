@extends('partials.layout')
@section('title', 'Homepage')

@section('content')
<div class="container mx-auto p-4 mt-8 bg-gray-100">
    <div class="flex justify-end">
        <h3>Logged in as: {{ auth()->user()->name }}</h3>
        <p>{{ $test }}</p>
        <a href="{{ route('data.addDataForm') }}" class="inline-block mt-6 px-4 py-2 btn btn-primary">Add Data</a>
        <a href="{{ route('orders.index') }}" class="inline-block mt-6 px-4 py-2 btn btn-secondary ml-4">View Orders</a>
    </div>

    <div class="text-center mt-3">
        <h1 class="text-4xl font-bold text-primary my-6">Homepage</h1>
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
        <h2 class="text-3xl font-bold text-primary mb-6">{{ $source }} - Time Taken: {{ number_format($timeTaken, 4) }} seconds</h2>
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Activity Log</h3>
        @if($activity->isEmpty())
        <p class="text-lg text-gray-600">No activity recorded.</p>
        @else

        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="border px-4 py-2">S.N</th>
                    <th class="border px-4 py-2">Customer ID</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Subject Type</th>
                    <th class="border px-4 py-2">Customer Name</th>
                    <th class="border px-4 py-2">Order Amount</th>
                    <th class="border px-4 py-2">Customer Email</th>
                </tr>
            </thead>
            @foreach($activity as $act)
            <tr>
                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2">{{ $act['subject_id'] }}</td>
                <td class="border px-4 py-2">{{ $act['description'] }}</td>
                <td class="border px-4 py-2">{{ $act['created_at'] }}</td>
                <td class="border px-4 py-2">{{ $act['subject_type'] }}</td>
                <td class="border px-4 py-2">{{ $orders[$act['subject_id']]->customer_name ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $orders[$act['subject_id']]->order_amount ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $orders[$act['subject_id']]->customer_email ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </table>

         <div class="mt-4 d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0" style="font-size:0.875rem;">
                    Showing {{ $activity->firstItem() }} to {{ $activity->lastItem() }} of {{ $activity->total() }} results
                </p>
                {{ $activity->links() }}
            </div>
            
        @endif
    </div>

    <div class="mt-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Index Log</h3>
        @if($logindex->isEmpty())
        <p class="text-lg text-gray-600">No index activity recorded.</p>
        @else

        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="border px-4 py-2">id</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Subject Type</th>
                </tr>
            </thead>
            @foreach($logindex as $log)
            <tr>
                <td class="border px-4 py-2">{{ $log->id }}</td>
                <td class="border px-4 py-2">{{ $log->description }}</td>
                <td class="border px-4 py-2">{{ $log->created_at }}</td>
                <td class="border px-4 py-2">{{ $log->subject_type }}</td>
            </tr>
            @endforeach
        </table>
        @endif



        @endsection