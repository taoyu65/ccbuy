<?php
/**
 * Created by PhpStorm.
 * User: taoyu
 * Date: 9/14/2016
 * Time: 10:26 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getIndex(){}
    //show custom list
    public function getShowcustom()
    {
        $custom = DB::table('customs')->get();
        return view('addCart', ['customs' => $custom]);
    }
    public function showCustom()
    {
        $custom = DB::table('customs')->get();
        return view('addCart', ['customs' => $custom]);
    }
}