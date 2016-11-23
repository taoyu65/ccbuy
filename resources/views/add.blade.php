
@extends('layouts.foot')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='{{url("css/additem.css")}}' rel="stylesheet" type="text/css">

    <script type="text/javascript" src='{{url("ui/layer/layer.js")}}'></script>
    <script type="text/javascript" src='{{url("js/uploadimg.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/laydate/laydate.js")}}'></script>
    <script type="text/javascript" src='{{url("js/jquery.form.js")}}'></script>
    <script type="text/javascript" src='{{url("js/yt_validation.js")}}'></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            //before submit Form - validation
            $('#submitBtn').click(function(){
                if(!checkForm('add_form'))
                    return false;
                var index = layer.load(0, {
                    shade: [0.5,'#393D49'] //0.1透明度的白色背景
                });
                jQuery('#submitBtn').attr('disabled', 'disabled');
                $('#add_form').submit();
            });

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

            //get date
            var myDate = new Date();
            var today = myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
            $('#showDate').val(today);
        });

        //弹出 查询订单窗口 //layer插件
        function getCartInfor() {
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
        function createCartinfor() {
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

        //add store
        function addStore() {
            layer.open({
                type: 2,
                shade: [0.8, '#393D49'],
                area:['850px','300px'],
                title: ['添加商店' , 'font-size:12px;color:white;background-color:#FF77AB'],
                scrollbar: false,
                //dataType:'get',
                content: ['{{url("store")}}', 'no'],
                closeBtn:0,
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

        //sny special price to market price
        function synMartketPrice(label) {
            var marketPrice = $('#marketPrice').val();
            $('#'+label).val(marketPrice);
        }

        //sny special price to market price
        function getPriceAfterTax(label) {
            var marketPrice = $('#marketPrice').val();
            var costPrice = $('#costPrice').val();
            if((costPrice/marketPrice).toFixed(2) != 1.08) {
                var price = $('#costPrice').val() * 1.08;
                $('#'+label).val(price.toFixed(2));
            }else {
                alert('不能连续2次加税!~价格已经是税后!');
            }
        }

        //syc the price
        function syc(val) {
            $('#specialPrice').val(val);
            $('#costPrice').val(val);
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
                    <label class="col-xs-6 control-label" for="sellPrice">出售金额 ¥<span class="label-danger" id="sellPrice_error"></span></label>
                    <label class="col-xs-6 control-label" for="itemNum">物品数量</label>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input yt-validation="yes" yt-check="money" yt-errorMessage="请填写正确金额" yt-target="sellPrice_error" class="form-control input-sm" type="text" value="" name="sellPrice" id="money" placeholder="默认为人民币¥, 可以设置相同物品总价格, 填写对应的物品数量">
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
                    <label class="col-xs-6 control-label" for="itemName">物品名称 <span class="label-danger" id="itemName_error"></span></label>
                    <label class="col-xs-6 control-label" for="storeId">购买地点 <input type="button" value="添加商店" class="button small green" onclick="addStore();"> <span class="label-danger" id="storeId_error"></span></label>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input yt-validation="yes" yt-check="null" yt-errorMessage="不能为空" yt-target="itemName_error" class="form-control input-sm" type="text" id="itemName" name="itemName" placeholder="简单介绍谁买的什么  例如:隔壁老王买的印度神油">
                    </div>
                    <div class="col-xs-6">
                        <select yt-validation="yes" yt-check="null" yt-errorMessage="请选择商店" yt-target="storeId_error" class="form-control input-sm" name="storeId" id="storeId">
                            <option value="" selected>选择商店</option>
                            @foreach($stores as $store)
                                <option value="{{$store->id}}"
                                        title="{{$store->info}}">{{$store->storeName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{--订单ID 上传图片--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-6 control-label" for="cartId">订单ID <span class="label-danger" id="cartId_error"></span></label>
                    <label class="col-xs-2 control-label" for=""></label>
                    <label class="col-xs-2 control-label" for=""></label>
                    <label class="col-xs-2 control-label" for="">上传图片</label>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input yt-validation="yes" yt-check="id" yt-errorMessage="请输入一个有效的数字" yt-target="cartId_error" class="form-control input-sm"  name="cartId" id="cartId">
                    </div>
                    <input type="button" value="新开订单" class="button green" onclick="createCartinfor()" name="newopencart" id="newopencart">
                    <input type="button" value="查询订单" class="button green" onclick="getCartInfor()">
                    <input type="button" value="点击上传" class="button orange" onclick="">
                </div>
            </div>

            {{--市场价格 促销价格 实际支付--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-4 control-label" for="marketPrice">市场价格 $<span class="label-danger" id="marketPrice_error"></span></label>
                    <label class="col-xs-4 control-label" for="specialPrice">促销价格 <input type="button" value="同步于市场价格" class="button small green" onclick="synMartketPrice('specialPrice')"> <span class="label-danger" id="specialPrice_error"></span></label>
                    <label class="col-xs-4 control-label" for="costPrice">实际支付 <input type="button" value="计算税后价格" class="button small green" onclick="getPriceAfterTax('costPrice')"><span class="label-danger" id="costPrice_error"></span></label>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <input yt-validation="yes" yt-check="money" yt-errorMessage="请填写正确价格" yt-target="marketPrice_error" name="marketPrice" id="marketPrice" class="form-control input-sm" placeholder="对客户显示的价格" onkeyup="syc(this.value);">
                    </div>
                    <div class="col-xs-4">
                        <input yt-validation="yes" yt-check="money" yt-errorMessage="<-点 *" yt-target="specialPrice_error" name="specialPrice" id="specialPrice" class="form-control input-sm" placeholder="促销价格">
                    </div>
                    <div class="col-xs-4">
                        <input yt-validation="yes" yt-check="money" yt-errorMessage="<-点 *" yt-target="costPrice_error" name="costPrice" id="costPrice" class="form-control input-sm" placeholder="实际购买价格">
                    </div>
                </div>
            </div>

            {{--物品重量 快递费率 购买地点--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-4 control-label" for="date">购买日期 <span class="label-danger" id="date_error"></span></label>
                    <label class="col-xs-4 control-label" for="storeId">兑换汇率 <span class="label-danger" id="exchangeRate_error"></span></label>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <input yt-validation="yes" yt-check="null" yt-errorMessage="日期格式不正确" yt-target="date_error" name="date" class="form-control input-sm laydate-icon" id="showDate" onclick="laydate()">
                    </div>
                    <div class="col-xs-4">
                        <input yt-validation="yes" yt-check="money" yt-errorMessage="数字" yt-target="exchangeRate_error" name="exchangeRate"  class="form-control input-sm" value="6.8" title="美金兑人民币">
                    </div>
                </div>
            </div>

            {{--购买日期 备注信息 是否付款--}}
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-8 control-label" for="info">备注信息</label>
                    <label class="col-xs-4 control-label" for="view">是否付款</label>
                </div>
                <div class="row">
                    <div class="col-xs-8">
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
            {{--submit--}}
            <div class="form-group">
                <div class="col-xs-12">
                    <input class="button orange" style="width: 100%" type="button" value="添加记录" id="submitBtn">
                </div>
            </div>
        </div>

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
