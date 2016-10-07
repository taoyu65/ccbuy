<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Item;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    //first page show item
    public function firstPage()
    {
        $items = DB::table('items');
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
        return view('add',['stores' => $stores]);
    }

    public function store(Request $request)
    {
        $item = new Item;
        $item->carts_id = $request->get('cartId');
        $item->stores_id = $request->get('storeId');
        $item->itemName = $request->get('itemName');
        $item->itemAmount = $request->get('itemNum');
        $item->sellPrice = $request->get('sellPrice');
        $item->specialPrice = $request->get('specialPrice');
        $item->weight = $request->get('weight');
        $item->postRate = $request->get('postRate');
        $item->marketPrice = $request->get('marketPrice');
        $item->costPrice = $request->get('costPrice');
        $item->date = $request->get('date');
        $item->isDeal = $request->get('view');
        $item->itemPic = $request->get('fileName_hide');
        $item->info = $request->get('info');

        if ($item->save()) {
            return redirect('item/create')->with('status', '添加记录成功');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
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
}
