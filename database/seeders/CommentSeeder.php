<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $publishedPosts = Post::where('is_published', true)->get();

        foreach ($publishedPosts as $post) {
            $count = rand(0, 5);
            for ($i = 0; $i < $count; $i++) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'body' => fake()->sentence(),
                ]);
            }
        }

        $pinnedPost = Post::where('is_pinned', true)->first();
        $lola = User::where('email', 'lola.domingo@bulletin.test')->first();
        
        if ($pinnedPost && $lola) {
            $existingCount = $pinnedPost->comments()->count();
            $needed = 3 - $existingCount;

            if ($needed > 0) {
                for ($i = 0; $i < $needed; $i++) {
                    Comment::create([
                        'post_id' => $pinnedPost->id,
                        'user_id' => $lola->id,
                        'body' => fake()->sentence(),
                    ]);
                }
            }
        }
    }
}