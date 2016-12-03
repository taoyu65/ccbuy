
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
    <div class="c03" > <a href="#"><img id="addimg" src="images/yl{{trans('collecting.pic')}}.jpg"></a></div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{trans('collecting.cartName')}}</th>
            <th>{{trans('collecting.weight')}}</th>
            <th>{{trans('collecting.date')}}</th>
            <th>{{trans('collecting.profits')}}</th>
            <th>{{trans('collecting.profitRatio')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($carts as $cart)
            @if($cart->isHelpBuy == 1)

                <tr title="{{trans('collecting.dmMode')}}" onclick="showItemRow({{$cart->id}});" style="cursor:pointer;color: #f47a20;" class="red">

            @else
                <tr onclick="showItemRow({{$cart->id}});" style="cursor:pointer">
            @endif
                    <td>{{$cart->rename}}</td>
                    @if($cart->isHelpBuy == 1)
                        <td>{{trans('collecting.dmMode')}}</td>
                        <td>{{$cart->date}}</td>
                        <td >{{$cart->profits}}$</td>
                        <td>{{$cart->profitRatio}}</td>
                    @else
                        <td>{{$cart->weight}}</td>
                        <td>{{$cart->date}}</td>
                        <td ><span style="color: #00aa88">{{$cart->profits}}$</span></td>
                        <td><span style="color: #00aaee">{{$cart->profitRatio}}</span></td>
                    @endif
                </tr>
                <tr id="tr{{$cart->id}}"></tr>  {{--container for items which are shown after clicking the cart--}}
        @endforeach
        </tbody>
    </table>

    {{--<div class="text-center">{!! with(new \App\Foundations\Pagination\CustomerPresenter($carts))->render() !!}</div>--}}
    <div class="text-center">{!! $carts->render() !!}</div>
@endsection