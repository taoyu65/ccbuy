
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <!-- 支持icheck(或者加载jquery1.7+) -->
    <script type="text/javascript" src='{{url("js/jquery-1.8.3.mini.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/bootstrap-mini/bootstrap.min.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/layer/layer.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/laydate/laydate.js")}}'></script>
    <script type="text/javascript" src='{{url("js/jquery.form.js")}}'></script>
    <script type="text/javascript" src='{{url("js/yt_validation.js")}}'></script>

    <link type="text/css" rel="stylesheet" href='{{url("ui/bootstrap-mini/bootstrap.min.css")}}'>
    <link href='{{url("css/additem.css")}}' rel="stylesheet" type="text/css">

    <style type="text/css">
        .addheight{height:40px}
        .addheight{height:40px}
        .submitButton{border-color: #FF77AB;background-color:#FF77AB;width:150px;height:30px;}
        .submitButton strong{color:white}
        input[disabled],input:disabled{
            border:1px solid #a70d17;
            background-color: #232323;
            color:#ACA899;
        }
        * html input.disabled{
            border:1px solid #a70d17;
            background-color:#232323;
            color:#ACA899;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            /*jQuery('#storeNameBtn').click(function(){
                if(!checkForm('addStoreForm')) {
                    return false;
                }else {
                    //add shade to prevent add additional data
                    var index = layer.load(0, {
                        shade: [0.5,'#393D49'] //0.1透明度的白色背景
                    });
                    jQuery('#addStoreForm').submit();
                }
            });*/
            //
            var options = {
                url: "{{url('cc_admin/tableEdit/' . $tableName . '/' . $id)}}",
                type: 'post',
                beforeSubmit:function(){
                    if(!checkForm('addStoreForm'))
                        return false;
                    //add shade to prevent add additional data
                    var index = layer.load(0, {
                        shade: [0.5,'#393D49'] //0.1透明度的白色背景
                    });
                    jQuery('#btsubmit').attr('disabled', 'disabled');
                },
                success: function(data){
                    //layer.alert('添加成功! 页面自动返回并添加此订单ID', {icon:1});
                    layer.confirm('更新成功!返回上一层继续 或者 留在当前页面', {
                        btn: ['返回上一层','留在当前页'] //按钮
                    }, function(){
                        closeWindos_store();
                    }, function(){
                        jQuery('#btsubmit').removeAttr('disabled');
                        window.location.reload(false);
                    });
                },
                error: function () {
                    layer.alert('发生未知错误! 请连续涛哥!',{icon:2});
                }
            };
            $('#addStoreForm').submit(function () {
                if(checkForm('addStoreForm')) {
                    $(this).ajaxSubmit(options);
                }
                return false;
            });
        });

        //close window and transfer the new store to add page //layer plugin
        function closeWindos_store()
        {
            window.parent.location.reload(false);
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
{!! $html !!}
</body>
</html>
