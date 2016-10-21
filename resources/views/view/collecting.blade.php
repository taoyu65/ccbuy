
@extends('layouts.foot')
@section('content')
    <link href='{{url("css/welcome.css")}}' rel="stylesheet" type="text/css">
    <script type="text/javascript" src='{{url("ui/laypage/laypage.js")}}'></script>
<script type="text/javascript">
    function showItemRow(cid)
    {
        // see if the first time ajax the items
        if ($("#tr"+cid+"> td").length > 0)
        {
            if($('#tr'+cid).is(':hidden')){
                $('#tr'+cid).show();
            }else{
                $('#tr'+cid).hide();
            }
        }
        else    //first time click will be loading items
        {
            $('#tr' + cid).append('<td colspan="4"><div><img src="images/loading.gif"></div></td>');
            $.get('getItems/'+cid, function (data, status) {//alert(data);
                $('#tr'+cid).empty();
                $('#tr' + cid).append('<td colspan="4"><div style="padding: 15px">'+data+'</div></td>');
            });
        }
    }
</script>
    <div class="c03" > <a href="#"><img id="addimg" src="images/yl.jpg"></a></div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>订单名称</th>
            <th>订单重量</th>
            <th>创建日期</th>
            <th>订单利润</th>
        </tr>
        </thead>
        <tbody>
        @foreach($carts as $cart)
            <tr onclick="showItemRow({{$cart->id}});" style="cursor:pointer">
                <td>{{$cart->rename}}</td>
                <td>{{$cart->weight}}</td>
                <td>{{$cart->date}}</td>
                <td>{{$cart->profits}}$</td>
            </tr>
            <tr id="tr{{$cart->id}}"></tr>
        @endforeach
        </tbody>
    </table>

    <div id="page" style="text-align: center"></div>
    <input id="count" value="" type="hidden">
@endsection