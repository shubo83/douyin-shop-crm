@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" onerror="javascript:this.src='{{asset('/static/admin/images/avatar.png')}}';this.onerror = null" src="{{$admin['user']['avatar']}}" alt="头像">
                    <h3 class="profile-username text-center">{{$admin['user']['nickname']}}</h3>
                    <p class="text-muted text-center">{{$admin['user']['username']}}</p>
                    <p>
                        @foreach($admin['user']['role_text'] as $item)
                        <small class="label bg-blue">{{$item['name']}}</small>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true">个人信息</a></li>
                    <li class=""><a href="#privacy" data-toggle="tab" aria-expanded="false">修改密码</a></li>
                    <li class=""><a href="#avatars" data-toggle="tab" aria-expanded="false">修改头像</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        <form class="dataForm form-horizontal" id="dataForm1" action="{{route('admin.admin_user.update_nickname')}}" method="post">
                            <div class="form-group">
                                <label for="nickname" class="col-sm-2 control-label">昵称</label>
                                <div class="col-sm-10 col-md-4">
                                    <input class="form-control" value="{{$admin['user']['nickname']}}" name="nickname"
                                           id="nickname" maxlength="30"
                                           placeholder="请输入昵称">
                                </div>
                            </div>
                            @csrf
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane" id="privacy">
                        <form class="dataForm form-horizontal" id="dataForm2" action="{{route('admin.admin_user.update_password')}}" method="post">
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">当前密码</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="password" autocomplete='password' class="form-control" name="password" id="password"
                                           placeholder="请输入当前密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="col-sm-2 control-label">新密码</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="password" class="form-control" autocomplete='off' name="new_password" id="new_password"
                                           placeholder="请输入新密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="renew_password" class="col-sm-2 control-label">确认新密码</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="password" class="form-control" autocomplete='off' name="renew_password" id="renew_password"
                                           placeholder="再次输入新密码">
                                </div>
                            </div>
                            @csrf
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="avatars">
                        <form class="dataForm form-horizontal" id="dataForm3" action="{{route('admin.admin_user.update_avatar')}}" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="avatar" class="col-sm-2 control-label">头像</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="file" class="form-control" name="avatar" id="avatar"
                                           placeholder="头像可空">
                                </div>
                            </div>
                            @csrf
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $("#dataForm1").validate({
        rules: {
            nickname: {
                required: true,
                minlength: 2,
                maxlength: 10
            }
        },
        messages: {
            nickname: {
                required: "请输入昵称",
                minlength: "昵称长度不能小于2",
                maxlength: "昵称长度不能大于10"
            }
        }
    });

    $("#dataForm2").validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            new_password: {
                required: true,
                minlength: 6
            },
            renew_password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            password: {
                required: "请输入当前密码",
                minlength: "当前密码长度不能小于6"
            },
            new_password: {
                required: "请输入新密码",
                minlength: "新密码长度不能小于6"
            },
            renew_password: {
                required: "请输入确认新密码",
                minlength: "确认新密码长度不能小于6"
            }
        }
    });

    $("#dataForm3").validate({
        rules: {
            avatar: {
                required: true
            }
        },
        messages: {
            avatar: {
                required: "请选择文件"
            }
        }
    });
</script>

@endsection
