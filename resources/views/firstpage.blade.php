
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
    <div class="c03" > <a href="{{url('/item/create')}}"><img id="addimg" src="images/add.png"></a> </div>

    <div class="nav-left">
        <dl>
            @foreach($items as $item)
                <dd>
                    <div id="itemshow">
                        <a href="#">
                        <div id='itemshow-a'>{{$item->itemName}}</div>
                        <div id="itemshow-c">${{$item->sellPrice}}</div>
                        <div id='itemshow-b'>{{$item->date}}</div>
                        </a>
                    </div>
                </dd>
            @endforeach()
        </dl>
    </div>

    <div id="page" style="text-align: center"></div>
    <input id="count" value="{{$count}}" type="hidden">

@endsection
