
@extends('layouts.ccadmin')
@section('content1')
    <script type="text/javascript">
        jQuery('#li_table').attr('class' , 'active');
        jQuery('#li_table_carts').attr('class' , 'active');
    </script>

    {!! $html !!}
@endsection