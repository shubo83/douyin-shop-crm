@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">

                <!-- 表单头部 -->
                <div class="box-header with-border">
                    <div class="btn-group">
                        <a class="btn flat btn-sm btn-default BackButton">
                            <i class="fa fa-arrow-left"></i>
                            返回
                        </a>
                    </div>
                </div>

                <form id="dataForm" class="dataForm form-horizontal" action="{{route('admin.admin_menu.update')}}" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="parent_id" class="col-sm-2 control-label">上级菜单</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="parent_id" id="parent_id" class="form-control select2">
                                        <option value="0">/</option>
                                        {!! $parents !!}
                                    </select>
                                </div>
                            </div>
                            <script>
                                $('#parent_id').select2();
                            </script>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">名称</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="name" name="name" value="{{isset($data['name']) ? $data['name'] : ''}}"
                                           class="form-control" placeholder="请输入菜单名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="url" class="col-sm-2 control-label">url</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="100" id="url" name="url" value="{{isset($data['url']) ? $data['url'] : ''}}"
                                           class="form-control" placeholder="菜单url">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="route_name" class="col-sm-2 control-label">路由名</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="100" id="route_name" name="route_name" value="{{isset($data['route_name']) ? $data['route_name'] : ''}}"
                                           class="form-control" placeholder="路由名">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="icon" class="col-sm-2 control-label">图标</label>
                                <div class="col-sm-10 col-md-4">
                                    <div class="input-group iconpicker-container">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input maxlength="30" id="icon" name="icon"
                                               value="{{isset($data['icon']) ? $data['icon'] : 'fa-list'}}" class="form-control "
                                               placeholder="请输入图标class">
                                    </div>
                                </div>
                            </div>
                            <script>
                                $('#icon').iconpicker({placement: 'bottomLeft'});
                            </script>

                            <div class="form-group">
                                <label for="sort_id" class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-10 col-md-4">
                                    <div class="input-group">
                                        <input max="9999" min="1" type="number" id="sort_id" name="sort_id"
                                               value="{{isset($data['sort_id']) ? $data['sort_id'] : '1000'}}"
                                               class="form-control input-number field-number" placeholder="默认1000">
                                    </div>
                                </div>
                            </div>
                            <script>
                                $('#sort_id')
                                    .bootstrapNumber({
                                        upClass: 'success',
                                        downClass: 'primary',
                                        center: true
                                    });
                            </script>

                            <div class="form-group">
                                <label for="is_show" class="col-sm-2 control-label">是否显示</label>
                                <div class="col-sm-10 col-md-4">
                                    <input class="input-switch" id="is_show" value="1"
                                           @if(!isset($data) || $data['is_show'] == 1)checked @endif type="checkbox"/>
                                    <input class="switch" name="is_show" value="{{isset($data['is_show']) ? $data['is_show'] : '1'}}"
                                           placeholder="" hidden/>
                                </div>
                            </div>
                            <script>
                                $('#is_show').bootstrapSwitch({
                                    onText: "是",
                                    offText: "否",
                                    onColor: "success",
                                    offColor: "danger",
                                    onSwitchChange: function (event, state) {
                                        $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
                                    }
                                });
                            </script>
                            <div class="form-group">
                                <label for="log_method" class="col-sm-2 control-label">日志请求方式</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="log_method" id="log_method" class="form-control select2">
                                        @foreach($log_method as $item)
                                        <option value="{{$item}}" @if(isset($data) && $data['log_method'] == $item)selected @endif>
                                            {{$item}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <script>
                                $('#log_method').select2();
                            </script>

                            @if(!isset($data))
                            <div class="form-group">
                                <label for="is_more" class="col-sm-2 control-label">是否自动生成增删改菜单</label>
                                <div class="col-sm-10 col-md-4">
                                    <input id="is_more" class="input-switch" placeholder="" type="checkbox"/>
                                    <input class="switch" name="is_more" value="0" hidden/>
                                </div>
                            </div>
                            <script>
                                $('#is_more').bootstrapSwitch({
                                    onText: "是",
                                    offText: "否",
                                    onColor: "success",
                                    offColor: "danger",
                                    onSwitchChange: function (event, state) {
                                        $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
                                    }
                                });
                            </script>
                            <div class="form-group">
                                <label for="more_name" class="col-sm-2 control-label">增删改操作名称</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="more_name" name="more_name"
                                           value="{{isset($data['more_name']) ? $data['more_name'] : ''}}" class="form-control"
                                           placeholder="请输入操作名称">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--表单底部-->
                    <div class="box-footer">
                        @csrf
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10 col-md-4">
                            @if(!isset($data))
                            <div class="btn-group pull-right">
                                <label class="createContinue">
                                    <input type="checkbox" value="1" id="_create" name="_create"
                                           title="继续添加数据">继续添加</label>
                            </div>
                            @endif
                            <div class="btn-group">
                                <button type="submit" class="btn flat btn-info dataFormSubmit">
                                    保存
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="reset" class="btn flat btn-default dataFormReset">
                                    重置
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    $("#dataForm").validate({
        rules: {
            name: {
                required: true,
            },
            url: {
                required: true
            },
            icon: {
                required: true
            },
            sort_id: {
                required: true
            }
        },
        messages: {
            name: {
                required: "名称不能为空",
            },
            url: {
                required: "url不能为空",
            },
            icon: {
                required: "图标不能为空",
            },
            sort_id: {
                required: "排序不能为空",
            },
        },
    });
</script>

@endsection