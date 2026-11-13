<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $lola = User::create([
            'name' => 'Lola Domingo',
            'email' => 'lola.domingo@bulletin.test',
            'password' => Hash::make('password12345'),
        ]);

        $kagawadUser = User::create([
            'name' => 'Kagawad Juan Domingo',
            'email' => 'kagawad.domingo@bulletin.test',
            'password' => Hash::make('password12345'),
        ]);

        $kagawadAuthor = Author::where('email', 'kagawad.domingo@bulletin.test')->first();
        if ($kagawadAuthor) {
            $kagawadAuthor->user_id = $kagawadUser->id;
            $kagawadAuthor->save();
        }

        User::factory()->count(8)->create();
    }
}