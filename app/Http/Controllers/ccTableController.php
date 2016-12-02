<?php

namespace App\Http\Controllers;

use App\Foundations\Table;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ccTableController extends Controller
{
    protected $configFileName = 'ccbuy';
    //build table //required table name
    public function showTable($table)
    {
        //get the column which will be shown on the page from ccbuy config
        $showingColumn = Config::get($this->configFileName . '.showColumn.'.$table);
        //set second para to show column that you want to review
        $data = new Table($table, $showingColumn);
        $html = $data->getHtml();
        return view('cc_admin/table', ['html' => $html, 'table' => $table]);
    }

    public function showTableBySearch($table)
    {
        //get the column which will be shown on the page from ccbuy config
        $showingColumn = Config::get($this->configFileName . '.showColumn.'.$table);
        //set second para to show column that you want to review
        $data = new Table($table, $showingColumn);
        $html = $data->getHtml();
        return view('cc_admin/table', ['html' => $html, 'table' => $table]);
    }
    /**
     * edit page to show
     * @param $tableName
     * @param $id
     * @return mixed
     */
    public function editShow($tableName, $id)
    {

        //get the column which will be shown on the page from ccbuy config
        $showingColumn = Config::get($this->configFileName . '.showColumn.'.$tableName);
        //don't set second para to show all the field that can be edited
        $data = new Table($tableName, $showingColumn);
        /*//set validation for every field
        $validation = Config::get($this->configFileName . '.validation.' . $tableName);
        $data->setValidation($validation);*/
        $html = $data->getHtmlToEdit($id);
        return view('cc_admin/tableEdit', ['html' => $html, 'tableName' => $tableName, 'id' => $id]);
    }

    /**
     * edit action
     * @param $tableName
     * @param $id
     * @return mixed
     */
    public function edit($tableName, $id)
    {
        $_REQUEST['id'] = $id;
        $fieldsName = $_REQUEST['fields'];  //field name (string with ,) from database waiting for to be updated
        $fieldsName = rtrim($fieldsName, ',');
        $fieldsList = explode(',', $fieldsName);
        $data = [];
        foreach ($fieldsList as $a => $b) {
            if(array_key_exists($b, $_REQUEST))
                $data[$b] = $_REQUEST[$b];
        }
        if(count($data) != 0){
            DB::table($tableName)->where('id', $id)->update($data);
            //execute special edit
            $this->special($tableName);
        }
    }

    /**
     * @param $tableName
     * @param $id
     * @return mixed
     */
    public function deleteShow($tableName, $id)
    {
        $data = new Table($tableName);
        $html = $data->getHtmlToDelete($id);
        return view('cc_admin/tableDelete', ['html' => $html, 'tableName' => $tableName, 'id' => $id]);
    }

    /**
     *delete action
     */
    public function delete()
    {
        $deleteString = $_REQUEST['deleteString'];
        try {
            $deleteString = Crypt::decrypt($deleteString);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
        $deleteString = rtrim($deleteString, ',');
        //$tbName = explode('@', $deleteString);
        $deleteList = explode(',', $deleteString);
        foreach ($deleteList as $d) {
            $getOne = explode(':', $d);     //example: tableName:id=1
            $tableName = $getOne[0];
            $where = $getOne[1];
            DB::delete('delete from ' . $tableName . ' where ' . $where);
        }
        //execute special delete (if use for another project special operation must be deleted)
        $this->special($_REQUEST['tbName']);
    }

    /**
     * @param $tableName -
     */
    private function special($tableName)
    {
        //get special operation
        switch ($tableName) {
            //when delete items record, the relative table carts's record will be update
            case 'items':
                $foreignId = $_REQUEST['carts_id'];
                $sumProfits = DB::table('items')->where('carts_id', $foreignId)->sum('itemProfit');
                $cart = DB::table('carts')->select('weight', 'postRate')->where('id', $foreignId)->first();
                $postCost = $cart->weight * $cart->postRate;
                $newProfit = $sumProfits - $postCost;
                DB::table('carts')->where('id', $foreignId)->update(array('profits' => $newProfit));
                break;
            default:
                break;
        }
    }
}
