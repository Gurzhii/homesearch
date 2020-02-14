<?php

use App\Post;
use App\User;
use App\Comment;
use Tests\TestCase;
use App\Mail\ProfileDeleted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_delete_his_profile()
    {
        $user1 = factory(User::class)->create();
        $this->actingAs($user1);
        $user2 = factory(User::class)->create();

        $post1 = factory(Post::class)->create(['user_id' => $user1->id]);
        $post2 = factory(Post::class)->create(['user_id' => $user2->id]);
        $comment = factory(Comment::class)->create(['post_id' => $post1->id, 'user_id' => $user1]);

        $response = $this->delete('/users/1');
        $response->assertStatus(200);
        $this->assertNull(User::find(1));
        $this->assertNotNull(User::find(2));

        $this->assertNull(Post::find(1));
        $this->assertNotNull(Post::find(2));
        $this->assertNull(Comment::find(1));
    }

    /** @test */
    public function user_can_not_delete_not_his_profile()
    {
        $user1 = factory(User::class)->create();
        $this->actingAs($user1);
        $user2 = factory(User::class)->create();
        $response = $this->delete('/users/2');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_got_the_email_after_profile_deleted()
    {
        Mail::fake();
        $user1 = factory(User::class)->create();
        $this->actingAs($user1);
        factory(User::class)->create();
        $this->delete('/users/1');

        Mail::assertSent(ProfileDeleted::class);
    }
}
