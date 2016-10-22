<?php

namespace App\Http\Controllers;

use App\Foundations\Table;
use Illuminate\Http\Request;
use App\Http\Requests;

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
        $data = new Table($table, $showingColumn);
        $html = $data->getHtml();
        return view('cc_admin/table', ['html' => $html]);
    }
}
