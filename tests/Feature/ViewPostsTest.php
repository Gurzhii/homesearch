<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_existing_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id' => $user->id]);
        $response = $this->get('/posts/1');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_not_see_unpublished_post()
    {
        $user = factory(User::class)->create();
        factory(Post::class)->create(['user_id' => $user->id]);
        $response = $this->get('/posts/2');

        $response->assertStatus(404);
    }
}
