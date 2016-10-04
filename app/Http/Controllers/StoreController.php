<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Store;

class StoreController extends Controller
{
    //
    public function index()
    {
        return view('view/store');
    }

    public function store(Request $request)
    {
        $store = new Store;
        $store->storeName = $request->get('storeName');
        $store->info = $request->get('info');
        if ($store->save()) {
            $select = $store->storeName.','.$store->id;
            return redirect('store')->with('status', $select);
        } else {
            return redirect()->back()->withInput()->withErrors('出现意外错误.请联系涛哥');
        }
    }
}
