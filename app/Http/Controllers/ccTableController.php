<?php

namespace App\Http\Controllers;

use App\Foundations\Table;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;

class ccTableController extends Controller
{
    //build table //required table name
    public function showTable($table)
    {
        //the column that is showing on the webPage
        $showingColumn = '*';
        switch ($table) {
            case 'carts':
                $showingColumn = '*';
                break;
            case 'customs':
                $showingColumn = '*';
                break;
            case 'incomes':
                $showingColumn = '*';
                break;
            case 'items':
                $showingColumn = 'id,itemName,sellPrice,costPrice,itemProfit,date,isDeal';
                break;
            case 'stores':
                $showingColumn = '*';
                break;
            case 'users':
                $showingColumn = '*';
                break;
        }
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
        //don't set second para to show all the field that can be edited
        $data = new Table($tableName);
        //set validation for every field
        $data->setValidation($validation);
        $html = $data->getHtmlToEdit($tableName, $id);
        return view('cc_admin/tableEdit', ['html' => $html]);
    }

    //edit action
    /**
     * @param $tableName
     * @param $id
     */
    public function edit($tableName, $id)
    {
        dd($_REQUEST['storeName']);
    }
}
