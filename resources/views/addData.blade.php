@extends('partials.layout')
@section('title', 'Add Data to table')

@section('content')
<div class="container isolate bg-white px-6 py-24 sm:py-32 lg:px-8 mx-auto">
    <h1 class="text-4xl font-semibold tracking-tight text-balance text-gray-900 sm:text-5xl text-center">Add Data to table</h1>
    <form action="{{ route('data.addData') }}" method="POST">
        @csrf
        <div class="mb-3 form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control block w-full rounded-md px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" id="name" name="name" required>
        </div>
        <div class="mb-3 form-group">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" id="description" name="description" required>
        </div>
        <button type="submit" class="btn btn-outline-primary block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center">Add Data</button>
        <a href="{{ route('data.index') }}" class="btn btn-outline-secondary block w-full rounded-md bg-gray-200 px-3.5 py-2.5 text-center mt-2">Return</a>
    </form>
</div>
@endsection