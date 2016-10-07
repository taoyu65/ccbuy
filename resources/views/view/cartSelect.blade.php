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
    <script type="text/javascript" src='{{url("ui/laypage/laypage.js")}}'></script>

    <link type="text/css" rel="stylesheet" href='{{url("ui/bootstrap-mini/bootstrap.min.css")}}'>

    <style type="text/css">
        .addheight{height:40px}
        .submitButton{border-color: #6ABB52;background-color:#6ABB52;width:150px;height:30px;}
        .submitButton strong{color:white}
    </style>
    <script type="text/javascript">

        $(document).ready(function() {
            //laypage   http://laypage.layui.com/
            var count = jQuery('#count').val();
            laypage({
                cont: 'page11',
                pages: count, //total page
                skin: 'molv',
                curr: function(){ //get currently page
                    var page = location.search.match(/page=(\d+)/);
                    return page ? page[1] : 1;
                }(),
                jump: function(e, first){ //call back after page
                    if(!first){ //prevent endless refresh
                        location.href = '?page='+e.curr;
                    }
                }
            });
        });

        //search all cart by custom name
        function filterByCustomName(customid)
        {
            location.href = "{{url('searchCart')}}" + '/' + customid;
            //jQuery('#customsNameList').val(customid);
        }

        //get cart id and return to last page with cartid
        function getCartId(cartid)
        {
            jQuery('#cartId', window.parent.document).val(cartid);
            closeWindos();
        }

        // close window
        function closeWindos()
        {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }

        //close current window and refrash last page
        function goback()
        {
            var a = jQuery('#newopencart',window.parent.document);
            parent.layer.closeAll();  //close all layer
            a.click();
        }
    </script>
</head>

<body>
<form class="form-horizontal" id="addCustomForm">

    <div class="addheight"></div>

    <div class="form-group">
        <label class="col-xs-2 control-label" for="customsNameList">按客户搜</label>
        <div class="col-xs-9">
            <select class="form-control input-sm" id="customsNameList" name="customsNameList" onchange="filterByCustomName(this.value)">
                <option  value="">选择客户名称</option>
                @foreach($customs as $custom)
                    <option value="{{$custom->id}}" title="{{$custom->dgFrom}}'的'{{$custom->relationship}}">{{$custom->customName}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-2 control-label"></div>
        <div class="col-xs-9">
            <div class="panel panel-default panel-success">
                <div class="panel-heading">点击选择订单 并返回相应ID到上一页</div>
                <div class="panel-body">
                    <div class="list-group">
                        @foreach($carts as $cart)
                            <a href="javascript:void(0);" class="list-group-item" onclick="getCartId({{$cart->id}});">
                                <div class="row">
                                    <div class="col-xs-1">{{$cart->id}}</div>
                                    <div class="col-xs-8 text-left">{{$cart->rename}}</div>
                                    <div class="col-xs-3 text-right">{{$cart->date}}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{--laravel original page by custom --}}
                    <div class="text-center">{!! $carts->render() !!}</div>
                    <div class="text-center">{{--{!! with(new \App\Foundations\Pagination\CustomerPresenter($carts))->render() !!}--}}</div>
                    {{--layer javascript page--}}
                    <div id="page11" class="text-center"></div>
                    <input id="count" value="{{$count}}" type="hidden">
                </div>
            </div>
        </div>

    </div>

    <div class="form-group">
        <div class="col-xs-5"></div>
        <div class="col-xs-6 text-left"><p><button class="submitButton" onclick="closeWindos()"><strong>关闭窗口</strong></button></p></div>
    </div>
</form>
</body>
</html>
