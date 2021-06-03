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
                <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.admin_user.update')}}" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="role" class="col-sm-2 control-label">角色</label>
                            <div class="col-sm-10 col-md-4">
                                <select name="role[]" id="role" class="form-control field-multi-select"
                                        multiple="multiple">
                                    @foreach($role as $item)
                                    <option value="{{$item['id']}}" @if(isset($data) && in_array($item['id'],$data['role'])) selected @endif>
                                        {{$item['name']}}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <script>
                            $('#role').select2();
                        </script>

                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-10 col-md-4">
                                <input maxlength="50" class="form-control" id="nickname" placeholder="请输入昵称" name="nickname" value="{{isset($data['nickname']) ? $data['nickname'] : ''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">账号</label>
                            <div class="col-sm-10 col-md-4">
                                <input maxlength="50" id="username" autocomplete="off" name="username"
                                       value="{{isset($data['username']) ? $data['username'] : ''}}" class="form-control" placeholder="请输入账号">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10 col-md-4">
                                <input maxlength="255" id="password" autocomplete="off" type="password" name="password"
                                       value="{{isset($data['password']) ? $data['password'] : ''}}" class="form-control" placeholder="请输入密码">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">启用状态</label>
                            <div class="col-sm-10 col-md-4">
                                <input class="input-switch" id="status" value="1" @if(!isset($data) || $data['status'] == '1') checked @endif type="checkbox"/>
                                <input class="switch field-switch" name="status" value="{{isset($data['status']) ? $data['status'] : '1'}}" hidden/>
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
            nickname: {
                required: true,
                minlength: 2
            },
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 6
            },
        },
        messages: {
            nickname: {
                required: "请输入昵称",
                minlength: "名称长度不能小于2"
            },
            username: {
                required: "请输入账号",
                minlength: "用户名长度不能小于2"
            },
            password: {
                required: "请输入密码",
                minlength: "密码长度不能小于6"
            },
        },

    });
</script>

@endsection

