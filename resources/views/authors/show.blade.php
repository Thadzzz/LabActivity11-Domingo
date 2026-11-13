<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $author->name }} - Barangay Bulletin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 p-6">

    <div class="max-w-4xl mx-auto">
        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline mb-6 inline-block font-medium">&larr; Back to Bulletin</a>

        <div class="bg-white p-6 rounded shadow mb-8">
            <h1 class="text-3xl font-bold">{{ $author->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $author->position }}</p>
            <p class="text-sm text-gray-500 mt-2">{{ $commentCount }} comments received</p>
        </div>

        <h2 class="text-2xl font-bold mb-4">Published Posts</h2>

        @forelse ($author->posts as $post)
            <div class="bg-white p-4 rounded shadow mb-4">
                <h3 class="text-xl font-semibold">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:underline">
                        {{ $post->title }}
                    </a>
                </h3>
                <div class="text-sm text-gray-500 mt-2">
                    <span class="bg-gray-200 px-2 py-1 rounded">{{ $post->category }}</span>
                    <span>Published: {{ $post->published_at ? $post->published_at->format('M d, Y') : 'N/A' }}</span>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No published posts yet.</p>
        @endforelse
    </div>

</body>
</html>