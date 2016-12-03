
@extends('layouts.ccadmin')
@section('content1')
    <script type="text/javascript">
        jQuery('#li_main').attr('class' , 'active');
        jQuery('#li_main_system').attr('class' , 'active');
    </script>
    <div class="line-big">
        <div class="xm3">
            <div class="panel border-back">
                <div class="panel-body text-center">
                    <img src="images/face.jpg" width="120" class="radius-circle" >
                    <br > {{trans('cc_admin/main.admin')}}
                </div>
                <div class="panel-foot bg-back border-back">{{trans('cc_admin/main.hello')}}，{{Auth::user()->name}}，{{trans('cc_admin/main.lastTime')}}</div>
            </div>
            <br >
            <div class="panel">
                <div class="panel-head"><strong>{{trans('cc_admin/main.webStatistic')}}</strong></div>
                <ul class="list-group">
                    <li><span class="float-right badge bg-red">88</span><span class="icon-user"></span> {{trans('cc_admin/main.member')}}</li>
                    <li><span class="float-right badge bg-main">828</span><span class="icon-file"></span> {{trans('cc_admin/main.file')}}</li>
                    <li><span class="float-right badge bg-main">828</span><span class="icon-shopping-cart"></span> {{trans('cc_admin/main.order')}}</li>
                    <li><span class="float-right badge bg-main">828</span><span class="icon-file-text"></span> {{trans('cc_admin/main.content')}}</li>
                    <li><span class="float-right badge bg-main">828</span><span class="icon-database"></span> {{trans('cc_admin/main.database')}}</li>
                </ul>
            </div>
            <br >
        </div>
        <div class="xm9">
            <div class="alert alert-yellow"><span class="close"></span><strong>{{trans('cc_admin/main.caution')}}：</strong>{{trans('cc_admin/unread.')}}，<a href="#">{{trans('cc_admin/main.check')}}</a>。</div>
            <div class="alert">
                <h4>{{trans('cc_admin/main.pinTu')}}</h4>
                <p class="text-gray padding-top">{{trans('cc_admin/main.ptInfo')}}</p>
                <a target="_blank" class="button bg-dot icon-code" href="pintuer2.zip"> {{trans('cc_admin/main.download')}}</a>
                <a target="_blank" class="button bg-main icon-download" href="http://www.pintuer.com/download/pintuer.zip"> {{trans('cc_admin/main.download')}}</a>
                <a target="_blank" class="button border-main icon-file" href="http://www.pintuer.com/"> {{trans('cc_admin/main.document')}}</a>
            </div>
            <div class="panel">
                <div class="panel-head"><strong>{{trans('cc_admin/main.systemInfo')}}</strong></div>
                <table class="table">
                    <tr>
                        <th colspan="2">{{trans('cc_admin/main.serverInfo')}}</th>
                        <th colspan="2">{{trans('cc_admin/main.systemInfo')}}</th>
                    </tr>
                    <tr>
                        <td width="110" align="right">{{trans('cc_admin/main.win')}}：</td>
                        <td>Windows 2008</td>
                        <td width="90" align="right">{{trans('cc_admin/main.development')}}：</td>
                        <td><a href="http://www.pintuer.com" target="_blank">{{trans('cc_admin/main.ptWeb')}}</a></td>
                    </tr>
                    <tr>
                        <td align="right">{{trans('cc_admin/main.web')}}：</td>
                        <td>Apache</td>
                        <td align="right">{{trans('cc_admin/main.page')}}：</td>
                        <td><a href="http://www.pintuer.com" target="_blank">http://www.pintuer.com</a></td>
                    </tr>
                    <tr>
                        <td align="right">{{trans('cc_admin/main.lan')}}：</td>
                        <td>PHP</td>
                        <td align="right">{{trans('cc_admin/main.demo')}}：</td>
                        <td><a href="http://www.pintuer.com/demo/" target="_blank">demo/</a></td>
                    </tr>
                    <tr>
                        <td align="right">{{trans('cc_admin/main.database2')}}：</td>
                        <td>MySQL</td>
                        <td align="right">{{trans('cc_admin/main.qq')}}：</td>
                        <td><a href="http://shang.qq.com/wpa/qunwpa?idkey=a08e4d729d15d32cec493212f7672a6a312c7e59884a959c47ae7a846c3fadc1" target="_blank">201916085</a> {{trans('cc_admin/main.in')}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection