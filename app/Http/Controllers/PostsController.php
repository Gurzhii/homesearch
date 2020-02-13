<?php

namespace App\Http\Controllers;

class PostsController extends Controller
{

    public function show($id)
    {
        $post = \DB::table('posts')
            ->select([
                'posts.id',
                'posts.title',
                \DB::raw('user.name as username')
            ])
            ->join('user', 'post.user_id', '=', 'user.id')
            ->where('posts.id', $id);

        $comments = \DB::table('comments')
            ->select('post_id', 'text')
            ->where('comments.post_id', $id);

        $post->comments = $comments;

        return $post;
    }
}