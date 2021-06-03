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
                <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.user.update')}}" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="avatar" class="col-sm-2 control-label">头像</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="avatar" name="avatar" placeholder="请上传头像" @if(isset($data['avatar']))data-initial-preview="{{$data['avatar']}}" @endif type="file" class="form-control field-image" >
                            </div>
                        </div>
                        <script>
                            $('#avatar').fileinput({
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
                            <label for="user_level_id" class="col-sm-2 control-label">用户等级</label>
                            <div class="col-sm-10 col-md-4">
                                <select name="user_level_id" id="user_level_id" class="form-control field-select"
                                        data-placeholder="请选择用户等级">
                                    <option value=""></option>
                                    @foreach($user_level_list as $item)
                                    <option value="{{$item['id']}}" @if(isset($data) && $data['user_level_id']==$item['id'])selected @endif>
                                        {{$item['name']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <script>
                            $('#user_level_id').select2();
                        </script>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="username" name="username" value="{{isset($data['username']) ? $data['username'] : ''}}"
                                       placeholder="请输入用户名" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-sm-2 control-label">手机号</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="mobile" name="mobile" value="{{isset($data['mobile']) ? $data['mobile'] : ''}}" placeholder="请输入手机号"
                                       type="tel" maxlength="11" class="form-control field-mobile">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="nickname" name="nickname" value="{{isset($data['nickname']) ? $data['nickname'] : ''}}"
                                       placeholder="请输入昵称" type="text" class="form-control field-text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="password" name="password"
                                       value="{{isset($data['password']) ? $data['password'] : '123456'}}"
                                       placeholder="请输入密码" type="password" class="form-control field-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="img" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-10 col-md-10">
                                <script id="description" name="description" type="text/plain">{!! isset($data['description']) ? $data['description'] : '' !!}
                                </script>
                            </div>
                        </div>
                        <script>
                            UE.delEditor('description');
                            var description = UE.getEditor('description', {
                                serverUrl: UEServer
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
            'user_level_id': {
                required: true,
            },
            'username': {
                required: true,
            },
            'mobile': {
                required: true,
            },
            'nickname': {
                required: true,
            },
            'password': {
                required: true,
            },
            'status': {
                required: true,
            },

        },
        messages: {
            'user_level_id': {
                required: "用户等级不能为空",
            },
            'username': {
                required: "用户名不能为空",
            },
            'mobile': {
                required: "手机号不能为空",
            },
            'nickname': {
                required: "昵称不能为空",
            },
            'password': {
                required: "密码不能为空",
            },
            'status': {
                required: "是否启用不能为空",
            },

        }
    });
</script>
@endsection