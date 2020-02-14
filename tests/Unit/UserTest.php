<?php

namespace Tests\Unit;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_has_posts()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        factory(Post::class, 3)->create(['user_id' => $user1->id]);
        factory(Post::class)->create(['user_id' => $user2->id]);

        $this->assertEquals(4, Post::count());
        $this->assertEquals(3, User::find($user1->id)->posts()->count());
        $this->assertEquals(1, User::find($user2->id)->posts()->count());
        $this->assertEquals(0, User::find($user3->id)->posts()->count());
    }
}
