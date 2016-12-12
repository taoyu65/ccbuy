
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
            <button class="btn btn-success btn130Width" type="button" onclick="javascript:window.location.href='{{url('statisticsAllItem')}}'">
                {{trans('statistic.items')}} <span class="badge">{{trans('statistic.all')}}</span>
            </button>
        </div>
    </div>

    <script type="text/javascript" src='{{url("js/Chart.min.js")}}'></script>
    <canvas id="myChart" width="600" height="300"></canvas>
    <script>
        var color = [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(199,21,133, 0.5)',
            'rgba(95,158,160, 0.5)',
            'rgba(85,107,47, 0.5)',
            'rgba(0,255,0, 0.5)',
            'rgba(165,42,42, 0.5)',
            'rgba(105,105,105, 0.5)',
        ];

        var returnData = '{!! $dataSet !!}';
        var jsonData = eval('(' + returnData + ')');
        var arr = [];
        var i = 0;
        for(var label in jsonData){
            i++;
            if(i > 11) {
                var r = GetRandomNum(0, 250).toString();
                var g = GetRandomNum(0, 250).toString();
                var b = GetRandomNum(0, 250).toString();
                color.push('rgba('+r+', '+g+', '+b+', 0.5)');
            }
            var json = {
                label: label,
                data: jsonData[label],
                backgroundColor: color[i],
                //hoverBackgroundColor: "#FF6384",
            };
            arr.push(json);
        }
        var bubbleChartData = {
            datasets: arr
        };
        window.onload = function() {
            var ctx = document.getElementById("myChart").getContext("2d");
            window.myChart = new Chart(ctx, {
                type: 'bubble',
                data: bubbleChartData,
                options: {
                    responsive: true,
                    title:{
                        display:true,
                        text:'Chart.js Bubble Chart'
                    },
                    tooltips: {
                        mode: 'point'
                    }
                }
            });
        };
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
