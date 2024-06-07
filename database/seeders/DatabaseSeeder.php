<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        // User::factory()->count(10)->create([
        //     'username'          => fake()->name(),
        //     'email'             => fake()->unique()->safeEmail(),
        //     'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        //     'email_verified_at' => now(),
        //     'remember_token'    => Str::random(10),
        //     'is_admin'          => 1
        // ]);

        Post::create([
            'user_id'    => random_int(1, 3),
            'title'      => fake()->sentence(),
            'body'       => fake()->text(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
