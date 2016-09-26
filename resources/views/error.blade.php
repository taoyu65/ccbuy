

@if(count($errors) > 0)
    <div class="alert alert-danger">
        <strong>意外错误</strong> 可能是由于:<span style="color: red">{{$reason or '输入不符合要求'}}</span> 导致<br><br>
        {!! implode('<br>', $errors->all()) !!}
    </div>
@endif

