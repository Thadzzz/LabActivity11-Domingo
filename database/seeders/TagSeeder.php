<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tagNames = ['Purok Domingo', 'Urgent', 'Libre', 'Schedule', 'Health'];
        $tags = [];

        foreach ($tagNames as $name) {
            $tags[] = Tag::create(['name' => $name]);
        }

        $posts = Post::all();
        foreach ($posts as $post) {
            $randomTags = collect($tags)->random(rand(1, 3))->pluck('id');
            $post->tags()->attach($randomTags);
        }

        $pinnedPost = Post::where('is_pinned', true)->first();
        if ($pinnedPost) {
            $purokTag = Tag::where('name', 'Purok Domingo')->first();
            $urgentTag = Tag::where('name', 'Urgent')->first();
            $pinnedPost->tags()->sync([$purokTag->id, $urgentTag->id]);
        }
    }
}