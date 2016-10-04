<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <!-- 支持icheck(或者加载jquery1.7+) -->
    <script type="text/javascript" src='{{url("js/jquery-1.8.3.mini.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/bootstrap-mini/bootstrap.min.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/layer/layer.js")}}'></script>
    <script type="text/javascript" src='{{url("js/jquery.form.js")}}'></script>
    <script type="text/javascript" src='{{url("js/yt_validation.js")}}'></script>

    <link type="text/css" rel="stylesheet" href='{{url("ui/bootstrap-mini/bootstrap.min.css")}}'>

    <style type="text/css">
        .addheight{height:40px}
        .addheight{height:40px}
        .submitButton{border-color: #FF77AB;background-color:#FF77AB;width:150px;height:30px;}
        .submitButton strong{color:white}
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            jQuery('#storeNameBtn').click(function(){
                if(!checkForm('addStoreForm')) {
                    return false;
                }else {
                    jQuery('#addStoreForm').submit();
                }
            });
        });

        //close window and transfer the new store to add page //layer plugin
        function closeWindos_store()
        {
            var text = jQuery('#selectText').val();
            var value = jQuery('#selectValue').val();
            if(text != null && trim(text) != '') {
                var slt =  parent.document.getElementById('storeId');
                slt.options.add(new Option(text, value, false, true));   //(text,value,default selected, selected)
            }
            //slt.options[slt.options.length-1].selected='selected';
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }

        //show the message
        //str: text->value
        function showReturnMessage() {
            layer.alert('添加成功',{
                skin: 'layui-layer-molv',
                title:'商店添加',
                closeBtn:0}
            );
        }
    </script>
</head>

<body>
@include('../error')
@if(session('status'))
    <script>showReturnMessage();</script>
@endif
<form class="form-horizontal" id="addStoreForm" method="post" action="{{url('store')}}">
    {!! csrf_field() !!}
    <?php
        //to show the store name that was just added in
        $str = session('status');
        $arr = explode(',', $str);
        if(count($arr)>1)
        {
            echo '<input type="hidden" id="selectText" value="'.$arr[0].'">';
            echo '<input type="hidden" id="selectValue" value="'.$arr[1].'">';
        }
    ?>
    <div class="addheight"></div>
    <input type="hidden" id="selectText" value="">
    <input type="hidden" id="selectText" value="">
    <div class="form-group">
        <div class="row">
            <label class="col-xs-2 control-label" for="storeName">商店名称</label>
            <div class="col-xs-9">
                <input yt-validation="yes" yt-check="null" yt-errorMessage="不能为空" yt-target="storeName_error" class="form-control input-sm" type="text" name="storeName" id="storeName" placeholder="比如 JET, Amazon">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-xs-offset-2">
                <span class="label-danger" id="storeName_error"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <label class="col-xs-2 control-label" for="info">备注</label>
            <div class="col-xs-9">
                <input class="form-control input-sm" type="text" name="info" id="info" placeholder="额外信息">
            </div>
        </div>
    </div>

    <div class="addheight"></div>

    <div class="form-group">
        <div class="col-xs-5 text-right"><p><button class="submitButton" name="storeNameBtn" id="storeNameBtn" type="submit"><strong>添加客户</strong></button></p></div>
        <div class="col-xs-2"></div>
        <div class="col-xs-5 text-left"><p><button class="submitButton" onclick="closeWindos_store()"><strong>关闭窗口</strong></button></p></div>
    </div>
</form>

</body>
</html>
