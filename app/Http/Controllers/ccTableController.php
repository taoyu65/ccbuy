<?php

namespace App\Http\Controllers;

use App\Foundations\Table;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ccTableController extends Controller
{
    //build table //required table name
    public function showTable($table)
    {
        //get the column which will be shown on the page from ccbuy config
        $showingColumn = Config::get('ccbuy.showColumn.'.$table);
        //set second para to show column that you want to review
        $data = new Table($table, $showingColumn);
        $html = $data->getHtml();
        return view('cc_admin/table', ['html' => $html, 'table' => $table]);
    }

    //edit page to show
    /**
     * @param $tableName
     * @param $id
     */
    public function editShow($tableName, $id)
    {
        $validation = Config::get('ccbuy.validation.' . $tableName);
        //get the column which will be shown on the page from ccbuy config
        $showingColumn = Config::get('ccbuy.showColumn.'.$tableName);
        //don't set second para to show all the field that can be edited
        $data = new Table($tableName, $showingColumn);
        //set validation for every field
        $data->setValidation($validation);
        $html = $data->getHtmlToEdit($tableName, $id);
        return view('cc_admin/tableEdit', ['html' => $html, 'tableName' => $tableName, 'id' => $id]);
    }

    //edit action
    /**
     * @param $tableName
     * @param $id
     */
    public function edit($tableName, $id)
    {
        //$updateList = ['info' => 'aa1a', 'customName' => 'new1','asdf' => 'asdf'];dd($_REQUEST);
        unset($_REQUEST['_token']);
        if(count($_REQUEST) != 0){
            $num = DB::table($tableName)->where('id', $id)->update($_REQUEST);
            if ($num) {
                return redirect('item/create')->with('status', '添加记录成功');
            }
        }
    }
}
