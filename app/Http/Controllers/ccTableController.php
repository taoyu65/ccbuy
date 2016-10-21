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
        $data = new Table($table, 'id,isDeal');
        $html = $data->getHtml();
        return view('cc_admin/table', ['html' => $html]);
    }
}
