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
                \DB::raw('users.name as username')
            ])
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.id', $id)->get();

        $comments = \DB::table('comments')
            ->select('post_id', 'text')
            ->where('comments.post_id', $id)->get();

        $post->comments = $comments;

        return $post;
    }
}
