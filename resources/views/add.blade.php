
@extends('layouts.foot')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='{{url("css/additem.css")}}' rel="stylesheet" type="text/css">

    <script type="text/javascript" src='{{url("ui/layer/layer.js")}}'></script>
    <script type="text/javascript" src='{{url("js/uploadimg.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/laydate/laydate.js")}}'></script>
    <script type="text/javascript" src='{{url("js/jquery.form.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/bootstrap-mini/bootstrap.min.js")}}'></script>

    <link type="text/css" rel="stylesheet" href='{{url("ui/bootstrap-mini/bootstrap.min.css")}}'>
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //before submit Form - validation
            $('#add_form').submit(function(){

            });
            //check if the number meet the money form
            function isMoney(money)
            {
                var regular = /^[0-9]*(\.[0-9]{1,2})?$/;
                if(!regular.test(money))
                    return false;
                return true;
            }
            //add pic
            var options_add = {
                //target: '#showResult',
                url: "{{url('additemupload')}}",
                type: 'post',
                //dataType: 'json', //http://jquery.malsup.com/form/#json
                beforeSubmit:function(){
                },
                success: function(data){
                    isUploaded = data.pic;
                    jQuery('#fileName_hide').val(data.filename);
                    document.getElementById('deleteImgId').value = isUploaded;
                    showMessage('success','上传成功');
                    uploadedFileName = document.getElementById('image_file').value;
                },
                error: function () {
                    layer.alert('发生未知错误! 请连续涛哥!',{icon:2});
                }
            };
            $('#upload_form').submit(function () {
                $(this).ajaxSubmit(options_add);
                return false;
            });

            //delete pic
            var options_delete = {
                url: "{{url('additemdelete')}}",
                type: 'post',
                //dataType: 'json', //http://jquery.malsup.com/form/#json
                beforeSubmit:function(){
                },
                success: function(data){
                    showMessage('success', '删除图片成功');
                    cleanall();
                },
                error: function () {
                    layer.alert('发生未知错误! 请连续涛哥!',{icon:2});
                }
            };
            $('#delete_form').submit(function () {
                $(this).ajaxSubmit(options_delete);
                return false;
            });
        });

        //弹出 查询订单窗口 //layer插件
        function getCartInfor()
        {
            layer.open({
                type: 2,
                shade:[0.8, '#393D49'],
                area: ['850px', '650px'],
                title: ['选择所属于的订单','font-size:12px;color:white;background-color:#6ABB52'],
                scrollbar: false,
                content:['{{url("searchCart/all")}}', 'no'],
                success:function(layero, index){
                },
                cancel:function(index){
                }
            });
        }

        //弹出 新加订单窗口 //layer插件
        function createCartinfor()
        {
            layer.open({
                type: 2,
                shade: [0.8, '#393D49'],
                area:['850px','500px'],
                title: ['添加新订单', 'font-size:12px;color:white;background-color:#6a5a8c'],
                scrollbar: false,
                content: ['{{url("showcart")}}', 'no'],
                closeBtn:1,
                success: function(layero, index){
                },
                cancel:function(index){
                }
            });
        }

        //show the message
        function showReturnMessage(str) {
            layer.alert(str,{
                skin: 'layui-layer-molv',
                title:'用户添加',
                closeBtn:0}
            );
        }

        //
        function checkForm(form)
        {
            var money = jQuery('#money').val();
            var regular = /^[0-9]*(\.[0-9]{1,2})?$/;
            if(!regular.test(money))
                    return false;
            //form.submit();
        }
    </script>

