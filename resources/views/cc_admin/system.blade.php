
@extends('layouts.ccadmin')
@section('content1')

    <script type="text/javascript" src='{{url("js/yt_validation.js")}}'></script>
    <script type="text/javascript">
        jQuery('#li_system').attr('class' , 'active');
        jQuery('#li_system_setup').attr('class' , 'active');

        function closeCartSubmit(form) {

            if(!checkForm(form.id))
                return false;
            layer.confirm('确定结算吗?订单利润将会减去邮费金额(重量*快递费率)', {
                btn: ['确认结算', '取消结算']
            }, function () {
                form.submit();
            }, function () {

            });

        }
    </script>
    <div class="alert alert-yellow"><span class="close"></span><strong>注意：</strong>正在显示所有 <strong>未结算</strong> 的订单。</div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th width="10%">ID</th>
            <th width="30%">订单名称</th>
            <th width="10%">重量</th>
            <th width="10%">邮费每磅</th>
            <th width="10%">订单利润</th>
            <th width="10%">日期</th>
            <th width="10%">结算</th>
        </tr>
        </thead></table>
        <tbody>
        @foreach($DBs as $data)
            <form method="post" action="{{url('cc_admin/system/close')}}" id="scForm{{$data->id}}" >
                {!! csrf_field() !!}
                <input type="hidden" name="cartId" value="{{$data->id}}">
                <input type="hidden" name="profits" value="{{$data->profits}}">
                <table class="table table-hover">
                <tr>
                    <td width="10%">{{$data->id}}</td>
                    <td width="30%">{{$data->rename}}</td>
                    <td width="10%"><input yt-validation="yes" yt-check="money,no0" yt-errorMessage="格式不正确" yt-target="weight{{$data->id}}" name="weight" value="{{$data->weight}}" class="input" type="text">
                        <span class="badge bg-red" id="weight{{$data->id}}"></span></td>
                    <td width="10%"><input yt-validation="yes" yt-check="money,no0" yt-errorMessage="格式不正确" yt-target="postRate{{$data->id}}" name="postRate" value="{{$data->postRate}}" class="input" type="text">
                        <span class="badge bg-red" id="postRate{{$data->id}}"></span></td>
                    <td width="10%">{{$data->profits}}</td>
                    <td width="10%">{{$data->date}}</td>
                    <td width="10%"><button type="button" onclick="closeCartSubmit(this.form);" class="button border-green">结算</button></td>
                </tr>
                </table>
            </form>
        @endforeach
        </tbody>

@endsection