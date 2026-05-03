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

</div>



@endsection