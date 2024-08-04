<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendAuthController extends Controller
{
    public function login(){
        $admin = Admin::find(2);
        Auth::guard('admin')->login($admin);
    }
    public function logout(){
        if(Auth::guard("admin")->check()){
             Auth::guard("admin")->logout();
        }
    }
}
