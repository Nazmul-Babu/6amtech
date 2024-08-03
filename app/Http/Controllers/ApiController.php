<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function __construct()
    {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
    }

    public function login(Request $request)
    {
        $server_response = [
            "status" => false,
            "message" => "Wrong Attempt..",
            'user_id' => 0,
            'name' => '',
            'email' => '',
            'api_secret_key' => '',
        ];
        //checking method
        if ($request->isMethod('post')) {
            $token_generate = sha1(rand(10000, 100000)); // for avoiding multiple login together by same id 
            $login_status = Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]);
            if ($login_status) {
                $user = Auth::user();
                $server_response = [
                    "status" => true,
                    "message" => "LoggedIn Successfully",
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'api_secret_key' => $token_generate,
                ];
                // for avoiding multiple login together by same id 
                User::where('id', $user->id)->update([
                    'api_secret_key' => $token_generate
                ]);
            }
        } else {
            $server_response = [
                "status" => false,
                "message" => "Method Not Allowed",
                'user_id' => 0,
                'name' => '',
                'email' => '',
                'api_secret_key' => '',
            ];
        }
        return response()->json($server_response);
    }
    // common function for checking token 
    public function login_auth_check($user_id, $api_secret_key): bool
    {
        return User::where('id', $user_id)->where('api_secret_key', $api_secret_key)->count();
    }

    public function posts(Request $request)
    {
        $server_response = [
            "status" => false,
            "message" => "Wrong Attempt..",
            'posts' => []
        ];
        // double ensuring  method check 
        if ($request->isMethod('post')) {
            $user_id = $request->user_id;
            $api_secret_key = $request->api_secret_key;
            // login auth check
            if ($this->login_auth_check($user_id, $api_secret_key)) {
                $query = Post::select('*');
                // if have request parameter search
                if ($request->has('search')) {
                    $query->where('title', 'like', "%{$request->search}%")
                        ->orWhere('body', 'like', "%{$request->search}%");
                }
                $query->paginate(10)->withQueryString(); // ->withQueryString() for pagination $request parameter 
                $server_response = [
                    "status" => true,
                    "message" => "Posts get Successfully",
                    'posts' => $query
                ];
            } else {
                // login auth check
                $server_response = [
                    "status" => false,
                    "message" => "Auth Check Failed",
                    'posts' => []
                ];
            }
        } else {
            // method check
            $server_response = [
                "status" => false,
                "message" => "Method Not Allowed",
                'posts' => []
            ];
        }
        return response()->json($server_response);
    }
}
