<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * welcome
     */
    public function welcome()
    {
        $items = DB::table('items')->get();

        return view('welcome', ['items' => $items]);
    }

    /**
     * add item
     */
    public function add()
    {
        return view('add');
    }
}
