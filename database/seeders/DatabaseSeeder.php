<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Category::factory(10)->create();

        User::factory()->create([
            'name' => 'Abyan Falah',
            'username' => 'abyan',
            'email' => 'abyan@gmail.com',
            'password' => '$2y$10$ABhIaKHc3TPUXOKqo7MOiObwbCro6EBO5BSD23r5kb/5mbp9nc6Iq',
        ]);

        // User::factory()->create([
        //     'name' => 'Yafi Gamtina',
        //     'username' => 'YafiG',
        //     'email' => 'yafi@gmail.com',
        //     'password' => '$2y$10$ABhIaKHc3TPUXOKqo7MOiObwbCro6EBO5BSD23r5kb/5mbp9nc6Iq',
        // ]);

        User::factory()->create([
            'name' => 'Meiko Whitepaper',
            'username' => 'meikowhitepaper',
            'email' => 'meiko@gmail.com',
            'password' => '$2y$10$ABhIaKHc3TPUXOKqo7MOiObwbCro6EBO5BSD23r5kb/5mbp9nc6Iq',
        ]);


        // User::factory()
        //     ->has(
        //         Category::factory()->has(
        //             Thread::factory()->count(5)
        //         )->count(5)
        //     )
        //     ->create();

        // User::factory(10)->has(Thread::factory()->count(10))
        // ->create();
    }
}
