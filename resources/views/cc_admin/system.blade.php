
@extends('layouts.ccadmin')
@section('content1')

    <script type="text/javascript" src='{{url("js/yt_validation.js")}}'></script>
    <script type="text/javascript">
        jQuery('#li_system').attr('class' , 'active');
        jQuery('#li_system_setup').attr('class' , 'active');

        function closeCartSubmit(form) {

            if(!checkForm(form.id))
                return false;
            layer.confirm('{{trans('cc_admin/system.confirm')}}', {
                btn: ['{{trans('cc_admin/system.yes')}}', '{{trans('cc_admin/system.no')}}']
            }, function () {
                form.submit();
            }, function () {

            });

        }
    </script>
    <div class="alert alert-yellow"><span class="close"></span><strong>{{trans('cc_admin/system.warning')}}：</strong>
        {{trans('cc_admin/system.closing')}}</div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th width="10%">{{trans('cc_admin/system.id')}}</th>
            <th width="30%">{{trans('cc_admin/system.name')}}</th>
            <th width="10%">{{trans('cc_admin/system.weight')}}</th>
            <th width="10%">{{trans('cc_admin/system.postRate')}}</th>
            <th width="10%">{{trans('cc_admin/system.profit')}}</th>
            <th width="10%">{{trans('cc_admin/system.date')}}</th>
            <th width="10%">{{trans('cc_admin/system.close')}}</th>
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
                    <td width="10%"><input yt-validation="yes" yt-check="money,no0" yt-errorMessage="{{trans('cc_admin/system.error')}}" yt-target="weight{{$data->id}}" name="weight" value="{{$data->weight}}" class="input" type="text">
                        <span class="badge bg-red" id="weight{{$data->id}}"></span></td>
                    <td width="10%"><input yt-validation="yes" yt-check="money,no0" yt-errorMessage="{{trans('cc_admin/system.error')}}" yt-target="postRate{{$data->id}}" name="postRate" value="{{$data->postRate}}" class="input" type="text">
                        <span class="badge bg-red" id="postRate{{$data->id}}"></span></td>
                    <td width="10%">{{$data->profits}}</td>
                    <td width="10%">{{$data->date}}</td>
                    <td width="10%"><button type="button" onclick="closeCartSubmit(this.form);" class="button border-green">{{trans('cc_admin/system.close')}}</button></td>
                </tr>
                </table>
            </form>
        @endforeach
        </tbody>

@endsection