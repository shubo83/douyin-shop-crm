@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div>
                        <a title="添加" data-toggle="tooltip" class="btn btn-primary btn-sm " href="{{route('admin.admin_menu.add')}}">
                            <i class="fa fa-plus"></i> 添加
                        </a>
                        <a class="btn btn-danger btn-sm AjaxButton" data-toggle="tooltip" title="删除选中数据"
                           data-confirm-title="删除确认" data-confirm-content="您确定要删除选中的数据吗？" data-id="checked"
                           data-url="{{route('admin.admin_menu.del')}}">
                            <i class="fa fa-trash"></i> 删除
                        </a>
                        <a class="btn btn-success btn-sm ReloadButton" data-toggle="tooltip" title="刷新"
                           data-id="checked" data-url="{{route('admin.admin_menu.del')}}">
                            <i class="fa fa-refresh"></i> 刷新
                        </a>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered datatable" width="100%">
                        <thead>
                        <tr>
                            <th>
                                <input id="dataCheckAll" type="checkbox" onclick="checkAll(this)" class="checkbox"
                                       placeholder="全选/取消">
                            </th>
                            <th>ID</th>
                            <th>菜单名称</th>
                            <th>url</th>
                            <th>路由名</th>
                            <th>父级ID</th>
                            <th>图标</th>
                            <th>排序</th>
                            <th>状态</th>
                            <th>日志记录方式</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {!! $data !!}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection