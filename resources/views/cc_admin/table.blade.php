
@extends('layouts.ccadmin')
@section('content1')
    <script type="text/javascript" src='{{url("ui/laydate/laydate.js")}}'></script>
    <script type="text/javascript">
        //change hover css when change different table
        var label = '{{$table}}';
        jQuery('#li_table').attr('class' , 'active');
        jQuery('#li_table_' + label).attr('class' , 'active');

        //edit
        function edit(tableName,id) {
            layer.open({
                type: 2,
                shade:[0.8, '#393D49'],
                area: ['850px', '650px'],
                title: ['Edit ' + tableName+ ' ID:'+id,'font-size:12px;color:white;background-color:#6ABB52'],
                scrollbar: false,
                content:['{{url("cc_admin/tableEdit/")}}' +'/' + tableName +'/' + id, 'yes'],
                success:function(layero, index){
                },
                cancel:function(index){
                }
            });
        }
        //delete
        function recordDelete(tableName, id)
        {
            layer.open({
                type: 2,
                shade: [0.8, '#393D49'],
                area: ['850px', '650px'],
                title: ['Delete '+ tableName + ' ID:' + id, 'font-size:12px;color:white;background-color:#c9302c'],
                scrollbar: false,
                content:['{{url("cc_admin/tableDelete/")}}' +'/' + tableName +'/' + id, 'yes'],
                success:function(layero, index){
                },
                cancel:function(index){
                }
            });
        }
    </script>
    {!! $html !!}

@endsection