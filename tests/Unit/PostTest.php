<?php

namespace Tests\Unit;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_owner()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $post = factory(Post::class)->create(['user_id' => $user1->id]);

        $this->assertEquals(1, $user1->posts()->count());
        $this->assertEquals($post->owner->getAttributes(), $user1->getAttributes());
        $this->assertEquals(0, $user2->posts()->count());
    }

    /** @test */
    public function it_has_comments()
    {
        $user = factory(User::class)->create();

        $post1 = factory(Post::class)->create(['user_id' => $user->id]);
        $post2 = factory(Post::class)->create(['user_id' => $user->id]);

        $comment = factory(Comment::class)->create(['post_id' => $post1->id, 'user_id' => $user]);

        $this->assertEquals(1, $post1->comments()->count());
        $this->assertEquals($post1->comments()->first()->getAttributes(), $comment->getAttributes());
        $this->assertEquals(0, $post2->comments()->count());
    }
}
