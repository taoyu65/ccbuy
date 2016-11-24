<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Item;
use App\Models\Store;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    //first page show item
    public function firstPage()
    {
        $items = DB::table('items')->orderBy('id', 'desc');
        $perPage = 5;
        $totalItems = $items->count();
        $totalPage = ceil($totalItems / $perPage);
        $currentItems = $items->paginate($perPage);
        return view('firstpage', ['items' => $currentItems, 'count' => $totalPage]);
    }

    //
    public function index()
    {

    }

    public function create()
    {
        //get stores
        $stores = Store::all();
        return view('add',['stores' => $stores, 'dm' => 0]);
    }

    /**
     *dai mai page
     */
    public function daiMai()
    {
        $stores = Store::all();
        return view('add',['stores' => $stores, 'dm' => 1]);
    }

    public function store(Request $request)
    {
        $item = new Item;
        $dm = $request->get('dm');  //daimai option
        $item->carts_id = $request->get('cartId');
        $item->stores_id = $request->get('storeId');
        $item->itemName = $request->get('itemName');
        $item->itemAmount = $request->get('itemNum');
        if($dm){
            $item->sellPrice = 0;
        }else{
            $item->sellPrice = $request->get('sellPrice');
        }
        $item->specialPrice = $request->get('specialPrice');
        if($dm){
            $item->exchangeRate = 0;
        }else{
            $item->exchangeRate = $request->get('exchangeRate');
        }
        $item->marketPrice = $request->get('marketPrice');
        $item->costPrice = $request->get('costPrice');
        $item->itemProfit = $this->getProfit($item, $dm);
        $item->date = $request->get('date');
        $item->isDeal = $request->get('view');
        $item->itemPic = $request->get('fileName_hide');
        $item->info = $request->get('info');

        if ($item->save()) {
            //set profits for table carts
            $cartId = $item->carts_id;
            $cart = Cart::find($cartId);
            $profitCurrent = $cart->profits;
            $postCost = $cart->weight * $cart->postRate;
            if($postCost == 0) {   //the deal has not been done, post cost or post rate is gonna be 0
                $profitNow = $item->itemProfit + $profitCurrent;
            }else{
                if($cart->profits == 0){    //the first item will be record and the post fee will be minus
                    $profitNow = $item->itemProfit + $profitCurrent - $postCost;
                } else {
                    $profitNow = $item->itemProfit + $profitCurrent;
                }
            }
            DB::table('carts')->where('id', $cartId)->update(['profits' => $profitNow]);
            if($dm){
                return redirect('item/create/daimai')->with('status', '添加记录成功');
            }else{
                return redirect('item/create')->with('status', '添加记录成功');
            }
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    //calculate profit
    private function getProfit($item, $dm)
    {
        if($dm)
        {
            $profit = $item->marketPrice - $item->costPrice;
            $profits = $profit * $item->itemAmount;
            return $profits;
        }
        else
        {
            $itemCost = $item->costPrice * $item->itemAmount;
            $sellPrice = $item->sellPrice / $item->exchangeRate;
            $profit = $sellPrice - $itemCost;//dd($profit.'---'.round($profit, 2));
            return round($profit, 2);
        }
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    //ajax get items
    public function getItems($cartId)
    {
        $items = Item::where('carts_id', $cartId)->get();
        $html = '';
        $html .= '<table class="table table-hover">';
        $html .= '<thead class="bg-warning">';
        $html .= '<tr>';
        $html .= '    <th>物品名称</th>';
        $html .= '    <th>售价</th>';
        $html .= '    <th>利润</th>';
        $html .= '    <th>付费</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($items as $item) {
            $html .= '<tr class="success">';
            $html .= '<td>'.$item->itemName.'</td>';
            $html .= '<td>'.$item->sellPrice.'¥</td>';
            $html .= '<td>'.$item->itemProfit.'$</td>';
            if($item->isDeal) {
                $html .= '<td><img src="images/yes.png"></td>';
            }else{
                $html .= '<td><img src="images/no.png"></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        return $html;
    }
}
