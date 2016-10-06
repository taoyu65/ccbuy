
@extends('layouts.foot')
@section('content')
    <link href="css/welcome.css" rel="stylesheet" type="text/css">

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

@endsection
