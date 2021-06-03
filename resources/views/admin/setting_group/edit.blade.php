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
                <!-- 表单 -->
                <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.setting_group.update')}}" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <!-- 表单字段区域 -->
                    <div class="box-body">

                        <div class="form-group">
                            <label for="module" class="col-sm-2 control-label">作用模块</label>
                            <div class="col-sm-10 col-md-4">
                                <select name="module" id="module" class="form-control field-select"
                                        data-placeholder="请选择作用模块，默认整个项目">
                                    <option value=""></option>
                                    <option value="app" @if(isset($data) && $data['module']=='app') selected @endif>app(整个项目)</option>
                                    @foreach($module_list as $item)
                                    <option value="{{$item}}" @if(isset($data) && $data['module']==$item) selected @endif>
                                        {{$item}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <script>
                            $('#module').select2();
                        </script>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="name" name="name" value="{{isset($data['name']) ? $data['name'] : ''}}" placeholder="请输入名称"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="description" name="description" value="{{isset($data['description']) ? $data['description'] : ''}}"
                                       placeholder="请输入描述" type="text" class="form-control field-text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">代码</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="code" name="code" value="{{isset($data['code']) ? $data['code'] : ''}}" placeholder="请输入代码"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort_number" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10 col-md-4">
                                <div class="input-group">
                                    <input id="sort_number" name="sort_number"
                                           value="{{isset($data['sort_number']) ? $data['sort_number'] : '1000'}}" placeholder="请输入排序" type="number"
                                           class="form-control field-number">
                                </div>
                            </div>
                        </div>
                        <script>
                            $('#sort_number')
                                .bootstrapNumber({
                                    upClass: 'success',
                                    downClass: 'primary',
                                    center: true
                                });
                        </script>

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
                            <label for="auto_create_menu" class="col-sm-2 control-label">自动生成菜单</label>
                            <div class="col-sm-10 col-md-4">
                                <input class="input-switch" id="auto_create_menu" value="1" @if(isset($data) && $data['auto_create_menu']==1)checked @endif type="checkbox"/>
                                <input class="switch field-switch" placeholder="自动生成菜单" name="auto_create_menu"
                                       value="{{isset($data['auto_create_menu']) ? $data['auto_create_menu'] : '0'}}" hidden/>
                            </div>
                        </div>

                        <script>
                            $('#auto_create_menu').bootstrapSwitch({
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
                            <label for="auto_create_file" class="col-sm-2 control-label">自动生成配置文件</label>
                            <div class="col-sm-10 col-md-4">
                                <input class="input-switch" id="auto_create_file" value="1" @if(isset($data) && $data['auto_create_file']==1)checked @endif type="checkbox"/>
                                <input class="switch field-switch" placeholder="自动生成配置文件" name="auto_create_file"
                                       value="{{isset($data['auto_create_file']) ? $data['auto_create_file'] : '0'}}" hidden/>
                            </div>
                        </div>

                        <script>
                            $('#auto_create_file').bootstrapSwitch({
                                onText: "是",
                                offText: "否",
                                onColor: "success",
                                offColor: "danger",
                                onSwitchChange: function (event, state) {
                                    $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
                                }
                            });
                        </script>

                    </div>
                    <!-- 表单底部 -->
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
    /** 表单验证 **/
    $('#dataForm').validate({
        rules: {
            'name': {
                required: true,
            },
            'description': {
                required: true,
            },
            'module': {
                required: true,
            },
            'code': {
                required: true,
            },
            'sort_number': {
                required: true,
            },
            'auto_create_menu': {
                required: true,
            },
            'auto_create_file': {
                required: true,
            },

        },
        messages: {
            'name': {
                required: "名称不能为空",
            },
            'description': {
                required: "描述不能为空",
            },
            'module': {
                required: "作用模块不能为空",
            },
            'code': {
                required: "代码不能为空",
            },
            'sort_number': {
                required: "排序不能为空",
            },
            'auto_create_menu': {
                required: "自动生成菜单不能为空",
            },
            'auto_create_file': {
                required: "自动生成配置文件不能为空",
            },

        }
    });
</script>
@endsection