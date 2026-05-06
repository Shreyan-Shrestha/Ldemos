<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-6">

    <div class="max-w-3xl mx-auto space-y-8">

        {{-- Search --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Search Posts</h1>

            <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
                <div class="flex gap-3">
                    <input
                        type="text"
                        name="q"
                        value="{{ $query }}"
                        placeholder="Search by title or content..."
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        autofocus
                    >
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                        Search
                    </button>
                </div>
            </form>

            @if(filled($query))
                <p class="text-sm text-gray-500 mb-4">
                    {{ $posts->count() }} result(s) for
                    <span class="font-medium text-gray-700">"{{ $query }}"</span>
                </p>

                @forelse($posts as $post)
                    <div class="border-b border-gray-200 py-5 last:border-0">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $post->title }}</h2>
                        <p class="text-sm text-gray-400 mt-1">
                            By {{ $post->author->name }}
                            &middot;
                            {{ $post->published_at->diffForHumans() }}
                        </p>
                        <p class="mt-2 text-gray-600 leading-relaxed">
                            {{ Str::limit($post->content, 200) }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 py-4">No posts found for "{{ $query }}".</p>
                @endforelse
            @endif
        </div>

        {{-- Session Message --}}
        @if(session('message'))
            <div class="p-3 bg-green-50 border border-green-200 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        {{-- Published Posts --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Published Posts</h1>

            @forelse($posts as $post)
                @if(!filled($query))
                <div class="border-b border-gray-200 py-5 last:border-0">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $post->title }}</h2>
                    <p class="text-sm text-gray-400 mt-1">
                        By <span class="text-blue-400">{{ $post->author->name }}</span>
                        &middot;
                        {{ $post->published_at->diffForHumans() }}
                    </p>
                    <p class="text-gray-600 mt-2 leading-relaxed">
                        {{ Str::limit($post->content, 160) }}
                    </p>
                    <form action="{{ route('posts.unpublish', $post) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Unpublish
                        </button>
                    </form>
                </div>
                @endif
            @empty
                @if(!filled($query))
                    <p class="text-gray-500 py-4">No published posts yet.</p>
                @endif
            @endforelse

            @if(!filled($query))
                <div class="mt-6">{{ $posts->links() }}</div>
            @endif
        </div>

        {{-- Draft Posts --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Draft Posts</h1>

            @forelse($unposts as $unpost)
                <div class="border-b border-gray-200 py-5 last:border-0">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $unpost->title }}</h2>
                    <p class="text-sm text-gray-400 mt-1">
                        By <span class="text-blue-400">{{ $unpost->author->name }}</span>
                        &middot;
                        {{ $unpost->created_at->diffForHumans() }}
                    </p>
                    <p class="text-gray-600 mt-2 leading-relaxed">
                        {{ Str::limit($unpost->content, 160) }}
                    </p>
                    <form action="{{ route('posts.publish', $unpost) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                            Publish
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500 py-4">No draft posts yet.</p>
            @endforelse

            <div class="mt-6">{{ $unposts->links() }}</div>
        </div>

    </div>

</body>
</html>