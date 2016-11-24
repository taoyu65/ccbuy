<?php
/**
 * Created by PhpStorm.
 * User: taoyu
 * Date: 9/14/2016
 * Time: 10:26 PM
 */

namespace App\Http\Controllers;

//use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Cart;
use Illuminate\Support\Facades\Input;

class CartController extends Controller
{
    public function index(){}

    //show custom list
    public function showcustomList($dm = '')
    {
        $custom = DB::table('customs')->get();
        if ($dm == 'daimai'){
            return view('addCart', ['customs' => $custom, 'dmCart' => 1]);
        }else{
            return view('addCart', ['customs' => $custom, 'dmCart' => 0]);
        }
    }

    //add
    public function add()
    {
        $cart = new Cart;   //dd($cart);
        //set different way to save id
        $idmodel = Input::get('idModel');
        //get if dai mai model
        $dm = Input::get('dmCart');
        if($idmodel == 'name') {
            $cart->customs_id = Input::get('customsNameList');
        }
        if($idmodel == 'id'){
            $cart->customs_id = Input::get('customId');
        }
        $cart->rename = Input::get('reName');
        if ($dm) {
            $cart->weight = 0;
            $cart->postRate = 0;
        }else{
            $cart->weight = Input::get('weight');
            $cart->postRate = Input::get('postRate');
        }
        $cart->isHelpBuy = $dm;
        $cart->date=  Input::get('dateInput');
        if($cart->save()){
            return $cart->id;
        }else{
        }
    }

    //search and select to return cart id
    /**
     * @param get|string $customId get all cart by custom id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search($customId = '')
    {
        //show custom name dropdown list
        $customName = DB::table('customs')->get();

        //page
        $perPage = 5;
        $obj = DB::table('view_carts_customs')->orderBy('id', 'desc');
        if(is_numeric($customId))
            $obj = $obj->where('customs_id', '=', $customId);
        $totalPage = $obj->count();
        $re = $obj->paginate($perPage);//simplePaginate(num)  will be showing << >>
        return view('view/cartSelect', ['customs'=> $customName, 'carts' => $re, 'count' => ceil($totalPage/$perPage)]);
    }


    /**
     *  showing all the deal that have not done
     */
    public function unFinishDeal()
    {
        $carts = Cart::orderBy('id', 'desc')->get();

        return view('view/collecting', ['carts' => $carts]);
    }

    /**
     *  finish deal
     */
    public function dealDone()
    {

    }
}