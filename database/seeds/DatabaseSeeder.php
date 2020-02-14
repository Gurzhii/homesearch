<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 3)->create()->each(function ($user) {
           factory(App\Post::class, 5)->create(['user_id' => $user->id])->each(function ($post) use ($user) {
                factory(App\Comment::class, 4)->create(['user_id' => $user->id, 'post_id' => $post->id]);
           });
        });
    }
}
