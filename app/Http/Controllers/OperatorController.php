<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BackendAuthCheckMiddleware;
use App\Http\Middleware\IpWhitelistMiddleware;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public static function middleware(){
        return [
         BackendAuthCheckMiddleware::class.':operator',
          IpWhitelistMiddleware::class 
        ];
     }

     public function approve_post(Request $request){
       dd("Approved");
     }
}
