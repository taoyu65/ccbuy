<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use App\Models\Custom;

class CustomController extends Controller
{
    //
    function showWindow()
    {

        $relationship = Config::get('ccbuy.custom.relationship');
        $count = count($relationship);
        $from = Config::get('ccbuy.custom.from');
        return view('view/customShow', ['relationship' => $relationship, 'from' => $from, 'count' => $count]);
    }

    //
    function add()
    {
        $custom = new Custom;
        $custom->customName = Input::get('customName');
        $custom->relationship = Input::get('relationship');
        $custom->dgFrom = Input::get('dgFrom');
        $custom->info = Input::get('info');
        if ($custom->save()) {
            //return true;
        } else {

        }
    }

    //根据ID 查询
    function getCustomName($id)
    {
        //if (!is_numeric($id))
            //return '请输入数字';     //not functional because Route set a pattern id must be number
        $custom = Custom::find($id);
        //return para[custom's name, is in the database]
        if ($custom == null) {
            return ['没有客户信息,请核对在输入', false];
        }else {
            return [$custom->customName,true];
        }
    }
}
