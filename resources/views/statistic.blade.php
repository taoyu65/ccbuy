
@extends('layouts.foot')
@section('content')
<style>
    .btn130Width{
        width:130px;text-align: left;
    }

</style>
    <div class="line">
        <div class="xl3">
            <button class="btn btn-primary btn130Width" type="button" onclick="javascript:window.location.href='{{url('statistics/2016/profits')}}'">
                {{trans('statistic.profits')}} <span class="badge">2016</span>
            </button>
        </div>
        <div class="xl3">
            <button class="btn btn-primary btn130Width" type="button" onclick="javascript:window.location.href='{{url('statistics/2017/profits')}}'">
                {{trans('statistic.profits')}} <span class="badge">2017</span>
            </button>
        </div>
        <div class="xl3">
            <button class="btn btn-primary btn130Width" type="button" onclick="javascript:window.location.href='{{url('statistics/All/profits')}}'">
                {{trans('statistic.profits')}} <span class="badge">{{trans('statistic.all')}}</span>
            </button>
        </div>
    </div>
    <div class="line" style="padding-top: 10px">
        <div class="xl3">
            <button class="btn btn-warning btn130Width" type="button" onclick="javascript:window.location.href='{{url('statistics/2016/customer')}}'">
                {{trans('statistic.customer')}} <span class="badge">2016</span>
            </button>
        </div>
        <div class="xl3">
            <button class="btn btn-warning btn130Width" type="button" onclick="javascript:window.location.href='{{url('statistics/2017/customer')}}'">
                {{trans('statistic.customer')}} <span class="badge">2017</span>
            </button>
        </div>
        <div class="xl3">
            <button class="btn btn-warning btn130Width" type="button" onclick="javascript:window.location.href='{{url('statistics/All/customer')}}'">
                {{trans('statistic.customer')}} <span class="badge">{{trans('statistic.all')}}</span>
            </button>
        </div>
    </div>

    <div class="line-middle" style="padding-top: 10px">
        <div class="xl2">
            <button class="btn btn-success btn130Width" type="button">
                {{trans('statistic.items')}} <span class="badge">{{trans('statistic.all')}}</span>
            </button>
        </div>
    </div>

    <script type="text/javascript" src='{{url("js/Chart.min.js")}}'></script>
    <canvas id="myChart" width="600" height="300"></canvas>
    <script>


        var color = [
            'rgba(255, 99, 132, 1)',
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
            'rgba(105,105,105, 1)',
        ];
        var borderColor = [
            'rgba(255,99,132,1)',
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
            'rgba(105,105,105, 1)',
        ];
        var customers = ("{{$month}}").split(',');
        for (var i = 12; i < customers.length; i++) {
            var r = GetRandomNum(0, 250).toString();
            var g = GetRandomNum(0, 250).toString();
            var b = GetRandomNum(0, 250).toString();
            var a = Math.random().toFixed(1).toString();
            color.push('rgba('+r+', '+b+', '+b+', 0.5)');
            borderColor.push('rgba('+r+', '+b+', '+b+', 1)');
        }

        var ctx = $("#myChart");
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            display: true,
            data: {
                labels: "{{$month}}".split(','),
                datasets: [{
                    label: '{{$title}}',
                    data: "{{$data}}".split(','),
                    backgroundColor: color,
                    borderColor: borderColor,
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
        //get random number
        function GetRandomNum(Min,Max)
        {
            var Range = Max - Min;
            var Rand = Math.random();
            return(Min + Math.round(Rand * Range));
        }
    </script>
    <button type="button" class="btn btn-default btn-lg btn-block" onclick="refresh();"><strong>{{trans('statistic.refresh')}}</strong></button>
@endsection
