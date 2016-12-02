
@extends('layouts.foot')
@section('content')
    <link href="css/welcome.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src='{{url("ui/laypage/laypage.js")}}'></script>
    <script>
        $(document).ready(function(){
            var count = jQuery('#count').val();
            laypage({
                cont: 'page',
                pages: count,
                skin: 'molv',
                curr:function(){
                    var page = location.search.match(/page=(\d+)/);
                    return page ? page[1] : 1;
                }(),
                jump: function(e, first) {
                    if(!first) {
                        location.href = '?page=' + e.curr;
                    }
                }
            });
        });
    </script>
    <a href="#">
        <div class="c02" ><img src="images/example_head.png" alt="" id="headfack" /></div>
        <div id="bian"></div>
    </a>
    <!--/*add*/-->
    <div class="row">
        <div class="col-xs-6 complete">
            <a href="{{url('/item/create')}}"><img id="addimg" src="images/add.png" width="100%"></a>
        </div>
        <div class="col-xs-6 ">
            <a href="{{url('/item/create/daimai')}}"><img id="addimg" src="images/dm.png" width="100%"></a>
        </div>
    </div>
    {{----}}
    <table class="table table-hover">
        <thead>
        <tr>
            <th>物品名称</th>
            <th>出售金额 ¥</th>
            <th>成本 $</th>
            <th>净利 $(不含邮费)</th>
            <th>日期</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
        <tr>
            <td>
                {{$item->itemName}}
                @if($item->itemAmount != 1)
                    *{{$item->itemAmount}}
                @endif
            </td>
            <td>¥{{$item->sellPrice}}</td>
            <td title="{{$item->costPrice}} * {{$item->itemAmount}}"><span class="text-danger"><strong>${{$item->costPrice*$item->itemAmount}}</strong></span></td></td>
            <td><span class="text-success"><strong>${{$item->itemProfit * 1}}</strong></span></td>
            <td>{{$item->date}}</td>
        </tr>
        @endforeach()
        </tbody>
    </table>

    <div id="page" style="text-align: center"></div>
    <input id="count" value="{{$count}}" type="hidden">

@endsection
