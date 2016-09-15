<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src="../ui/bootstrap-mini/bootstrap.min.js"></script>
    <!-- 支持icheck(或者加载jquery1.7+) -->
    <script type="text/javascript" src="../js/jquery-1.8.3.mini.js"></script>
    <script type="text/javascript" src="../ui/icheck/icheck.min.js"></script>
    <script type="text/javascript" src="../ui/laydate/laydate.js"></script>
    <script type="text/javascript" src="../ui/layer/layer.js"></script>

    <link type="text/css" rel="stylesheet" href="../ui/bootstrap-mini/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../ui/icheck/skins/line/line.css">
    <link type="text/css" rel="stylesheet" href="../ui/icheck/skins/line/purple.css">

    <link type="text/css" rel="stylesheet" href="../ui/icheck/skins/square/square.css">
    <link type="text/css" rel="stylesheet" href="../ui/icheck/skins/square/purple.css">
    <style type="text/css">
        .addheight{height:40px}
        #hello{height:28px}
        .submitButton{border-color: #A295BB;background-color:#6a5a8c;width:150px;height:30px;}
        .submitButton span{color:white}
        .warning{background-color: #A295BB;padding-top:10px;}
    </style>
    <script type="text/javascript">
        //使用iCheck插件
        $(document).ready(function(){
            //客户ID输入模式开启
            $('input').each(function(){
                var self = $(this),
                        label = self.next(),
                        label_text = label.text();
                label.remove();
                self.iCheck({
                    checkboxClass: 'icheckbox_line-purple',
                    radioClass: 'iradio_line-purple',
                    insert: '<div class="icheck_line-icon"></div>' + label_text
                });
            });
            //初始化生产今日日期的checkbox
            $('#selectDate').iCheck({
                checkboxClass: 'icheckbox_square-purple',
                uncheckedClass: 'hover',
                radioClass: 'iradio_square-purple'
            });
            //点击设置今日日期
            $('#selectDate').on('ifChecked', function(event){
                var myDate = new Date();
                var showToday = myDate.format('yyyy-MM-dd');
                document.getElementById('dateInput').value = showToday;
            });
            //下拉选择和输入ID只能激活其中之一
            $('#icheck1').on('ifClicked', function(event){
                var isChecked = document.getElementById('icheck1').checked;
                if(!isChecked)
                {
                    document.getElementById('customsNameList').setAttribute('disabled', 'true');
                    document.getElementById('customId').removeAttribute('disabled');
                }
                else
                {
                    document.getElementById('customId').setAttribute('disabled', 'true');
                    document.getElementById('customsNameList').removeAttribute('disabled');
                }
            });
        });
        //格式化日期
        Date.prototype.format =function(format)
        {
            var o = {
                "M+" : this.getMonth()+1, //month
                "d+" : this.getDate(), //day
                "h+" : this.getHours(), //hour
                "m+" : this.getMinutes(), //minute
                "s+" : this.getSeconds(), //second
                "q+" : Math.floor((this.getMonth()+3)/3), //quarter
                "S" : this.getMilliseconds() //millisecond
            }
            if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
                    (this.getFullYear()+"").substr(4- RegExp.$1.length));
            for(var k in o)if(new RegExp("("+ k +")").test(format))
                format = format.replace(RegExp.$1,
                        RegExp.$1.length==1? o[k] :
                                ("00"+ o[k]).substr((""+ o[k]).length));
            return format;
        }
        //添加一个记录 异步提交
        jQuery(document).ready(function (){
            jQuery('#addCartForm').bind("submit", function(){
                var customId = jQuery('#customsNameList').val();
                var rename = jQuery('#reName').val();
                var date = jQuery('#dateInput').val();
                if(customId == 0)
                {
                    layer.tips('小样! 你还没有选择ID', '#customsNameList', {
                        tips: [1, '#78BA32']
                    });
                    return false;
                }
                if(rename == '')
                {
                    layer.tips('小样! 写些什么啊. 懒死了.', '#reName', {
                        tips: [3, '#78BA32']
                    });
                    return false;
                }
                if(date == '')
                {
                    layer.tips('小样! 点这个可以快速设置日期为今天.', '#selectDate', {
                        tips: [3, '#78BA32']
                    });
                    return false;
                }
                var options = {
                    url: '',
                    type: 'post',
                    dataType: 'text',
                    data: $("#search_form").serialize(),
                    success: function (data) {
                        if (data.length > 0)
                            jQuery("#user_info").html(data);
                    }
                };
                $.ajax(options);
                return false;
            })

            $('#search').click(function(){
                $('#search_form').submit();
            })
        });

        /*$('#editRealMsgForm').submit(function() {
            jQuery.ajax({
                url:'editRealMsg.eri',
                data:$('#editRealMsgForm').serialize(),
                type:"POST",
                beforeSend:function()
                {
                    $('#submitButton').hide();
                    $('#editRealMsgImg').show();
                },
                success:function()
                {
                    $('#editRealMsgImg').hide();
                    $('#modifyButton').show();
                    $('#realName').attr("disabled","true");
                    $('#tel').attr("disabled","true");
                }
            });
            returnfalse;
        });*/





        //关闭窗口  //layer插件
        function closeWindos()
        {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }
    </script>
</head>

<body>
<form class="form-horizontal" id="addCartForm" role="form" method="post">

    <div class="addheight"></div>

    <div class="form-group">
        <label class="col-xs-2 control-label" for="customId">客户选择</label>
        <div class="col-xs-2">
            {{--<input class="form-control input-sm" type="text" id="customsNameList">--}}
            <select class="form-control input-sm" id="customsNameList">
                <option selected value="0">选择客户</option>
                @foreach($customs as $custom)
                <option value="{{$custom->id}}" title="{{$custom->dgFrom}}'的'{{$custom->relationship}}">{{$custom->customName}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-xs-2 text-right" id="col1">
            <input type="checkbox" name="icheck1" id="icheck1"><label>ID模式</label>
           {{-- <label class="control-label">点击输入ID</label>--}}
        </div>

        <div class="col-xs-1" >
            <input class="form-control input-sm" type="text" id="customId" disabled>
        </div>
        <div class="col-xs-4" >
            <div class="warning"><p>请确认客户ID在输入,以免数据混乱</p></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-2 control-label">创建客户</label>
        <div class="col-xs-2">

            <button type="button" class="btn btn-warning">创建新客户</button>
        </div>
        <div class="col-xs-4">
            <div class="warning"><p>只有在需要添加新客户的时候点击</p></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-2 control-label" for="reName">订单别名</label>
        <div class="col-xs-9">
            <input class="form-control input-sm" type="text" id="reName" placeholder="简单介绍谁买的什么  例如:隔壁老王买的印度神油">
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-2 control-label" for="date">创建日期</label>
        <div class="col-xs-3">
            <input id="dateInput" class="laydate-icon">
            <script>
                laydate.skin('molv');
                laydate({
                    elem: '#dateInput', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
                    choose: function(datas){
                       $('#selectDate').iCheck('uncheck');
                    } //响应事件。如果没有传入event，则按照默认的click
                });
            </script>
        </div>
        <div class="col-xs-2">今日 <input type="checkbox" id="selectDate" ></div>
    </div>

    <div class="addheight"></div>

    <div class="form-group">
        <div class="col-xs-5 text-right"><p><button class="submitButton" onclick="addCart()"><span>添加记录</span></button></p></div>
        <div class="col-xs-2"></div>
        <div class="col-xs-5 text-left"><p><button class="submitButton" onclick="closeWindos()"><span>关闭窗口</span></button></p></div>
    </div>

</form>

</body>
</html>
