<?php
namespace App\Foundations;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
/**
 * Created by PhpStorm.
 * User: taoyu
 * Date: 10/14/2016
 * Time: 9:49 AM
 * auto create backend table operation including validation
 */
class Table
{
    private $tableName;
    private $columnCount = 0;
    private $columnName;
    private $perPage = 5;
    private $sql = '';

    /**
     * Table constructor.
     * @param $tableName Type:String
     * @param $columnName Type:Array or String separated with ,
     */
    public function __construct($tableName, $columnName = '*')
    {
        $this->tableName = $tableName;
        if ($columnName == '*') {
            //$aaa = DB::table('')->where('', '')->lists('');
            //$users = DB::table('users')->select('name', 'email')->get();
            $this->sql = "select column_name from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='".$tableName."'";
            $this->columnName = DB::select($this->sql);
        }else{
            if (is_string($columnName)) {
                $this->columnName = explode(',', $columnName);
            } elseif (is_array($columnName)) {
                $this->columnName = $columnName;
            }
        }
        $this->columnCount = count($columnName);
    }

    /*set how many row per page*/
    public function setPerPage($num)
    {
        $this->perPage = $num;
    }

    public function getColumn()
    {

    }

    public function getSql()
    {
        return "select * From ".$this->tableName;
    }

    public function getData()
    {
        $data = DB::select($this->getSql());//->Paginate($this->perPage);
        return $data;
    }
    public function getHtml()
    {
        if ($this->columnCount == 0) {
            return '没有任何数据';
        }
        $tables = $this->getData();
        /*building html*/
        $html = '';
        /*Table Head*/
        $html += '<table class="table table-hover">';
        $html += '  <thead>';
        $html += '    <tr>';
        for ($i = 0; $i < $this->columnCount; $i++) {
            $html += '<th>';
            $html += $this->columnName[$i];
            $html += '</th>';
        }
        $html += '    </tr>';
        $html += '  </thead>';
        $html += '</table>';
        /*Table Body*/
        $html += '<tbody>';
        $html += '<tr>';
        foreach ($tables as $k => $v) {
            for ($i = 0; $i < $this->columnCount; $i++)
            {
                $html += '<td>';
                $html += 'fdsa';
                $html += '</td>';
            }
        }
        $html += '</tr>';
        $html += '</tbody>';
        return $html;
    }
}