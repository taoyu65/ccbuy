<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Item;

class ItemController extends Controller
{
    //
    public function index()
    {

    }

    public function create()
    {
        return view('add');
    }

    public function store(Request $request)
    {
        $item = new Item;
        $item->carts_id = $request->get('CartId');
        $item->stores_id = $request->get('storeId');
        $item->itemName = $request->get('itemName');
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
            return redirect('item/create');
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
