<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BackendAuthCheckMiddleware;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(){
       return [
        BackendAuthCheckMiddleware::class.':admin'
       ];
    }
    
    public function delete_post($id){
             dd('delete post');
    }
}
