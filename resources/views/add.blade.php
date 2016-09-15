
@extends('layouts.foot')
@section('content')

    <link href="css/additem.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="ui/layer/layer.js"></script>
    <script type="text/javascript" src="js/uploadimg.js"></script>
    <script type="text/javascript" src="ui/laydate/laydate.js"></script>

    <script type="text/javascript">
        var marked = true;//确保在激活状态不能再点击
        function selectPic()
        {
            document.getElementById('image_file').click();
        }

        //显示预览已经上传的图片   //layer插件
        function showerrorinfo()
        {

            if(marked) {
                marked = false;
                layer.open({
                    type: 1,
                    shade: [0.8, '#393D49'],
                    //shadeClose: true,
                    title: false, //不显示标题
                    time: 5000,
                    scrollbar: false,
                    content: $('#preshowimg'), //捕获的元素
                    success: function(layero, index){
                        //console.log(layero, index);
                        showMessage('warning', '更新图片请先删除此图片');
                    },
                    cancel: function (index) {
                        layer.close(index);
                        this.content.show();
                        marked = true;
                        //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', {time: 5000, icon:6});
                    }
                });
            }
        }

        //弹出 新加订单窗口 //layer插件
        function createCartinfor()
        {
            layer.open({
                type: 2,
                shade: [0.8, '#393D49'],
                area:['850px','500px'],
                title: ['添加新订单', 'font-size:12px;color:white;background-color:#6a5a8c'],
                scrollbar: false,
                content: ['cart/showcustom', 'no'],
                closeBtn:1,
                success: function(layero, index){
                },
                cancel:function(index){
                }
            });
        }

        //弹出 查询订单窗口 //layer插件
        function getCartInfor()
        {
            layer.open({
                type: 1,
                shade:[0.8, '#393D49'],
                title: ['选择所属于的订单','font-size:12px;color:grey'],
                scrollbar: false,
                content:'',
                success:function(layero, index){

                },
                cancel:function(index){

                }
            });
        }
    </script>



    <div id="additemdiv">
        <div><img src="images/addtop.jpg" /></div>
        <div class="width100">
            {{--<form class="register" style="width:100%">--}}
            <div id="skipsomeheight"></div>

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
                    <form id="upload_form" enctype="multipart/form-data" method="post" action="uploadItemPic">
                        <input type="file" name="image_file" id="image_file" onchange="fileSelected()" style="display: none"/>
                    </form>
                    <div class="sanhang">
                        <img src="images/paizhao.png" width="48" height="48" alt="选择图片" onclick="selectPic()" id="selectimg"/>
                        <div id="layerid"><img  id="preshowimg" style="display:none" title="更新图片请先删除此图片" onclick="showerrorinfo()" /></div>
                    </div>
                    <div class="sanhang"><img src="images/upload.png" width="48" height="48" alt="上传图片" id="addpic" onclick="startUploading()"/></div>
                    <div class="sanhang"><img src="images/removepic.png" width="48" height="48" alt="删除图片" id="removepic" onclick="deleteImg()"/></div>
                </div>
            </div>
            <form id="delete_form" enctype="multipart/form-data" method="post">
                {{--判断是否删除图片(或者只是选择了图片) 来决定是否执行后台的删除图片操作--}}
                <input hidden id="deleteImgId" name="deleteImgId">
            </form>
            <div id="showinfo">

            </div>


            <div class="width100">
                <div class="txt">
                    <div class="twohang">物品名称</div>
                    <div class="sanhang">
                        订单ID
                        <input type="button" value="查询订单" class="button small green" onclick="getCartInfor()">
                        <input type="button" value="新开订单" class="button small green" onclick="createCartinfor()">
                    </div>
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
                <div class="sanhang"><input required class="register-input2 laydate-icon" id="showDate" onclick="laydate()"></div>
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

    {{--隐藏:添加表单--}}
    <div></div>

<script type="text/javascript">
/*;!function(){
    laydate({
        elem: '#showDate'
    })
};*/
</script>

@endsection
