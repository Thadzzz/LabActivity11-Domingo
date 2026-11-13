<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%" . $request->q . "%");
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->where('name', $request->tag);
                });
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(7) 
            ->withQueryString();

        $categories = Post::query()->distinct()->orderBy('category')->pluck('category');
        $tags = Tag::orderBy('name')->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        
        if (!$post->is_published) {
            abort(404);
        }

        $post->views = $post->views + 1;
        $post->save();

        $post->load(['author', 'tags', 'comments' => function ($query) {
            $query->latest();
        }, 'comments.user']);

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('posts.create', compact('tags'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $tagIds = $data['tags'];
        unset($data['tags']);

        if ($request->has('is_published')) {
            $data['is_published'] = true;
            $data['published_at'] = now();
        } else {
            $data['is_published'] = false;
        }

        $post = auth()->user()->author->posts()->create($data);
        $post->tags()->sync($tagIds);

        return redirect()->route('posts.show', $post->id)->with('success', 'Post created.');
    }
}