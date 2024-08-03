<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Middleware\UserAuthenticationMiddleware;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            UserAuthenticationMiddleware::class
        ];
    }

    public function UserWithPosts()
    {
        $data = [];
        $data['posts'] = Post::leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->select('users.*', 'posts.id as post_id', 'posts.title', 'posts.content')
            ->where('posts.user_id', Auth::id())
            ->get();
        return view('users.index', compact('data'));
    }
}
