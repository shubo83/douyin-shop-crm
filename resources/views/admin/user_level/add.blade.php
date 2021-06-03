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
                <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.user_level.create')}}" method="post"
                      enctype="multipart/form-data">
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="name" name="name" value="{{isset($data['name']) ? $data['name'] : ''}}" placeholder="请输入名称"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="description" name="description" value="{{isset($data['description']) ? $data['description'] : ''}}"
                                       placeholder="请输入简介" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="img" class="col-sm-2 control-label">图片</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="img" name="img" placeholder="请上传图片" @if(isset($data['img']))data-initial-preview="{{$data['img']}}" @endif type="file"
                                class="form-control field-image" >
                            </div>
                        </div>
                        <script>
                            $('#img').fileinput({
                                language: 'zh',
                                overwriteInitial: true,
                                browseLabel: '浏览',
                                initialPreviewAsData: true,
                                dropZoneEnabled: false,
                                showUpload: false,
                                showRemove: false,
                                allowedFileTypes: ['image'],
                                maxFileSize: 10240,
                            });
                        </script>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">是否启用</label>
                            <div class="col-sm-10 col-md-4">
                                <input class="input-switch" id="status" value="1" @if(!isset($data) || $data['status'] == 1)checked @endif type="checkbox"/>
                                <input class="switch field-switch" placeholder="是否启用" name="status"
                                       value="{{isset($data['status']) ? $data['status'] : '1'}}" hidden/>
                            </div>
                        </div>

                        <script>
                            $('#status').bootstrapSwitch({
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
            'status': {
                required: true,
            },

        },
        messages: {
            'name': {
                required: "名称不能为空",
            },
            'description': {
                required: "简介不能为空",
            },
            'status': {
                required: "是否启用不能为空",
            },

        }
    });
</script>
@endsection