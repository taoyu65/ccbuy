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
 * 1.new Table(tableName, ?columnName)  //columnName like id,itemName...(has to be separated by ',') or use array
 * 2.invoke getHtml()
 * 3.param operate: optional, marked as function of showing the button that you can delete or edit
 */
class Table
{
    private $tableName;
    private $columnCount = 0;
    private $columnName;
    private $perPage = 10;
    private $validation = [];

    /**
     * Table constructor.
     * @param $tableName Type:String
     * @param Type|string $columnName Type:Array or String separated with ,in the edit model do not set up this para to show all field
     * @param bool $operate is showing operating function like update or delete button
     */
    public function __construct($tableName, $columnName = '*', $operate = true)
    {
        $this->tableName = $tableName;
        if ($columnName == '*') {
            //$aaa = DB::table('')->where('', '')->lists('');
            //$users = DB::table('users')->select('name', 'email')->get();
            //$sql = "select column_name from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='".$tableName."'";
            //$this->columnName = DB::select($sql);
            //$this->columnName = DB::table('INFORMATION_SCHEMA.COLUMNS')->select('column_name')->where('TABLE_NAME', $tableName)->get();
            $obj = DB::table('information_schema.columns')->select('column_name')->where('table_name', $tableName)->get();
            $this->columnName = $this->getColumn($obj);
        }else{
            if (is_string($columnName)) {
                $this->columnName = explode(',', $columnName);
            } elseif (is_array($columnName)) {
                $this->columnName = $columnName;
            }
            //making sure has id column in array columnName because of order by
            if (!in_array('id', $this->columnName)) {
                array_unshift($this->columnName, 'id');
            }
        }
        $this->columnCount = count($this->columnName);
        $this->operate = $operate;
    }
    //set field rule
    public function setValidation ($role)
    {
        $this->validation = $role;
    }
    //get column as array from two-dimensional array 二维数组
    private function getColumn($object) {
        if (is_object($object) || is_array($object)) {
            foreach ($object as $key => $value) {
                //$array[$key] = $value;
                foreach ($value as $k => $v) {
                    $array[] = $v;
                }
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }
    /*set how many row per page*/
    public function setPerPage($num)
    {
        $this->perPage = $num;
    }
    //get item's row
    private function getData()
    {
        $data = DB::table($this->tableName)->select($this->columnName)->orderBy('id', 'desc')->Paginate($this->perPage);
        return $data;
    }
    //print table
    public function getHtml()
    {
        if ($this->columnCount == 0) {
           return '没有任何数据';
        }
        $tables = $this->getData();
        /*building html*/
        $html = '';
        /*Table Head*/
        $html .= '<table class="table table-hover">';
        $html .= '  <thead>';
        $html .= '    <tr>';
        for ($i = 0; $i < $this->columnCount; $i++) {
            $html .= '<th>';
            $html .= $this->columnName[$i];
            $html .= '</th>';
        }
        $html .= '    </tr>';
        $html .= '  </thead>';
        /*Table Body*/
        $itemsCount = count($tables);
        $html .= '<tbody>';
        for ($i = 0; $i < $itemsCount; $i++) {
            $html .= '<tr>';
            foreach ($tables[$i] as $k => $v) {
                $html .= '<td>';
                $html .= $v;
                $html .= '</td>';
            }
            $html .= '<td><button class="button bg-main" onclick="edit(\''.$this->tableName.'\', \''.$tables[$i]->id.'\');">update</button>  <button class="button bg-dot">delete</button></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $pageHtml = $tables->render();
        $html .= '<div class="text-center">'.$pageHtml.'</div>';
        return $html;
    }
    //get html to edit table
    public function getHtmlToEdit($tableName, $id)
    {
        $html = '';

        return $html;
    }
}