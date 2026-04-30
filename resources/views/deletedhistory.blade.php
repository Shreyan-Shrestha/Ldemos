@extends('partials.layout')

@section('title', 'Deleted History')

@section('content')
<div class="container mx-auto p-4 bg-gray-100 min-h-screen">
    <h1 class="text-4xl font-bold text-red-600 mb-6">Deleted History</h1>
    <ul class="list-group text-start mt-3 gap-2">
        @foreach($deletedhistory as $history)
        <li class="text-lg list-group-item">{{ $history->name }} : {{ $history->description }} (Deleted at: {{ $history->created_at }})</li>
        @endforeach
    </ul>
</div>
@endsection