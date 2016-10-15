
@extends('layouts.foot')
@section('content')
    <link href='{{url("css/welcome.css")}}' rel="stylesheet" type="text/css">
    <script type="text/javascript" src='{{url("ui/laypage/laypage.js")}}'></script>

    <div class="c03" > <a href="#"><img id="addimg" src="images/collecting.jpg"></a></div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>物品名称 {{$count->b}}</th>
            <th>出售金额 ¥</th>
            <th>成本 $</th>
            <th>净利 $(不含邮费)</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div id="page" style="text-align: center"></div>
    <input id="count" value="" type="hidden">
@endsection