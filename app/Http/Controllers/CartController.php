<?php
/**
 * Created by PhpStorm.
 * User: taoyu
 * Date: 9/14/2016
 * Time: 10:26 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Cart;
use Illuminate\Support\Facades\Input;

class CartController extends Controller
{
    public function index(){}

    //show custom list
    public function showcustomList()
    {
        $custom = DB::table('customs')->get();
        return view('addCart', ['customs' => $custom]);
    }

    //add
    public function add()
    {
        $cart = new Cart;   //dd($cart);
        //set different way to save id
        $idmodel = Input::get('idModel');
        if($idmodel == 'name') {
            $cart->customs_id = Input::get('customsNameList');
        }
        if($idmodel == 'id'){
            $cart->customs_id = Input::get('customId');
        }
        $cart->rename = Input::get('reName');
        $cart->date=  Input::get('dateInput');
        if($cart->save()){
            return $cart->id;
        }else{

        }
    }


}