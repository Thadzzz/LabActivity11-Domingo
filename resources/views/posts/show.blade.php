<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Barangay Bulletin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 p-6">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow mt-10">
        
        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline mb-6 inline-block font-medium">&larr; Back to Bulletin</a>

        <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
        
        <div class="text-sm text-gray-500 mb-6 flex flex-wrap gap-4 border-b pb-4 items-center">
            <span class="bg-gray-100 px-3 py-1 rounded"><strong>Category:</strong> {{ $post->category }}</span>
            <span><strong>Author:</strong> <a href="{{ route('authors.show', $post->author->id) }}" class="text-blue-600 hover:underline">{{ $post->author->name }}</a></span>
            <span><strong>Published:</strong> {{ $post->published_at ? $post->published_at->format('M d, Y') : 'N/A' }}</span>
            <span><strong>Views:</strong> {{ $post->views }}</span>
            
            @if($post->is_pinned)
                <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded font-bold">Pinned</span>
            @endif
        </div>

        @if($post->tags->isNotEmpty())
            <div class="mb-6 flex gap-2">
                @foreach($post->tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded hover:bg-blue-200">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="text-gray-700 leading-relaxed text-lg mb-10">
            {!! nl2br(e($post->body)) !!}
        </div>

        <div class="border-t pt-6">
            <h3 class="text-xl font-bold mb-4">Comments ({{ $post->comments->count() }})</h3>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @auth
                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('comments.store', $post->id) }}" class="mb-6">
                    @csrf
                    <textarea name="body" rows="3" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write a comment...">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Post Comment</button>
                </form>
            @else
                <p class="text-sm text-gray-500 mb-6"><a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign in</a> to comment.</p>
            @endauth

            <div class="space-y-4">
                @forelse($post->comments as $comment)
                    <div class="bg-gray-50 p-4 rounded border">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $comment->body }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No comments yet. Be the first!</p>
                @endforelse
            </div>
        </div>

    </div>

</body>
</html>