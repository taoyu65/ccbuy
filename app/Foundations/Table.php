<?php
namespace App\Foundations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
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
            $html .= $this->getCustomName($this->columnName[$i]);//$this->columnName[$i];
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
        $data = DB::table($tableName)->where('id', $id)->first();
        $html = '';
        //$html .= '<form class="form-horizontal" id="addStoreForm" method="post" action="'.url('cc_admin/tableEdit/'.$tableName.'/'.$id).'">';
        $html .= '<form class="form-horizontal" id="addStoreForm">';
        $html .= csrf_field();
        $html .= '<div class="addheight"></div>';
        //get all the fields
        foreach ($this->columnName as $column) {
            if (in_array($column, $this->columnName)) {
                $html .= $this->getHtmlToRow($data->$column, $column);
            }
        }
        //submit button
        $html .= '<div class="form-group">';
        $html .= '<div class="col-xs-5 text-right"><p><button class="submitButton" name="btsubmit" id="btsubmit" type="submit"><strong>提交更新</strong></button></p></div>';
        $html .= '<div class="col-xs-2"></div>';
        $html .= '<div class="col-xs-5 text-left"><p><button class="submitButton" onclick="closeWindos_store()"><strong>关闭窗口</strong></button></p></div>';
        $html .= '</div>';
        $html .= '</form>';
        return $html;
    }

    /**
     * @param $data
     * @param $column - get custom name that can be easy read
     * @return string - get html for one row
     */
    private function getHtmlToRow($data, $column)
    {
        $rename = $this->getCustomName($column);
        $html = '';
        $html .= '<div class="form-group">';
        $html .= '    <div class="row">';
        $html .= '        <label class="col-xs-2 control-label" for="storeName">'.$rename.'</label>';
        $html .= '        <div class="col-xs-9">';
        $html .= $this->getInputHtml($data, $column);
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '    <div class="row">';
        $html .= '        <div class="col-xs-9 col-xs-offset-2">';
        $html .= '            <span class="label-danger" id="storeName_error"></span>';
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }

    /**
     * @param $name - name on the database
     * @return string - return new name that defined on the config ccbuy.php
     */
    private function getCustomName($name)
    {
        $nameList = Config::get('ccbuy.rename.'.$this->tableName);
        $rename = $nameList[$name];
        return $rename;
    }

    /**
     * @param $data - the input's value
     * @param $name - field name in the database
     * @return mixed - return the role for html of validation
     */
    private function getInputHtml($data, $name)
    {
        $validationList = Config::get('ccbuy.validation.'.$this->tableName);
        $validation = $validationList[$name];
        $html = '';
        switch ($validation) {
            case 'readOnly':
                $html = '<input readonly disabled="true" style="background-color:gary" class="form-control input-sm" type="text" value="'.$data.'" id="'.$name.'" name="'.$name.'">';
                break;
            case 'money':
                $html = '<input yt-validation="yes" yt-check="money" yt-errorMessage="格式不正确" yt-target="'.$name.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$name.'" name="'.$name.'">';
                $html .= '<span class="label-danger" id="'.$name.'_error"></span>';
                break;
            case 'foreignKey':
                $html = $this->getDropDownList($name, $data);
                break;
            case 'required':
                $html = '<input yt-validation="yes" yt-check="null" yt-errorMessage="不能为空" yt-target="'.$name.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$name.'" name="'.$name.'">';
                $html .= '<span class="label-danger" id="'.$name.'_error"></span>';
                break;
            case 'date':
                $html = '<input yt-validation="yes" yt-check="null" yt-errorMessage="日期格式不正确" yt-target="'.$name.'_error" class="form-control input-sm laydate-icon"  onclick="laydate()" value="'.$data.'" name="'.$name.'">';
                $html .= '<span class="label-danger" id="'.$name.'_error"></span>';
                break;
            case 'bool':
                $statusYes = 'checked';
                $statusNo = '';
                if ($data != '1') {
                    $statusYes = '';
                    $statusNo = 'checked';
                }
                $html = '<div class="switch">';
                $html .= '<input type="radio" class="switch-input" name="'.$name.'" value="0" id="nopay" '.$statusNo.'>';
                $html .= '<label for="nopay" class="switch-label switch-label-off">还没</label>';
                $html .= '<input type="radio" class="switch-input" name="'.$name.'" value="1" id="yespay" '.$statusYes.'>';
                $html .= '<label for="yespay" class="switch-label switch-label-on">已付</label>';
                $html .= '<span class="switch-selection"></span>';
                $html .= '</div>';
                break;
            case 'email':
                $html = '<input yt-validation="yes" yt-check="email" yt-errorMessage="格式不正确" yt-target="'.$name.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$name.'" name="'.$name.'">';
                $html .= '<span class="label-danger" id="'.$name.'_error"></span>';
                break;
            case 'none':
                $html = '<input id="'.$name.'" name="'.$name.'" value="'.$data.'" class="form-control input-sm" type="text">';
                break;
            case '':
                break;
        }
        return $html;
    }


    /**
     * if this field is foreign key than html will be drop down list
     * @param $columnName - id is foreign key in the database and has to be follow the rule (table name plus '_' plus id such as tableNames_id)
     * @param $foreignId - actually foreign id
     * @return string
     */
    private function getDropDownList($columnName, $foreignId)
    {
        $arr = explode('_', $columnName);
        if (count($arr) <= 1){
            $tableName = $columnName;
        }else{
            $tableName = $arr[0];
        }
        //
        $showDropDownName = $this->getDropDownName($tableName);
        $data = DB::table($tableName)->get();
        $html = '<select class="form-control input-sm" id="'.$columnName.'" name="'.$columnName.'">';
        foreach ($data as $d) {
            if ($foreignId == $d->id) {
                $html .= '<option value="'.$d->id.'" selected>'.$d->$showDropDownName.'</option>';
            }else{
                $html .= '<option value="'.$d->id.'">'.$d->$showDropDownName.'</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    /**
     * @param $tableName
     * @return string - return the column name that showing in the drop down list as text will be set up in the ccbuy config
     */
    private function getDropDownName($tableName)
    {
        $nameList = Config::get('ccbuy.dropDownName');
        if (array_key_exists($tableName, $nameList)) {
            return $nameList[$tableName];
        }
        //anything happened will be showing id column
        return 'id';
    }
}