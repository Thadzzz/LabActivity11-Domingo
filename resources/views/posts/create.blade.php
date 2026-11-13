<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - Barangay Bulletin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 p-6">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow mt-10">
        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline mb-6 inline-block font-medium">&larr; Back to Bulletin</a>
        <h1 class="text-3xl font-bold mb-6">Create New Post</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('posts.store') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block font-medium mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
                @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Category</label>
                <select name="category" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Category</option>
                    <option value="Announcement" {{ old('category') == 'Announcement' ? 'selected' : '' }}>Announcement</option>
                    <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}>Health</option>
                    <option value="Peace & Order" {{ old('category') == 'Peace & Order' ? 'selected' : '' }}>Peace & Order</option>
                    <option value="Ayuda" {{ old('category') == 'Ayuda' ? 'selected' : '' }}>Ayuda</option>
                    <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                </select>
                @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Body</label>
                <textarea name="body" rows="5" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">{{ old('body') }}</textarea>
                @error('body') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Tags</label>
                <div class="flex gap-4 flex-wrap">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} class="mr-2 rounded text-blue-600">
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
                @error('tags') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="mr-2 rounded text-blue-600">
                    Publish immediately
                </label>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Post</button>
        </form>
    </div>

</body>
</html>