<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Published Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">Published Posts</h1>

        @if(session('message'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        @forelse($posts as $post)
            <div class="border-b border-gray-200 py-5 last:border-0">
                <h2 class="text-lg font-semibold text-gray-900">{{ $post->title }}</h2>
                <p class="text-sm text-gray-400 mt-1">
                    By <span class="text-blue-400">{{ $post->author->name }}</span>
                    &middot;
                    {{ $post->published_at->diffForHumans() }}
                </p>
                <p class="text-gray-600 mt-2 leading-relaxed">
                    {{ Str::limit($post->body, 160) }}
                </p>

                <form action="{{ route('posts.unpublish', $post) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                        Unpublish
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 py-4">No published posts yet.</p>
        @endforelse

        <div class="mt-6">
            {{ $posts->links() }}
        </div>

    </div>

    <div class="max-w-4xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">Unpublished Posts</h1>

        @if(session('message'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        @forelse($unposts as $unpost)
            <div class="border-b border-gray-200 py-5 last:border-0">
                <h2 class="text-lg font-semibold text-gray-900">{{ $unpost->title }}</h2>
                <p class="text-sm text-gray-400 mt-1">
                    By <span class="text-blue-400">{{ $unpost->author->name }}</span>
                    &middot;
                    {{ $unpost->created_at->diffForHumans() }}
                </p>
                <p class="text-gray-600 mt-2 leading-relaxed">
                    {{ Str::limit($unpost->body, 160) }}
                </p>
                 <form action="{{ route('posts.publish', $unpost) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Publish</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 py-4">No unpublished posts yet.</p>
        @endforelse

        <div class="mt-6">
            {{ $unposts->links() }}
        </div>

</body>
</html>