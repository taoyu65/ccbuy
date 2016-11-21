
@extends('layouts.foot')
@section('content')

    <div>
        <button class="btn btn-primary" type="button" onclick="javascript:window.location.href='{{url('statistics/2016/profits')}}'">
            按利润 <span class="badge">2016</span>
        </button>
        <button class="btn btn-primary" type="button" onclick="javascript:window.location.href='{{url('statistics/2017/profits')}}'">
            按利润 <span class="badge">2017</span>
        </button>
        <button class="btn btn-primary" type="button" onclick="javascript:window.location.href='{{url('statistics/all/profits')}}'">
            按利润 <span class="badge">所有</span>
        </button>
        <button class="btn btn-warning" type="button">
            按客户 <span class="badge">2016</span>
        </button>
        <button class="btn btn-warning" type="button">
            按客户 <span class="badge">2017</span>
        </button>
        <button class="btn btn-warning" type="button">
            按客户 <span class="badge">所有</span>
        </button>
    </div>
    <div style="padding-top: 15px">
        <button class="btn btn-success" type="button">
            按物品 <span class="badge">所有</span>
        </button>
    </div>
  {{--  <ul class="nav nav-pills" role="tablist">
        ...
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Dropdown <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                ...
            </ul>
        </li>
        ...
    </ul>
--}}
    <script type="text/javascript" src='{{url("js/Chart.min.js")}}'></script>
    <canvas id="myChart" width="600" height="300"></canvas>
    <script>
        var ctx = $("#myChart");
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            display: true,
            data: {
                labels: "{{$month}}".split(','),
                datasets: [{
                    label: 'hdf',
                    data: "{{$data}}".split(','),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(199,21,133, 0.2)',
                        'rgba(95,158,160, 0.2)',
                        'rgba(85,107,47, 0.2)',
                        'rgba(0,255,0, 0.2)',
                        'rgba(165,42,42, 0.2)',
                        'rgba(105,105,105, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,0.8)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199,21,133, 1)',
                        'rgba(95,158,160, 1)',
                        'rgba(85,107,47, 1)',
                        'rgba(0,255,0, 1)',
                        'rgba(165,42,42, 1)',
                        'rgba(105,105,105, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            //beginAtZero:true,
                            //stepSize: 2
                        }
                    }]
                }
            }
        });
        //get refresh page
        function refresh() {
            var url = document.URL;
            url = url.replace('/refresh', '');
            url += '/refresh';
            window.location.href = url;
        }
    </script>
    <button type="button" class="btn btn-default btn-lg btn-block" onclick="refresh();"><strong>刷 新 图 表</strong></button>
@endsection
