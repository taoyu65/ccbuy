
<script>
    function setLanguage(lang) {
        location.href='{{url('setLanguage/')}}/' + lang;
    }
</script>
<div class="panel" style="position:fixed;top:0;left:0;">
    <div class="panel-head">
        <strong>Click to Change Language (点击切换语言)</strong>
    </div>
     <img src="{{url('images/lang.en.png')}}" onclick="setLanguage('en');" style="cursor: pointer;">  <img src="{{url('images/lang.zh.png')}}" onclick="setLanguage('zh_cn');" style="cursor: pointer">
</div>