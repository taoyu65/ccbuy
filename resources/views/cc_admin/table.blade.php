
@extends('layouts.ccadmin')
@section('content1')
    <script type="text/javascript">
        jQuery('#li_table').attr('class' , 'active');
        jQuery('#li_table_carts').attr('class' , 'active');
    </script>

    <div class="table-responsive-y">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>
                    起步
                </th>
                <th>
                    CSS
                </th>
                <th>
                    元件
                </th>
                <th>
                    模块
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td data-title="起步">
                    下载前端框架
                </td>
                <td data-title="CSS">
                    文本
                </td>
                <td data-title="元件">
                    网格系统
                </td>
                <td data-title="模块">
                    框架
                </td>
            </tr>
            <tr>
                <td data-title="起步">
                    框架包含的文件
                </td>
                <td data-title="CSS">
                    图片
                </td>
                <td data-title="元件">
                    图标
                </td>
                <td data-title="模块">
                    头部
                </td>
            </tr>
            <tr>
                <td data-title="起步">
                    基本页面
                </td>
                <td data-title="CSS">
                    水平线
                </td>
                <td data-title="元件">
                    标签
                </td>
                <td data-title="模块">
                    Banner
                </td>
            </tr>
            <tr>
                <td data-title="起步">
                    响应式布局
                </td>
                <td data-title="CSS">
                    按钮
                </td>
                <td data-title="元件">
                    徽章
                </td>
                <td data-title="模块">
                    导航
                </td>
            </tr>
            <tr>
                <td data-title="起步">
                    浏览器支持
                </td>
                <td data-title="CSS">
                    列表
                </td>
                <td data-title="元件">
                    进度条
                </td>
                <td data-title="模块">
                    面包屑
                </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection