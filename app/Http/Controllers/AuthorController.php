<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show(Author $author)
    {
        $author->load(['posts' => function ($query) {
            $query->where('is_published', true)->latest('published_at');
        }]);

        $commentCount = $author->comments()->count();

        return view('authors.show', compact('author', 'commentCount'));
    }
}