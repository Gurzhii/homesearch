<?php

namespace App\Http\Controllers;

use App\Post;

class PostsController extends Controller
{

    public function show($id)
    {
        return Post::with(['owner', 'comments'])->findOrFail($id);
    }
}
