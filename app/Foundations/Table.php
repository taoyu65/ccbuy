<?php
namespace App\Foundations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
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
    #set field rule
    public function setValidation ($role)
    {
        $this->validation = $role;
    }
    #get column as array from two-dimensional array 二维数组
    private function getColumn($object)
    {
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
    #set how many row per page
    public function setPerPage($num)
    {
        $this->perPage = $num;
    }
    #get item's row
    private function getData()
    {
        $data = DB::table($this->tableName)->select($this->columnName)->orderBy('id', 'desc')->Paginate($this->perPage);
        return $data;
    }
    #region get all data and operation button
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
            $html .= '<td><button class="button bg-main" onclick="edit(\''.$this->tableName.'\', \''.$tables[$i]->id.'\');">update</button>  ';
            $html .= '<button class="button bg-dot" onclick="recordDelete(\''.$this->tableName.'\', \''.$tables[$i]->id.'\');">delete</button></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $pageHtml = $tables->render();
        $html .= '<div class="text-center">'.$pageHtml.'</div>';
        return $html;
    }
    #get edit page. html for edit table
    public function getHtmlToEdit($id)
    {
        $data = DB::table($this->tableName)->where('id', $id)->first();
        $html = '';
        $html .= '<form class="form-horizontal" id="updateForm">';
        $html .= csrf_field();
        $html .= '<div class="addheight"></div>';
        $fieldsName = '';
        #get all the fields
        foreach ($this->columnName as $column) {
            if (in_array($column, $this->columnName)) {
                $html .= $this->getHtmlToRow($data->$column, $column, 'edit');
                $fieldsName .= $column . ',';
            }
        }
        $html .= '<div class="form-group">';
        $html .= '<div class="col-xs-5 text-right"><p><button class="submitButton" name="btsubmit" id="btsubmit" type="submit"><strong>提交更新</strong></button></p></div>';
        $html .= '<div class="col-xs-2"></div>';
        $html .= '<div class="col-xs-5 text-left"><p><button class="submitButton" onclick="closeWindos_store()"><strong>关闭窗口</strong></button></p></div>';
        $html .= '</div>';
        $html .= '<input type="hidden" name="fields" value="'.$fieldsName.'">';
        $html .= '</form>';
        return $html;
    }

    /**
     *  delete page
     * @param $data - field's value
     * @param $fieldName - column name in the database
     * @param $type - 'edit'    : to show html for edit page
     *                'delete'  : to show html for delete page
     * @return string - get html for one row
     */
    private function getHtmlToRow($data, $fieldName, $type)
    {
        $rename = $this->getCustomName($fieldName);
        $html = '';
        $html .= '<div class="form-group">';
        $html .= '    <div class="row">';
        $html .= '        <label class="col-xs-2 control-label" for="storeName">'.$rename.'</label>';
        $html .= '        <div class="col-xs-9">';
        if ($type == 'edit') {
            $html .= $this->getInputHtml($data, $fieldName);
        }
        elseif ($type == 'delete') {
            $html .= $this->getLabelHtml($data, $fieldName);
        }
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
     * @param $fieldName - field name in the table of database
     * @return string - return new name that defined on the config ccbuy.php
     */
    private function getCustomName($fieldName)
    {
        $nameList = Config::get('ccbuy.rename.'.$this->tableName);
        $rename = $fieldName;
        if(array_key_exists($fieldName, $nameList))
            $rename = $nameList[$fieldName];
        return $rename;
    }

    /**
     * @param $data - the input's value
     * @param $fieldName - field name in the table of database
     * @return mixed - return the role for html of validation
     */
    private function getInputHtml($data, $fieldName)
    {
        $validationList = Config::get('ccbuy.validation.'.$this->tableName);
        $validation = '';
        if(array_key_exists($fieldName, $validationList))
            $validation = $validationList[$fieldName];
        $html = '';
        switch ($validation) {
            case 'readOnly':
                $html = '<input readonly disabled="true" style="background-color:gary" class="form-control input-sm" type="text" value="'.$data.'" id="'.$fieldName.'" name="'.$fieldName.'">';
                break;
            case 'money':
                $html = '<input yt-validation="yes" yt-check="money" yt-errorMessage="格式不正确" yt-target="'.$fieldName.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$fieldName.'" name="'.$fieldName.'">';
                $html .= '<span class="label-danger" id="'.$fieldName.'_error"></span>';
                break;
            case 'foreignKey':
                $html = $this->getDropDownList($fieldName, $data);
                break;
            case 'required':
                $html = '<input yt-validation="yes" yt-check="null" yt-errorMessage="不能为空" yt-target="'.$fieldName.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$fieldName.'" name="'.$fieldName.'">';
                $html .= '<span class="label-danger" id="'.$fieldName.'_error"></span>';
                break;
            case 'date':
                $html = '<input yt-validation="yes" yt-check="null" yt-errorMessage="日期格式不正确" yt-target="'.$fieldName.'_error" class="form-control input-sm laydate-icon"  onclick="laydate()" value="'.$data.'" name="'.$fieldName.'">';
                $html .= '<span class="label-danger" id="'.$fieldName.'_error"></span>';
                break;
            case 'bool':
                $statusYes = 'checked';
                $statusNo = '';
                if ($data != '1') {
                    $statusYes = '';
                    $statusNo = 'checked';
                }
                $html = '<div class="switch">';
                $html .= '<input type="radio" class="switch-input" name="'.$fieldName.'" value="0" id="nopay" '.$statusNo.'>';
                $html .= '<label for="nopay" class="switch-label switch-label-off">NO</label>';
                $html .= '<input type="radio" class="switch-input" name="'.$fieldName.'" value="1" id="yespay" '.$statusYes.'>';
                $html .= '<label for="yespay" class="switch-label switch-label-on">YES</label>';
                $html .= '<span class="switch-selection"></span>';
                $html .= '</div>';
                break;
            case 'email':
                $html = '<input yt-validation="yes" yt-check="email" yt-errorMessage="格式不正确" yt-target="'.$fieldName.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$fieldName.'" name="'.$fieldName.'">';
                $html .= '<span class="label-danger" id="'.$fieldName.'_error"></span>';
                break;
            case 'none':
                $html = '<input id="'.$fieldName.'" name="'.$fieldName.'" value="'.$data.'" class="form-control input-sm" type="text">';
                break;
            case '':
                break;
            default:
                break;
        }
        return $html;
    }

    /**
     * @param $data - value as showing in the html
     * @return string
     */
    private function getLabelHtml($data, $fieldName)
    {
        $html = '<label >'.$data.'</label>';
        #region //special operation - adding hidden field to located foreign key and special value and transfer them to finish logical operation - defined in config file
        $specialList = Config::get('ccbuy.special.' . $this->tableName . '.delete');
        if (count($specialList) > 0) {
            foreach ($specialList as $special) {
                if($special == $fieldName)
                    $html .= '<input type="hidden" name="'.$fieldName.'" value="'.$data.'">';
            }
        }
        #endregion
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

    /**
     * @param $id
     * @return string
     */
    public function getHtmlToDelete($id)
    {
        #region get all the fields as label
        $data = DB::table($this->tableName)->where('id', $id)->first();
        $html = '';
        $deleteString = $this->tableName . ':' . 'id=' . $id . ',';     //showing records that will be deleted. like 'tableName1:id=@id,tableName2:id=@id' might be multiple records
        $html .= '<form class="form-horizontal" id="deleteForm">';
        $html .= csrf_field();
        $html .= '<div class="addheight"></div>';
        foreach ($this->columnName as $column) {//get all the fields
            if (in_array($column, $this->columnName)) {
                $html .= $this->getHtmlToRow($data->$column, $column, 'delete');    //get one field as label
            }
        }
        //
        $html .= '<input type="hidden" name="" value="">';
        #endregion
        #region get all the warning information
        $config = Config::get('ccbuy.delete');
        $buttonActive = true;      //if there is a record of another table still related this record that want to be deleted than button is not gonna be available.
        if (array_key_exists($this->tableName, $config)) {
            $config = $config[$this->tableName];
            foreach ($config as $type => $b) {
                switch ($type) {
                    case 'interlock':
                        foreach ($b as $foreignTableName => $field) {
                            foreach ($field as $f => $fieldShow) {
                                $warning = $this->getWarningHtml_interlock($foreignTableName, $id, $fieldShow);
                                $html .= $warning;
                                if ($warning != '')
                                    $deleteString .= $foreignTableName . ':' . $this->tableName . '_id=' . $id . ',';
                            }
                        }
                        break;
                    case 'existing':
                        $warning = $this->getWarningHtml_existing($b, $id);
                        if($warning != '')
                            $buttonActive = false;
                        $html .= $warning;
                        break;
                }
            }
        }
        #endregion
        #region get submit and cancel button
        $html .= '<div class="form-group">';
        $html .= '<div class="col-xs-5 text-right"><p><button class="submitButton" name="btsubmit" id="btsubmit" type="submit" ';
        if(!$buttonActive)
            $html .= ' disabled=true';
        $html .= '><strong>确认删除</strong></button></p></div>';
        $html .= '<div class="col-xs-2"></div>';
        $html .= '<div class="col-xs-5 text-left"><p><button class="submitButton" onclick="closeWindos_store()"><strong>关闭窗口</strong></button></p></div>';
        $html .= '</div>';
        $html .= '<input type="hidden" name="deleteString" value="'.Crypt::encrypt($deleteString).'">';
        $html .= '</form>';
        #endregion
        return $html;
    }

    /**
     * only delete record when no another table's record related this record
     * @param $foreignTableName - foreign table from config file
     * @param $id
     * @return string
     */
    private function getWarningHtml_existing($foreignTableName, $id)
    {
        $html = '';
        $foreignId = $this->tableName . '_id';
        $result = DB::table($foreignTableName)->where($foreignId, $id)->first();
        if ($result)
            $html = '<script type="application/javascript">$("#btsubmit").attr("disabled",true);</script><div class="alert alert-danger" role="alert"><strong>警告! </strong>不能删除此条记录! 仍然有数据在使用此条记录! 请先删除相关记录</div>';
        return $html;
    }

    /**
     * interlock delete
     * @param $foreignTableName - foreign table name which is related to
     * @param $id - foreign id
     * @param $showingColumn - title
     * @return string
     */
    private function getWarningHtml_interlock($foreignTableName, $id, $showingColumn)
    {
        $foreignKey = $this->tableName . '_id';
        $data = DB::table($foreignTableName)->where($foreignKey, $id)->get();
        $html = '';
        if (count($data) != 0) {
            $html .= '<div class="form-group">';
            $html .= '    <div class="row">';
            $html .= '        <div class="col-xs-9 col-xs-offset-1">';
            $html .= '            <div class="panel panel-danger">';
            $html .= '                <div class="panel-title bg-danger">';
            $html .= '                  警告:删除此条记录将会同时删除以下数据';
            $html .= '                </div>';
            $html .= '                <div class="panel-body">';
            $html .= '<table class="table">';
            $html .= '<tr>';
            foreach ($showingColumn as $fieldName => $showingName) {
                $html .= '<th>';
                $html .= $showingName;
                $html .= '</th>';
            }
            $html .= '</tr>';
            foreach ($data as $d) {
                $html .= '<tr>';
                foreach ($showingColumn as $fieldName => $showingName) {
                    $html .= '<td>';
                    $html .= $d->$fieldName;
                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</table>';
            $html .= '                </div>';
            $html .= '            </div>';
            $html .= '        </div>';
            $html .= '    </div>';
            $html .= '</div>';
        }
        return $html;
    }
}