@extends('partials.layout')
@section('title', 'Homepage')

@section('content')
<div class="container mx-auto p-4 mt-8 bg-gray-100">
    <a href="{{ route('addDataForm') }}" class="inline-block mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Add Data</a>
    <h1 class="text-4xl font-bold text-blue-600 my-6">Homepage</h1>
    <ul class="list-disc list-inside space-y-2">
        @foreach($demos as $demo)
            <li class="text-lg text-gray-800">{{ $demo->name }} : {{ $demo->description }}</li>
        @endforeach
    </ul>

    
</div>



@endsection