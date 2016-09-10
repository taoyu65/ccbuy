
@extends('layouts.foot')
@section('content')

    <link href="css/additem.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">
        function showsuccess()
        {
            $().toastmessage('showSuccessToast','添加成功');
        }
        function selectPic()
        {
            document.getElementById('uploadpic').click();
        }
    </script>



<div id="additemdiv">
    <div><img src="images/addtop.jpg" /></div>
    <div class="width100">
        {{--<form class="register" style="width:100%">--}}
            <div id="skipsomeheight"></div>
        <form>
           <div class="width100">
                <div class="txt">
                    <div class="twohang">出售金额</div>
                    <div class="sanhang">
                        <div class="sanhang">选择图片</div>
                        <div class="sanhang">上传图片</div>
                        <div class="sanhang">删除图片</div>
                    </div>
                </div>
                <div class="twohang"><input type="number" required class="register-input" id="money" placeholder="物品金额" title="金额" value="0.00"></div>
                <div class="sanhang">
                    <input type="file" id="uploadpic">
                    <div class="sanhang"><img src="images/paizhao.png" alt="选择图片" onclick="selectPic()"/></div>
                    <div class="sanhang"><img src="images/upload.png" alt="上传图片" id="addpic" onclick="showsuccess()"/></div>
                    <div class="sanhang"><img src="images/removepic.png" alt="删除图片" id="removepic" style="display: block" /></div>
                </div>
            </div>
        </form>

            <div class="width100">
                <div class="txt">
                    <div class="twohang">物品名称</div>
                    <div class="sanhang">订单ID <input type="button" value="点击查询订单" class="button small green"></div>
                </div>
                <div class="twohang"><input type="text" required class="register-input" placeholder="物品名称" ></div>
                <div class="sanhang"> <input type="number"  class="register-input" placeholder="如果是新订单保留为空"></div>
            </div>

            <div class="width100">
                <div class="txt">
                    <div class="sanhang">市场价格<input type="button" value="同步于出售金额" class="button small green"></div>
                    <div class="sanhang">促销价格</div>
                    <div class="sanhang">实际支付<input type="button" value="同步于市场价格" class="button small green"></div>
                </div>
                <div class="sanhang"><input type="number" required class="register-input2" placeholder="对客户显示的价格" ></div>
                <div class="sanhang"><input type="number" required class="register-input2" placeholder="促销价格" ></div>
                <div class="sanhang"><input type="number" required class="register-input2" placeholder="实际购买价格" ></div>
            </div>

            <div class="width100">

                <div class="txt">
                    <div class="sanhang">物品重量</div>
                    <div class="sanhang">快递费率<input type="button" value="同步于出售金额" class="button small green"></div>
                    <div class="sanhang">购买地点</div>
                </div>
                <div class="sanhang"><input type="text" required class="register-input2" placeholder="单位磅" ></div>
                <div class="sanhang"><input type="text" required class="register-input2" placeholder="默认为普通货物4.5每磅" value="4.5"></div>
                <div class="sanhang">
                    <select required class="register-select" title="aaa">
                        <option value="" selected>选择商店</option>
                        <option value="1">Walmart</option>
                        <option value="1">Target</option>
                        <option value="1">Jet</option>
                    </select>
                </div>
            </div>

            <div class="width100">

                <div class="txt">
                    <div class="sanhang">购买日期</div>
                    <div class="sanhang">备注信息</div>
                    <div class="sanhang">是否付款</div>
                </div>
                <div class="sanhang"><input type="date" required class="register-input2" placeholder="" ></div>
                <div class="sanhang"><input type="text" required class="register-input2" placeholder="备注" ></div>
                <div class="sanhang">
                    <div class="switch">
                        <input type="radio" class="switch-input" name="view" value="0" id="nopay" checked>
                        <label for="nopay" class="switch-label switch-label-off">还没</label>
                        <input type="radio" class="switch-input" name="view" value="1" id="yespay">
                        <label for="yespay" class="switch-label switch-label-on">已付</label>
                        <span class="switch-selection"></span>
                    </div>
                </div>
            </div>

            {{--<div class="width100"><input type="submit" value="添加记录" class="register-button"></div>--}}
            <input class="button orange" style="width: 100%" type="submit" value="添加记录">
        {{--</form>--}}
    </div>
</div>


@endsection
