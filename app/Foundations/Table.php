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
    private $validation = [];   //rules and what kind of input will be showing on page
    private $configFileName = 'ccbuy';
    /**
     * Table constructor.
     * @param $tableName Type:String
     * @param Type|string $columnName Type:Array or String separated with ,in the edit model do not set up this para to show all field
     * @param bool $operate is showing operating function like update or delete button
     */
    public function __construct($tableName, $columnName = '*', $operate = true)
    {
        $databaseName = Config::get($this->configFileName.'.currentDatabase');
        $this->tableName = $tableName;
        if ($columnName == '*') {
            $obj = DB::table('information_schema.COLUMNS')->select('COLUMN_NAME')->where(['TABLE_SCHEMA'=>$databaseName,'TABLE_NAME'=>$tableName])->get();
            $this->columnName = $this->getColumn($obj);
        }else{
            if (is_string($columnName)) {
                $this->columnName = explode(',', $columnName);
            } elseif (is_array($columnName)) {
                $this->columnName = $columnName;
            }
            if ($columnName === null)   //if give a wrong table name than return null 
                return ;
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
    #region table - get all data and operation button
    /**
     * @param bool $search - search function is open or not
     * @param string $where - if search set true than can set where (sql)
     * @param string $selectTab - which tab will be used for searching
     * @return string
     */
    public function getHtml($search = true, $where = '', $selectTab = '')
    {
        if ($this->columnCount == 0) {
           return '没有任何数据';
        }
        $tables = $this->getData($where);
        /*building html*/
        $html = '';
        /* search */
        if($search)
            $html .= $this->insertSearchHtml($selectTab);
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
        //$pageHtml = $tables->render();
        $pageHtml = $tables->appends(['w'=>base64_encode($where),'a'=>'aaa'])->links();
        $html .= '<div class="text-center">'.$pageHtml.'</div>';
        return $html;
    }
    #get item's row
    private function getData($where = '')
    {
        if ($where != '') {
            $data = DB::table($this->tableName)->whereRaw($where)->select($this->columnName)->orderBy('id', 'desc')->Paginate($this->perPage);
        }else{
            $data = DB::table($this->tableName)->select($this->columnName)->orderBy('id', 'desc')->Paginate($this->perPage);
        }
        return $data;
    }
    #joint a where to sql according with search option
    private function getWhereBySearch($selectTab)
    {
        $where = '';
        //do search on post method
        if(\Request::isMethod('post'))
        {
            $rules = Config::get($this->configFileName . '.search.tables.' . $this->tableName . '.tab.' . $selectTab);
            foreach ($rules as $rule) {
                $fieldName = $selectTab . $rule['columnName'];
                $value = (!isset($_REQUEST[$fieldName]))?'':$_REQUEST[$fieldName];
                if ($value == '') {
                    $where .= '';
                }else{
                    if ($rule['fuzzySearch'] === 'true') {
                        $where .= '`'.$rule['columnName'].'` like \'%'.$value.'%\' and ';

                    } else {
                        $where .= $rule['columnName'].'=\''.$value.'\' and ';
                    }
                }
            }
            $where .= ' 1=1';
        }
        else    //paginate will lose request, the parameter will be given in a url
        {
            if(isset($_REQUEST['w']))
                $where = base64_decode($_REQUEST['w']);
        }
        return $where;
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
    #get search html for invoke
    /**
     * @param $selectTab - selected tab
     * @return string
     */
    public function getSearchHtml($selectTab)
    {
        /*get where according with search option*/
        $where = $this->getWhereBySearch($selectTab);
        return $this->getHtml(true, $where, $selectTab);
    }
    #insert search html
    private function insertSearchHtml($selectTab)
    {
        $isShowSearch = Config::get($this->configFileName . '.search.isShowSearch');   //if show the search for all the table
        if($isShowSearch == 'false')
            return '';
        $searchConfig = Config::get($this->configFileName . '.search.tables');
        if(!array_key_exists($this->tableName, $searchConfig) || $searchConfig[$this->tableName] == '' || count($searchConfig[$this->tableName]) === 0) //make sure the rule has been set up, check to see if the rule present
            return '';
        if($searchConfig[$this->tableName]['isShow'] != 'true')     //if show the search for this table
            return '';
        $html = '';
        $html .= '<div class="tab border-green">';
        $html .= '        <div class="tab-head">';
        $html .= '            <strong><h2><span class="tag bg-sub">'.trans('cc_admin/table.search').'</span></h2></strong> <span class="tab-more"><a href="#"></a></span>';
        $html .= '            <ul class="tab-nav">';
        $configTabTitle = $searchConfig[$this->tableName]['tabTitles'];
        $active = ($selectTab == '')?'class="active"':'';     //only add in the html on the first time loaded
        foreach ($configTabTitle as $num => $tabName) {     //add tab
            if($num == $selectTab)
                $active = 'class="active"';
            $html .= '                <li '.$active.'><a href="#'.$num.'">'.trans('cc_admin/table.'.$tabName).'</a></li>';
            $active = '';
        }
        $html .= '            </ul>';
        $html .= '        </div>';
        $html .= '        <div class="tab-body tab-body-bordered">';
        $configTab = $searchConfig[$this->tableName]['tab'];
        $active = ($selectTab == '')?'active':'';     //only add in the html on the first time loaded
        foreach ($configTab as $tab => $tabRules) {  //add contain to tab
            if($tab == $selectTab)
                $active = 'active';
            $html .= '        <div class="tab-panel '.$active.'" id="'.$tab.'">';
            $html .= $this->getContainForTab($tab, $tabRules);
            $html .= '        </div>';
            $active = '';
        }
        $html .= '        </div>';
        $html .= '    </div>';
        return $html;
    }
    #check if config available or not
    private function checkConfig($checkingItem, $configName)
    {
        $configList = Config::get($this->configFileName . '.' . $configName);
        if(array_key_exists($checkingItem, $configList))
            return true;
        return false;
    }
    #create search form
    private function getContainForTab($tab, $tabRules)
    {
        $html = '';
        $html .= '<form id="search_'.$tab.'" method="post" action="'.url('cc_admin/table/'.$this->tableName.'/search/'.$tab).'" id="search_'.$tab.'">';
        $html .= csrf_field();
        $html .= '<div class="line">';
        foreach ($tabRules as $num => $rule) {
            if(array_key_exists('title', $rule)){
                $html .= '<div class="xl3"><span class="text-gray" style="padding-right: 5px">'.trans('cc_admin/table.'.$rule['title']).'</span>';
                if (array_key_exists('columnName', $rule) && array_key_exists('validation', $rule)) {
                    $html .= '';
                    $html .= $this->getInput($rule['validation'], $rule['columnName'], '', $tab);
                    $html .= '</div>';
                    //$hiddenValue = (empty($_REQUEST[$tab.$rule['columnName']]))? '':$_REQUEST[$tab.$rule['columnName']];
                    //$html .= '<input type="hidden" name="'.$tab.$rule['columnName'].'_hidden" value="'.$hiddenValue.'">';   //use for paginate
                }
            }
        }
        $html .= '</div>';
        $html .= '<div class="line" style="padding-top: 15px"><div class="xl2">';
        $html .= '<button type="submit" class="button border-green" onclick="if(checkForm(\'search_'.$tab.'\')){sm(this.form);}">'.trans('cc_admin/table.search').'</button>';
        $html .= '</div></div>';
        $html .= '</form>';
        return $html;
    }

    /**
     * @param $validation
     * @param $name
     * @param $data
     * @param $tab - prevent same id for input - during search option is created, in different tab might be have same id of input, id will be use tab name as prefix
     * @return string
     */
    private function getInput($validation, $name, $data, $tab = '')
    {
        $html = '';
        switch ($validation) {
            case 'readOnly':
                $html = '<input readonly disabled="true" style="background-color:gary" class="form-control input-sm" type="text" value="'.$data.'" id="'.$tab.$name.'" name="'.$tab.$name.'">';
                break;
            case 'money':
                $html = '<input yt-validation="yes" yt-check="money" yt-errorMessage="格式不正确" yt-target="'.$tab.$name.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$tab.$name.'" name="'.$tab.$name.'">';
                $html .= '<span class="label-danger text-red" id="'.$tab.$name.'_error"></span>';
                break;
            case 'foreignKey':
                $html = $this->getDropDownList($name, $data, $tab);
                break;
            case 'required':
                $html = '<input yt-validation="yes" yt-check="null" yt-errorMessage="不能为空" yt-target="'.$tab.$name.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$tab.$name.'" name="'.$tab.$name.'">';
                $html .= '<span class="label-danger text-red" id="'.$tab.$name.'_error"></span>';
                break;
            case 'date':
                $html = '<input yt-validation="yes" yt-check="null" yt-errorMessage="日期格式不正确" yt-target="'.$tab.$name.'_error" class="form-control input-sm laydate-icon"  onclick="laydate()" value="'.$data.'" name="'.$tab.$name.'">';
                $html .= '<span class="label-danger text-red" id="'.$tab.$name.'_error"></span>';
                break;
            case 'bool':
                $statusYes = 'checked';
                $statusNo = '';
                if ($data != '1') {
                    $statusYes = '';
                    $statusNo = 'checked';
                }
                $html .= '<div class="button-group radio border-green">';
                $html .= '    <label class="button">';
                $html .= '        <input name="'.$tab.$name.'" value=1 '.$statusYes.' type="radio"><span class="icon icon-check"></span> '.trans('yes').'</label>';
                $html .= '    <label class="button active">';
                $html .= '    <input name="'.$tab.$name.'" value=0 '.$statusNo.' type="radio"><span class="icon icon-times"></span> '.trans('no').'</label>';
                $html .= '</div>';
                break;
            case 'email':
                $html = '<input yt-validation="yes" yt-check="email" yt-errorMessage="格式不正确" yt-target="'.$tab.$name.'_error" class="form-control input-sm" type="text" value="'.$data.'" id="'.$tab.$name.'" name="'.$tab.$name.'">';
                $html .= '<span class="label-danger text-red" id="'.$tab.$name.'_error"></span>';
                break;
            case 'none':
                $html = '<input id="'.$tab.$name.'" name="'.$tab.$name.'" value="'.$data.'" class="form-control input-sm" type="text">';
                break;
            default:
                $html = '<input id="'.$tab.$name.'" name="'.$tab.$name.'" value="'.$data.'" class="form-control input-sm" type="text">';
                break;
        }
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
        $nameList = [];
        if($this->checkConfig( $this->tableName, 'rename'))
            $nameList = Config::get($this->configFileName . '.rename.'.$this->tableName);
        $rename = $fieldName;
        if(array_key_exists($fieldName, $nameList))
            $rename = $nameList[$fieldName];
        $rename = trans('cc_admin/table.'.$rename);
        return $rename;
    }

    /**
     * @param $data - the input's value
     * @param $fieldName - field name in the table of database
     * @return mixed - return the role for html of validation
     */
    private function getInputHtml($data, $fieldName)
    {
        $validationList = [];
        if($this->checkConfig($this->tableName, 'validation'))
            $validationList = Config::get($this->configFileName . '.validation.' . $this->tableName);
        $validation = '';
        if(array_key_exists($fieldName, $validationList))
            $validation = $validationList[$fieldName];
        $html = $this->getInput($validation, $fieldName, $data);
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
        $specialList_delete = Config::get($this->configFileName . '.special.' . $this->tableName . '.delete');
        if (count($specialList_delete) > 0 && is_array($specialList_delete)) {
            foreach ($specialList_delete as $special) {
                if($special == $fieldName)
                    $html .= '<input type="hidden" name="'.$fieldName.'" value="'.$data.'">';
            }
        }
        $specialList_update = Config::get($this->configFileName . '.special.' . $this->tableName . '.update');
        if (count($specialList_update) > 0 && is_array($specialList_update)) {
            foreach ($specialList_update as $special) {
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
     * @param $tab
     * @return string
     */
    private function getDropDownList($columnName, $foreignId, $tab)
    {
        $configDropDownList = Config::get($this->configFileName . '.dropDownName');
        if(!array_key_exists($this->tableName, $configDropDownList)){
            echo '';return false;
        }
        $rules = $configDropDownList[$this->tableName];
        $tableName = $showDropDownName = '';
        foreach ($rules as $rule) {
            if ($rule['foreignKey'] === $columnName) {
                $tableName = $rule['foreignTableName'];
                $showDropDownName = $rule['columnShow'];
            }
        }
        $data = DB::table($tableName)->get();
        $html = '<select class="form-control input-sm" id="'.$tab.$columnName.'" name="'.$tab.$columnName.'">';
        $html .= '<option value="">请选择</option>';
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
     * @param $id
     * @return string
     */
    public function getHtmlToDelete($id)
    {
        #region get all the fields as label
        $data = DB::table($this->tableName)->where('id', $id)->first();
        $html = '';
        $deleteString = '';
        $deleteString .= $this->tableName . ':' . 'id=' . $id . ',';     //showing records that will be deleted. like 'tableName1:id=@id,tableName2:id=@id' might be multiple records
        $html .= '<form class="form-horizontal" method="post" id="deleteForm">';
        $html .= csrf_field();
        $html .= '<input type="hidden" name="tbName" value="'.$this->tableName.'">';
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
        $config = Config::get($this->configFileName . '.delete');
        $buttonActive = true;      //if there is a record of another table still related this record that want to be deleted than button is not gonna be available.
        if (array_key_exists($this->tableName, $config)) {
            $config = $config[$this->tableName];
            foreach ($config as $type => $b) {
                switch ($type) {
                    case 'interlock':
                        foreach ($b as $foreignTableName => $field) {
                            $foreignId = $field['columnName'];
                            $fieldShow = $field['field'];
                            $warning = $this->getWarningHtml_interlock($foreignTableName, $id, $fieldShow, $foreignId);
                            $html .= $warning;
                            if ($warning != '')
                                $deleteString .= $foreignTableName . ':' . $foreignId . '=' . $id . ',';
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
        $html .= '<div class="col-xs-5 text-left"><p><button class="submitButton" onclick="closeWindos_store()" type="button"><strong>关闭窗口</strong></button></p></div>';
        $html .= '</div>';
        $html .= '<input type="hidden" name="deleteString" value="'.Crypt::encrypt($deleteString).'">';
        $html .= '</form>';
        #endregion
        return $html;
    }

    /**
     * only delete record when no another table's record related this record
     * @param $rules - foreign table from config file
     * @param $id
     * @return string
     */
    private function getWarningHtml_existing($rules, $id)
    {
        foreach ($rules as $foreignTableName => $foreignId) {
            $result = DB::table($foreignTableName)->where($foreignId, $id)->first();
            if ($result) {
                $html = '<script type="application/javascript">$("#btsubmit").attr("disabled",true);</script><div class="alert alert-danger" role="alert"><strong>警告! </strong>不能删除此条记录! 表:' . $foreignTableName . ' 仍然有数据在使用此条记录! 请先删除相关记录</div>';
                return $html;
            }
        }
    }

    /**
     * interlock delete
     * @param $foreignTableName - foreign table name which is related to
     * @param $id - foreign id
     * @param $showingColumn - title
     * @param $foreignId
     * @return string
     */
    private function getWarningHtml_interlock($foreignTableName, $id, $showingColumn, $foreignId)
    {
        //$foreignKey = $this->tableName . '_id';
        $data = DB::table($foreignTableName)->where($foreignId, $id)->get();
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