
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

    <link type="text/css" rel="stylesheet" href='{{url("ui/bootstrap-mini/bootstrap.min.css")}}'>
    <link href='{{url("css/additem.css")}}' rel="stylesheet" type="text/css">

    <style type="text/css">
        .addheight{height:40px}
        .addheight{height:40px}
        .submitButton{border-color: #c9302c;background-color:#c9302c;width:150px;height:30px;}
        .submitButton strong{color:white}
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            //
            var options = {
                url: "{{url('cc_admin/delete')}}",
                type: 'post',
                beforeSubmit:function(){
                    //add shade to prevent add additional data
                    var index = layer.load(0, {
                        shade: [0.5,'#393D49'] //0.1透明度的白色背景
                    });
                    jQuery('#btsubmit').attr('disabled', 'disabled');
                },
                success: function(data){
                    layer.alert('删除成功!', {icon:1}, function(){
                        closeWindos_store(true);    //arg:true - delete and refresh
                    });
                },
                error: function () {
                    layer.alert('发生未知错误! 请连续涛哥!',{icon:2});
                }
            };
            $('#deleteForm').submit(function () {
                //$(this).submit();
                $(this).ajaxSubmit(options);
                return false;
            });
        });

        //close window and transfer the new store to add page //layer plugin
        function closeWindos_store(refresh)
        {
            if(refresh)
                window.parent.location.reload(false);
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }
    </script>
</head>

<body>
{!! $html !!}
</body>
</html>
