
<script>
    function setLanguage(lang) {
        location.href='{{url('setLanguage/')}}/' + lang;
    }
</script>
<div class="panel" style="position:fixed;top:0;left:0;">
    <div class="panel-head">
        <strong>Click to Change Language (点击切换语言)</strong>
    </div>
    <img src="{{url('images/lang.en.png')}}" onclick="setLanguage('en');" style="cursor: pointer;">
    <img src="{{url('images/lang.zh.png')}}" onclick="setLanguage('zh_cn');" style="cursor: pointer;">
    <img src="{{url('images/lang.mexico.png')}}" onclick="" title="Está en la construcción" >
    @if(\Illuminate\Support\Facades\Auth::check())
    <div style="position: fixed;top:0;right: 0;padding-top: 10px;padding-right: 10px;"><a href="{{url('cc_admin/logout')}}"><h5>{{trans('firstPage.logout')}}</h5> <img src="{{url('images/logout.png')}}"></a></div>
    @endif
</div>