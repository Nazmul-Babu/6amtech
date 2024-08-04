<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserAuthenticationMiddleware;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller implements HasMiddleware
{
    // checking User & for protecting controller 
    public static function middleware()
    {
        return [
            UserAuthenticationMiddleware::class // dummy 
        ];
    }
    // Creating a Post with Tags
    public function create_post(Request $request)
    {
        $data = []; //for compact all variable together 
        $post = Post::create([
            'user_id' => 1,
            'title' => 'Sample Post',
            'content' => 'This is a sample post content'
        ]);
        // dummy tag 
        $tag = Tag::create(['name' => 'Laravel']);

        $post->tags()->attach($tag->id);

    }
    // Creating a Comment with Nested Comments and Tags:
    public function create_comment(Request $request)
    {
        $data = []; //for compact all variable together 
        $comment = Comment::create([
            'user_id' => 1,
            'post_id' => $request->post_id,
            'content' => 'This is a comment'
        ]);
        $nestedComment = Comment::create([
            'user_id' => 1,
            'post_id' => $request->post_id,
            'parent_id' => $comment->id,
            'content' => 'This is a nested comment'
        ]);

        $tag = Tag::create(['name' => 'PHP']);

        $comment->tags()->attach($tag->id);
    }

    public function filtering_post_by_tag(Request $request)
    {
        $data = []; //for compact all variable together 
        $tag = Tag::where('name', 'Laravel')->first();
        $data['posts'] = $tag->posts; 
    }
}