<div id="additemdiv">
    <div><img src='{{url("images/addtop.jpg")}}'/></div>
    @include('error')
    @if(session('status'))
        <script>showReturnMessage('{{session("status")}}');</script>
    @endif
    <form id="add_form" method="post" action="{{url('item')}}">
        {!! csrf_field() !!}
        <div class="width100">
            <div id="showError"></div>
            {{--出售金额 物品数量--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-6 control-label" for="sellPrice">出售金额</label>
                    <label class="col-xs-6 control-label" for="itemNum">物品数量</label>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input yt-check="money" class="form-control input-sm" type="text" name="sellPrice" id="money" placeholder="默认为人民币¥, 可以设置相同物品总价格, 填写对应的物品数量">
                    </div>
                    <div class="col-xs-6">
                        <select id="itemNum" name="itemNum" class="form-control input-sm">
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>
            </div>
            {{--物品名称--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-12 control-label" for="itemName">物品名称</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" id="itemName" name="itemName" placeholder="简单介绍谁买的什么  例如:隔壁老王买的印度神油">
                    </div>
                </div>
            </div>
            {{--订单ID 上传图片--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-6 control-label" for="cartId">订单ID</label>
                    <label class="col-xs-2 control-label" for=""></label>
                    <label class="col-xs-2 control-label" for=""></label>
                    <label class="col-xs-2 control-label" for="">上传图片</label>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input class="form-control input-sm"  name="cartId" id="cartId">
                    </div>
                    <input type="button" value="新开订单" class="button green" onclick="createCartinfor()" name="newopencart" id="newopencart">
                    <input type="button" value="查询订单" class="button green" onclick="getCartInfor()">
                    <input type="button" value="点击上传" class="button orange" onclick="">
                </div>
            </div>

            {{--市场价格 促销价格 实际支付--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-4 control-label" for="marketPrice">市场价格</label>
                    <label class="col-xs-4 control-label" for="specialPrice">促销价格</label>
                    <label class="col-xs-4 control-label" for="costPrice">实际支付</label>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                    <input name="marketPrice"  class="form-control input-sm" placeholder="对客户显示的价格">
                        </div>
                    <div class="col-xs-4">
                    <input name="specialPrice"  class="form-control input-sm" placeholder="促销价格">
                        </div>
                    <div class="col-xs-4">
                    <input name="costPrice"  class="form-control input-sm" placeholder="实际购买价格">
                        </div>
                </div>
            </div>

            {{--物品重量 快递费率 购买地点--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-4 control-label" for="weight">物品重量</label>
                    <label class="col-xs-4 control-label" for="postRate">快递费率</label>
                    <label class="col-xs-4 control-label" for="storeId">购买地点</label>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <input name="weight"  class="form-control input-sm" placeholder="单位磅">
                    </div>
                    <div class="col-xs-4">
                        <input name="postRate"  class="form-control input-sm" value="4.5">
                    </div>
                    <div class="col-xs-4">
                        <select class="form-control input-sm" name="storeId" id="storeId">
                            <option value="" selected>选择商店</option>
                            @foreach($stores as $store)
                                <option value="{{$store->id}}"
                                        title="{{$store->info}}">{{$store->storeName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{--购买日期 备注信息 是否付款--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-4 control-label" for="date">购买日期</label>
                    <label class="col-xs-4 control-label" for="info">备注信息</label>
                    <label class="col-xs-4 control-label" for="view">是否付款</label>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <input name="date" class="form-control input-sm laydate-icon" id="showDate" onclick="laydate()">
                    </div>
                    <div class="col-xs-4">
                        <input name="info" type="text" class="form-control input-sm" placeholder="备注">
                    </div>
                    <div class="col-xs-4">
                        <div class="switch">
                            <input type="radio" class="switch-input" name="view" value="0" id="nopay" checked>
                            <label for="nopay" class="switch-label switch-label-off">还没</label>
                            <input type="radio" class="switch-input" name="view" value="1" id="yespay">
                            <label for="yespay" class="switch-label switch-label-on">已付</label>
                            <span class="switch-selection"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input class="button orange" style="width: 100%" type="submit" value="添加记录">
        {{--for pic file name--}}
        <input type="hidden" id="fileName_hide" name="fileName_hide" value="">
    </form>
</div>

{{--隐藏:添加表单--}}
<form id="upload_form" enctype="multipart/form-data" method="post" >
    <input type="file" name="image_file" id="image_file" onchange="fileSelected()" style="display: none" value="" />
</form>
{{--判断是否删除图片(或者只是选择了图片) 来决定是否执行后台的删除图片操作--}}
<form id="delete_form" enctype="multipart/form-data" method="post">
    <input hidden id="deleteImgId" name="deleteImgId">
</form>

<script type="text/javascript">
</script>

@endsection
