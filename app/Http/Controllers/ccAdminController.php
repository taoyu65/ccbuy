<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ccAdminController extends Controller
{
    //showing the page that recalculate profit. 订单结算页面显示
    public function closeCartShow()
    {
        $DB = DB::table('carts')->whereRaw('weight*postRate=0 and isHelpBuy=0')->get();
        return view('cc_admin/system',['DBs' => $DB]);
    }
    public function closeCart()
    {
        $id = $_REQUEST['cartId'];
        $weight = $_REQUEST['weight'];
        $postRate = $_REQUEST['postRate'];
        $profits = $_REQUEST['profits'] - ($weight * $postRate);
        $updateList = [
            'weight'    => $weight,
            'postRate'  => $postRate,
            'profits'   => $profits
        ];
        DB::table('carts')->where('id', $id)->update($updateList);
        return Redirect::back();
    }
}
