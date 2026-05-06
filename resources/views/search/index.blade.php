<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-6">
<div class="max-w-3xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Search Posts</h1>

    <form action="{{ route('search.index') }}" method="GET" class="mb-8">
        <div class="flex gap-3">
            <input
                type="text"
                name="q"
                value="{{ $query }}"
                placeholder="Search by title or content..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                autofocus
            >
            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition"
            >
                Search
            </button>
        </div>
    </form>

    @if(filled($query))
        <p class="text-sm text-gray-500 mb-4">
            {{ $posts->count() }} result(s) for <span class="font-medium text-gray-700">"{{ $query }}"</span>
        </p>
    @endif

    @forelse($posts as $post)
        <div class="border-b border-gray-200 py-5 last:border-0">
            <h2 class="text-lg font-semibold text-gray-900">{{ $post->title }}</h2>
            <p class="text-sm text-gray-400 mt-1">
                By {{ $post->author->name }}
                &middot;
                {{ $post->published_at->diffForHumans() }}
            </p>
            <p class="mt-2 text-gray-600 leading-relaxed">
                {{ Str::limit($post->body, 200) }}
            </p>
        </div>
    @empty
        @if(filled($query))
            <p class="text-gray-500 py-4">No posts found for "{{ $query }}".</p>
        @else
            <p class="text-gray-500 py-4">Enter a keyword above to search published posts.</p>
        @endif
    @endforelse

    <div class="mt-8 mb-6 text-center text-sm text-gray-500">
        <a href="https://qadrlabs.com"
           class="text-blue-600 hover:text-blue-800 hover:underline transition"
           target="_blank">Tutorial Elasticsearch at qadrlabs.com</a>
    </div>

</div>
</body>
</html>