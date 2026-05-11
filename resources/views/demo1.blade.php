@extends('partials.layout')

@section('title', 'Demo 1')

@section('content')
<div class="container mx-auto p-4 bg-gray-100 min-h-screen">
    <h1 class="text-4xl font-bold text-green-600 mb-6">Job and Queue</h1>
    <ul class="list-group mt-3 gap-2" >
       <ul class="list-group text-start mt-3 gap-2" >
        @foreach($demos as $demo)
            <li class="text-lg list-group-item">{{ $demo->description }} : {{ $demo->name }}</li>
        @endforeach
    </ul>

</div>