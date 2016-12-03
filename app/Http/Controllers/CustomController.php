<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use App\Models\Custom;

class CustomController extends Controller
{
    //get dromdown list to relationship
    //no longer to use , now using js to read json file to show data
    function showWindow()
    {

        $relationship = Config::get('ccbuy.custom.relationship');
        $count = count($relationship);
        $from = Config::get('ccbuy.custom.from');
        return view('view/customShow', ['relationship' => $relationship, 'from' => $from, 'count' => $count]);
    }

    //add custom info and add dropdownlist data
    function add()
    {
        $jsonPath = Config::get('ccbuy.json');
        $custom = new Custom;
        $custom->customName = Input::get('customName');
        $custom->relationship = Input::get('relationship');
        $custom->dgFrom = Input::get('dgFrom');
        $custom->info = Input::get('info');
        $custom->save();
        if ($custom->save()) {
            //relationship dropdown
            $this->addRelationshipToJson($jsonPath,$custom->relationship);
            //from dropdown
            $this->addFromToJson($jsonPath, $custom->dgFrom);
        }
    }

    /**
     * @param $jsonPath where to get json file
     * @param $relationshipName //if does exist skip, if not add
     */
    function addRelationshipToJson($jsonPath, $relationshipName)
    {
        $jsonString = file_get_contents(public_path($jsonPath));
        $data = json_decode($jsonString, true);     //turn into php array
        $newdata = $data['custom']['relationship'];
        foreach ($newdata as $a) {
            if($a == $relationshipName){
                return; //if data does exist then no need to add same one
            }
        }
        array_push($data['custom']['relationship'], $relationshipName);
        $jsonString= json_encode($data);
        file_put_contents($jsonPath, $jsonString);
    }

    /**
     * @param $jsonPath where to get json file
     * @param $fromName if does exist skip, if not add
     */
    function addFromToJson($jsonPath, $fromName)
    {
        $jsonString = file_get_contents(public_path($jsonPath));
        $data = json_decode($jsonString, true);     //turn into php array
        $newdata = $data['custom']['from'];
        foreach ($newdata as $a) {
            if($a == $fromName){
                return; //if data does exist then no need to add same one
            }
        }
        array_push($data['custom']['from'], $fromName);
        $jsonString= json_encode($data);
        file_put_contents($jsonPath, $jsonString);
    }

    //根据ID 查询
    function getCustomName($id)
    {
        //if (!is_numeric($id))
            //return '请输入数字';     //not functional because Route set a pattern id must be number
        $custom = Custom::find($id);
        //return para[custom's name, is in the database]
        if ($custom == null) {
            return [trans('addCart.warning'), false];
        }else {
            return [$custom->customName,true];
        }
    }
}
