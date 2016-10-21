<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //login
    public function submit(Request $request)
    {
        $name = $request->get('name');
        $password = $request->get('password');
        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            return redirect(url('firstpage'));
        }
        return view('cc_admin/login', ['error' => '<script>alert("please check username or password")</script>']);
    }

    //logout
    public function logout ()
    {
        Auth::logout();
        return view('cc_admin/login');
    }
}
