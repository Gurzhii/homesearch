<?php

use App\Post;
use App\User;
use App\Comment;
use App\Jobs\DeleteUserJob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_delete_his_profile()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $post1 = factory(Post::class)->create(['user_id' => $user1->id]);
        $post2 = factory(Post::class)->create(['user_id' => $user2->id]);
        $comment = factory(Comment::class)->create(['post_id' => $post1->id, 'user_id' => $user1]);

        $this->delete('/users/1');
        $this->assertNull(User::find(1));
        $this->assertNotNull(User::find(2));

        $this->assertNull(Post::find(1));
        $this->assertNotNull(Post::find(2));

        $this->assertNull(Comment::find(1));
    }
}
