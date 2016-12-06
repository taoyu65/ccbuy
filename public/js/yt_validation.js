/**
 * Created by taoyu on 9/29/2016.
 */
//****************************************************************************************************
//only invoke function checkForm(formId) and set up a container for error
//custom attribute in input
//      1.yt-validation     = 'yes'                             //to open this function
//      2.yt-check          = 'money/null...'                   //what kind of rule to check
//      3.yt-errorMessage   = 'any error message'               //error message
//      4.yt-target         = 'containerId'                     //where to show error
//example:
//<span class="label-danger" id="itemName_error"></span>
//<input yt-validation="yes" yt-check="null" yt-errmessage="不能为空" yt-target="itemName_error" >
//use checkForm(formId) before submit
//****************************************************************************************************
//bool to mark pass the validation or not
var b = true;
//form:the form's name need to be submitted
function checkForm(formId)
{
    b = true;
    var elements = getInputs(formId);
    checkElements(elements);
    return b;
}

//get all input as array
function getInputs(formId) {
    var form = document.getElementById(formId);
    var elements = new Array();
    var tagElements = form.getElementsByTagName('input');   //add input dom
    for (var j = 0; j < tagElements.length; j++){
        elements.push(tagElements[j]);
    }
    tagElements = form.getElementsByTagName('select');      //add select drop down list
    for (var j = 0; j < tagElements.length; j++){
        elements.push(tagElements[j]);
    }
    return elements;
}
//
function checkElements(e)
{
    for (var i = 0; i < e.length; i++) {
        if (e[i].getAttribute('yt-validation') == 'yes') {
            ClearErrMessage(e[i]);
            var checkType = e[i].getAttribute('yt-check');
            //multiple rule can be used - use ',' split rules
            var checkList = checkType.split(',');
            for (var j = 0; j < checkList.length; j++) {
                switch (checkList[j]) {
                    case 'money' :
                        isMoney(e[i]);
                        break;
                    //addBlur(e[i], 'isMoney');
                    case 'null' :
                        isNull(e[i]);
                        break;
                    case 'id' :
                        isInteger(e[i]);
                        break;
                    case 'date' :
                        isDate(e[i]);
                        break;
                    case 'no0' :
                        nonzero(e[i]);
                        break;
                    default :
                        break;
                }
            }
        }
    }
}

//is date
function isDate(e) {
    return false;
}

//check see if it's a integer number
function isNumber(e, regular)
{
    var s = trim(e.value);
    if(s!=null){
        var r;
        r = s.match(regular);
        if (r!= s) {
            showError(e);
            b = false;
        }
        //return (r==s)?true:{showError(e);b = false;}
    }
}
/********check numbers but different regular*********/
function isInteger(e) {
    var regular = /^\+?[1-9][0-9]*$/;
    isNumber(e, regular);
}
/********************end***************************/
//check if the number meet the money form
function isMoney(e)
{
    var money = trim(e.value);
    var regular = /^-?[0-9]*(\.[0-9]{1,2})?$/;
    //var regular = /^[+-]?\d*\.?\d{1,2}$/;
    if(!regular.test(money) || money == ''){
        showError(e);
        b = false;
    }
}
//if null
function isNull(e) {
    var val = trim(e.value);
    if (val == '') {
        showError(e);
        b = false;
    }
}
//non-zero
function nonzero(e) {
    var num = trim(e.value);
    if(num == 0){
        showError(e);
        b = false;
    }
}
function showError(e)
{
    var errorMessage = e.getAttribute('yt-errorMessage');
    var target = e.getAttribute('yt-target');
    document.getElementById(target).innerText = errorMessage;
}
//clear all the error information
function ClearErrMessage(e) {
    var target = e.getAttribute('yt-target');
    document.getElementById(target).innerText = '';
}

//not functional    //add blur event
function addBlur(e, f)
{
    if(window.attachEvent) {
        e.attachEvent('onblur', function (){alert('添加事件成功！')});
    }
    else {
        e.addEventListener('onblur', function (){alert('添加事件成功！')} , false );
    }
}
function trim(str){ //删除左右两端的空格
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str){ //删除左边的空格
    return str.replace(/(^\s*)/g,"");
}
function rtrim(str){ //删除右边的空格
    return str.replace(/(\s*$)/g,"");
}
